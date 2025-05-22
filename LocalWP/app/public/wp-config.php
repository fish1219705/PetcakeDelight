<?php
//Begin Really Simple Security session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple Security cookie settings
//Begin Really Simple Security key
define('RSSSL_KEY', 'wRmJsVgSEvlmPJA2zv7VQjhOj5JEwf7xBbDL1yOkV4NyPYI1o1IFTQEld0OuFx1j');
//END Really Simple Security key
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
define( 'DB_NAME', 'local' );
/** Database username */
define( 'DB_USER', 'root' );
/** Database password */
define( 'DB_PASSWORD', 'root' );
/** Database hostname */
define( 'DB_HOST', 'localhost' );
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
define( 'AUTH_KEY',          '+0rH~]E~T;gyTq$p*{I1_{kT@+kbWhPe>bWFdxLLd:`{F|X@*]*}Aejb?^9sI)Pv' );
define( 'SECURE_AUTH_KEY',   'TwKmt>)RWA{M!usER<)#s*z(NBZ`Y}wa3x)>FNPjssnnLH4yolCdxv26}Pj.J&vI' );
define( 'LOGGED_IN_KEY',     '#Br%II]FTnHya[m5v*,h,0QZUK-0~,r-}?dhmJN|RhudnN8p]TW-c>!mdPQggU<4' );
define( 'NONCE_KEY',         'o*qUvh&mKA)/5=y(RoY#uRCSi)vv^kjlrZ-~D6N7^j+tG4<y{uL-3%r$/=)#+ODu' );
define( 'AUTH_SALT',         ' bOTOxZp4?OU9tH(kSvi]eP0qJ# e5.7/y;:tobAs1V1B~M%{hUzdFxjx!zm9?~K' );
define( 'SECURE_AUTH_SALT',  't+wP$G07FuaPe`Y#TUNv((7jsO<,#DhO}-i),[0i1vX66|l}<C!LO<J,1]!<>#{>' );
define( 'LOGGED_IN_SALT',    'l>S>*&.F3c0.-^Y%<YRwrA-ciM}r?lGRp^vsYps:Z0&#{n]J8zA]5MRqkH=I-7TA' );
define( 'NONCE_SALT',        '%)/Ax]OKJo?B-0ZL}Gq6IhGl_ev$N.OZI}pK]No 0:[dd.` aCjnvd{yo<)2.Vw_' );
define( 'WP_CACHE_KEY_SALT', 'AAcWzj?g%aewwzK29+(5z;J13W8&eL13|UX,LK?p*)e^93#MFq|Nz7t(oNU9H<C ' );
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
define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
