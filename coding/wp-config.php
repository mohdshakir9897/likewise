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
define( 'DB_NAME', 'coding' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '-q`?m2M-aRn&7/3e ![judwVlQ%NcV1]miMcvTgV~/g|Ps0YQu^s//1%k[V3@RsC' );
define( 'SECURE_AUTH_KEY',  '2?ru5C?vT&D *Q)lR>P3#p+(>EM@w@h;3HF xtv2ORL_U`ma-FYyZ_d#1d)a` w#' );
define( 'LOGGED_IN_KEY',    '<`/iSK+-g!xCnxAuzzqp213VKVN% @XeWuAy9x|o(=>[7V|c,~wKOx=Bq8z]tQ2<' );
define( 'NONCE_KEY',        'q24#%o})(|qV/#DkYt)l=:&z0O+PFi`3h+ngF,KMd?q|5Xld!,eaD :`4|?Frx6/' );
define( 'AUTH_SALT',        'W)lw>.e%WX4HPCjb95$]%|F8W.^E=Mxt@KOB@H@o(^UnFkI)Hi>T{ty;3&>FS@!,' );
define( 'SECURE_AUTH_SALT', ')eV+2wpWa0*zjkn4V4Q?q ~slLExX,GEp -;.qd6:thxxfb83#n/[PF|,H.jjxu@' );
define( 'LOGGED_IN_SALT',   'vJR owT~/5<f%t1bOKdDMpy_JE@mo{z-~Bd/hb-@!a3V+e{v~VfR-A`_XNfOMQ-,' );
define( 'NONCE_SALT',       'pBGo>LcE.Z?s^k_>GP3jFy-AwLiQ8yM,UZ3_O@LuC^(6U^BcgZgp9MpKs=5~4R(Y' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
