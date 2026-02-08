<?php

/**
 * @var string $cloneID The ID of the clone.
 * @var array  $data    An array of Clone data.
 * @var $license
 * @var bool $isValidLicense
 *
 * @see src/views/clone/ajax/single-overview.php:62
 */

?>

<?php if ($isValidLicense) : ?>
    <a href="#" class="wpstg-clone-action wpstg--edit--staging-site" data-cloneId="<?php echo esc_attr($cloneID) ?>"
       title="<?php echo esc_html__("Edit data of the selected staging site. Reconnect a clone to production site after moving to another server and changing paths.", "wp-staging") ?>">
        <?php esc_html_e("Edit Data", "wp-staging"); ?>
    </a>
<?php else : ?>
    <a href="javascript:void(0)" class="wpstg-pro-clone-feature wpstg-pro-feature-disabled wpstg-clone-action"  title="<?php echo esc_html__("Activate the license first!", "wp-staging") ?>">
        <?php esc_html_e("Edit Data", "wp-staging"); ?>
        <span class="wpstg--red-warning"><?php esc_html_e("(Unregistered)", "wp-staging"); ?></span>
    </a>
<?php endif;?>
