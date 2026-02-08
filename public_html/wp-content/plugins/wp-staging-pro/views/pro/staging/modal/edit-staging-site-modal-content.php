<?php

/**
 * @var string $cloneId
 * @var \WPStaging\Staging\Dto\StagingSiteDto $stagingSite
 */

use WPStaging\Framework\Facades\UI\Checkbox;

?>
<form id="editStagingSiteForm" class="wpstg-edit-staging-site-form" name="editStagingSiteForm">
    <input type="hidden" id="wpstg-edit-clone-data-clone-id" name="cloneId" value="<?php echo esc_attr($cloneId); ?>">
    <div class="wpstg-form-row">
        <label id="wpstg-edit-clone-data-clone-name-label" for="wpstg-edit-clone-data-clone-name">
            <?php esc_html_e("Site Name", "wp-staging"); ?>
        </label>
        <input type="text" id="wpstg-edit-clone-data-clone-name" name="cloneName" value="<?php
        echo esc_attr($stagingSite->getCloneName()) ?>">
    </div>
    <div class="wpstg-form-row">
        <label id="wpstg-edit-clone-data-directory-name-label" for="wpstg-edit-clone-data-directory-name">
            <?php esc_html_e("Subdirectory Name", "wp-staging"); ?>
        </label>
        <input type="text" id="wpstg-edit-clone-data-directory-name" name="directoryName" value="<?php
        echo esc_attr($stagingSite->getDirectoryName()) ?>">
    </div>
    <div class="wpstg-form-row">
        <label id="wpstg-edit-clone-data-path-label" for="wpstg-edit-clone-data-path">
            <?php esc_html_e("Target Directory", "wp-staging"); ?>
        </label>
        <input type="text" id="wpstg-edit-clone-data-path" name="path" value="<?php
        echo esc_attr($stagingSite->getPath()) ?>">
    </div>
    <div class="wpstg-form-row">
        <label id="wpstg-edit-clone-data-url-label" for="wpstg-edit-clone-data-url">
            <?php esc_html_e("Target Hostname", "wp-staging"); ?>
        </label>
        <input type="text" id="wpstg-edit-clone-data-url" name="url" value="<?php
        echo esc_attr($stagingSite->getUrl()) ?>">
    </div>
    <div class="wpstg-form-row">
        <label id="wpstg-edit-clone-data-prefix-label" for="wpstg-edit-clone-data-prefix">
            <?php esc_html_e("Database Table Prefix", "wp-staging"); ?>
            <span class='wpstg--tooltip wpstg--tooltip-normal'>
                <?php $assetsUrl = trailingslashit(WPSTG_PLUGIN_URL); ?>
                <img class='wpstg--dashicons wpstg--grey wpstg-symlink-dir-tooltip' src='<?php echo esc_url($assetsUrl); ?>assets/svg/info-outline.svg' alt='info'/>
                <span class='wpstg--tooltiptext'>
                    <?php esc_html_e('This prefix is used if the staging site uses the same database as the production website.', 'wp-staging'); ?>
                </span>
            </span>
        </label>
        <input type="text" class="wpstg-edit-clone-db-inputs" id="wpstg-edit-clone-data-prefix" name="prefix" value="<?php
        echo esc_attr($stagingSite->getPrefix()) ?>">
    </div>
    <h4><?php esc_html_e('External Database Access Data', 'wp-staging'); ?></h4>
    <div class="wpstg-form-row">
        <?php esc_html_e("The values below are used when the staging site is created in an external,", "wp-staging"); ?>
        <br />
        <?php esc_html_e("separate database and not in the same one as the live site.", "wp-staging") ?>
    </div>
    <div class="wpstg--staging-site--edit--external-connection">
        <div class="wpstg-form-row">
            <label id="wpstg-edit-clone-data-database-user-label" for="wpstg-edit-clone-data-database-user">
                <?php esc_html_e("Database User", "wp-staging"); ?>
            </label>
            <input type="text" class="wpstg-edit-clone-db-inputs" id="wpstg-edit-clone-data-database-user" name="databaseUser" value="<?php
            echo esc_attr($stagingSite->getDatabaseUser()) ?>">
        </div>
        <div class="wpstg-form-row">
            <label id="wpstg-edit-clone-data-database-password-label" for="wpstg-edit-clone-data-database-password">
                <?php esc_html_e("Database Password", "wp-staging"); ?>
            </label>
            <input type="password" class="wpstg-edit-clone-db-inputs" id="wpstg-edit-clone-data-database-password" name="databasePassword" value="<?php
            echo esc_attr($stagingSite->getDatabasePassword()) ?>">
        </div>
        <div class="wpstg-form-row">
            <label id="wpstg-edit-clone-data-database-database-label" for="wpstg-edit-clone-data-database-database">
                <?php esc_html_e("Database Name", "wp-staging"); ?>
            </label>
            <input type="text" class="wpstg-edit-clone-db-inputs" id="wpstg-edit-clone-data-database-database" name="databaseDatabase" value="<?php
            echo esc_attr($stagingSite->getDatabaseDatabase()) ?>">
        </div>
        <div class="wpstg-form-row">
            <label id="wpstg-edit-clone-data-database-server-label" for="wpstg-edit-clone-data-database-server">
                <?php esc_html_e("Database Hostname", "wp-staging"); ?>
            </label>
            <input type="text" class="wpstg-edit-clone-db-inputs" id="wpstg-edit-clone-data-database-server" name="databaseServer" value="<?php
            echo esc_attr($stagingSite->getDatabaseServer()) ?>">
        </div>
        <div class="wpstg-form-row">
            <label id="wpstg-edit-clone-data-database-prefix-label" for="wpstg-edit-clone-data-database-prefix">
                <?php esc_html_e("Database Table Prefix", "wp-staging"); ?>
            </label>
            <input type="text" class="wpstg-edit-clone-db-inputs" id="wpstg-edit-clone-data-database-prefix" name="databasePrefix" value="<?php
            echo esc_attr($stagingSite->getDatabasePrefix()) ?>">
        </div>
        <div class="wpstg-form-row">
            <label id="wpstg-edit-clone-data-database-ssl-label" for="wpstg-edit-clone-data-database-ssl">
                <?php esc_html_e("Database Use SSL", "wp-staging"); ?>
            </label>
            <?php Checkbox::render('wpstg-edit-clone-data-database-ssl', 'databaseSsl', 'true', esc_attr($stagingSite->getDatabaseSsl())); ?>
        </div>
        <div class="wpstg-form-group wpstg-text-field wpstg-mt-20px">
            <span id="wpstg-db-connection-running"><?php esc_html_e("Testing db connection...", "wp-staging"); ?></span>
            <a href="javascript:void(0)" id="wpstg-test-db-connection"><?php esc_html_e("Test Database Connection", "wp-staging"); ?></a>
        </div>
    </div>
</form>
