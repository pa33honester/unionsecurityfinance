<?php

namespace WPStaging\Pro\Backup\Storage\Storages\OneDrive;

use Exception;
use WPStaging\Backup\Dto\Interfaces\RemoteUploadDtoInterface;
use WPStaging\Core\WPStaging;
use WPStaging\Framework\Adapter\Directory;
use WPStaging\Framework\Filesystem\FileObject;
use WPStaging\Framework\Utils\Strings;
use WPStaging\Framework\Traits\HttpRequestTrait;
use WPStaging\Backup\Dto\Job\JobBackupDataDto;
use WPStaging\Backup\Exceptions\StorageException;
use WPStaging\Backup\WithBackupIdentifier;
use WPStaging\Framework\Queue\FinishedQueueException;
use WPStaging\Pro\Backup\Dto\Job\JobCloudDownloadDataDto;
use WPStaging\Pro\Backup\Storage\RemoteUploaderInterface;
use WPStaging\Pro\Backup\Storage\Storages\OneDrive\Auth;
use WPStaging\Pro\Backup\Task\Tasks\JobBackup\AbstractStorageTask;
use WPStaging\Vendor\Psr\Log\LoggerInterface;

use function WPStaging\functions\debug_log;

class Uploader implements RemoteUploaderInterface
{
    use WithBackupIdentifier;
    use HttpRequestTrait;

    /** @var string */
    const ONE_DRIVE_API_URL = 'https://graph.microsoft.com/v1.0/me/drive';

    /** @var RemoteUploadDtoInterface|JobCloudDownloadDataDto */
    private $jobDataDto;

    /** @var LoggerInterface */
    private $logger;

    /** @var string */
    private $filePath;

    /** @var string */
    private $fileName;

    /** @var string */
    private $folderName;

    /** @var int */
    private $maxBackupsToKeep;

    /** @var FileObject */
    private $fileObject;

    /** @var int */
    private $chunkSize;

    /** @var Auth */
    private $auth;

    /** @var bool|string */
    private $error;

    /** @var array */
    protected $options;

    /** @var Strings */
    private $strings;

    /** @var Directory */
    private $dirAdapter;

    public function __construct(Auth $auth, Strings $strings, Directory $directory)
    {
        $this->auth = $auth;
        try {
            if (!$this->auth->testConnection() && !$this->auth->refreshToken()) {
                $this->error = 'Fail to refresh the access token, the process should resume automatically, if the error persists please reconnect to your OneDrive account.';
                return;
            }
        } catch (\Throwable $th) {
            return;
        }

        if (!$this->auth->isAuthenticated()) {
            $this->error = 'Microsoft OneDrive is not authenticated. Backup is still available locally.';
            return;
        }

        $this->error            = false;
        $this->strings          = $strings;
        $this->dirAdapter       = $directory;
        $this->options          = $this->auth->getOptions();
        $this->folderName       = isset($this->options['folderName']) ? $this->options['folderName'] : Auth::FOLDER_NAME;
        $this->maxBackupsToKeep = isset($this->options['maxBackupsToKeep']) && $this->options['maxBackupsToKeep'] > 0 ? intval($this->options['maxBackupsToKeep']) : 15;
    }

    public function getProviderName(): string
    {
        return 'OneDrive';
    }

    /**
     * @param LoggerInterface $logger
     * @param RemoteUploadDtoInterface $jobDataDto
     * @param int $chunkSize
     * @return void
     */
    public function setupUpload(LoggerInterface $logger, RemoteUploadDtoInterface $jobDataDto, $chunkSize = 1 * MB_IN_BYTES)
    {
        $this->logger     = $logger;
        $this->jobDataDto = $jobDataDto;
        $this->chunkSize  = $chunkSize;
        $this->auth->createBackupsDestination();
    }

    /**
     * @param int $backupSize
     */
    public function checkDiskSize($backupSize)
    {
        // no-op
    }

    /**
     * @param  string $backupFilePath
     * @param  string $fileName
     * @return bool
     */
    public function setBackupFilePath($backupFilePath, $fileName): bool
    {
        $this->fileName   = $fileName;
        $this->filePath   = $backupFilePath;
        $this->fileObject = new FileObject($this->filePath, FileObject::MODE_READ);

        $uploadMetadata = (array)$this->jobDataDto->getRemoteStorageMeta();
        if (!array_key_exists($this->fileName, $uploadMetadata)) {
            $this->logger->info('OneDrive: Starting upload of backup file:' . $this->fileName);
        }

        return true;
    }

    /**
     * @throws FinishedQueueException
     *
     * @return int Number of bytes uploaded
     */
    public function chunkUpload(): int
    {
        if (isset($this->jobDataDto->getRemoteStorageMeta()[$this->fileName]['Offset'])) {
            $fileMetadata = $this->jobDataDto->getRemoteStorageMeta()[$this->fileName];
            $offset       = $fileMetadata['Offset'];
        } else {
            $offset = 0;
            unset($this->options['uploadUrl']);
            $this->auth->saveOptions($this->options);
        }

        $this->fileObject->fseek($offset);
        $chunk     = $this->fileObject->fread($this->chunkSize);
        $chunkSize = strlen($chunk);
        $fileSize  = $this->fileObject->getSize();
        try {
            if ($offset === 0 && !isset($this->options['uploadUrl'])) {
                $chunkSize = 0;
                $this->startUploadSession();
                // start uploading right away!
                if (isset($this->options['uploadUrl'])) {
                    $chunkSize = $this->appendUploadSession((int)$offset, $chunk);
                }
            } elseif (isset($this->options['uploadUrl'])) {
                $chunkSize = $this->appendUploadSession((int)$offset, $chunk);
            } else {
                unset($this->options['uploadUrl']);
                $this->auth->saveOptions($this->options);
                throw new FinishedQueueException();
            }
        } catch (StorageException $se) {
            unset($this->options['uploadUrl']);
            $this->auth->saveOptions($this->options);
            $this->setMetadata(null);
        }

        // finish upload task if the file is fully uploaded!
        if (!isset($this->options['uploadUrl']) && ($chunkSize + $offset) >= $fileSize) {
            throw new FinishedQueueException();
        }

        return $chunkSize;
    }

    /**
     * @param string $filePath
     * @param string $remoteFileName
     *
     * @throws Exception
     * @return bool
     */
    public function uploadFile($filePath, $remoteFileName = ''): bool
    {
        $this->chunkSize  = AbstractStorageTask::CHUNK_SIZE * MB_IN_BYTES;
        $this->fileName   = $remoteFileName;
        $this->fileObject = new FileObject($filePath, FileObject::MODE_READ);
        $this->jobDataDto = WPStaging::make(JobBackupDataDto::class);
        try {
            $this->chunkUpload();
        } catch (FinishedQueueException $exception) {
            return true;
        } catch (Exception $ex) {
            throw new Exception("OneDrive error in uploadFile: " . $ex->getMessage());
        }

        return true;
    }

    /**
     * @return void
     */
    public function stopUpload()
    {
        // no-op
    }

    /** @return string|bool */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return array
     */
    public function getBackups(): array
    {
        return $this->auth->getBackups();
    }

    /**
     * @return bool
     */
    public function deleteOldestBackups(): bool
    {
        $retainedBackups = $this->auth->getRetainedBackups();
        if (count($retainedBackups) < $this->maxBackupsToKeep) {
            return true;
        }

        $remoteBackupsFiles = $this->getBackups();

        foreach ($retainedBackups as $retainedBackupId => $retainedBackup) {
            if (count($retainedBackups) < $this->maxBackupsToKeep) {
                break;
            }

            $this->deleteBackupFiles($retainedBackupId, $remoteBackupsFiles);

            $this->auth->unsetStorageFromRetainedBackups($retainedBackupId);
            unset($retainedBackups[$retainedBackupId]);
        }

        return true;
    }

    /**
     * @param  array $uploadsToVerify
     * @return bool
     */
    public function verifyUploads(array $uploadsToVerify): bool
    {
        $backups          = $this->getBackups();
        $uploadsConfirmed = [];
        foreach ($backups as $file) {
            $fileName = $file['name'];
            if (!array_key_exists($fileName, $uploadsToVerify)) {
                continue;
            }

            $toVerify = $uploadsToVerify[$fileName];
            $fileSize = (int)$file['size'];
            if ($fileSize !== $toVerify['size']) {
                continue;
            }

            /**
             * 'quickXorHash' is not available all time, if so let's assume everything is fine when it misses.
             *
             * @see https://learn.microsoft.com/en-us/graph/api/resources/hashes?view=graph-rest-1.0
             */
            if (empty($file['file']['hashes']['quickXorHash']) || $file['file']['hashes']['quickXorHash'] !== $toVerify['hash']) {
                debug_log('Fail to compare file quickXorHash for the uploaded file!');
            }

            $uploadsConfirmed[] = $fileName;
        }

        return count($uploadsConfirmed) === count($uploadsToVerify);
    }

    /**
     * @see https://learn.microsoft.com/en-us/graph/api/driveitem-createuploadsession?view=graph-rest-1.0
     *
     * @return void
     */
    protected function startUploadSession()
    {
        $body = [
                'name'                              => $this->fileName,
                '@microsoft.graph.conflictBehavior' => 'replace'
        ];
        $args = [
            'headers' => [
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer ' . $this->options['accessToken'],
            ],
            'body'   => json_encode($body),
            'method' => 'POST',
        ];
        $folderName = empty($this->options['folderName']) ? Auth::FOLDER_NAME : $this->options['folderName'];
        $response   = $this->getRequestBody(self::ONE_DRIVE_API_URL . "/root:/$folderName/" . $this->fileName . ":/createUploadSession", $args);
        if (!isset($response['uploadUrl'])) {
            debug_log('Microsoft OneDrive upload url is missing. Should Retry...');
            return;
        }

        $this->setMetadata(0);
        $this->options['uploadUrl'] = $response['uploadUrl'];
        $this->auth->saveOptions($this->options);
        return;
    }

    /**
     * @see https://learn.microsoft.com/en-us/graph/api/driveitem-createuploadsession?view=graph-rest-1.0
     *
     * @param  int $offset
     * @param  string $chunk Chunk of data to upload
     *
     * @return int Number of bytes uploaded
     */
    protected function appendUploadSession(int $offset, string $chunk): int
    {
        $start = $offset;
        $end   = $offset + strlen($chunk) - 1;
        $total = $this->fileObject->getSize();
        $args  = [
            'headers' => [
                'Content-Length' => strlen($chunk),
                'Content-Range'  => "bytes $start-$end/$total",
            ],
            'body'   => $chunk,
            'method' => 'PUT',
        ];
        $response = $this->getRequestBody($this->options['uploadUrl'], $args);
        if (empty($response)) {
            return 0;
        }

        // then upload is completed.
        if (!empty($response['name'])) {
            unset($this->options['uploadUrl']);
            $this->auth->saveOptions($this->options);
        }

        $this->setMetadata($offset + strlen($chunk));
        return strlen($chunk);
    }

    /**
     * @param  int|null $offset
     * @return void
     */
    protected function setMetadata($offset = 0)
    {
        $this->jobDataDto->setRemoteStorageMeta([
            $this->fileName => [
                'Offset' => $offset,
            ]
        ]);
    }

    /**
     * Deletes remote backup files that match a given retained backup ID.
     *
     * @param string $retainedBackupId The ID of the retained backup to match.
     * @param array $remoteBackupsFiles List of remote backup files to check.
     *
     * @return void
     */
    private function deleteBackupFiles(string $retainedBackupId, array $remoteBackupsFiles)
    {
        foreach ($remoteBackupsFiles as $file) {
            $fileName = $file['name'];
            if (strpos($fileName, $retainedBackupId) !== false) {
                $args = [
                'headers' => [
                    'Content-Type'    => 'application/json',
                    'Authorization'   => 'Bearer ' . $this->options['accessToken'],
                ],
                'method' => 'DELETE',
                ];
                try {
                    $this->getRequestBody(self::ONE_DRIVE_API_URL . '/items/' . $file['id'], $args);
                } catch (\Throwable $th) {
                    debug_log("Failed to delete old backups. Error message: " . $th->getMessage());
                }
            }
        }
    }
}
