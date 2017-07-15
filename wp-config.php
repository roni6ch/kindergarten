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
define('DB_NAME', 'kindergarten');

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
define('AUTH_KEY',         'fyy T$}A`QQqztQ~~!!7=s}{!_&>?xihc:2SJo ~SLQCfUQg|,X^zL@8GslS-P P');
define('SECURE_AUTH_KEY',  'f{roM:tyciS&lXT]O.D[?UI~++gv&eU$B_Car(r/jx mW{MfuKHc]DP$Xt1OjyO6');
define('LOGGED_IN_KEY',    ':Y7~Di:VHKMhLMI;fp1z,vtFXZe&=B=n0E pFux}`YH244p[{}qsFj@J(x]SO{R$');
define('NONCE_KEY',        ';l}[y.=XRpQF5>[3*@1vH7<W_PQ/6^hn jFw<^zs-`Xyx30j Azr^[!aKKg~i(Y4');
define('AUTH_SALT',        '*L3@GI-;9lQRp%iViD/;Oy2PBVUp.%uZCi6TSq-21pG,V0DXHacRqH.S75:H>3Rf');
define('SECURE_AUTH_SALT', 'kN_5[bCdjve$w|Uo^s#%@%.>@bRaBn#W]6P?~)u>&H1@=iu;noA*Vk1f^]B%m6/.');
define('LOGGED_IN_SALT',   'au$2[uoZ=CHo+?[|c(wW+cT3M02*oXrJv<?C5R@U2joi4;P9:dj)Hx+Lp5s!Ugq;');
define('NONCE_SALT',       '#uWsI(g5w*L.V%Xe*{hdwY7GQ(RFUiyPd.S3k@q/$X=*|/Db9d<Kq;N }b*@k/Jv');

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
