<?php

namespace WPStaging\Pro\Staging;

use WPStaging\Backend\Modules\Jobs\Cloning;
use WPStaging\Backend\Pro\Modules\Jobs\CloningPro;
use WPStaging\Core\CloningJobProvider;
use WPStaging\Framework\DI\ServiceProvider;
use WPStaging\Pro\Staging\Ajax\Edit;
use WPStaging\Pro\Staging\Ajax\ExternalDatabase;
use WPStaging\Pro\Staging\Ajax\UserAccountSynchronizer;
use WPStaging\Pro\Staging\EmailReminder;
use WPStaging\Pro\Staging\Service\StagingSetup;
use WPStaging\Staging\Ajax\Setup;
use WPStaging\Staging\Service\AbstractStagingSetup;

/**
 * Used to register classes and hooks for the staging/cloning related services.
 */
class StagingServiceProvider extends ServiceProvider
{
    protected function registerClasses()
    {
        $this->container->make(UserAccountSynchronizer::class);
        $this->container->make(ExternalDatabase::class);

        $this->container->when(CloningJobProvider::class)
                        ->needs(Cloning::class)
                        ->give(CloningPro::class);

        $this->container->when(Setup::class)
                        ->needs(AbstractStagingSetup::class)
                        ->give(StagingSetup::class);
    }

    protected function addHooks()
    {
        add_action("wp_ajax_wpstg_sync_account", $this->container->callback(UserAccountSynchronizer::class, "ajaxSyncAccount")); // phpcs:ignore WPStaging.Security.AuthorizationChecked
        add_action("wp_ajax_wpstg_database_connect", $this->container->callback(ExternalDatabase::class, "ajaxDatabaseConnect")); // phpcs:ignore WPStaging.Security.AuthorizationChecked
        add_action("wp_ajax_wpstg_database_verification", $this->container->callback(ExternalDatabase::class, "ajaxDatabaseVerification")); // phpcs:ignore WPStaging.Security.AuthorizationChecked
        add_action('wpstg_daily_event', $this->container->callback(EmailReminder::class, "maybeSendEmailReminder"));
        add_action('admin_init', $this->container->callback(EmailReminder::class, "sendStagingEmailNotification"));
        add_action("admin_post_wpstg-disable-staging-reminder", $this->container->callback(EmailReminder::class, "disableRemindEmailPublicEndpoint")); // phpcs:ignore WPStaging.Security.AuthorizationChecked
        add_action("wp_ajax_wpstg_database_verify_grants", $this->container->callback(ExternalDatabase::class, "ajaxVerifyDatabaseGrants")); // phpcs:ignore WPStaging.Security.AuthorizationChecked
        $this->enqueueStagingAjaxListeners();
    }

    protected function enqueueStagingAjaxListeners()
    {
        add_action('wp_ajax_wpstg--staging-site--edit-modal', $this->container->callback(Edit::class, 'ajaxModalContent')); // phpcs:ignore WPStaging.Security.AuthorizationChecked
        add_action('wp_ajax_wpstg--staging-site--edit-save', $this->container->callback(Edit::class, 'ajaxSave')); // phpcs:ignore WPStaging.Security.AuthorizationChecked
    }
}
