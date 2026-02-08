<?php

namespace WPStaging\Pro\Auth;

use WPStaging\Framework\Adapter\DatabaseInterface;
use WPStaging\Framework\Component\AbstractTemplateComponent;
use WPStaging\Framework\Security\Auth;
use WPStaging\Framework\Security\Capabilities;
use WPStaging\Framework\SiteInfo;
use WPStaging\Framework\TemplateEngine\TemplateEngine;
use WPStaging\Framework\Facades\Sanitize;
use WPStaging\Framework\Utils\Times;
use WPStaging\Pro\License\Licensing;
use WPStaging\Staging\Sites;

/**
 * Class TemporaryLogins
 *
 * This class is responsible for managing temporary user logins.
 * Temporary logins are generated without requiring a password, based on their email, roles and link expiration.
 * Key functionalities include creating, updating, and deleting of temporary logins.
 *
 * @package WPStaging\Pro\Auth
 * @see /WPStaging/Pro/Auth/AuthServiceProvider
 * @see /WPStaging/Pro/Auth/LoginByLink
 */
class TemporaryLogins extends AbstractTemplateComponent
{
    /**
     * The option that stores current site login link settings
     * @var  string
     */
    const OPTION_CURRENT_SITE_LOGIN_LINKS = 'wpstg_current_site_login_links';

    /**
     * @var string
     */
    const LOGIN_LINK_PREFIX = 'wpstgtmpuser';

    /**
     * @var string
     */
    const LOGIN_PREFIX = 'wpstg_login';

    /**
     * @var string
     */
    const STAGING_LOGIN_PREFIX = 'wpstg_staging_login';

    /**
     * @var int
     */
    const SECONDS_IN_DAY = 60 * 60 * 24;

    /**
     * @var int
     */
    const SECONDS_IN_HOUR = 60 * 60;

    /**
     * @var int
     */
    const SECONDS_IN_MINUTE = 60;

    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var DatabaseInterface
     */
    private $database;

    /**
     * @var array
     */
    private $loginLinkSettings = [];

    /**
     * @var \DateTime
     */
    private $datetime;

    /**
     * @var bool
     */
    private $isUserLoggedInByLink = false;

    /**
     * @var Times
     */
    private $times;

    /**
     * @var string[]
     */
    private $roles;

    /**
     * @var SiteInfo
     */
    private $siteInfo;

    /**
     * @var bool
     */
    private $isStagingSite;

    /**
     * @var Licensing
     */
    private $licensing;

    /**
     * @var bool
     */
    private $isAgencyOrDeveloper;

    /**
     * @param Auth $auth
     * @param TemplateEngine $templateEngine
     * @param Times $times
     * @param SiteInfo $siteInfo
     * @param DatabaseInterface $database
     * @param Licensing $licensing
     * @throws \Exception
     */
    public function __construct(Auth $auth, TemplateEngine $templateEngine, Times $times, SiteInfo $siteInfo, DatabaseInterface $database, Licensing $licensing)
    {
        parent::__construct($templateEngine);
        $this->auth                = $auth;
        $this->database            = $database;
        $this->datetime            = new \DateTime();
        $this->times               = $times;
        $this->roles               = wp_roles()->get_names();
        $this->siteInfo            = $siteInfo;
        $this->isStagingSite       = $this->siteInfo->isStagingSite();
        $this->licensing           = $licensing;
        $this->isAgencyOrDeveloper = $this->licensing->isAgencyOrDeveloperPlan();

        if (is_multisite()) {
            $this->roles[LoginByLink::WPSTG_SUPER_ADMIN_ROLE] = esc_html('Super Admin');
        }

        $this->getOption();
        $this->isUserLoggedInByLink();
    }

    /**
     * @param $wpAdminBar
     * @return void
     */
    public function mayBeShowTemporaryLoginTab($wpAdminBar)
    {
        if (!$this->isUserLoggedInByLink) {
            return;
        }

        $wpAdminBar->add_menu(
            [
                'id'     => 'wpstg-temporay-access',
                'parent' => 'top-secondary',
                'title'  => __('Temp Access', 'wp-staging'),
                'meta'   => [
                        'class' => 'wpstg-temporary-login-tab'
                    ]
            ]
        );
    }

    /**
     * @return void
     */
    public function ajaxLoadTemporaryLoginInterface()
    {
        if (!$this->auth->isAuthenticatedRequest() || $this->isUserLoggedInByLink) {
            return;
        }

        if (!$this->isAgencyOrDeveloper) {
            wp_send_json_error(['message' => esc_html__('You need a WP Staging developer plan or higher. Please upgrade your license.', 'wp-staging')]);
        }

        $result = $this->templateEngine->render(
            'pro/settings/create-temporary-login.php',
            [
                'roleList'  => $this->roles,
                'days'      => range(0, 10),
                'hours'     => range(0, 23),
                'minutes'   => range(0, 55, 5),
                'loginData' => [],
                'expiry'    => [],
                'isUpdate'  => false
            ]
        );

        wp_send_json($result);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function ajaxLoadUpdateTemporaryLoginInterface()
    {
        if (!$this->auth->isAuthenticatedRequest() || $this->isUserLoggedInByLink || empty($_POST['loginID']) || !$this->isAgencyOrDeveloper) {
            wp_send_json_error();
        }

        $loginID   = Sanitize::sanitizeString($_POST['loginID']);
        $loginData = $this->getTemporaryLoginData($loginID);
        if (empty($loginData)) {
            wp_send_json_error();
        }

        $minutes = range(0, 55, 5);
        $expiry  = $this->convertTimestampToArray($loginData['expiration']);

        if (!in_array($expiry['minutes'], $minutes)) {
            $minutes[] = $expiry['minutes'];
            sort($minutes);
        }

        $result = $this->templateEngine->render(
            'pro/settings/create-temporary-login.php',
            [
                'roleList'  => $this->roles,
                'days'      => range(0, 10),
                'hours'     => range(0, 23),
                'minutes'   => $minutes,
                'loginData' => $loginData,
                'expiry'    => $expiry,
                'isUpdate'  => true
            ]
        );

        wp_send_json($result);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function ajaxGetTemporaryLoginsData()
    {
        if (!$this->auth->isAuthenticatedRequest() || $this->isUserLoggedInByLink || !$this->isAgencyOrDeveloper) {
            return;
        }

        $temporaryLoginsData = $this->getTemporaryLogins();
        $stagingLoginsData   = $this->getStagingLoginLinks();
        if (count($stagingLoginsData) > 0) {
            $temporaryLoginsData[] = $stagingLoginsData;
        }

        $result = $this->templateEngine->render(
            'pro/settings/list-temporary-logins.php',
            [
                'temporaryLoginsData' => $temporaryLoginsData,
                'urlAssets'           => trailingslashit(WPSTG_PLUGIN_URL) . 'assets/'
            ]
        );

        wp_send_json($result);
    }

    /**
     * @return void
     */
    public function ajaxRemoveTemporaryLoginsData()
    {
        if (!$this->auth->isAuthenticatedRequest() || empty($_POST['loginID']) || !current_user_can('manage_options')) {
            wp_send_json_error();
        }

        $loginID = Sanitize::sanitizeString($_POST['loginID']);

        $this->removeTemporaryUser($loginID);

        wp_send_json_error();
    }

    /**
     * @return void
     */
    public function ajaxSaveTemporaryLoginData()
    {
        if (!$this->auth->isAuthenticatedRequest()) {
            return;
        }


        $this->mayBeUpdateLoginLink();
        $result = $this->init();
        if ($result === false) {
            wp_send_json_error(['message' => esc_html__('Failed to create temporary login!', 'wp-staging')]);
        }

        wp_send_json_success(['message' => esc_html__('Login Link created successfully!', 'wp-staging')]);
    }

    /**
     * @return void
     */
    public function addTemporaryLoginTabCss()
    {
        if (!$this->isUserLoggedInByLink) {
            return;
        }

        $bgColor = $this->isStagingSite ? '#1d2327' : '#ea9f33';
        ?>
        <style>
            .wpstg-temporary-login-tab .ab-item, .wpstg-temporary-login-tab .ab-item:hover {
                background-color: <?php echo esc_attr($bgColor); ?> !important;
                color: #fff !important;
            }
        </style>
        <?php
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function mayBeLogoutTemporaryUser()
    {
        if (!is_user_logged_in()) {
            return;
        }

        $currentUserID    = wp_get_current_user()->ID;
        $loggedInUserData = array_filter($this->loginLinkSettings, function ($loginLinkData) use ($currentUserID) {
            return $loginLinkData['userId'] === $currentUserID;
        });

        $this->isUserLoggedInByLink = !empty($loggedInUserData);

        if ($this->isUserLoggedInByLink === false) {
            return;
        }

        $loggedInUserData        = end($loggedInUserData);
        $timeDifferenceInSeconds = $loggedInUserData['expiration'] - $this->times->getCurrentTimestamp();

        if ($timeDifferenceInSeconds > 0) {
            return;
        }

        wp_logout();
        wp_redirect(wp_login_url());
    }

    /**
     * @return void
     */
    protected function mayBeUpdateLoginLink()
    {
        if (empty($_POST['loginID'])) {
            return;
        }

        $loginID = empty($_POST['loginID']) ? '' : Sanitize::sanitizeString($_POST['loginID']);
        $role    = empty($_POST['role']) ? '' :  Sanitize::sanitizeString($_POST['role']);
        if (empty($loginID) || empty($role)) {
            wp_send_json_error(['message' => esc_html__('Failed to update temporary login!', 'wp-staging')]);
        }

        $expiration = $this->calculateExpiration();
        if (!$expiration) {
            wp_send_json_error(['message' => esc_html__('Failed to update temporary login!', 'wp-staging')]);
        }

        $userId = '';
        foreach ($this->loginLinkSettings as $key => $loginLinkData) {
            if ($loginLinkData['loginID'] === $loginID) {
                $this->loginLinkSettings[$key]['role']       = $role;
                $this->loginLinkSettings[$key]['expiration'] = $expiration;
                $userId                                      = $loginLinkData['userId'];
            }
        }

        if (empty($userId)) {
            wp_send_json_error(['message' => esc_html__('Failed to update temporary login!', 'wp-staging')]);
        }

        if (is_multisite() && $role === LoginByLink::WPSTG_SUPER_ADMIN_ROLE) {
            $role = 'administrator';
        }

        $this->updateUserRole($userId, $role);
        $result = $this->saveData();
        if ($result === false) {
            wp_send_json_error(['message' => esc_html__('Failed to update temporary login!', 'wp-staging')]);
        }

        wp_send_json_success(['message' => esc_html__('Login link updated successfully!', 'wp-staging')]);
    }

    /**
     * @return bool|\mysqli_result|resource
     */
    protected function init()
    {
        if (!empty($_POST['loginID'])) {
            return false;
        }

        if (empty($_POST['role']) || empty($_POST['uniqueId']) || empty($_POST['email'])) {
            return false;
        }

        $email      = Sanitize::sanitizeString($_POST['email']);
        $role       = Sanitize::sanitizeString($_POST['role']);
        $uniqueId   = Sanitize::sanitizeString($_POST['uniqueId']);
        $expiration = $this->calculateExpiration();

        if (!$expiration) {
            return false;
        }

        $tempUserName = self::LOGIN_LINK_PREFIX . $this->getTemporaryUserID();
        $userRole     = $role;
        if (is_multisite() && $role === LoginByLink::WPSTG_SUPER_ADMIN_ROLE) {
            $userRole = 'administrator';
        }

        $userId = $this->createTemporaryUser($email, $userRole, $tempUserName);
        if (!$userId) {
            return false;
        }

        $this->loginLinkSettings[] = [
            'name'       => $tempUserName,
            'email'      => $email,
            'role'       => $role,
            'loginID'    => $uniqueId,
            'expiration' => $expiration,
            'userId'     => $userId,
            'attempts'   => 0,
            'lastLogin'  => null
        ];

        return $this->saveData();
    }

    /**
     * @return false|int
     */
    protected function calculateExpiration()
    {
        $days    = empty($_POST['days']) ? 0 : Sanitize::sanitizeString($_POST['days']);
        $hours   = empty($_POST['hours']) ? 0 : Sanitize::sanitizeInt($_POST['hours']);
        $minutes = empty($_POST['minutes']) ? 0 : Sanitize::sanitizeInt($_POST['minutes']);

        return strtotime("+$days days +$hours hours +$minutes minutes");
    }

    /**
     * @param string $email
     * @param string $role
     * @param string $tempUserName
     * @return int
     */
    protected function createTemporaryUser(string $email, string $role, string $tempUserName)
    {
        $userId = wp_insert_user([
            'user_login' => $tempUserName,
            'user_pass'  => uniqid('wpstg'),
            'role'       => $role,
            'user_email' => $email,
        ]);

        if (is_wp_error($userId)) {
            wp_send_json_error(['message' => esc_html($userId->get_error_message())]);
        }

        return $userId;
    }

    /**
     * @param int $userId
     * @param string $role
     * @return bool
     */
    protected function updateUserRole(int $userId, string $role): bool
    {
        $user = get_userdata($userId);
        if (!$user) {
            return false;
        }

        $user->set_role($role);

        return in_array($role, $user->roles);
    }


    /**
     * @return bool|\mysqli_result|resource
     */
    protected function saveData()
    {
        $optionName     = self::OPTION_CURRENT_SITE_LOGIN_LINKS;
        $serializedData = serialize($this->loginLinkSettings);
        $tableName      = $this->database->getPrefix() . 'options';

        $result = $this->database->getClient()->query("SELECT option_value FROM `$tableName` WHERE option_name = '$optionName'");

        if ($result && $result->num_rows > 0) {
            return $this->database->getClient()->query("UPDATE `$tableName` SET option_value = '$serializedData' WHERE option_name = '$optionName'");
        }

        return $this->database->getClient()->query("INSERT INTO `$tableName` (option_name, option_value) VALUES ('$optionName', '$serializedData')");
    }

    /**
     * @return array
     */
    protected function getTemporaryLogins(): array
    {
        if (empty($this->loginLinkSettings)) {
            return [];
        }

        return array_map([$this, 'formatTemporaryUser'], $this->loginLinkSettings);
    }

    /**
     * @param array $loginLinkData
     * @return array
     * @throws \Exception
     */
    protected function formatTemporaryUser(array $loginLinkData): array
    {
        $user = get_userdata($loginLinkData['userId']);
        if (!$user) {
            $this->cleanExistingLoginData($loginLinkData['userId']);
            return [];
        }

        $lastLogin = empty($loginLinkData['lastLogin']) ? 'Not Logged In' : $this->datetime->setTimestamp($loginLinkData['lastLogin'])->format('Y-m-d g:i:s A');
        $isExpired = $this->times->getCurrentTimestamp() > $loginLinkData['expiration'];
        $roles     = implode(', ', $user->roles);
        if (array_key_exists($loginLinkData['role'], $this->roles)) {
            $roles = $this->roles[$loginLinkData['role']];
        }

        $loginPrefix = $this->isStagingSite ? self::STAGING_LOGIN_PREFIX : self::LOGIN_PREFIX;
        $loginLink   = home_url() . '/wp-login.php?' . $loginPrefix . '=' . $loginLinkData['loginID'];

        return [
            'id'            => $user->ID,
            'user_login'    => $user->user_login,
            'user_email'    => $user->user_email,
            'display_name'  => $user->display_name,
            'roles'         => $roles,
            'expiration'    => date('F j, Y \a\t H:i:s', $loginLinkData['expiration']),
            'loginLink'     => $loginLink,
            'isExpired'     => $isExpired,
            'loginAttempts' => empty($loginLinkData['attempts']) ? 0 : $loginLinkData['attempts'],
            'lastLogin'     => $lastLogin,
        ];
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function isUserLoggedInByLink()
    {
        if (!is_user_logged_in()) {
            return;
        }

        $currentUserID    = wp_get_current_user()->ID;
        $loggedInUserData = array_filter($this->loginLinkSettings, function ($loginLinkData) use ($currentUserID) {
            return $loginLinkData['userId'] === $currentUserID;
        });

        $this->isUserLoggedInByLink = !empty($loggedInUserData);
    }

    /**
     * @param int $userID
     * @return void
     */
    protected function removeTemporaryUser(int $userID)
    {
        $user = get_userdata($userID);
        if (!$user) {
            wp_send_json_error(['message' => esc_html__('User does not exist.', 'wp-staging')]);
        }

        if (!$this->isTemporaryUser($userID, $user->user_login)) {
            wp_send_json_error(['message' => esc_html__('You are not allowed to delete this user.', 'wp-staging')]);
        }

        if (is_super_admin($userID)) {
            revoke_super_admin($userID);
        }

        is_multisite() ? wpmu_delete_user($userID) : wp_delete_user($userID);
        $this->cleanExistingLoginData($userID);
        wp_send_json_success(['message' => esc_html__('Temporary user deleted successfully.', 'wp-staging')]);
    }

    /**
     * Verify if a user is a temporary user
     * @param int $userID
     * @param string $userName
     * @return bool
     */
    protected function isTemporaryUser(int $userID, string $userName): bool
    {
        if (strpos($userName, self::LOGIN_LINK_PREFIX) !== 0) {
            return false;
        }

        foreach ($this->loginLinkSettings as $loginLinkData) {
            if ($loginLinkData['userId'] === $userID) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param int $userID
     * @return void
     */
    protected function cleanExistingLoginData(int $userID)
    {
        $this->loginLinkSettings = array_filter($this->loginLinkSettings, function ($loginLinkData) use ($userID) {
            return $loginLinkData['userId'] !== $userID;
        });

        update_option(self::OPTION_CURRENT_SITE_LOGIN_LINKS, $this->loginLinkSettings);
    }

    /**
     * @param int $userID
     * @return array
     */
    protected function getTemporaryLoginData(int $userID): array
    {
        $this->loginLinkSettings = array_filter($this->loginLinkSettings, function ($loginLinkData) use ($userID) {
            return $loginLinkData['userId'] === $userID;
        });

        if (count($this->loginLinkSettings) === 0) {
            return [];
        }

        return end($this->loginLinkSettings);
    }

    /**
     * Return expiration of login link in days hours and minutes
     * @param $timestamp
     * @return array
     * @throws \Exception
     */
    protected function convertTimestampToArray($timestamp): array
    {
        $currentTime             = $this->times->getCurrentTimestamp();
        $timeDifferenceInSeconds = $timestamp - $currentTime;

        if ($timeDifferenceInSeconds < 0) {
            return [
                'days'    => 0,
                'hours'   => 0,
                'minutes' => 0
            ];
        }

        $days             = floor($timeDifferenceInSeconds / self::SECONDS_IN_DAY);
        $remainingSeconds = $timeDifferenceInSeconds % self::SECONDS_IN_DAY;

        $hours            = floor($remainingSeconds / self::SECONDS_IN_HOUR);
        $remainingSeconds = $remainingSeconds % self::SECONDS_IN_HOUR;

        $minutes = floor($remainingSeconds / self::SECONDS_IN_MINUTE);

        return [
            'days'    => $days,
            'hours'   => $hours,
            'minutes' => $minutes
        ];
    }

    /**
     * @return int
     */
    private function getTemporaryUserID(): int
    {
        $tableName = $this->database->getPrefix() . 'users';
        $result    = $this->database->getClient()->query("SELECT ID FROM `$tableName` ORDER BY ID DESC LIMIT 1");

        if ($result && $result->num_rows > 0) {
            $row          = $this->database->getClient()->fetchAssoc($result);
            $latestUserID = $row['ID'];
        } else {
            $latestUserID = 0;
        }

        return $latestUserID + 1;
    }

    /**
     * Retrieves an option value directly from the database, bypassing the object cache.
     * @param $optionName
     * @return void
     */
    private function getOption($optionName = self::OPTION_CURRENT_SITE_LOGIN_LINKS)
    {
        $tableName = $this->database->getPrefix() . 'options';

        $query  = "SELECT option_value FROM `$tableName` WHERE option_name = '$optionName' LIMIT 1";
        $result = $this->database->getClient()->query($query);
        if ($result && $data = $this->database->getClient()->fetchAssoc($result)) {
            $optionValue             = maybe_unserialize($data['option_value']);
            $this->loginLinkSettings = $optionValue;
        } else {
            $this->loginLinkSettings = [];
        }
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function getStagingLoginLinks()
    {
        if (!$this->isStagingSite) {
            return [];
        }

        $loginLinks    = get_option(Sites::STAGING_LOGIN_LINK_SETTINGS, []);
        $loginLinkData = maybe_unserialize($loginLinks);
        if (count($loginLinkData) === 0) {
            return [];
        }

        $isExpired   = $this->times->getCurrentTimestamp() > $loginLinkData['expiration'];
        $loginLink   = home_url() . '/wp-login.php?' . self::LOGIN_PREFIX . '=' . $loginLinkData['loginID'];
        $login       = self::LOGIN_LINK_PREFIX . $loginLinkData['loginID'];
        $user        = get_user_by('login', $login);
        $userId      = '';
        $userLogin   = '';
        $userEmail   = '';
        $displayName = $login;

        if (is_object($user)) {
            $userId      = $user->ID;
            $userLogin   = $user->user_login;
            $userEmail   = $user->user_email;
            $displayName = $user->display_name;
        }

        return [
            'id'            => $userId,
            'user_login'    => $userLogin,
            'user_email'    => $userEmail,
            'display_name'  => $displayName,
            'roles'         => $loginLinkData['role'] === Capabilities::WPSTG_VISITOR_ROLE ? 'Visitor' : ucfirst($loginLinkData['role']),
            'expiration'    => date('F j, Y \a\t H:i:s', $loginLinkData['expiration']),
            'loginLink'     => $loginLink,
            'isExpired'     => $isExpired,
            'loginAttempts' => empty($loginLinkData['attempts']) ? 0 : $loginLinkData['attempts'],
            'lastLogin'     => '',
        ];
    }
}
