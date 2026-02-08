<?php

namespace WPStaging\Pro\Backup\Storage\Storages\GoogleDrive;

use Exception;
use WPStaging\Core\WPStaging;
use WPStaging\Backup\Dto\Interfaces\RemoteUploadDtoInterface;
use WPStaging\Framework\Filesystem\FileObject;
use WPStaging\Framework\Queue\FinishedQueueException;
use WPStaging\Framework\Utils\Strings;
use WPStaging\Framework\Job\Exception\DiskNotWritableException;
use WPStaging\Pro\Backup\Storage\RemoteUploaderInterface;
use WPStaging\Backup\WithBackupIdentifier;
use WPStaging\Vendor\Psr\Log\LoggerInterface;
use WPStaging\Framework\Traits\HttpRequestTrait;
use WPStaging\Pro\Backup\Task\Tasks\JobBackup\AbstractStorageTask;
use WPStaging\Backup\Dto\Job\JobBackupDataDto;

use function WPStaging\functions\debug_log;

class Uploader implements RemoteUploaderInterface
{
    use WithBackupIdentifier;
    use HttpRequestTrait;

    /** @var RemoteUploadDtoInterface */
    private $jobDataDto;

    /** @var LoggerInterface */
    private $logger;

    /** @var string */
    private $filePath;

    /** @var string */
    private $fileName;

    /** @var string */
    private $folderId;

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

    /** @var Strings */
    private $strings;

    public function __construct(Auth $auth, Strings $strings)
    {
        $this->error = false;
        $this->auth = $auth;
        $this->strings = $strings;

        if (!$this->auth->isAuthenticated()) {
            $this->error = __('Google Drive is not authenticated. Backup is still available locally.', 'wp-staging');
            return;
        }

        $options                = $this->auth->getOptions();
        $this->folderName       = isset($options['folderName']) ? $this->auth->sanitizeGoogleDriveLocation($options['folderName']) : Auth::FOLDER_NAME;
        $this->maxBackupsToKeep = isset($options['maxBackupsToKeep']) ? $options['maxBackupsToKeep'] : 15;
        $this->maxBackupsToKeep = intval($this->maxBackupsToKeep);
        $this->maxBackupsToKeep = $this->maxBackupsToKeep > 0 ? $this->maxBackupsToKeep : 15;
        $this->folderId         = $this->auth->getFolderIdByLocation($this->folderName);
    }

    public function getProviderName(): string
    {
        return 'Google Drive';
    }

    /**
     * @param LoggerInterface $logger
     * @param RemoteUploadDtoInterface $jobDataDto
     * @param int $chunkSize = MB_IN_BYTES
     * @return void
     */
    public function setupUpload(LoggerInterface $logger, RemoteUploadDtoInterface $jobDataDto, $chunkSize = MB_IN_BYTES)
    {
        $this->logger     = $logger;
        $this->jobDataDto = $jobDataDto;
        $this->chunkSize  = $chunkSize;

        $this->folderId = $this->createBackupsDestination();
    }

    /**
     * @param int $backupSize
     * @throws DiskNotWritableException
     */
    public function checkDiskSize($backupSize)
    {
        if (!$this->doExceedGoogleDiskLimit($backupSize)) {
            throw new DiskNotWritableException($this->error);
        }
    }

    /**
     * @param  string $backupFilePath
     * @param  string $fileName
     * @return bool
     */
    public function setBackupFilePath($backupFilePath, $fileName)
    {
        $this->fileName   = $fileName;
        $this->filePath   = $backupFilePath;
        $this->fileObject = new FileObject($this->filePath, FileObject::MODE_READ);

        $uploadMetadata = (array)$this->jobDataDto->getRemoteStorageMeta();
        if (!array_key_exists($this->fileName, $uploadMetadata)) {
            $this->folderId = $this->createBackupsDestination();
            $resumeURI      = $this->getResumeUri();
            $this->setMetadata($resumeURI, 0);
            if (is_object($this->logger)) {
                $this->logger->info('Starting upload of file:' . $this->fileName);
            }

            return true;
        }

        return true;
    }

    /**
     * @return int
     *
     * @throws FinishedQueueException
     */
    public function chunkUpload()
    {
        if (empty($this->jobDataDto->getRemoteStorageMeta()[$this->fileName])) {
            debug_log($this->getProviderName() . ' Fail to start upload!');
            return 0;
        }

        $chunkSize    = 0;
        $fileMetadata = $this->jobDataDto->getRemoteStorageMeta()[$this->fileName];
        $offset       = $fileMetadata['Offset'];

        $this->fileObject->fseek($offset);
        $chunk = $this->fileObject->fread($this->chunkSize);
        $chunkSize = $this->nextChunk($fileMetadata['ResumeURI'], $chunk, $offset);

        $offset += $chunkSize;
        $this->setMetadata($fileMetadata['ResumeURI'], $offset);
        return $chunkSize;
    }

    /**
     * @param string $filePath
     * @param string $remoteFileName
     *
     * @throws Exception
     *
     * @return bool
     */
    public function uploadFile($filePath, $remoteFileName = ''): bool
    {
        $this->chunkSize  = AbstractStorageTask::CHUNK_SIZE * MB_IN_BYTES;
        $this->fileName   = $remoteFileName;
        $this->fileObject = new FileObject($filePath, FileObject::MODE_READ);
        $this->jobDataDto = WPStaging::make(JobBackupDataDto::class);
        $this->setBackupFilePath($filePath, $remoteFileName);
        try {
            $this->chunkUpload();
        } catch (FinishedQueueException $exception) {
            return true;
        } catch (Exception $ex) {
            throw new Exception(" error in uploadFile: " . $ex->getMessage());
        }

        return true;
    }

    public function stopUpload()
    {
        // no-op
    }

    /** @return string */
    public function getError()
    {
        return $this->error;
    }

    public function getBackups(): array
    {
        return $this->auth->getBackups();
    }

    public function deleteOldestBackups(): bool
    {
        $retainedBackups = $this->auth->getRetainedBackups();
        if (count($retainedBackups) < $this->maxBackupsToKeep) {
            return true;
        }

        $remoteBackupsFiles = $this->auth->getBackups();

        foreach ($retainedBackups as $retainedBackupId => $retainedBackup) {
            if (count($retainedBackups) < $this->maxBackupsToKeep) {
                break;
            }

            foreach ($remoteBackupsFiles as $file) {
                $fileName = $file->name;
                if (strpos($fileName, $retainedBackupId) !== false) {
                    try {
                        $this->auth->deleteRemoteFileById($file->id);
                    } catch (\Throwable $th) {
                    }
                }
            }

            $this->auth->unsetStorageFromRetainedBackups($retainedBackupId);
            unset($retainedBackups[$retainedBackupId]);
        }

        return true;
    }

    /**
     * @param array $uploadsToVerify
     * @return bool
     */
    public function verifyUploads(array $uploadsToVerify): bool
    {
        $files            = $this->auth->getBackups();
        $uploadsConfirmed = [];
        foreach ($files as $file) {
            if (empty($file->name) || empty($file->size)) {
                continue;
            }

            $fileName = $file->name;
            if (!array_key_exists($fileName, $uploadsToVerify)) {
                continue;
            }

            $fileSize = (int)$file->size;
            $toVerify = $uploadsToVerify[$fileName];
            if ($toVerify['size'] !== $fileSize) {
                continue;
            }

            $uploadsConfirmed[] = $fileName;
        }

        $this->auth->saveStorageAccountInfo();

        return count($uploadsConfirmed) === count($uploadsToVerify);
    }

    /**
     * @return string
     */
    protected function getResumeUri(): string
    {
        $options = $this->auth->getOptions();
        if (empty($options['accessToken'])) {
            return '';
        }

        $body = [
            'parents' => [$this->folderId],
            'name'    => $this->fileName,
        ];
        $args = [
        'headers' => [
            'Content-Type'            => 'application/json; charset=UTF-8',
            'Authorization'           => 'Bearer ' . $options['accessToken'],
            'X-Upload-Content-Type'   => 'application/octet-stream',
            'X-Upload-Content-Length' => $this->fileObject->getSize(),
        ],
        'body'   => json_encode($body),
        'method' => 'POST',
        ];

        try {
            $response        = $this->getRemoteRequest('https://www.googleapis.com/upload/drive/v3/files?uploadType=resumable', $args);
            $responseHeaders = wp_remote_retrieve_headers($response);
            if (empty($responseHeaders['location'])) {
                debug_log('upload url is missing. Should Retry...');
                return '';
            }

            return $responseHeaders['location'];
        } catch (\Throwable $th) {
            debug_log('Fail to get resume uri, error message: ' . $th->getMessage());
        }

        return '';
    }

    /**
     * @param  string $uploadUrl
     * @param  string $chunk
     * @param  int $offset
     *
     * @throws FinishedQueueException
     *
     * @return int
     */
    protected function nextChunk(string $uploadUrl, string $chunk, int $offset)
    {
        $options  = $this->auth->getOptions();
        $fileSize = $this->fileObject->getSize();

        $args = [
            'headers' => [
                'Authorization'  => 'Bearer ' . $options['accessToken'],
                'Content-Length' => strlen($chunk),
                'Content-Range'  => "bytes {$offset}-" . ($offset + strlen($chunk) - 1) . "/{$fileSize}",
            ],
            'body'   => $chunk,
            'method' => 'PUT',
        ];

        $responseCode = 0;
        try {
            $response     = $this->getRemoteRequest($uploadUrl, $args);
            $responseCode = wp_remote_retrieve_response_code($response);
        } catch (\Throwable $th) {
            debug_log('Fail to upload next chunk, error message: ' . $th->getMessage());
        }

        if ($responseCode === 308) {
            return strlen($chunk);
        } elseif ($responseCode === 200 || $responseCode === 201) {
            // Upload complete.
            throw new FinishedQueueException();
        }

        return strlen('');
    }

    protected function setMetadata($resumeURI, $offset)
    {
        $this->jobDataDto->setRemoteStorageMeta([
            $this->fileName => [
                'ResumeURI' => $resumeURI,
                'Offset' => $offset,
            ]
        ]);
    }

    /**
     * @param int $backupSize
     * @return bool
     */
    private function doExceedGoogleDiskLimit($backupSize): bool
    {
        if (apply_filters('wpstg.googleDrive.bypassDiskSpace', false)) {
            return true;
        }

        try {
            $options    = $this->auth->getOptions();
            $totalQuota = $options['storageInfo']['allocation']['allocated'];
            $usedQuota  = $options['storageInfo']['used'];
        } catch (Exception $ex) {
            return true;
        }

        if (!is_numeric($totalQuota) || !is_numeric($usedQuota)) {
            $this->logger->warning('Unable to get size of used or available storage space. Continuing with Upload to Google Drive!');
            return true;
        }

        $availableQuota = $totalQuota - $usedQuota;
        if (empty($availableQuota) || !is_numeric($availableQuota) || $availableQuota < 0) {
            return true;
        }

        if ($backupSize > $availableQuota) {
            $this->error = sprintf(__('Could not upload backup to Google Drive. Reason: Disk Quota Exceeded. Increase google drive space or delete old data! Backup Size: %s. Space Available: %s. Backup is still available locally.', 'wp-staging'), size_format($this->fileObject->getSize(), 2), size_format($availableQuota, 2));
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    protected function createBackupsDestination(): string
    {
        $location       = $this->getBackupsLocation();
        $locationURI    = $this->auth->getFoldersFromLocation($location);
        $parentFolderId = 'root';
        foreach ($locationURI as $folder) {
            $folderId = $this->auth->getFolderIdByName($folder, $parentFolderId);
            if (!empty($this->auth->getError())) {
                $this->logger->error($this->auth->getError());
            }

            if ($folderId === '' && !empty($parentFolderId)) {
                $folderId = $this->createFolder($folder, $parentFolderId);
            }

            if ($folderId === '') {
                return ''; // Early bail: fail to get or to create the current folder, no need to continue the loop. Something is wrong!
            }

            $parentFolderId = $folderId;
        }

        return $folderId;
    }

    /**
     * @param  string $path
     * @param  string $parentFolderId
     * @return string
     */
    private function createFolder(string $path, string $parentFolderId): string
    {
        if (empty($parentFolderId)) {
            return '';
        }

        $options = $this->auth->getOptions();
        $body = [
            'parents'  => [$parentFolderId],
            'mimeType' => 'application/vnd.google-apps.folder',
            'name'     => $path,
        ];
        $args = [
            'headers' => [
                'Content-Type'  => 'application/json; charset=UTF-8',
                'Authorization' => 'Bearer ' . $options['accessToken'],
            ],
            'body'   => json_encode($body),
            'method' => 'POST',
        ];

        try {
            $response = $this->getRequestBody(Auth::GOOGLEDRIVE_API_V3_BASE_URL . '/files', $args);
            if (!empty($response['id'])) {
                return $response['id'];
            }
        } catch (\Throwable $th) {
            debug_log("Fail to create folder. Error: " . $th->getMessage());
        }

        return '';
    }

    /**
     * @return string
     */
    protected function getBackupsLocation(): string
    {
        $options = $this->auth->getOptions();
        return !empty($options['folderName']) ? $options['folderName'] : Auth::FOLDER_NAME;
    }
}
