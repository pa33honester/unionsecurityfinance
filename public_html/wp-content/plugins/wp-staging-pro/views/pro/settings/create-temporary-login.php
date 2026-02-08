<?php

use WPStaging\Framework\TemplateEngine\TemplateEngine;

/**
 * @see WPStaging\Pro\Auth\TemporaryLogins::ajaxLoadTemporaryLoginInterface
 * @var TemplateEngine $this
 * @var array $roleList
 * @var array $days
 * @var array $hours
 * @var array $minutes
 * @var array $loginData
 * @var array $expiry
 * @var bool $isUpdate
 */

$disabled = $isUpdate ? 'disabled' : '';
$loginID  = empty($loginData['loginID']) ? '' : $loginData['loginID'];
?>

<div class="temporary-logins-container">
    <h2>
        <?php
        if ($isUpdate) {
            esc_html_e('Update Temporary Login', 'wp-staging');
        } else {
            esc_html_e('Create Temporary Login', 'wp-staging');
        }
        ?>
    </h2>
    <div class="wpstg-temporary-login-form-group">
        <label for="wpstg-temporary-login-email" class="wpstg-temporary-login-label"><?php esc_html_e('Email', 'wp-staging') ?></label>
        <input id="wpstg-temporary-login-email" class="wpstg-temporary-login-input-field" type="email" name="wpstg-temporary-login-email" value="<?php echo empty($loginData['email']) ? '' : esc_attr($loginData['email']) ?>" <?php echo esc_attr($disabled) ?> />
        <input id="wpstg-temporary-login-id" type="hidden" value="<?php echo esc_attr($loginID) ?>" />
    </div>
    <div class="wpstg-temporary-login-form-group">
        <label for="wpstg-temporary-login-role" class="wpstg-temporary-login-label"><?php esc_html_e('Role', 'wp-staging') ?></label>
        <select class="wpstg-temporary-login-input-field" name="wpstg-temporary-login-role" id="wpstg-temporary-login-role">
            <?php foreach ($roleList as $roleKey => $roleName) : ?>
                <option value="<?php echo esc_attr($roleKey) ?>" <?php echo (!empty($loginData['role']) && ($roleKey === $loginData['role'])) ? 'selected' : ''; ?> >
                    <?php echo esc_html(translate_user_role($roleName)); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <label class="wpstg-temporary-login-label"><?php esc_html_e('Expiry', 'wp-staging') ?></label>
    <div class="wpstg-temporary-login-expiry-group">
        <select name="wpstg-temporary-login-days" id="wpstg-temporary-login-days" class="wpstg-temporary-login-input-field">
            <?php foreach ($days as $day) : ?>
                <option value="<?php echo esc_attr($day) ?>" <?php echo (!empty($expiry['days']) && ($day == $expiry['days'])) ? 'selected="selected"' : '' ?>>
                    <?php echo esc_html($day) . ' days'; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <select name="wpstg-temporary-login-hours" id="wpstg-temporary-login-hours" class="wpstg-temporary-login-input-field">
            <?php foreach ($hours as $hour) : ?>
                <option value="<?php echo esc_attr($hour) ?>" <?php echo (!empty($expiry['hours']) && ($hour == $expiry['hours'])) ? 'selected="selected"' : '' ?>>
                    <?php echo esc_html($hour) . ' hours'; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <select name="wpstg-temporary-login-minutes" id="wpstg-temporary-login-minutes" class="wpstg-temporary-login-input-field">
            <?php foreach ($minutes as $minute) : ?>
                <option value="<?php echo esc_attr($minute) ?>" <?php echo (!empty($expiry['minutes']) && ($minute == $expiry['minutes'])) ? 'selected="selected"' : '' ?>>
                    <?php echo esc_html($minute) . ' mins'; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
