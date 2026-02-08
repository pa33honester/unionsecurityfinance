<?php

namespace WPStaging\Pro\Auth;

use WPStaging\Core\WPStaging;
use WPStaging\Framework\Security\Capabilities;
use WPStaging\Framework\SiteInfo;
use WPStaging\Framework\Utils\Times;
use WPStaging\Staging\Sites;
use WPStaging\Framework\Rest\Rest;

require_once ABSPATH . 'wp-admin/includes/user.php'; // need for wp_delete_user();
require_once ABSPATH . 'wp-admin/includes/ms.php'; // need for wpmu_delete_user();

/**
 * @package WPStaging\Framework\Auth
 */
class LoginByLink
{
    /**
     * @var string
     */
    const LOGIN_LINK_PREFIX = 'wpstg_login_link_';

    /**
     * @var string
     */
    const WPSTG_SUPER_ADMIN_ROLE = 'wpstg_super_admin';

    /**
     * @var array
     */
    private $loginLinkData;

    /**
     * @var SiteInfo
     */
    private $siteInfo;

    /**
     * @var Times
     */
    private $times;

    /**
     * @var array
     */
    private $currentSiteLoginLinkData;

    /**
     * @var bool
     */
    private $isStagingSite;

    /**
     * @var bool
     */
    private $cleanTemporaryLogins;

    /**
     * @param SiteInfo $siteInfo
     * @param Times $times
     */
    public function __construct(SiteInfo $siteInfo, Times $times)
    {
        $this->loginLinkData = get_option(Sites::STAGING_LOGIN_LINK_SETTINGS, []);
        $this->siteInfo      = $siteInfo;
        $this->isStagingSite = $this->siteInfo->isStagingSite();
        $this->times         = $times;
        $this->defineHooks();
    }

    /**
     * Define Hooks
     */
    private function defineHooks()
    {
        static $isRegistered = false;
        if ($isRegistered) {
            return;
        }

        add_action("init", [$this, "loginUserByTemporaryLink"]);
        add_action("init", [$this, "disconnectNonExistingUser"]);
        add_action('rest_api_init', [$this, 'registerRestRoutes']);
        $isRegistered = true;
    }

    /**
     * Register routes for endpoints.
     *
     * @return void
     */
    public function registerRestRoutes()
    {
        register_rest_route(Rest::WPSTG_ROUTE_NAMESPACE_V1, '/check_magic_login', [
            'methods'             => \WP_REST_Server::READABLE,
            'callback'            => [$this, 'canUseMagicLogicEndpoint'],
            'permission_callback' => '__return_true',
        ]);
    }

    /**
     * @return \WP_REST_Response|\WP_Error
     */
    public function canUseMagicLogicEndpoint()
    {
        return rest_ensure_response(true);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function loginUserByLink()
    {
        $this->cleanTemporaryLogins = true;
        if (!isset($_GET['wpstg_login'])) {
            return;
        }

        $loginID = sanitize_text_field($_GET['wpstg_login']);
        $login   = self::LOGIN_LINK_PREFIX . $loginID;
        $user    = get_user_by('login', $login);
        $userId  = null;
        if (is_object($user)) {
            $userId = $user->ID;
        }

        $this->validateLoginLink($loginID, $userId);

        if (empty($userId)) {
            $role = $this->loginLinkData['role'];
            if ($this->loginLinkData['role'] === self::WPSTG_SUPER_ADMIN_ROLE) {
                $role = 'administrator'; // super admin is a privilege, let's give administrator role and then give privilege to the user.
            }

            $userId = wp_insert_user([
                'user_login' => $login,
                'user_pass'  => uniqid('wpstg'),
                'role'       => $role,
            ]);

            if (is_wp_error($userId)) {
                wp_die('Error creating user. Error: ' . $userId->get_error_message());
            }
        }

        $this->authenticateAndRedirect($userId);
    }

    /**
     * @return void
     */
    public function disconnectNonExistingUser()
    {
        if (!is_user_logged_in()) {
            return;
        }

        $currentUser = wp_get_current_user();
        $userData    = $currentUser->data;
        $loginID     = strpos($userData->user_login, self::LOGIN_LINK_PREFIX) === 0
            ? substr($userData->user_login, strlen(self::LOGIN_LINK_PREFIX))
            : false;

        if (empty($loginID)) {
            return;
        }

        if (!is_array($this->loginLinkData)) {
            return;
        }

        if (!in_array($loginID, $this->loginLinkData, true)) {
            return;
        }

        if (time() <= $this->loginLinkData['expiration']) {
            return;
        }

        $this->deleteUser($userData->ID);
        wp_logout();
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function loginUserByTemporaryLink()
    {
        if ($this->isStagingSite && !empty($_GET[TemporaryLogins::LOGIN_PREFIX])) {
            $this->loginUserByLink();
            return;
        }

        $this->currentSiteLoginLinkData = get_option(TemporaryLogins::OPTION_CURRENT_SITE_LOGIN_LINKS, []);
        $loginID = false;

        if ($this->isStagingSite && !empty($_GET[TemporaryLogins::STAGING_LOGIN_PREFIX])) {
            $loginID = sanitize_text_field($_GET[TemporaryLogins::STAGING_LOGIN_PREFIX]);
        }

        if (!$this->isStagingSite && !empty($_GET[TemporaryLogins::LOGIN_PREFIX])) {
            $loginID = sanitize_text_field($_GET[TemporaryLogins::LOGIN_PREFIX]);
        }

        if (!$loginID) {
            return;
        }

        $this->loginLinkData = [];
        if (count($this->currentSiteLoginLinkData) === 0) {
            return;
        }

        foreach ($this->currentSiteLoginLinkData as $loginData) {
            if ($loginData['loginID'] === $loginID) {
                $this->loginLinkData = $loginData;
                break;
            }
        }

        if (empty($this->loginLinkData['name'])) {
            return;
        }

        $user    = get_user_by('login', $this->loginLinkData['name']);
        $userId  = null;
        if (is_object($user)) {
            $userId = $user->ID;
        }

        $this->validateLoginLink($loginID, $userId);
        $this->authenticateAndRedirect($userId);
    }

    /**
     * @param  int $userID
     * @return void
     */
    private function deleteUser(int $userID)
    {
        if (is_multisite()) {
            wpmu_delete_user($userID);
        } else {
            wp_delete_user($userID);
        }
    }

    /**
     * @param  int|null $userId
     * @return void
     */
    private function cleanExistingLoginData($userId)
    {
        if (!$this->cleanTemporaryLogins) {
            return;
        }

        if (is_int($userId)) {
            $this->deleteUser($userId);
        }

        delete_option(Sites::STAGING_LOGIN_LINK_SETTINGS);
    }

    /**
     * @param int $userId
     * @return void
     * @throws \Exception
     */
    private function updateTemporaryLoginCounter(int $userId)
    {
        if (count($this->currentSiteLoginLinkData) === 0) {
            return;
        }

        foreach ($this->currentSiteLoginLinkData as $key => $loginData) {
            if ($loginData['userId'] !== $userId) {
                continue;
            }

            $this->currentSiteLoginLinkData[$key]['attempts']  = empty($loginData['attempts']) ? 1 : (int)$loginData['attempts'] + 1;
            $this->currentSiteLoginLinkData[$key]['lastLogin'] = $this->times->getCurrentTimestamp();
        }

        update_option(TemporaryLogins::OPTION_CURRENT_SITE_LOGIN_LINKS, $this->currentSiteLoginLinkData);
    }

    /**
     * @param string $loginID
     * @param $userId
     * @return void
     */
    private function validateLoginLink(string $loginID, $userId)
    {
        $errorMessage = wp_kses(
            __(
                "The login link has been expired. If you just created a staging site, open it again from <b>WP Staging -> Staging Sites -> Actions -> Open</b>. <br><br>
                If you want to create a new login link go to <b>WP Staging -> Staging Sites -> Actions -> Share Login Link</b>. <br><br>",
                'wp-staging'
            ),
            [
                'b'  => [],
                'br' => [],
            ]
        );


        if (!in_array($loginID, $this->loginLinkData, true)) {
            $this->cleanExistingLoginData($userId);
            $errorMessage .= __("Error code: ", 'wp-staging');
            $errorMessage .= "101";
            wp_die(wp_kses_post($errorMessage));
        }

        if (empty($this->loginLinkData['expiration'])) {
            $this->cleanExistingLoginData($userId);
            $errorMessage .= __("Error code: ", 'wp-staging');
            $errorMessage .= "102";
            wp_die(wp_kses_post($errorMessage));
        }

        if (time() > $this->loginLinkData['expiration']) {
            $this->cleanExistingLoginData($userId);
            $errorMessage .= __("Error code: ", 'wp-staging');
            $errorMessage .= "103";
            wp_die(wp_kses_post($errorMessage));
        }
    }

    /**
     * @param int $userId
     * @return void
     * @throws \Exception
     */
    private function authenticateAndRedirect($userId)
    {
        if (!is_int($userId)) {
            wp_die('Something went wrong, please contact the administrator.');
        }

        if (is_multisite() && ($this->loginLinkData['role'] === self::WPSTG_SUPER_ADMIN_ROLE)) {
            grant_super_admin($userId);
        }

        wp_clear_auth_cookie();
        wp_set_current_user($userId);
        wp_set_auth_cookie($userId);
        if (!$this->cleanTemporaryLogins) {
            $this->updateTemporaryLoginCounter($userId);
        }

        if ($this->loginLinkData['role'] === Capabilities::WPSTG_VISITOR_ROLE) {
            wp_redirect(home_url());
            return;
        }

        wp_redirect(admin_url());
    }
}
