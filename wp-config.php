<?php
/** 
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

 /**
 * Autor: Cristian
 * IMPORTANTE: Esta Version esa adaptada para la configuracion de Host: localhost:8080
 * Cambiar en caso de necesitar
 **/

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
//cristian
define('WP_MEMORY_LIMIT', '312M'); 

/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'secytec_nuevo');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'root');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', '');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost:8080');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'kI%[6>yL?ph~fROlFZwasEDt`sb{L#vvto8jC2x!j{M5[58Ni#u.=)s}/Xl<Gpvh'); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_KEY', '0Tc(iOY/Wi(GpMESUmoDv;r].)K*wisvHS!;e5Ug9b?`E_xc3[<i@e<w:M&f3h@U'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_KEY', ';0MuB6&>*uAqo*NNh;{}ZM}1o#(~f!DaOw@fS!]t`~(Gvq~od7@7W^/UtG!#wSB('); // Cambia esto por tu frase aleatoria.
define('NONCE_KEY', 'e<!.d#:u(!xw0rcEgv:<VYj]9rEV#me}#j4}tjRe=A)@Bm9hFX|y*fGhqv!4r!S~'); // Cambia esto por tu frase aleatoria.
define('AUTH_SALT', 'yS z73ybwmFXlKDASl.):DcceBZwry}FkfxHgvEMPcb#O|=6l(^M5.`g#.9W;p9p'); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_SALT', 'kw|)Pk%D_s1m1_YZ}wfALKK^Qn)),:B L5~^=d>}pP`3<6DOeLgc91jeY O)9V=+'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_SALT', '2~a4f4tjU?(x,;r*f<1+3G%<0ou]AA-L[gZ^uznD`SQx}xuo]6=xeh.-kD7p~Xk,'); // Cambia esto por tu frase aleatoria.
define('NONCE_SALT', 'S+lI+_Y Lt`8H-c:< #/+/r$ lF*A!On.9IdgAX&t i&052]bY6l:h@NphXcA}Rn'); // Cambia esto por tu frase aleatoria.

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_';


/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

