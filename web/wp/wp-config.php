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
define('DB_NAME', 'cissaorg_wp130');

/** MySQL database username */
define('DB_USER', 'cissaorg_wp130');

/** MySQL database password */
define('DB_PASSWORD', '5B-4.LSU4P');

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
define('AUTH_KEY',         'c9hsuw1hxwlgfccemelpvyw86t8eryxqn8bw4tljnig5mb5gr9dicixkasjo1svu');
define('SECURE_AUTH_KEY',  'ixb476vdhlarqdymvowdrl38nyxyvlzbcwcmy358tz2tb5lxdsnvlji0j9otcexf');
define('LOGGED_IN_KEY',    'js9lunezcof7qeeykbrwl55sqf5hgg1j43pybsiwnnrn2fjhsvkxf5xdc8thjvsc');
define('NONCE_KEY',        'otmgcq5bgqcdy4djehttdaftyocrncbznhedt9innu8kl0bfadbzqehzbylc0bq2');
define('AUTH_SALT',        'rnmvjzyc3f9bktkct8sqrh9ejomadw1lue4fw1wqawp7orhog5wb1oah7wajh6ft');
define('SECURE_AUTH_SALT', 'dwyvasfxx8ovttofzgizpjjty9ax7xtknkdyysoarxw0k2we8aor6zu8tdtwk09b');
define('LOGGED_IN_SALT',   'ca3bimz4qvss7fgkyywtbbyeddqffw7lbc3kwpifvutbsycpu06h0euaspk864yx');
define('NONCE_SALT',       '6bnp6nbzitqbj2jjp8di5vrvsv6asxzkz8bzgwjsonxzsjv4wrcaohb8liri08zm');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpfg_';

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
