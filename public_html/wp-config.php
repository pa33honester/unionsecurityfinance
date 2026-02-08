<?php
define( 'WP_CACHE', true );

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u416041620_ijXtD' );

/** Database username */
define( 'DB_USER', 'u416041620_CXhW8' );

/** Database password */
define( 'DB_PASSWORD', '9JkvsvFKst' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          ':fOIsi)1ca>G[MT@9d@ N_g4#tXxvv6H$j`$euvS-/??E=Jv<%<=Y_#FbNBjnt 7' );
define( 'SECURE_AUTH_KEY',   'XJ%?q`Q I?hzL>>sO6oNk<jM^Ma^ TbI]M}_tI:mhZdn*F2LQiSc4tfs fB1+U33' );
define( 'LOGGED_IN_KEY',     'lS/!H^sP7hmQjS/,=:2P@1J1Qh,V*9IPccQ@Aa9 /k,]<7K&Vn)]n)qZrk4Ktuvk' );
define( 'NONCE_KEY',         '_T#:-<5>OX~AGTYJr.N>rF 8t+)U&g|M*A)@kxVk9pjWXv~44(l##`X bXdG;TZu' );
define( 'AUTH_SALT',         '}Om!D](7R2~=,0$Hlx(fi/N=MW@V;fxgb)jg^W0nsIs]I`z||uJB+{e1(x4b#9#x' );
define( 'SECURE_AUTH_SALT',  'Y35J/j7XhA)*:dN,x0)|[G{x@YaM|MITd&H={2oRy=f%G5+kD-_(cz<fo~iIoXSZ' );
define( 'LOGGED_IN_SALT',    ',nyBa1bCn1~4Dl[P*8Jjq|d{XtoZae5UIF5%-X/?}z>sKwEY0RA`uFWy*GuajJ|8' );
define( 'NONCE_SALT',        'WowB2wGKY>@b}lC?l8<LkBj_A$)XVJqvSMlY}uk6HcKn,d]nG|f?fM@D)Z?n_OSl' );
define( 'WP_CACHE_KEY_SALT', 'YF8jx{/ P;nFYl0rAl^U#dyOQLAUvi;e.[{*HXEgePnksMt3^M|e!6SWj:3:c~T9' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'FS_METHOD', 'direct' );
define( 'COOKIEHASH', '6e75c567dfde4e913fd326f6c488014d' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
