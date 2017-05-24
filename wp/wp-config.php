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
define('DB_NAME', 'wp_demo');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'interaktiv.!@#');

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
define('AUTH_KEY',         'x#}(5,R(rsUJ,`-:d9Bk]n+%A~]1EckHa}q14,;##G@=|[0)0;JkY`VmycxN1`5q');
define('SECURE_AUTH_KEY',  ' oJ]H?-A_NA&iD.L3uksh@bC,CpvUQKt#}c168<bU={bm9ab@FPIYv5is1t,cQs&');
define('LOGGED_IN_KEY',    '>,$!N CZ@rF<lI&&%bn{G=z6PU*~2c6X{R,#<J!^R$adx(Oh,hQ-|A,Fy={J^|VQ');
define('NONCE_KEY',        '{/M(n4v[<{F=R|tX>roA,M|a*Kzi%G-FvWgn1Fko#[Kmq-~Ldjp<O+41rJ`5GQ,H');
define('AUTH_SALT',        '_trWtH!kL5RzCoJ@M~Mn#(X;u00|k{-5S0BD_Fj~x1-,ipL(V{6~hZ-Z/3c!aGGc');
define('SECURE_AUTH_SALT', 'I_/cU-@Xcqm:ee9@*QJNJ*^ ME>9!kNV3 (~I8}7hw^d?!T eaG*d(!!-elm}x~7');
define('LOGGED_IN_SALT',   'm-%xT5c2]`sNCa^h6Zh(3Ok`o0I__DE1x8TyfOk:/}Uv?0SL 2|xVnVJ&LgV&t+0');
define('NONCE_SALT',       'K]<6)x!!+PpW<PM7+4m1-D0)K`#PH8_Z`o-+j|>8Z!{=/eU^p7QDoVY]h-gmG;6d');

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
