<?php
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
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp_demo' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'we4IT&3>VXl_U|.sY8^`<xEd|94A1p=V/Uc{g]8`GCV5DWl5T^xDFP5O7>RgZE, ' );
define( 'SECURE_AUTH_KEY',  ',x#5vC<&T?YQr[gjZ~+mj^L/$m;$0rPe+Zt9?;#5~ZKer#A>$~`QOjpRG*g?aLth' );
define( 'LOGGED_IN_KEY',    'q?|r/+S9*qET^>j{</,a65VUhwV>4we>!dtf2wQ#`9{H$WTfBV!g$2lXxP|px7#^' );
define( 'NONCE_KEY',        '=^4moe2efV5RS7~ltTCj=s9~&l$dc+6snhs=G<j:fPU=#C?t~x9AhPmy*.E;_v0D' );
define( 'AUTH_SALT',        '%5_5,(VOT+3)sag)M6<LA{=EQTYxYRUak]6z6Ff H*`kjb8vOax?y#%pMcz>3/r ' );
define( 'SECURE_AUTH_SALT', '$1.zN.#h4M5;@;0e~:)C&fRTCC4[U:CtqK}>$>AYydb9U=N2t&l&t*s#GZ*v&V*l' );
define( 'LOGGED_IN_SALT',   'XZs1-xW:+pndYYT);~Q>6Wzd!ep9?E-e2/|U9~gbpTfWcirnBjal3b3|~qN0RFEj' );
define( 'NONCE_SALT',       ',ggDab~f@~u:T~W,:,XQ;51<]wFbNY/pjMk*2sN]J`QAefXa*KyY9kXCkh(YA!O/' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
