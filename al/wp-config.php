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
define('DB_NAME', 'alzheimer_wp');

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
define('AUTH_KEY',         'hE0!/*^&opKsRG $7_SKc]1E&!B_B8u(Ni7A#Q&l#5e(iH)#U5c|N4<!D9/:nmBz');
define('SECURE_AUTH_KEY',  'L$&ZaN[d=xjzPW~L=3-^Cy5^%[~<E+7b5INi3sTmB_Lq+;4<+<RB[@W,Lv^{/+jw');
define('LOGGED_IN_KEY',    'jjJon<TV1.|mZ@x=S8ou,@E:zm4o5fYh8Qx}9E<DiisP,4kz<+942I Rn`qU[QAm');
define('NONCE_KEY',        'YlE:x_fA*^#%C_,,qs{$Qs9oyWacz@!;:wxYLADRY,n(v27XcPxPxU||PhFYtwAa');
define('AUTH_SALT',        ',e7yok%ZpduHk&TG/|w;STIL>sBj[nkr,SFHC4J@}jTEttCDhN;Dn[1$]@+pq^#w');
define('SECURE_AUTH_SALT', '0?D<Q=7qj.tM?(Z|9~c?8CI`ImZDjG6 7%3ypca*7R0J*%r8Jvx:GoI`q(G4q|b8');
define('LOGGED_IN_SALT',   '7nun$~}l9;$W`8_{=l-c2$)*Epi&&|1I 4>Bih.r,WOaV H4OMS{e$j^~I0ZmKDq');
define('NONCE_SALT',       'n&>_vaoI=pKL9oXpm;g)m/u!6qpufh5YBY@bd1}xYg9q!$O jXKDm,Jw<&}sT!H-');

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
