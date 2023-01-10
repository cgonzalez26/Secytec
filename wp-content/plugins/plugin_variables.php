<?php
/* Plugin Name: Parametros por variable
Plugin URI: http://misitioweb.com.ar/
Description: Este plugin te permite agregar parámetros que seran enviados vía URL 
y p/ que WordPress lo reconozca
Author: Cristian
Version: 1.0
Author URI: http://www.misitioweb.com.ar/
*/

add_filter('query_vars' , 'parameter_queryvars' );

function parameter_queryvars( $qvars )
{
	$qvars[] = 'eje';
	return $qvars;
}
?>