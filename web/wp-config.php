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
define('DB_NAME', 'cissaorg_codeb');

/** MySQL database username */
define('DB_USER', 'cissaorg_codeb');

/** MySQL database password */
define('DB_PASSWORD', 'S()R8P50Wc');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'pr4sxmpf8d58dv9vs2eyuj4lkashyjywb1oupuhiqomv2bhuxqfflj0chuvlggr4');
define('SECURE_AUTH_KEY',  'ixvkrgr8vjywejsmixjxknbrh42fux1ofh3qg80mcthksstlbsxqvbzrzrmiwrll');
define('LOGGED_IN_KEY',    'sjagca13bepx9jr7eufp27rjpipl5bcjrjag6wuzojkgc0lb3u45q6oo3pgbgrdu');
define('NONCE_KEY',        'a4nryxacjy7zzwmvqueigyqlsw0rkrus1hsn9jdzirhzto0eedz7ylsiikmx2ebo');
define('AUTH_SALT',        'r4qjs57unuf4smjeis0jztke0bcakzbulg44f4f5y39wz1zlykg9e3vaeuv4b4fo');
define('SECURE_AUTH_SALT', '9yzplaox2xhsfnrggqsi0pxwyskscyccfbv3unnasizbie1wpslrhhgpmr9erquw');
define('LOGGED_IN_SALT',   'yehfsd5f96rgnrwku9bdpapveoegaa43u5l7ahn5ypuro4ylbwmgcemlwoqqhyii');
define('NONCE_SALT',       'mfggwrhvs1xv10keaafemtprb1mo08x1czthxvncrhsns6aruveiov92vrmhalf2');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpwa_';

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
