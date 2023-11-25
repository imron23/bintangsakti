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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'word' );

/** Database username */
define( 'DB_USER', 'imron' );

/** Database password */
define( 'DB_PASSWORD', '123' );

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
define( 'AUTH_KEY',         'MC;%*q`)=A9jV0-xsz-!yJ<m@c;JbNhCxx$dhF`S}|UW0fPbub *:{=:uMGOB1n1' );
define( 'SECURE_AUTH_KEY',  'FGn9 )78 ,wQw46 G^I/H4VWL9.#heq}ZI!xI%fg>,uB&IjOiYw=1_an<b5NI[Ap' );
define( 'LOGGED_IN_KEY',    '>b6yQQ3x-ZO/)Z%i9(P](s])v|59-!(hHg+w= A~LZU15ww3w)#nhg<`wbxjNY}G' );
define( 'NONCE_KEY',        'M3OAf&pM+f4+F7B7o{so<{l/k;}fYo~1|`a#@d3l7zx ^Lx.Q;xG!:&w`pj/:Hq2' );
define( 'AUTH_SALT',        '^Lp}KSlnzbhwiR=HZdg5{1.BYe<]SNrHoI&3j6|${!k+{tq>fu_d_Iv]KDH>^owy' );
define( 'SECURE_AUTH_SALT', '{#/1m%:VDF>B7ve{m~}sB^J>un{&PA]C/H$;Y?Kq8N&w@bxq=hex{7+.@p. eXmL' );
define( 'LOGGED_IN_SALT',   'sQ5>mwDCx~oUB}_[%*NEN,;[[,`1O.*X*Tc),gc(3`6+;PUK/2V1JP2zC*_MhVw)' );
define( 'NONCE_SALT',       '!p*rd~+b52AJj@8hhth^Kcwz9DH+IGRGSAHYWn QR$E#[+[zY/!5,p6_xM1{,nU`' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
