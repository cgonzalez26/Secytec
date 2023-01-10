<!DOCTYPE html>
<!--[if lt IE 7 ]>	<html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>		<html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>		<html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>		<html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
<head>

<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="HandheldFriendly" content="true">
<link rel="profile" href="http://gmpg.org/xfn/11">
<title><?php wp_title( '|', true, 'right' ); ?></title>

<?php do_action( 'bp_head' ) ?>

<!-- STYLESHEET INIT -->
<link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet" type="text/css" />
<?php if( function_exists('theme_custom_google_font')) { echo theme_custom_google_font(); } ?>

<!-- favicon.ico location -->
<?php
global $shortname, $option_upload_path, $option_upload_url;
if( file_exists( $option_upload_path . '/' . $shortname . '_fav_icon.jpg' ) ) { ?>
<link rel="icon" href="<?php echo $option_upload_url . '/' . $shortname . '_fav_icon.jpg'; ?>" type="images/x-icon" />
<?php } ?>

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!--[if gte IE 9]>
<style type="text/css">
</style>
<![endif]-->


<?php wp_head(); ?>

<script type="text/javascript">
//<![CDATA[
document.write('<style type="text/css">.tabber{display:none;}<\/style>');
//]]>
</script>


</head>

<body <?php body_class(); ?> id="custom">


<!-- CONTAINER START -->
<section id="container">



<div class="container-wrap">

<?php do_action( 'bp_before_header' ) ?>
<!-- HEADER START -->
<header class="iegradient" id="header" role="banner">

</header>
<!-- HEADER END -->

<?php do_action( 'bp_after_header' ) ?>


