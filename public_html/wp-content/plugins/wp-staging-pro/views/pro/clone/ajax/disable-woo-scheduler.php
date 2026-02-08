<?php

/**
 * This file is currently called in:
 * src/views/pro/clone/ajax/scan.php
 *
 * @var \WPStaging\Backend\Modules\Jobs\Scan $scan
 * @var \stdClass                            $options
 * @var bool                                 $isPro
 *
 * @see \WPStaging\Backend\Modules\Jobs\Scan::start For details on $options.
 */

use WPStaging\Framework\Facades\UI\Checkbox;

// unchecked by default.
$wooSchedulerDisabled = false;

// Only change default check status when clone options exists plugin is PRO
if (!empty($options->current)) {
    $wooSchedulerDisabled = isset($options->existingClones[$options->current]['wooSchedulerDisabled']) ? (bool) $options->existingClones[$options->current]['wooSchedulerDisabled'] : $wooSchedulerDisabled;
}

?>
<div class="wpstg--advanced-settings--checkbox">
    <label for="wpstg_woo_scheduler_disabled"><?php esc_html_e('Disable WooCommerce Scheduler', 'wp-staging'); ?></label>
    <?php Checkbox::render('wpstg_woo_scheduler_disabled', 'wpstg_woo_scheduler_disabled', 'false', $wooSchedulerDisabled); ?>
    <span class="wpstg--tooltip">
        <img class="wpstg--dashicons" src="<?php echo esc_url($scan->getInfoIcon()); ?>" alt="info" />
        <span class="wpstg--tooltiptext">
            <?php esc_html_e('Disable WooCommerce Action Scheduler.', 'wp-staging'); ?>
            <br /> <br />
            <b><?php esc_html_e('Note', 'wp-staging') ?>: </b> <?php echo sprintf(esc_html__('Disable WooCommerce Action Scheduler/Subscriptions on a staging site. %s.', 'wp-staging'), '<a href="https://wp-staging.com/docs/how-to-disable-woocommerce-subscriptions-on-a-staging-site/" target="_blank" rel="external">Read more about that here</a>'); ?>
        </span>
    </span>
</div>
