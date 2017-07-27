<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'S*kCGit/mw`B%w%UKAMbVZI>ns]Y;{Flw4X01.tjJW.IhE9?;tJPdY@z1EMz,9D~');
define('SECURE_AUTH_KEY',  'B^VB)3(;U1E4?+H8[X8Vl9;S:rxs7}w%V9Xl1m@*~Jm{O{KvOdF |{[@7TK>j;NQ');
define('LOGGED_IN_KEY',    'nqH9M2U:{%F:<!4~v[|][%+wJgotO~mhK:Fv`c2e1n,=+35%RD-{wXEj@eP^xn@[');
define('NONCE_KEY',        'l_9[.~}UG#F|jp+y8]g$}O/oz0UV]24>>(*+xexAza*LwS=eo8SexH(ZDy7Vm_FI');
define('AUTH_SALT',        '~vF6n`rojNonhN}PJgzQruZwj$cwtv3=swNpao$Sp?0/.i%A2Mdi-^DAbm[xE4lY');
define('SECURE_AUTH_SALT', 'ij/9)7(%-(1 tStr`3<wjq*[8~UFF8t9^(rEB$QZMTQmg6Hp?&o0<Hjb56E7Sl:P');
define('LOGGED_IN_SALT',   'Qx]tBTs7@N^b=cl{ewpEr3O2+)6c0..qn<Nq@)|5|@OHkkU<,lTlk(X/m1[[-$|)');
define('NONCE_SALT',       'uw12=lz22l96z|K9N:QtJd_4j[jfsQnGYI{G`rOw/f]Khq5hNgq8CnkR`wLSd!z6');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
