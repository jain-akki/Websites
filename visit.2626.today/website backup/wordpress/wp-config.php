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
define('DB_NAME', 'wordpress_74');

/** MySQL database username */
define('DB_USER', 'admin2626');

/** MySQL database password */
define('DB_PASSWORD', 'Kanika@123');

/** MySQL hostname */
define('DB_HOST', '148.72.232.170:3306');

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
define('AUTH_KEY',         ')HsThVzRRVeGwK^)gG%MCG5kR@))*b#WVpHQb&qad33CEPqj#hCOZIUJak!1*ex#');
define('SECURE_AUTH_KEY',  'nNBrDZV1CPys2qHGWM&N1Dz%R^UlhdWvUdEa@b6@FZI)dPavKU(Jmxljxh&q3gjA');
define('LOGGED_IN_KEY',    'gC4HF&ZTs)&gfmOE&K2UoLQXU4DB)HiX4gyu2mg)0yO7k3%tBPp%SZQ7@h(YOIrA');
define('NONCE_KEY',        '3vYEIldFN1pc6ztD4Uf&!2v#x6mcqv*W!BFPSN3sha*M(c(W)V2ga9vRjq(NT9)u');
define('AUTH_SALT',        'nU!(@obtuM(*#@!ymQdpBvT^6P4dnF@8UYRl71z*YQEmvT%*dg!5Y)R*G3he*Aoy');
define('SECURE_AUTH_SALT', 'haRePvic4KM6OriiHcvbH%Q3M5eb4%vq)mbivhV!QX7d3DtP^w&@K!9e#8tFd5YG');
define('LOGGED_IN_SALT',   'oLRvx1@0Ld(9cU^oLwIRKEP6%UCIUb)zboRSj@@&6MwsDx61wBjjmJj8^^%KBvus');
define('NONCE_SALT',       'nEQ&OReQnyz7ew9pqk0j8IKe9LQ!TEprZ1lEfeHXO^juB#sw(jfjJd3)Y%gikGB5');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_creativestudio';

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

define( 'WP_ALLOW_MULTISITE', true );

define ('FS_METHOD', 'direct');
?>