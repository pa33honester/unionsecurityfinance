<?php

use WPStaging\Core\WPStaging;
use WPStaging\Framework\Notices\Notices;
use WPStaging\Pro\License\Version;

/**
 * @var Version $outdatedNotice
 */
$outdatedNotice = WPStaging::make(Version::class);
if (isset($_GET['page']) && $_GET['page'] === 'wpstg_clone' || $_GET['page'] === 'wpstg_backup') {
    $display               = 'none;';
    $latestReleasedVersion = 'undefined';

    if (Notices::SHOW_ALL_NOTICES || $outdatedNotice->isOutdatedWpStagingProVersion()) {
        $latestReleasedVersion = $outdatedNotice->getLatestWpstgProVersion();
        $display = 'block;';
    }
    ?>
    <div id="wpstg-update-notify" style="display:<?php echo esc_attr($display); ?>">
        <strong><?php echo sprintf(esc_html__("New: WP Staging Pro v. %s is available.", 'wp-staging'), esc_html($latestReleasedVersion)); ?></strong><br/>
        <?php echo sprintf(esc_html__("Important: It's recommended to update the plugin before pushing a staging site to the live site. %sWhat's New?%s", 'wp-staging'), '<a href="https://wp-staging.com/wp-staging-pro-changelog/" target="_blank">', '</a>'); ?>
    </div>
<?php } ?>
