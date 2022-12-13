<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'radeema' );

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
define( 'AUTH_KEY',         '82[wGD<sp9Vzv>`_3S}f0v^RT}n?yc i?22(QUcyB-](lpGg_*Sv)Br3lr./|fOr' );
define( 'SECURE_AUTH_KEY',  'cvW|Gws&;-f]Tcgshx-C9wXelw>K?N+6nIntF,_,d>Bls[|wD{yv33-79FD]wF2a' );
define( 'LOGGED_IN_KEY',    'S^: |O)oYNH,(hzX(;0r,boB&`UhGfSL-IvZQr0?:tORWG(ca#$[=W~jsMJ.J<YD' );
define( 'NONCE_KEY',        '^q4W|9^fs^jCrH`9=}3Qnh).H1mi)!Ory+A{LG]s#Q=0AmsCsMV/R_oHX*Y<jko$' );
define( 'AUTH_SALT',        'c>[:},!^<!=YcKi@RBaeek&cES}z/X4{rmq4ELwaC<o8g;-+xA%~Baa:jgT&!S1x' );
define( 'SECURE_AUTH_SALT', 'i[;q.CiD<MPO9=_vjzVhK=VPHUj- ,rIF+`r`p@>~hZ&)Muyh!:]%.xmdh[DlIkJ' );
define( 'LOGGED_IN_SALT',   '++6i4$TUrJgQ94*wS9[<S4w.l:krXa[%o~P%?gS|I6+<2~s^/NI/L.Q+S.J5.F(8' );
define( 'NONCE_SALT',       'I)WITO->Y4XOC]!gs>!D!f-h6R4Gc2q3.6}$l7#<-R<8dQ,kYJ/*pmwL*#V#QF0M' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
