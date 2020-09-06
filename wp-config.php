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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'ferraritimedb' );

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
define( 'AUTH_KEY',         '|e$![a8C.J[5z$HHx`&}tfnzcLJ><(,636d)c}|Q@-G{UR7~cycFG2xJutWc?5iL' );
define( 'SECURE_AUTH_KEY',  'ZF&jlL&AH~Q/=.%mDm>/}^= ]_jFr&qSp`B@IJ&s5xAX0XCkyv$!bu NrEm=Q8m~' );
define( 'LOGGED_IN_KEY',    'ttO+;4A@=;UOBiZrT|QM17RlEiP$|MF3qBI(o>r`w=tr8NO<y?^,R8{/(l]G7,Q,' );
define( 'NONCE_KEY',        '4p,,-dii4{)*bomyigA9(:^Gi9F-%&j0Y_(Ky.Ky%#?cb[{W[vCWd`@Z}taeNB2p' );
define( 'AUTH_SALT',        'qm<K%]|6${5vy4x$O}~;OIzP5qy,<Kh.S!bpAlS&z}}u>_e7<|6w(qIYw#tu|?#z' );
define( 'SECURE_AUTH_SALT', ',B{oCa9g2^T>zU6gy`+v0LUuNc;d.h6.(UTM,AbZk{XkX;lCG{7zQwN?TaF!Cn>k' );
define( 'LOGGED_IN_SALT',   'op^WJ`fR?larglSihd%/%P8fQfk9|x{h~)Wg:Y+0XL.dxZbdv0Ta4F|N<43tNu|q' );
define( 'NONCE_SALT',       '{GaR2NFi(3+dPz_`j=7J]8U2q`sF=67LcroD3CC;X?`xU!j$;PmjQSojH:IR^IM[' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'frt_';

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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
