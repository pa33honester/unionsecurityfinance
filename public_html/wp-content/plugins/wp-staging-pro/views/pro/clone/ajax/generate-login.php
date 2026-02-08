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
    <a href="#" class="wpstg-generate-login-link-action wpstg-clone-action" data-clone="<?php echo esc_attr($cloneID) ?>"
    data-name="<?php echo esc_attr($data['cloneName']) ?>" title="<?php echo esc_html__("Generate login link for the selected staging site.", "wp-staging") ?>">
        <?php esc_html_e("Share Login Link", "wp-staging"); ?>
    </a>
<?php else : ?>
    <a href="javascript:void(0)" class="wpstg-pro-clone-feature wpstg-pro-feature-disabled wpstg-clone-action"  title="<?php echo esc_html__("Activate the license first!", "wp-staging") ?>">
        <?php esc_html_e("Share Login Link", "wp-staging"); ?>
        <span class="wpstg--red-warning"><?php esc_html_e("(Unregistered)", "wp-staging"); ?></span>
    </a>
<?php endif;?>
