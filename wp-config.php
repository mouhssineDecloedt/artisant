<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'artisant' );

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
define( 'AUTH_KEY',         ']$#ka[xs_&Y8Tv!lPQfY3ch?<|_U::GlUr30vw3O5QrL4v$n*P7EmVZWG1CDH)m6' );
define( 'SECURE_AUTH_KEY',  '-%ph-?Z$@R:#3mt,!HZx9/QPdQM99e0;A=VpXpmh)3`:5(Xx/w?m8_b`dJX!{#6z' );
define( 'LOGGED_IN_KEY',    '5KJ-<JQj]XjRY|bq|Pfwe5S1A*0wv)01plp}z,C }d-2zzsTQx&8h!?PaK06n9f3' );
define( 'NONCE_KEY',        'WGJK_Z44O5z`:y}G^u:`J}GY=rgv8_xy&5(gp?/j`N(b*DpoUw;$fv=@!+D1!J-}' );
define( 'AUTH_SALT',        'kbn<u6^:Ld4b-oq3#DQK,!u)FfD7kr?_kA15%(F>C>tBm(nX2jV;8/Hk{0_+|5]{' );
define( 'SECURE_AUTH_SALT', 'CE!RGIyeaybA*+Ay|/-|=qLK;d$OUWzQkt8U>/WdZbth!!alFqi!2PnbJ~&Tn1@-' );
define( 'LOGGED_IN_SALT',   'yqjL-eN%k71X[jVP#eyKYHaXKvCBK7xI?P`j1/CXJ&6f^*9Cot4hRu O0JJh8oZM' );
define( 'NONCE_SALT',       '%84N*aEUnF7n7{!7QS/qp0}L^LDq3Q,=y/Q9 ,i/<r[=0dK)}i)34+`mgbT4SvbF' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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


// Désactiver l'affichage des erreurs PHP
ini_set('display_errors', 0);
