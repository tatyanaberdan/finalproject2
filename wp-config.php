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
define('DB_NAME', 'finalproject2');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'QyRwj(@CB8}@I9K!I;08OPyn[(+WVXROy_vV?s4)d]Ynb~]Ry KDB<)GHl3vxA F');
define('SECURE_AUTH_KEY',  '0idl9:1?`b]e&a?0ydkt4y52,51|=[2/dOMURF(]blz0~hK +,_nP.WN*[HpG=?b');
define('LOGGED_IN_KEY',    'b;Ms)H1;c 5K]Pi0+VxWf=msaxzFwgzl]M&Z*PA%gSlz+;+r)] 2c2d7B16_wX6$');
define('NONCE_KEY',        'm$K^*N-5,duEi/KBj?|%0c_!Qd#aH;LhPuwBA2<,-yMmYQ-$gx^@bj#}h/mE9>*)');
define('AUTH_SALT',        '(n2ClkDrUTyMkEM]9*$rti<9eT#s05d#KJl>SD%i?,cVFa^W!Q9NpEHY|#nAu|i/');
define('SECURE_AUTH_SALT', '^9Rr6}$o.IOl`_Q6on$r8.O2+L4O<:#R5nTK@s0<W~Qe5LcoGty>ufpfX^rN-xx3');
define('LOGGED_IN_SALT',   'h8K!v 4JmQWtT.e4;5n]F)EI#uU@;XYs@@xbFez0y<u%QS8-N<%HJ{L=a*E1U$VS');
define('NONCE_SALT',       '_ZI2Cmy2yxpl*i^C#t=XRc>(T88_0: %BWQsicdBHKMlQPr5/[Z[4_=mcp<L_Cjb');

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
