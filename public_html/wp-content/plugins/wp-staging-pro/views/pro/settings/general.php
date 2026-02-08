<?php

use WPStaging\Framework\Facades\Escape;
use WPStaging\Pro\WPStagingPro;

/**
 * @var \WPStaging\Core\Forms\Form $form
 */

?>
<?php if (WPStagingPro::isValidLicense()) : ?>
    <tr class="wpstg-settings-row">
        <td class="wpstg-settings-row th">
            <div class="col-title">
                <?php $form->renderLabel("wpstg_settings[keepPermalinks]"); ?>
                <span class="description">
                    <?php
                    echo wp_kses_post(sprintf(
                        __(
                            'Use on the staging site the same permalink structure and do not set permalinks to plain structure. <br/>Read more: <a href="%1$s" target="_blank">Permalink Settings</a> ',
                            'wp-staging'
                        ),
                        'https://wp-staging.com/docs/activate-permalinks-staging-site/'
                    )); ?>
                </span>
            </div>
        </td>
        <td>
            <?php $form->renderInput("wpstg_settings[keepPermalinks]"); ?>
        </td>
    </tr>
    <tr class="wpstg-settings-row">
        <td class="wpstg-settings-row th">
            <div class="col-title">
                <?php $form->renderLabel("wpstg_settings[userRoles][]"); ?>
                <span class="description">
                    <?php
                    echo Escape::escapeHtml(__(
                        'Select the user role you want to give access to the staging site. You can select multiple roles by holding CTRL or ⌘ Cmd key while clicking. <strong>Change this option on the staging site if you want to change the authentication behavior there.</strong>',
                        'wp-staging'
                    )); ?>
                </span>
            </div>
        </td>
        <td>
            <?php $form->renderInput("wpstg_settings[userRoles][]"); ?>
        </td>
    </tr>
    <tr class="wpstg-settings-row">
        <td class="wpstg-settings-row th">
            <div class="col-title">
                <?php $form->renderLabel("wpstg_settings[usersWithStagingAccess]"); ?>
                <span class="description">
                    <?php
                    echo Escape::escapeHtml(__(
                        'Specify users who will have access to the staging site regardless of their role. You can enter multiple user names separated by a comma. <strong>Change this option on the staging site if you want to change the authentication behavior there.</strong>',
                        'wp-staging'
                    )); ?>
                </span>
            </div>
        </td>
        <td>
            <?php $form->renderInput("wpstg_settings[usersWithStagingAccess]"); ?>
        </td>
    </tr>
    <tr class="wpstg-settings-row">
        <td class="wpstg-settings-row th">
            <div class="col-title">
                <?php $form->renderLabel("wpstg_settings[adminBarColor]"); ?>
                <span class="description">
                                    </span>
            </div>
        </td>
        <td>
            <?php $form->renderInput("wpstg_settings[adminBarColor]"); ?>
        </td>
    </tr>
    <tr class="wpstg-settings-row">
        <td class="wpstg-settings-row th">
            <div class="col-title">
                <strong><?php esc_html_e('Send Usage Information', 'wp-staging'); ?></strong>
                <span class="description">
                    <?php
                    esc_html_e('Send usage information to wp-staging.com.', 'wp-staging');
                    echo '<br>';
                    echo '<i>' . wp_kses_post(sprintf(__('See the data we collect <a href="%s" target="_blank">here</a>', 'wp-staging'), 'https://wp-staging.com/what-data-do-we-collect/')) . '</i>';
                    ?>
                </span>
            </div>
        </td>
        <td>
            <?php
            $analytics        = \WPStaging\Core\WPStaging::make(\WPStaging\Framework\Analytics\AnalyticsConsent::class);
            $analyticsAllowed = $analytics->hasUserConsent();
            $isAllowed        = $analyticsAllowed;
            $isDisallowed     = !$analyticsAllowed && !is_null($analyticsAllowed); // "null" means didn't answer, "false" means declined
            ?>
            <div style="font-weight:<?php echo $isAllowed ? 'bold' : ''; ?>"><a href="<?php echo esc_url($analytics->getConsentLink(true)) ?>"><?php echo esc_html__('Yes, send usage information. I\'d like to help improving this plugin.', 'wp-staging') ?></a></div>
            <div style="margin-top:10px;font-weight:<?php echo $isDisallowed ? 'bold' : ''; ?>"><a href="<?php echo esc_url($analytics->getConsentLink(false)) ?>"><?php echo esc_html__('No, Don\'t send any usage information.', 'wp-staging') ?></a></div>
            <?php
            ?>
        </td>
    </tr>
    <tr class="wpstg-settings-row">
        <td class="wpstg-settings-row th" colspan="2">
            <div class="col-title">
                <strong><?php
                    echo esc_html__('Backups', 'wp-staging') ?></strong>
                <span class="description"></span>
            </div>
        </td>
    </tr>
    <!-- Compressed Backups -->
    <tr class="wpstg-settings-row">
        <td class="wpstg-settings-row th">
            <div class="col-title">
                <?php
                $form->renderLabel("wpstg_settings[enableCompression]") ?>
                <span class="description">
                    <?php
                    echo esc_html__('This reduces backup size by up to 60%, making it especially useful for large databases.', 'wp-staging'); ?>
                </span>
            </div>
        </td>
        <td>
            <?php
            $form->renderInput("wpstg_settings[enableCompression]") ?>
        </td>
    </tr>
<?php endif;?>
