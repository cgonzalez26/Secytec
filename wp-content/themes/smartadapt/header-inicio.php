<!DOCTYPE html>
<!--[if lt IE 9]>
<html class="ie lt-ie9" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php

    wp_head();
    ?>
    <link rel="stylesheet" href="http://localhost:8080/SecyTec/wp-content/themes/smartadapt/style.css?ver=4.0" type="text/css">
    <style>
	
/*mobile*/
/*@media only screen and (max-width: 460px){
	#navigation-secondary a {
	padding: 0;
	margin-bottom: 0;
	display: inline !important;
	}
	#navigation-secondary li {
	padding: 0 0 5px !important;
	display: block;
	float: none;
	}	
	#navigation-secondary li {
		padding-right: 23px !important;
	}
	#navigation-secondary ul {
	padding-left: 150px !important;
	padding-top: 15px;
	display: block;
	}

}
@media only screen and (max-width: 620px){
	#navigation-secondary li {
	padding-right: 23px !important;
}

@media only screen and (max-width: 959px){
	#navigation-secondary a {
	padding: 15px 0 4px;
	margin-bottom: 0;
	}
}*/
	</style>
</head>

<body <?php body_class(); ?>>
<!--  <div id="page" class="hfeed site">-->
		<header id="masthead" class="site-header" role="banner">
			<div class="wrapper">
				<hgroup><h1><a href="http://localhost:8080/SecyTec/">Secretaria</a></h1>
			</hgroup>
			<nav id="navigation-secondary">
			<ul>
				<!--  <li id="nav-home" class="active has-children"><a href="http://localhost/Secretaria/">Inicio</a></li>
				<li id="nav-about" class="has-children"><a href="http://localhost/Secretaria/">Institución</a></li>
				<li id="nav-blog-index"><a href="http://localhost/Secretaria/">Autoridades</a></li>
				<li id="nav-prime-ministers" class="has-children"><a href="http://localhost/Secretaria/">Newsletters</a></li>
				<li id="nav-prime-ministers" class="has-children"><a href="http://localhost/Secretaria/">Contacto</a></li>
				--><?php 
				//wp_nav_menu( array( 'theme_location' => 'top_pages', 'menu_class' => 'top-menu' ) );
				wp_nav_menu(array("menu"=>"Menu Header")); 
				?>
			</ul></nav>
			<div class="search-wrapper">
			<div class="search-mobile"></div>
				<div class="search-form"><form method="get" action="<?php echo home_url('/'); ?>">
				<input type="search" name="s" placeholder="Buscar..." value="">
				<input type="hidden" name="sections" title="Enter search terms" value="">
				<button type="submit"><span></span>Search</button>
				</form>
				</div>
			</div>
			<nav id="navigation-main">
			<ul>
            	<!-- <li class="explore"><span>Explora nuestros ejes</span></li> daniel 12/01/15 -->
      				<li id="nav-vocacion" class="has-children"><a href="?page_id=35&eje=1">Vocación Científica</a></li>
      				<li id="nav-articulacion"><a href="?page_id=50&eje=2">Articulación Tecnológica</a></li>
      				<li id="nav-desarrollo" class="has-children"><a href="?page_id=52&eje=3">Desarrollo Científico</a></li>
      		</ul>
      	</nav>
	</div>

			
	</header><!-- #masthead -->

	<div id="main" class="site-main">
		



	

           



