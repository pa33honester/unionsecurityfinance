<?php

use WPStaging\Core\WPStaging;
use WPStaging\Framework\Facades\Escape;

$backupFileName = '';
if (!empty($_GET['hash'])) {
    $backupFileHash                     = sanitize_text_field($_GET['hash']);
    list($backupFileUrl, $backupFileId) = explode(".backupid:", base64_decode($backupFileHash));
    $backupFileName                     = basename($backupFileUrl);
    if (substr($backupFileName, -6) !== '.wpstg') {
        $backupFileName = '';
        $backupFileId   = '';
    }
}

$downloadAttribute = 'download';
if (WPStaging::isOnWordPressPlayground()) {
    $downloadAttribute = 'target=_blank';
}

/**
 * @see WPStaging\Backend\Administrator::getRestorerPage
 *
 * @var object $license
 */
?>
<div class="wpstg_admin" id="wpstg-clonepage-wrapper">
<?php
    require_once(WPSTG_VIEWS_DIR . 'pro/_main/header.php');

    $isActiveRestorerPage = true;
    require_once(WPSTG_VIEWS_DIR . '_main/main-navigation.php');
?>
    <div class="wpstg-metabox-holder wpstg-restorer-wrapper">
        <div class="wpstg-restore-ui-callout">
            <?php if (isset($license->license) && $license->license === 'valid') : ?>
                <p>
                <h2>
                    <?php
                    esc_html_e('Download Restore Script', 'wp-staging');
                    if (!empty($backupFileName)) {
                        esc_html_e(' and Backup', 'wp-staging');
                    }

                    esc_html_e(' for Use on Another Website', 'wp-staging');
                    ?>
                </h2>
                </p>

                <form method="post" action="<?php echo esc_url(admin_url("admin-post.php?action=wpstg_download_restorer")); ?>">
                    <input type="submit" name="wpstg-download-restorer" id="wpstg-download-restorer" class="wpstg-button wpstg-blue-primary" value="<?php esc_html_e('Download Restore Script', 'wp-staging');?>">
                    <?php wp_nonce_field('wpstg_restorer_nonce', 'wpstg_restorer_nonce');?>
                    <?php if (!empty($backupFileName)) : ?>
                        <input type="hidden" name="backup-file-name" value="<?php echo esc_attr($backupFileName);?>">
                        <input type="hidden" name="backup-file-id" value="<?php echo esc_attr($backupFileId);?>">
                        <a <?php echo esc_attr($downloadAttribute);?> id="wpstg-download-restore-ui-backup" class="wpstg-button wpstg-blue-primary" href="<?php echo esc_url($backupFileUrl);?>"><?php esc_html_e('Download Linked Backup', 'wp-staging');?></a>
                    <?php endif; ?>
                </form>
            <p>
                <?php if (!empty($backupFileName)) : ?>
                    <li>
                        <?php printf(Escape::escapeHtml(__("<strong>Linked backup file:</strong> <code>%s</code>. <br><strong>Backup ID:</strong> <code>%s</code>.", 'wp-staging')), esc_html($backupFileName), esc_html($backupFileId));?>
                    </li>
                <?php endif; ?>
            </p>
                <p>
                <h2><?php esc_html_e('Or Install Restore Script on This Website', 'wp-staging');?></h2>
                </p>
                <p>
                <ul>
                    <li><?php printf(Escape::escapeHtml(__('Click the Install button below to create the WP Staging Restore file at:<br> <code>%s/wpstg-restore.php</code>.', 'wp-staging')), esc_url(get_site_url()));?></li>
                    <li><?php echo Escape::escapeHtml(__("<strong>Important:</strong> Delete the restore script file manually when it's no longer needed.", 'wp-staging'));?></li>
                </ul>
                <form method="post" action="<?php echo esc_url(admin_url("admin-post.php?action=wpstg_download_restorer")); ?>" target=_blank>
                    <input type="submit" name="wpstg-download-restorer" id="wpstg-download-restorer" class="wpstg-button wpstg-blue-primary" value="<?php esc_html_e('Install Restore Script on This Site', 'wp-staging');?>">
                    <?php wp_nonce_field('wpstg_restorer_nonce', 'wpstg_restorer_nonce');?>
                    <?php if (!empty($backupFileName)) : ?>
                        <input type="hidden" name="backup-file-name" value="<?php echo esc_attr($backupFileName);?>">
                        <input type="hidden" name="backup-file-id" value="<?php echo esc_attr($backupFileId);?>">
                    <?php endif; ?>
                    <input type="hidden" name="copy-to-current-site" value="<?php echo esc_url(get_site_url());?>">
                </form>
                </p>
            <?php else : ?>
                <form method="post" action="<?php echo esc_url(admin_url("admin-post.php?action=wpstg_download_restorer")); ?>">
                    <input type="submit" disabled name="wpstg-download-restorer" id="wpstg-download-restorer" class="wpstg-button wpstg-blue-primary" value="<?php esc_html_e('Download WP Staging Restore', 'wp-staging');?>">
                </form>
                <p class="wpstg-activate-restorer-license-message">
                    <?php printf(esc_html__('You need a valid license in order to download %s.', 'wp-staging'), 'WP Staging Restore');?>
                </p>
                <p>
                    <?php
                    printf(
                        Escape::escapeHtml(
                            __('Please <a href="%s">activate</a> your license key or buy one from <a href="%s" rel="noopener" target="new">wp-staging.com</a>', 'wp-staging')
                        ),
                        esc_url(get_admin_url()) . 'admin.php?page=wpstg-license',
                        'https://wp-staging.com/'
                    );
                    ?>
                </p>
            <?php endif; ?>
            <p>
                <?php
                printf(Escape::escapeHtml(
                    __('Read the <a href="%s" target="new" rel="noopener">docs.</a>', 'wp-staging')
                ), 'https://wp-staging.com/docs/wp-staging-restore/');?>
            </p>
        </div>
        <h2><?php esc_html_e('What is WP Staging | Restore?', 'wp-staging');?></h2>
        <p>
            <?php printf(esc_html__('%s is a standalone PHP script (For WP Staging Pro license holders).', 'wp-staging'), 'WP Staging Restore');?>
            <br>
            <?php printf(esc_html__('It operates independently from WordPress and can perform the following tasks:', 'wp-staging'), 'WP Staging Restore');?>
            <ul>
                <li><strong><?php esc_html_e('Extract backups: ', 'wp-staging'); ?></strong> <?php esc_html_e('Extract a backup to a chosen directory to inspect its contents or retrieve individual files.', 'wp-staging');?></li>
                <li><strong><?php esc_html_e('Restore backups:', 'wp-staging'); ?></strong> <?php esc_html_e('Restore a backup, even if your WordPress site is broken or cannot load.', 'wp-staging');?></li>
            <li><strong><?php esc_html_e('Install WordPress & Migrate to new server:', 'wp-staging'); ?></strong> <?php esc_html_e('Automatically install and configure WordPress on a new server, then restore your backup there.', 'wp-staging');?></li>
            </ul>
        </p>
            <h2><?php esc_html_e('How to use it:', 'wp-staging');?></h2>
        <p>
            <ul class="wpstg-how-to-use-restorer">
                <li><?php echo Escape::escapeHtml(__('Download the WP Staging Restore script: <code>wpstg-restore.php</code> (Optionally the linked backup file, as well.)', 'wp-staging')); ?></li>
                <li><?php esc_html_e("Upload at least the restore file to your website's root directory (e.g., using FTP). Optionally upload the backup file as well.", 'wp-staging');?></li>
                <li><?php echo Escape::escapeHtml(__('Open the uploaded file <code>https://yoursite.com/wpstg-restore.php</code> in your browser.', 'wp-staging')); ?></li>
                <li>
                    <?php echo Escape::escapeHtml(__('Log in to the Restore tool admin interface by entering your license key or the exact backup file name,', 'wp-staging')); ?>
                    <br>
                    <?php echo Escape::escapeHtml(__(' (for example: <code>yoursite.com.20250205-110721_c1d442862ad1.wpstg</code>)', 'wp-staging')); ?>
                </li>

            </ul>
        </p>
        <p>
            <strong><?php esc_html_e('WP Staging Restore searches for backup files in these locations:', 'wp-staging');?></strong>
            <ul>
                <li><?php esc_html_e('WordPress root directory.', 'wp-staging');?></li>
                <li><?php echo Escape::escapeHtml(__('WP Staging backup directory (default location: <code>wp-content/uploads/wp-staging/backups/</code>).', 'wp-staging')); ?></li>
                <?php if (!empty($backupFileName)) : ?>
                    <li><?php esc_html_e("If a linked backup file with a valid ID is found in your root directory, WP Staging Restore will automatically log you in.", 'wp-staging'); ?>
                    <br><?php printf(Escape::escapeHtml(__("<strong>Linked backup file:</strong> <code>%s</code>. <br><strong>Backup ID:</strong> <code>%s</code>.", 'wp-staging')), esc_html($backupFileName), esc_html($backupFileId));?>
                    </li>
                <?php endif; ?>
            </ul>
        </p>
    </div>
</div>
<?php
require_once(WPSTG_VIEWS_DIR . '_main/footer.php');
