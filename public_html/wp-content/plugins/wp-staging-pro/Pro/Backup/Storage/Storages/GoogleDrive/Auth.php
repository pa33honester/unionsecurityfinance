<?php

namespace WPStaging\Pro\Backup\Storage\Storages\GoogleDrive;

use WPStaging\Core\WPStaging;
use WPStaging\Framework\Security\Auth as WPStagingAuth;
use WPStaging\Framework\Utils\Sanitize;
use WPStaging\Framework\Utils\Strings;
use WPStaging\Pro\Backup\Storage\AbstractStorage;
use WPStaging\Framework\Traits\HttpRequestTrait;

use function WPStaging\functions\debug_log;

class Auth extends AbstractStorage
{
    use HttpRequestTrait;

    /** @var string */
    const REDIRECT_URL = 'https://auth.wp-staging.com/googledrive/v2';

    /** @var string */
    const REFRESH_URL = 'https://auth.wp-staging.com/googledrive/v2/refreshToken';

    /** @var string */
    const FOLDER_NAME = 'wpstaging-backups';

    /** @var string */
    const GOOGLEDRIVE_OAUTH2_URL = 'https://oauth2.googleapis.com';

    /** @var string */
    const GOOGLEDRIVE_API_V3_BASE_URL = 'https://www.googleapis.com/drive/v3';

    /** @var string */
    const GOOGLEDRIVE_REQUIRED_SCOPES = 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/drive.file';

    /** @var string */
    private $redirectURI;

    /** @var Sanitize */
    protected $sanitize;

    /** @var array */
    protected $options;

    public function __construct(Sanitize $sanitize, WPStagingAuth $wpstagingAuth)
    {
        parent::__construct($wpstagingAuth);
        $this->identifier = 'googledrive';
        $this->label = 'Google Drive';
        $this->redirectURI = add_query_arg(
            [
                'action' => 'wpstg-googledrive-api-auth',
            ],
            network_admin_url('admin-post.php')
        );
        $this->sanitize = $sanitize;
    }

    /**
     * @return void
     */
    public function testConnection()
    {
        // no-op
    }

    /**
     * Verifies if access token is still valid, if not try to refresh it.
     *
     * @return bool
     */
    public function isAccessTokenValid(): bool
    {
        return $this->saveStorageAccountInfo() || $this->refreshToken();
    }

    /**
     * Get Authorization URL
     *
     * @return string
     */
    public function getAuthenticationURL(): string
    {
        return add_query_arg(
            [
                'state'  => urlencode((string)admin_url('admin-post.php')),
            ],
            self::REDIRECT_URL
        );
    }

    /**
     * Authentication of the storage
     * @return void
     */
    public function authenticate()
    {
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('You are not allowed to access this page.', 'wp-staging'));
        }

        $options = $this->getOptions();
        $options = array_merge($options, [
            'isAuthenticated' => true,
            'refreshToken'    => isset($_GET['refresh_token']) ? $this->sanitize->decodeBase64AndSanitize($_GET['refresh_token']) : '',
            'accessToken'     => isset($_GET['access_token']) ? $this->sanitize->decodeBase64AndSanitize($_GET['access_token']) : '',
            'expiresIn'       => isset($_GET['expires_in']) ? $this->sanitize->sanitizeInt($_GET['expires_in']) : 0,
            'showNotice'      => false
        ]);

        // Because it is authentication process, at least one token is needed before saving data.
        if (!empty($options['refreshToken']) || !empty($options['accessToken'])) {
            parent::saveOptions($options);
            $this->saveStorageAccountInfo();
        }

        $redirectURL = add_query_arg(
            [
                'page'         => 'wpstg-settings',
                'tab'          => 'remote-storages',
                'sub-tab'      => 'googledrive',
                'auth-storage' => 'true',
            ],
            admin_url('admin.php')
        );

        wp_redirect($redirectURL);
    }

    /**
     * Save storage account info in options(displayed in storage page)
     *
     * @return bool
     */
    public function saveStorageAccountInfo(): bool
    {
        $options = $this->getOptions();
        if (empty($options['accessToken'])) {
            return false;
        }

        $args    = [
            'headers' => [
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer ' . $options['accessToken'],
            ],
            'method' => 'GET',
        ];
        try {
            $response = $this->getRequestBody(self::GOOGLEDRIVE_API_V3_BASE_URL . '/about?fields=*', $args);
        } catch (\Throwable $th) {
            //no-op;
        }

        if (empty($response['user'])) {
            return false;
        }

        $options['userData']['displayName']                = $response['user']['displayName'] ?? '';
        $options['storageInfo']['used']                    = $response['storageQuota']['usageInDrive'] ?? '';
        $options['storageInfo']['allocation']['allocated'] = $response['storageQuota']['limit'] ?? '';
        if (!$options['userData']['displayName'] || !$options['storageInfo']['used'] || !$options['storageInfo']['allocation']['allocated']) {
            return false;
        }

        $this->saveOptions($options);
        return true;
    }

    /**
     * Authenticate when user set his own API credentials
     */
    public function apiAuthenticate()
    {
        $options = $this->getOptions();

        $userAuthorizedScopesAsStr     = filter_input(INPUT_GET, 'scope');
        $userAuthorizedScopesAsArr     = array_filter(explode(' ', $userAuthorizedScopesAsStr));
        $authorizedScopesRequiredAsArr = explode(' ', self::GOOGLEDRIVE_REQUIRED_SCOPES);
        $isAuthorizedAllRequiredScopes = true;
        foreach ($authorizedScopesRequiredAsArr as $authorizedScopesRequired) {
            if (!in_array($authorizedScopesRequired, $userAuthorizedScopesAsArr)) {
                $isAuthorizedAllRequiredScopes = false;
                break;
            }
        }

        if (!$isAuthorizedAllRequiredScopes) {
            echo sprintf('<strong style="font-family: arial,sans-serif;font-size:12px;">%s</strong>', esc_html__('You have not granted permissions required by the WP STAGING plugin. Please go back and retry the authorization.', 'wp-staging'));
            die;
        }

        $code = isset($_GET['code']) ? $this->sanitize->sanitizeString($_GET['code']) : '';
        $body = [
            'code'          => $code,
            'client_id'     => $options['googleClientId'],
            'client_secret' => $options['googleClientSecret'],
            'redirect_uri'  => $this->getRedirectURI(),
            'grant_type'    => 'authorization_code',
        ];
        $args = [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'method' => 'POST',
            'body'   => json_encode($body),
        ];
        try {
            $token = $this->getRequestBody(self::GOOGLEDRIVE_OAUTH2_URL . '/token', $args);
            $urlToRedirect = add_query_arg([
                'action'        => 'wpstg-googledrive-auth',
                'access_token'  => base64_encode($token['access_token']),
                'refresh_token' => base64_encode($token['refresh_token']),
                'expires_in'    => intval($token['expires_in']),
            ], admin_url('admin-post.php'));

            header('Location: ' . $urlToRedirect);
        } catch (\Throwable $th) {
            debug_log('Api authentication failed. Error message: ' . $th->getMessage());
        }
    }

    /**
     * @param array $settings
     * @return bool
     */
    public function updateSettings($settings)
    {
        $options                       = $this->getOptions();
        $backupLocation                = isset($settings['folder_name']) ? $settings['folder_name'] : self::FOLDER_NAME;
        $options['folderName']         = $this->sanitizeGoogleDriveLocation($backupLocation);
        $options['maxBackupsToKeep']   = isset($settings['max_backups_to_keep']) ? $settings['max_backups_to_keep'] : 0;
        $options['maxBackupsToKeep']   = $options['maxBackupsToKeep'] > 0 ? $options['maxBackupsToKeep'] : 15;
        $options['googleClientId']     = isset($settings['google_client_id']) ? $settings['google_client_id'] : '';
        $options['googleClientSecret'] = isset($settings['google_client_secret']) ? $settings['google_client_secret'] : '';

        $options['lastUpdated'] = time();
        $result = $this->saveOptions($options);

        if (empty($options['isAuthenticated']) && !empty($options['googleClientId']) && !empty($options['googleClientSecret'])) {
            $params = [
                'client_id'              => $options['googleClientId'],
                'redirect_uri'           => $this->getRedirectURI(),
                'response_type'          => 'code',
                'scope'                  => self::GOOGLEDRIVE_REQUIRED_SCOPES,
                'access_type'            => 'offline',
                'include_granted_scopes' => 'true',
                'prompt'                 => 'consent',
            ];
            $url = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);
            wp_send_json_success($url);
        }

        return $result;
    }

    /**
     * Get folders from Google Drive Location
     *
     * @param string $backupLocation
     *
     * @return array
     */
    public function getFoldersFromLocation($backupLocation)
    {
        $locationURI = explode('/', $backupLocation);
        return array_filter(array_map('trim', $locationURI), function ($folder) {
            return !empty($folder);
        });
    }

    /**
     * Clear the current storage settings from database (Revoking token should be done by user himself because it will disconnect all other sites, as well).
     *
     * @return bool
     */
    public function revoke()
    {
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('You are not allowed to do this.', 'wp-staging'));
        }

        return parent::saveOptions([]);
    }

    /** @return array */
    public function getFiles()
    {
        if (!$this->isAccessTokenValid()) {
            $this->showLoginIssueNotice();
            return [];
        }

        $options        = $this->getOptions();
        $backupLocation = isset($options['folderName']) ? $options['folderName'] : self::FOLDER_NAME;
        $folderId       = $this->getFolderIdByLocation($backupLocation);

        if (!$folderId) {
            return [];
        }

        // If we have folder id then no need to show notice!
        if (!empty($options['showNotice'])) {
            $this->hideLoginIssueNotice();
        }

        $args    = [
            'headers' => [
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer ' . $options['accessToken'],
            ],
            'method' => 'GET',
        ];
        $params = [
            'q'       => 'trashed = false and "' . $folderId . '" in parents',
            'fields'  => 'nextPageToken, files(id, name, mimeType, size, createdTime, modifiedTime)',
            'orderBy' => 'modifiedTime desc'
        ];

        $url = self::GOOGLEDRIVE_API_V3_BASE_URL . '/files?' . http_build_query($params);
        try {
            $response = $this->getRequestBody($url, $args);
            return $response['files'] ?? [];
        } catch (\Throwable $th) {
        }

        return [];
    }

    /**
     * @return array
     */
    public function getBackups()
    {
        $files = $this->getFiles();

        $backups = [];
        $strings = WPStaging::make(Strings::class);
        foreach ($files as $key => $file) {
            if ($strings->endsWith($file['name'], '.wpstg') || $strings->endsWith($file['name'], '.sql')) {
                $date                                = new \DateTime($file['createdTime']);
                $backups[$key]                       = json_decode(json_encode($file));
                $backups[$key]->dateCreatedTimestamp = $date->format('Y-m-d H:i:s');
                $backups[$key]->storageProviderName  = $this->getIdentifier();
                $backups[$key]->type                 = $this->label;
            }
        }

        return $backups;
    }

    /**
     * Delete all backup files
     * Used by /tests/webdriverBackup/Backup/GoogleDriveUploadCest.php
     * @return void
     */
    public function cleanBackups()
    {
        foreach ($this->getFiles() as $file) {
            $this->deleteRemoteFileById($file['id']);
        }
    }

    /**
     * @param string $location A folder name or path separated with slashes to the backup file
     * @return false|string
     */
    public function getFolderIdByLocation($location)
    {
        $locationURI = $this->getFoldersFromLocation($location);
        $folderId    = 'root';
        foreach ($locationURI as $folder) {
            $folderId = $this->getFolderIdByName($folder, $folderId);
            if ($folderId === '') {
                return false;
            }
        }

        return $folderId;
    }

    /**
     * @param string $path
     * @param string $parent 'root'
     * @return string return empty string if fails!
     */
    public function getFolderIdByName($path, $parent = 'root')
    {
        if (!$this->isAccessTokenValid()) {
            $this->showLoginIssueNotice();
            return '';
        }

        $options = $this->getOptions();
        $args    = [
            'headers' => [
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer ' . $options['accessToken'],
            ],
            'method' => 'GET',
        ];

        $params = [
            'q'      => "name ='" . $path . "' and trashed = false and '" . $parent . "' in parents and mimeType = 'application/vnd.google-apps.folder'",
            'fields' => 'nextPageToken, files(id, name, mimeType)',
        ];

        $url = self::GOOGLEDRIVE_API_V3_BASE_URL . '/files?' . http_build_query($params);
        try {
            $response = $this->getRequestBody($url, $args);
        } catch (\Throwable $th) {
            debug_log(sprintf('Can not list files from Google Drive. Please reconnect to Google Drive via WP STAGING > Settings > Storage Providers. Error: %s', $th->getMessage()));
            $this->showLoginIssueNotice();
            return '';
        }

        if (empty($response['files']['0']['id'])) {
            // Should not happen
            return '';
        }

        return $response['files']['0']['id'];
    }

    /**
     * This will refresh access token by using user api credentials.
     * @return bool
     */
    public function refreshAccessToken(): bool
    {
        $options = $this->getOptions();
        if (empty($options['refreshToken'])) {
            return false;
        }

        if (empty($options['googleClientId']) || empty($options['googleClientSecret'])) {
            return false;
        }

        $body = [
            'client_id'     => $options['googleClientId'],
            'client_secret' => $options['googleClientSecret'],
            'grant_type'    => 'refresh_token',
            'refresh_token' => $options['refreshToken'],
        ];

        $args = [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'method' => 'POST',
            'body'   => json_encode($body),
        ];
        try {
            $response = $this->getRequestBody(self::GOOGLEDRIVE_OAUTH2_URL . '/token', $args);
            if (isset($response['access_token'])) {
                $options['accessToken']     = $response['access_token'];
                $options['expiresIn']       = $response['expires_in'];
                $options['isAuthenticated'] = true;
                $options['showNotice']      = false;
                return $this->saveOptions($options);
            }
        } catch (\Throwable $th) {
            debug_log('Failed to refresh token using user api credentials, error message: ' . $th->getMessage());
        }
        return false;
    }

    /**
     * @return string
     */
    public function getRedirectURI()
    {
        return $this->redirectURI;
    }

    /**
     * @return bool
     */
    public function refreshToken()
    {
        $options = $this->getOptions();
        if (empty($options['refreshToken'])) {
            return false;
        }

        $clientSecret = isset($options['googleClientSecret']) ? $options['googleClientSecret'] : '';
        if (empty($clientSecret)) {
            $refreshResult = $this->refreshAccessTokenRemotely();
        } else {
            $refreshResult = $this->refreshAccessToken();
        }

        return $refreshResult;
    }

    /**
     * This will refresh access token by calling our auth api
     *
     * @param  int $retry
     * @return bool
     */
    protected function refreshAccessTokenRemotely(int $retry = 0): bool
    {
        $options = $this->getOptions();
        if (empty($options['refreshToken'])) {
            return false;
        }

        $body = [
            'refresh_token' => $options['refreshToken'],
        ];
        $args = [
            'body'   => $body,
            'method' => 'POST',
        ];

        try {
            /**
             * @see https://developers.google.com/identity/protocols/oauth2/web-server#offline
             */
            $response     = $this->getRemoteRequest(self::REFRESH_URL, $args);
            $responseCode = wp_remote_retrieve_response_code($response);
            if ($responseCode === 403 && $retry < 1) {
                // sleep the code a few seconds before to retry in case the remote server (wpstg server) is overloaded.
                debug_log("Retrying to refresh token in few seconds");
                sleep(5);
                return $this->refreshAccessTokenRemotely(++$retry);
            }

            $responseBody = json_decode(wp_remote_retrieve_body($response), true);
            if (isset($responseBody['access_token'])) {
                $options['accessToken']     = $responseBody['access_token'];
                $options['expiresIn']       = $responseBody['expires_in'];
                $options['isAuthenticated'] = true;
                $options['showNotice']      = false;
                return $this->saveOptions($options);
            }
        } catch (\Throwable $th) {
            debug_log("Failed to refresh token on remote. Error message: " . $th->getMessage());
        }

        return false;
    }

    /**
     * Trim extra spaces from each folder name
     *
     * @param string $backupLocation
     * @return string
     */
    public function sanitizeGoogleDriveLocation($backupLocation)
    {
        $locationURI = $this->getFoldersFromLocation(trim($backupLocation, '/'));
        return implode('/', $locationURI);
    }

    /**
     * @see WPStaging\Pro\Backup\Task\Tasks\JobBackup\AbstractStorageTask::shouldCleanOldBackupsForRemoteUpload
     * @param string $file
     * @return bool
     */
    public function deleteFile(string $file): bool
    {
        $files = $this->getFiles();
        foreach ($files as $fileInfo) {
            if ($fileInfo['name'] === $file) {
                return $this->deleteRemoteFileById($fileInfo['id']);
            }
        }

        return false;
    }

    /**
     * @param string $fileId
     * @return bool
     */
    public function deleteRemoteFileById(string $fileId): bool
    {
        $options = $this->getOptions();
        if (empty($options['accessToken'])) {
            return false;
        }

        try {
            $args = [
                'headers' => [
                    'Authorization' => 'Bearer ' . $options['accessToken'],
                ],
                'method' => 'DELETE',
            ];
            $this->getRequestBody(self::GOOGLEDRIVE_API_V3_BASE_URL . "/files/{$fileId}", $args);
            return true;
        } catch (\Throwable $th) {
        }

        return false;
    }

    /**
     * @return void
     */
    private function showLoginIssueNotice()
    {
        $options               = $this->getOptions();
        $options['showNotice'] = true;

        parent::saveOptions($options);

        return;
    }

    /**
     * @return void
     */
    private function hideLoginIssueNotice()
    {
        $options               = $this->getOptions();
        $options['showNotice'] = false;

        parent::saveOptions($options);

        return;
    }
}
