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
define('DB_NAME', 'instag8_instagram_dev');

/** MySQL database username */
define('DB_USER', 'instag8_instagra');

/** MySQL database password */
define('DB_PASSWORD', 'Ark85900');

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
define('AUTH_KEY',         'X|g}2nQ<{#Y~n4 #0g~SWF2xL?cgGt358C<Iq,#Aog< 3hSi7lX5(fUp>;n%8}O.');
define('SECURE_AUTH_KEY',  ' 0V*vx{&=vp#f{ wg2Y%=a_d4V#_]4:F1z3msYUZz~_rAeq|{QeT|TClmomW/E6{');
define('LOGGED_IN_KEY',    'Zm?ya==1*MMjWr?2&/uD<n_m2>1$RM!uSo[jK!)k%<Vd[X(D/#wLloR(:B)1Y]1O');
define('NONCE_KEY',        '_m](|wg7;on>A=,76rI_`psn=9(-dZM=Ly(OgfHX@+4EdBg9p/ai;Y^]FI.%W>*U');
define('AUTH_SALT',        '*4Hx;+IlA8)ow$r.l:%+:S=eZ)I}+.O]TvXEs~%Z96zuMZHtW+&FrdV!:0K4 tU`');
define('SECURE_AUTH_SALT', ')U-jd^qPHbO:.rLuw|DB;~`N@tgKT^11ctbG5h4t(Wr6>RpKHfAsc3 `Bq;bD*ql');
define('LOGGED_IN_SALT',   'X;|ey`5*uzfglN>5+J~lL{*UwVZnOp)LT#?;A9:I-!tOv!4.<-G>)#4!+F ZXVe}');
define('NONCE_SALT',       'z44;`j$Nf=>pa9S3kW]$KwyNiAi!5-)Fp3dj)xc^t~^U.K<pvxT`*)8jC027UzIO');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_ccts7s06y9_';

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

define('PHP_AUTH_USER', 'developer');
define('PHP_AUTH_PW', 'YQ3890d#R1dE');
