<?php

/**
 * @var string $providerId
 */

use WPStaging\Framework\Facades\Escape;
use WPStaging\Pro\Backup\Storage\Storages\OneDrive\Auth;

?>
<fieldset>
    <?php
    /** @var Auth */
    $oneDriveStorage         = \WPStaging\Core\WPStaging::make(Auth::class);
    $isOneDriveAuthenticated = $oneDriveStorage->isAuthenticated();
    $options                 = $oneDriveStorage->getOptions();
    $maxBackupsToKeep        = isset($options['maxBackupsToKeep']) ? $options['maxBackupsToKeep'] : 2;
    $folderName              = isset($options['folderName']) ? $options['folderName'] : Auth::FOLDER_NAME;
    $lastUpdated             = empty($options['lastUpdated']) ? 0 : $options['lastUpdated'];
    ?>
    <p>
        <strong class="wpstg-fs-18"> <?php esc_html_e('Microsoft OneDrive', 'wp-staging'); ?></strong>
        <br/>
        <br/>
        <?php echo esc_html__('Upload backup files to your Microsoft OneDrive account.', 'wp-staging'); ?>
        <br>
        <?php echo sprintf(
            Escape::escapeHtml(__('Your backup data will not be sent to us! %s.', 'wp-staging')),
            '<a href="https://wp-staging.com/privacy-policy/#oneDrive" target="_blank">Our privacy policy</a>'
        ); ?>
    </p>
    <div class="wpstg-form-group">
        <?php
        if ($isOneDriveAuthenticated) {
            ?>
            <strong class="wpstg-mr-10px">
                <?php
                esc_html_e('You are authenticated to Microsoft OneDrive.', 'wp-staging');
                ?>
            </strong>
            <br>
            <form class="wpstg-provider-revoke-form" id="wpstg-provider-revoke-form" method="post">
                <input type="hidden" name="provider" value="<?php echo esc_attr($providerId); ?>" />
                <button type="button" id="wpstg-btn-provider-revoke" class="wpstg-button--primary wpstg-button--blue"><?php esc_html_e("Logout from Microsoft OneDrive", "wp-staging") ?></button>
            </form>
            <br/>
            <?php
        } else {
            $authURL = $oneDriveStorage->getAuthenticationURL();
            ?>
            <a href="<?php echo esc_url($authURL); ?>" class="wpstg-btn-onedrive">
                <img class="wpstg--dashicons" src="<?php echo esc_url(WPSTG_PLUGIN_URL . 'assets/svg/onedrive-sign-in.svg'); ?>" alt="<?php esc_attr_e("Sign in with Microsoft OneDrive", "wp-staging") ?>"/>
            </a>
            <?php
        }
        ?>
    </div>
    <?php if ($isOneDriveAuthenticated) : ?>
    <div class="wpstg-form-group">
        <form class="wpstg-provider-settings-form" id="wpstg-provider-settings-form" method="post">
            <input type="hidden" name="provider" value="<?php echo esc_attr($providerId); ?>" />
            <strong><?php esc_html_e('Upload Settings', 'wp-staging') ?></strong>
            <fieldset class="wpstg-fieldset">
                <label for="wpstg-storage-provider-<?php echo esc_attr($providerId); ?>-max-backups-to-keep"><?php esc_html_e('Max Backups to Keep', 'wp-staging') ?></label>
                <input id="wpstg-storage-provider-<?php echo esc_attr($providerId); ?>-max-backups-to-keep" class="wpstg-form-control wpstg-storage-backup-retention-field" type="number" name="max_backups_to_keep" value="<?php echo esc_attr($maxBackupsToKeep); ?>" min="1" />
            </fieldset>

            <fieldset class="wpstg-fieldset">
                <label for="wpstg-storage-provider-<?php echo esc_attr($providerId); ?>-folder-name"><?php esc_html_e('Backup Location', 'wp-staging') ?></label>
                <span>/</span><input id="wpstg-storage-provider-<?php echo esc_attr($providerId); ?>-folder-name" class="wpstg-form-control wpstg-storage-provider-input-field" type="text" placeholder="/backups" name="folder_name" value="<?php echo esc_attr($folderName); ?>" />
            </fieldset>
            <?php require_once WPSTG_VIEWS_DIR . "pro/settings/tabs/storages/storage-notice.php";?>
            <hr/>
            <div class="wpstg-storage-provider-action-container">
                <button type="button" id="wpstg-btn-save-provider-settings" class="wpstg-button wpstg-blue-primary"><?php esc_html_e("Save Settings", "wp-staging") ?></button><?php require_once WPSTG_VIEWS_DIR . "pro/settings/tabs/storages/last-saved-notice.php"; ?>
            </div>
        </form>
    </div>
    <?php endif;?>
</fieldset>
