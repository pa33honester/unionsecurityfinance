<?php

namespace WPStaging\Pro;

use WPStaging\Core\WPStaging;
use WPStaging\Framework\DI\ServiceProvider;
use WPStaging\Framework\Facades\Hooks;
use WPStaging\Framework\Language\Language as FrameworkLanguage;
use WPStaging\Pro\Automations\PluginsUpdater\WordPressPluginsUpdater;
use WPStaging\Pro\Language\Language;

/**
 * A Service Provider to tell which services to register/bootstrap for the Pro feature.
 * Called at the start of bootstrapping process to make some feature available to the plugin.
 */
class ProServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function registerServiceProvider()
    {
        $this->container->register(BootstrapServiceProvider::class);
        $this->container->make(WPStagingPro::class);
        $this->container->make(WordPressPluginsUpdater::class);
    }

    /**
     * @return void
     */
    protected function addHooks()
    {
        Hooks::registerInternalHook(WPStaging::HOOK_BOOTSTRAP_SERVICES, [$this, 'registerServiceProvider']);
        Hooks::registerInternalHook(FrameworkLanguage::HOOK_LOAD_MO_FILES, $this->container->callback(Language::class, 'loadLanguage'));
    }

    /**
     * @return void
     */
    protected function registerClasses()
    {
        // This is to tell the container to use the PRO feature
        $this->container->setVar('WPSTG_BASIC', false);
    }
}
