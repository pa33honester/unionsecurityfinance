<?php

namespace WPStaging\Pro\Backup\Storage;

use Exception;
use WPStaging\Backend\Administrator;
use WPStaging\Framework\DI\ServiceProvider;
use WPStaging\Framework\Job\ProcessLock;
use WPStaging\Framework\Security\Auth;
use WPStaging\Framework\Utils\Sanitize;
use WPStaging\Pro\Backup\Storage\Storages\GoogleDrive\Auth as GoogleDriveStorage;
use WPStaging\Pro\Backup\Storage\Storages\Dropbox\Auth as DropboxStorage;
use WPStaging\Pro\Backup\Storage\Storages\OneDrive\Auth as OneDriveStorage;
use WPStaging\Pro\Backup\Ajax\Download;
use WPStaging\Pro\Backup\Ajax\CloudFileList;
use WPStaging\Pro\Backup\Ajax\CancelDownload;
use WPStaging\Pro\Backup\Task\Tasks\JobCloudDownload\AmazonS3DownloadTask;
use WPStaging\Pro\Backup\Storage\RemoteDownloaderInterface;
use WPStaging\Pro\Backup\Storage\Storages\Amazon\S3Downloader;
use WPStaging\Pro\Backup\Storage\Storages\DigitalOceanSpaces\Downloader as DigitalOceanDownloader;
use WPStaging\Pro\Backup\Storage\Storages\GenericS3\Downloader as GenericS3Downloader;
use WPStaging\Pro\Backup\Storage\Storages\Wasabi\Downloader as WasabiDownloader;
use WPStaging\Pro\Backup\Storage\Storages\GoogleDrive\Downloader as GoogleDriveDownloader;
use WPStaging\Pro\Backup\Storage\Storages\Dropbox\Downloader as DropboxDownloader;
use WPStaging\Pro\Backup\Storage\Storages\OneDrive\Downloader as OneDriveDownloader;
use WPStaging\Pro\Backup\Storage\Storages\SFTP\Downloader as SftpDownloader;
use WPStaging\Pro\Backup\Task\Tasks\JobCloudDownload\DigitalOceanSpacesDownloadTask;
use WPStaging\Pro\Backup\Task\Tasks\JobCloudDownload\GenericS3DownloadTask;
use WPStaging\Pro\Backup\Task\Tasks\JobCloudDownload\GoogleDriveDownloadTask;
use WPStaging\Pro\Backup\Task\Tasks\JobCloudDownload\DropboxDownloadTask;
use WPStaging\Pro\Backup\Task\Tasks\JobCloudDownload\OneDriveDownloadTask;
use WPStaging\Pro\Backup\Task\Tasks\JobCloudDownload\SFTPDownloadTask;
use WPStaging\Pro\Backup\Task\Tasks\JobCloudDownload\WasabiDownloadTask;

use function WPStaging\functions\debug_log;

class StoragesServiceProvider extends ServiceProvider
{
    protected function registerClasses()
    {
        $this->container->singleton(SettingsTab::class);

        $this->container->when(AmazonS3DownloadTask::class)
                        ->needs(RemoteDownloaderInterface::class)
                        ->give(S3Downloader::class);
        $this->container->when(DigitalOceanSpacesDownloadTask::class)
                        ->needs(RemoteDownloaderInterface::class)
                        ->give(DigitalOceanDownloader::class);
        $this->container->when(GenericS3DownloadTask::class)
                        ->needs(RemoteDownloaderInterface::class)
                        ->give(GenericS3Downloader::class);
        $this->container->when(GoogleDriveDownloadTask::class)
                        ->needs(RemoteDownloaderInterface::class)
                        ->give(GoogleDriveDownloader::class);
        $this->container->when(DropboxDownloadTask::class)
                        ->needs(RemoteDownloaderInterface::class)
                        ->give(DropboxDownloader::class);
        $this->container->when(OneDriveDownloadTask::class)
                        ->needs(RemoteDownloaderInterface::class)
                        ->give(OneDriveDownloader::class);
        $this->container->when(SFTPDownloadTask::class)
                        ->needs(RemoteDownloaderInterface::class)
                        ->give(SftpDownloader::class);
        $this->container->when(WasabiDownloadTask::class)
                        ->needs(RemoteDownloaderInterface::class)
                        ->give(WasabiDownloader::class);
    }

    protected function addHooks()
    {
        add_filter(Administrator::FILTER_MAIN_SETTING_TABS, $this->container->callback(SettingsTab::class, 'addRemoteStoragesSettingsTab'), 10, 1);
        add_action('admin_post_wpstg-googledrive-auth', $this->container->callback(GoogleDriveStorage::class, 'authenticate'), 10, 0); // phpcs:ignore WPStaging.Security.AuthorizationChecked
        add_action('admin_post_wpstg-googledrive-api-auth', $this->container->callback(GoogleDriveStorage::class, 'apiAuthenticate'), 10, 0); // phpcs:ignore WPStaging.Security.AuthorizationChecked
        add_action('wp_ajax_wpstg-provider-authenticate', $this->container->callback(StorageBase::class, 'authenticate'), 10, 0); // phpcs:ignore WPStaging.Security.AuthorizationChecked
        add_action('wp_ajax_wpstg-provider-revoke', $this->container->callback(StorageBase::class, 'revoke'), 10, 0); // phpcs:ignore WPStaging.Security.AuthorizationChecked
        add_action('wp_ajax_wpstg-provider-settings', $this->container->callback(StorageBase::class, 'updateSettings'), 10, 0); // phpcs:ignore WPStaging.Security.AuthorizationChecked
        add_action('wp_ajax_wpstg-provider-test-connection', $this->container->callback(StorageBase::class, 'testConnection'), 10, 0); // phpcs:ignore WPStaging.Security.AuthorizationChecked
        add_action('wpstg.all_admin_notices', $this->container->callback(GoogleDriveStorage::class, 'showAdminNotices'), 10, 0); // phpcs:ignore WPStaging.Security.AuthorizationChecked
        add_action('wpstg.all_admin_notices', $this->container->callback(DropboxStorage::class, 'showAdminNotices'), 10);// phpcs:ignore WPStaging.Security.AuthorizationChecked
        add_action('wpstg.all_admin_notices', $this->container->callback(OneDriveStorage::class, 'showAdminNotices'), 10);// phpcs:ignore WPStaging.Security.AuthorizationChecked
        add_action('admin_post_wpstg-dropbox-auth', $this->container->callback(DropboxStorage::class, 'authenticate'), 10, 0);// phpcs:ignore WPStaging.Security.AuthorizationChecked
        add_action('admin_post_wpstg-onedrive-auth', $this->container->callback(OneDriveStorage::class, 'authenticate'), 10, 0);// phpcs:ignore WPStaging.Security.AuthorizationChecked
        add_action('wp_ajax_wpstg--backups--download--cloud-backup', $this->container->callback(Download::class, 'render')); // phpcs:ignore WPStaging.Security.AuthorizationChecked
        add_action('wp_ajax_wpstg--backups--cloud--delete', $this->container->callback(CloudFileList::class, 'deleteCloudFile')); // phpcs:ignore WPStaging.Security.AuthorizationChecked
        add_action('wp_ajax_wpstg--backups--cloud--file-list', $this->container->callback(CloudFileList::class, 'render')); // phpcs:ignore WPStaging.Security.AuthorizationChecked
        add_action('wp_ajax_wpstg--storage--list', $this->container->callback(CloudFileList::class, 'getStorageList')); // phpcs:ignore WPStaging.Security.AuthorizationChecked
        add_action('wp_ajax_wpstg--download--cancel', $this->container->callback(CancelDownload::class, 'render')); // phpcs:ignore WPStaging.Security.AuthorizationChecked
        add_action('wp_ajax_wpstg-provider-delete-settings', $this->container->callback(StorageBase::class, 'deleteSettings'), 10, 0); // phpcs:ignore WPStaging.Security.AuthorizationChecked
    }
}
