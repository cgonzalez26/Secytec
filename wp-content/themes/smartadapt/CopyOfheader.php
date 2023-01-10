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
    <style>
	#button {
	padding: 0;
	float:right;
	}

	#button li {
	display: inline;
	float: left;
	}	

	</style>
	
<link rel="stylesheet" href="http://localhost/SecyTec/wp-content/themes/smartadapt/header_style.css?ver=4.0" type="text/css">    
     <style>
	#masthead {
	padding-left: 20px;
	padding-right: 20px;
	/*background: #042b38 url(../images/bg-masthead.jpg) top center no-repeat;*/
	background: #042b38;
	}
	
	#masthead .wrapper {
	min-height: 182px;
	position: relative;
	overflow: visible;
	}
	
	#masthead hgroup {
	height: 132px;
	left: 0;
	position: absolute;
	text-indent: -999em;
	top: 20px;
	width: 150px;
	}
	
#masthead nav {
margin-left: 180px;
}

#navigation-secondary {
display: inline;
float: left;
font-size: 14px;
font-size: 1.0rem;
text-transform: uppercase;
letter-spacing: .2em;
}

#navigation-main {
font-family: "din-condensed-web-1", "din-condensed-web-2", "Arial Narrow", "Helvetica Neue", Arial, sans-serif;
font-size: 31px;
font-size: 1.5rem;
text-transform: uppercase;
}

#navigation-secondary li {
padding-right: 60px;
position: relative;
font-size:0.6em;
}

#masthead li {
display: inline;
float: left;
}

#navigation-secondary ul {
padding-left: 30px;
}
#masthead ul {
overflow: hidden;
clear: both;
margin: 0;
padding: 0;
}

#navigation-secondary .active a {
color: #31c4ff;
border-color: #31c4ff;
}

#masthead nav a {
color: #fff;
display: block;
text-decoration: none;
}

#navigation-secondary a {
border-bottom: 1px transparent solid;
padding: 40px 0 4px;
margin-bottom: 16px;
}

#navigation-secondary li:after {
content: '/';
color: #577884;
position: absolute;
top: 40px;
right: 27px;
}

.search-form input {
-moz-box-sizing: border-box;
-webkit-box-sizing: border-box;
-ms-box-sizing: border-box;
box-sizing: border-box;
-moz-border-radius: 2px;
-webkit-border-radius: 2px;
-o-border-radius: 2px;
-ms-border-radius: 2px;
-khtml-border-radius: 2px;
border-radius: 2px;
background: #023042;
border: 1px #29667f solid;
color: #fafafa;
padding: 1em 65px 1.4em .6em;
width: 100%;
}

.search-form button {
text-shadow: rgba(0, 0, 0, 0.2) 0 -1px 0;
-moz-border-radius: 0;
-webkit-border-radius: 0;
-o-border-radius: 0;
-ms-border-radius: 0;
-khtml-border-radius: 0;
border-radius: 0;
-moz-border-radius-topright: 1px;
-webkit-border-top-right-radius: 1px;
-o-border-top-right-radius: 1px;
-ms-border-top-right-radius: 1px;
-khtml-border-top-right-radius: 1px;
border-top-right-radius: 1px;
-moz-border-radius-bottomright: 1px;
-webkit-border-bottom-right-radius: 1px;
-o-border-bottom-right-radius: 1px;
-ms-border-bottom-right-radius: 1px;
-khtml-border-bottom-right-radius: 1px;
border-bottom-right-radius: 1px;
background: #1a5871;
background: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #29667f), color-stop(100%, #1a5871));
background: -webkit-linear-gradient(#29667f,#1a5871);
background: -moz-linear-gradient(#29667f,#1a5871);
background: -o-linear-gradient(#29667f,#1a5871);
background: -ms-linear-gradient(#29667f,#1a5871);
background: linear-gradient(#29667f,#1a5871);
border: none;
bottom: 1px;
color: transparent;
overflow: hidden;
position: absolute;
right: 1px;
top: 1px;
font: 0/0 a;
}

.search-form button span {
background: url(wp-content/themes/smartadapt/images/icon-search.png) no-repeat 0 2px;
display: block;
height: 24px;
width: 17px;
}

#navigation-main li {
margin-right: 0;
padding:20px;
}



#navigation-main a:hover, #navigation-main a:focus {
background: #26525d;
}

#masthead .search-form {
display: inline;
float: right;
margin: 33px 0 0 40px;
/*width: 20%;*/
width:180px;
}

.search-form {
position: relative;
}

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

#masthead .logo {
height: 132px;
left: 0;
position: absolute;
/*text-indent: -999em;*/
top: 20px;
width: 180px;
}
	</style>
</head>

<body <?php body_class(); ?>>
<?php smartadapt_lt_ie7_info(); //display info if IE lower than 7  
//ruta_plantilla();
?>

	<?php
	//fixed top bar option
	$fixed = smartadapt_option( 'smartadapt_fixed_topbar' );
	 $clase_boton_eje1 = "menu-eje1-pagina";// Clase por Defecto
     $clase_boton_eje2 = "menu-eje2-pagina";
     $clase_boton_eje3 = "menu-eje3-pagina";
	 if($_GET["eje"]){
         $_SESSION["eje"]=$_GET["eje"];
     }
	   switch($_SESSION["eje"]){
			   case 1:
					   $_SESSION["categoria_padre"]=24;
					   $clase_boton_eje1 = "menu-eje1-activo";
					   break;
			   case 2:
					   $_SESSION["categoria_padre"]=25;
					   $clase_boton_eje2 = "menu-eje2-activo";
					   break;
			   case 3:
					   $_SESSION["categoria_padre"]=26;
					   $clase_boton_eje3 = "menu-eje3-activo";
					   break;        
	   }
	?>
<!-- <div id="page" class="hfeed site">-->
		<header id="masthead" class="site-header" role="banner">
			<div class="wrapper">
				<!--  <hgroup style="background:url('http://localhost/Secretaria/wp-content/uploads/2014/11/logo-SECYT.png')">												
				-->
				<!--  <div style="height: 180px;width:150px">-->
				<div class="logo">
				<a href="http://moadoph.gov.au"><img src="http://localhost/Secretaria/wp-content/uploads/2014/11/logo-SECYT.png" style="height:150px" /></a>
				</div>
			<nav id="navigation-secondary">
			<ul>
				<?php wp_nav_menu( array( 'theme_location' => 'top_pages', 'menu_class' => 'top-menu' ) ); ?>
			</ul></nav>
			<div class="search-wrapper">
			<div class="search-mobile"></div>
			 <?php //dynamic_sidebar('sidebar-6');?>
				 <div class="search-form"><form method="get" action="/search/">
				<input type="search" name="keywords" placeholder="Buscar..." value="">
				<input type="hidden" name="sections" title="Enter search terms" value="exhibitions,events,pages,online-resources,articles,speech,milestone,geo_milestone,person,timeline,trail,history">
				<button type="submit"><span></span>Search</button>
				</form>
				</div>
			</div>
			<nav id="navigation-main">
			<ul>
				<li id="nav-visiting" class="has-children"><a href="?page_id=35&eje=1">Vocacion Cientifica</a></li>
				<li id="nav-whats-on"><a href="?page_id=50&eje=2">Tecnologia e Inovacion</a></li>
				<li id="nav-collection" class="has-children"><a href="?page_id=52&eje=3">Desarrollo Cientifico</a></li>
			</ul>
			</nav>
			</div>			
		</header><!-- #masthead -->

		<!--<div id="main" class="site-main"> -->
		
	

<div id="wrapper" class="row">

	<?php
//if sidebar is one the left side
		if(check_position_of_component('sidebar', 'left', smartadapt_option( 'smartadapt_layout' )))
			get_sidebar();

	?>
	<div id="page" role="main" class="<?php echo get_class_of_component('page', smartadapt_option( 'smartadapt_layout' )) ?>">
		<?php
		//smartadapt_header(); //display header info or header image


		?>
		<div id="main" class="row">
			<nav id="mobile-navigation" class="columns sixteen show-for-small" role="navigation">
				<?php


			//if layout has vertical menu
				if(smartadapt_option( 'smartadapt_layout' )!=3){
				//display mobile menu
				smartadapt_wp_nav_menu_select(
					array(
						'theme_location' => 'categories'
					)
				);
			}
				?>

			</nav>
<?php
//if menu is one the left side
if(check_position_of_component('menu', 'left', smartadapt_option( 'smartadapt_layout' ))){
	//get_template_part('section', 'menu');
	
	//do_action( "get_template_part_section", "section", "menu" );
	$template = "section-menu.php";
	
	$options = array('eje' => $_SESSION["eje"]);
   
	locate_template($template, true, false);
}
?>
        



