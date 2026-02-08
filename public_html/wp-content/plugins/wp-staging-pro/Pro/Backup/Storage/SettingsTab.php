<?php

namespace WPStaging\Pro\Backup\Storage;

use WPStaging\Pro\WPStagingPro;

class SettingsTab
{
    /**
     * Add remote storage tab
     *
     * @filter wpstg_main_settings_tabs
     * @return array returns tabs in key and title format
     */
    public function addRemoteStoragesSettingsTab($tabs)
    {
        if (WPStagingPro::isValidLicense()) {
            $tabs['remote-storages'] = __("Storage Providers", "wp-staging");
        }

        return $tabs;
    }
}
