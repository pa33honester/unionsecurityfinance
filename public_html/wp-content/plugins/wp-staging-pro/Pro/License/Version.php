<?php

namespace WPStaging\Pro\License;

use WPStaging\Core\WPStaging;

use function WPStaging\functions\debug_log;

class Version
{
    const TRANSIENT_NAME_DAILY_VERSION_UPDATE    = 'wpstg_daily_version_update';
    const TRANSIENT_NAME_WEEKLY_VERSION_UPDATE   = 'wpstg_weekly_version_update';
    const TRANSIENT_NAME_RATE_LIMIT_UPDATE_CHECK = 'wpstg_rate_limit_update_check';
    const OPTION_PRO_LATEST_VERSION              = 'wpstg_pro_latest_version';
    const LATEST_VERSION_URL                     = 'https://wp-staging.com/changelog/version.txt';

    /**
     * @var Licensing
     */
    private $licensing;

    /**
     * @param Licensing $licensing
     */
    public function __construct(Licensing $licensing)
    {
        // Load some hooks
        add_action('wpstg_daily_event', [$this, 'updateDailyLatestWPStagingVersion']);
        add_action('wpstg_weekly_event', [$this, 'updateWeeklyLatestWPStagingVersion']);

        // For testing the hooks above uncomment these lines
        // add_action('admin_init', [$this, 'updateDailyLatestWPStagingVersion']);
        // add_action('admin_init', [$this, 'updateWeeklyLatestWPStagingVersion']);

        // this is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
        if (!defined('WPSTG_STORE_URL')) {
            define('WPSTG_STORE_URL', 'https://wp-staging.com');
        }

        $this->licensing = $licensing;
    }

    /**
     * Get and store the latest WP Staging version every day.
     * Call only the wp-staging.com API daily if the license is valid and not expired.
     *
     * @access  public
     * @return  void
     * @since   2.0.3
     */
    public function updateDailyLatestWPStagingVersion()
    {
        // Bail if license is expired or invalid to reduce number of API requests to wp-staging.com
        if ($this->licensing->isInvalidOrExpiredLicenseKey()) {
            return;
        }

        if ($this->alreadyMadeApiRequest(DAY_IN_SECONDS, self::TRANSIENT_NAME_DAILY_VERSION_UPDATE)) {
            return;
        }

        $this->requestApiAndUpdateVersionNumber();
    }


    /**
     * Get and store the latest WP Staging version every 7 days for all licenses that are invalid or expired.
     *
     * @access  public
     * @return  void
     * @since   2.0.3
     */
    public function updateWeeklyLatestWPStagingVersion()
    {
        // Bail if license is valid to reduce number of API requests to wp-staging.com
        if (!$this->licensing->isInvalidOrExpiredLicenseKey()) {
            return;
        }

        if ($this->alreadyMadeApiRequest(WEEK_IN_SECONDS, self::TRANSIENT_NAME_WEEKLY_VERSION_UPDATE)) {
            return;
        }

        $this->requestApiAndUpdateVersionNumber();
    }

    /**
     * @param int $interval
     * @param string $transientName
     * @return bool
     */
    private function alreadyMadeApiRequest(int $interval, string $transientName): bool
    {
        $transient = get_transient($transientName);

        if ($transient) {
            return true;
        }

        set_transient($transientName, true, $interval);
        return false;
    }

    /**
     * @return void
     */
    private function requestApiAndUpdateVersionNumber()
    {
        $apiParams = [
            'edd_action' => 'get_version',
            'item_id'    => 11,
            'url'        => home_url()
        ];

        $response = wp_remote_post(
            WPSTG_STORE_URL,
            [
                'timeout'   => 15,
                'sslverify' => false,
                'body'      => $apiParams,
            ]
        );

        if (is_wp_error($response)) {
            debug_log('Version Check API Error: ' . $response->get_error_message());
            return;
        }

        $body    = wp_remote_retrieve_body($response);
        $headers = wp_remote_retrieve_headers($response);
        if (json_last_error() !== JSON_ERROR_NONE) {
            debug_log('Version Check API Invalid JSON response: ' . $body);
            return;
        }

        $license = json_decode($body);
        if (!$license || !isset($license->stable_version)) {
            debug_log('Version Check API Response Headers: ' . print_r($headers, true));
            debug_log('Version Check API Response Body: ' . $body);
            return;
        }

        update_option('wpstg_version_latest', $license->stable_version ?? '');
    }

    /**
     * Check if the current WP Staging version is outdated
     *
     * @return boolean
     */
    public function isOutdatedWpStagingProVersion()
    {

        $latestVersion = $this->getLatestWpstgProVersion();

        // If latest pro version is not available there is no need to update
        if ($latestVersion === null) {
            return false;
        }

        return version_compare($latestVersion, WPStaging::getVersion(), '>') ? true : false;
    }

    /**
     * Get the latest available WP STAGING PRO version
     *
     * @return string|null
     */
    public function getLatestWpstgProVersion()
    {
        // Early bail if there is already a transient
        if (get_transient(self::TRANSIENT_NAME_RATE_LIMIT_UPDATE_CHECK) !== false) {
            $latestVersion = get_option(self::OPTION_PRO_LATEST_VERSION, null);

            return $latestVersion;
        }

        set_transient(self::TRANSIENT_NAME_RATE_LIMIT_UPDATE_CHECK, true, DAY_IN_SECONDS);

        $response = wp_remote_get(self::LATEST_VERSION_URL);
        if (is_wp_error($response)) {
            debug_log('Error fetching version data: ' . $response->get_error_message());

            return null;
        }

        $body          = wp_remote_retrieve_body($response);
        $latestVersion = strtok($body, "\n");

        update_option(self::OPTION_PRO_LATEST_VERSION, $latestVersion, false);

        return $latestVersion;
    }
}
