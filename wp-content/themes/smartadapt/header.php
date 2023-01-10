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
    <link rel="stylesheet" href="http://localhost:8080/Secytec/wp-content/themes/smartadapt/style.css?ver=4.0" type="text/css">
	<script type="text/javascript" src="http://localhost:8080/SecyTec/wp-content/themes/smartadapt/js/foundation/app.js?ver=1.0"></script>
	<script type="text/javascript" src="http://localhost:8080/SecyTec/wp-content/themes/smartadapt/js/mobile-menu.js?ver=4.0"></script>
    <style>
	
	/*daniel*/
	

	/*#masthead {
	padding-left: 20px;
	padding-right: 20px;
	/*daniel
	padding-top:0;
	padding-bottom:0;
	background: #441021 url('../images/patt.png') top center no-repeat;
	/*background: #e29d02 url(../images/bg-masthead-wrapper.jpg) top center no-repeat;
	}*/
	/*
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
	#masthead hgroup a {
    background-image: url(images/logo.png);
    display: block;
    height: 132px;
    line-height: 132px;
    overflow: hidden;
    position: relative;
	width: 150px;
    z-index: 2;
	}*/
/*daniel
#masthead nav {
margin-left: 210px;
}*/	
/*
#navigation-secondary {
display: inline;
float: left;
font-size: 14px;
font-size: 1.2rem;
text-transform: uppercase;
letter-spacing: .2em;
}

#navigation-main {
font-family: "tradegothic-condensed-bold", "din-condensed-web-1", "din-condensed-web-2", "Arial Narrow", "Helvetica Neue", Arial, sans-serif;
font-size: 31px;
font-size: 1.5rem;
text-transform: uppercase;
}

#navigation-secondary li {
padding-right: 60px;
position: relative;
}

#masthead li {
display: inline;
float: left;
}*/
/*daniel
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
daniel
color: #E7B041;
border-color: #E7B041;
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
color: #7E4154;
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
height:32px;
}

.search-form button span {
background: url(./wp-content/themes/smartadapt/images/icon-search.png) no-repeat 0 2px;
display: block;
height: 24px;
width: 17px;
}*/
/*daniel
#navigation-main li {
margin-left: 0%;
margin-right: 0.2%;
margin-top: 12px;
padding:0;
background: #4C1728;
}*/
/*daniel
#navigation-main a:hover, #navigation-main a:focus {
background: #621D36;
}

#masthead .search-form {
display: inline;
float: right;
margin: 33px 0 0 40px;
width: 20%;
}

.search-form {
position: relative;
}*/

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
<?php
//ruta_plantilla();
	//fixed top bar option
	$fixed = smartadapt_option( 'smartadapt_fixed_topbar' );
	 $clase_boton_eje1 = "nav-vocacion";// Clase por Defecto
     $clase_boton_eje2 = "nav-articulacion";
     $clase_boton_eje3 = "nav-desarrollo";
	 if($_GET["eje"]){
         $_SESSION["eje"]=$_GET["eje"];
     }
	   switch($_SESSION["eje"]){
			   case 1:
					   $_SESSION["categoria_padre"]=24;
					   $clase_boton_eje1 = "current_page_item";
					   $_SESSION["color_eje"]="#cc5d1d";
					   break;
			   case 2:
					   $_SESSION["categoria_padre"]=25;
					   $clase_boton_eje2 = "current_page_item";
					   $_SESSION["color_eje"]="#1859a9";
					   break;
			   case 3:
					   $_SESSION["categoria_padre"]=26;
					   $clase_boton_eje3 = "current_page_item";
					   $_SESSION["color_eje"]="#1795a9";
					   break;        
	   }
	?>
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
				<input type="search" name="s" placeholder="Buscar" value="">
				<input type="hidden" name="sections" title="Enter search terms" value="">
				<button type="submit"><span></span>Search</button>
				</form>
				</div>
			</div>
			<nav id="navigation-main">
			<ul>
            	<li class="explore"><span>Explora nuestros ejes</span></li>
				<li id="nav-vocacion" class="has-children">
					<!--<a href="?page_id=35&eje=1">Vocación Científica</a>-->
					<a href="<?php echo esc_url( home_url( '/' ) )."?page_id=35&eje=1"; ?>"
                         title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"
                         rel="home"
                         class=<?php echo $clase_boton_eje1;?> >Vocación Científica</a>
				</li>
				<li id="nav-articulacion">
					<!--<a href="?page_id=50&eje=2">Articulación Tecnológica</a>-->
					 <a href="<?php echo esc_url( home_url( '/' ) )."?page_id=50&eje=2"; ?>"
                         title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"
                         rel="home"
                         class=<?php echo $clase_boton_eje2;?> >Articulación Tecnológica</a>
					</li>
				<li id="nav-desarrollo" class="has-children">
					<!--<a href="?page_id=52&eje=3">Desarrollo Científico</a>-->
					<a href="<?php echo esc_url( home_url( '/' ) )."?page_id=52&eje=3"; ?>"
                        title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"
                        rel="home"
                        class=<?php echo $clase_boton_eje3;?> >Desarrollo Científico</a>
				</li>
			</ul>
			</nav>
			</div>

			
		</header><!-- #masthead -->

<!-- <header class="entry-header row" style="max-width: 1240px;border-bottom:1px solid #D8D8D8;padding-left:212px;padding-top:20px;height:80px">
    <h3 class="entry-title"><?php //the_title(); ?></h3>
</header>-->
<?php
global $post;
$args = array('taxonomy'=>'product_cat',);
$terms = wp_get_post_terms($post->ID,'product_cat',$args);
$count = count($terms);
$categ = "";
$categ_parent = "";
//$_terms = wp_get_post_terms($post->ID, 'product_cat');

/*$parent  = get_term_by( 'id', $post->ID, 'product_cat');
while ($parent->parent != '0'){
    $term_id = $parent->parent;
    $categ_parent  = get_term_by( 'id', $term_id, $taxonomy);
}*/
  

if($count > 0){
	foreach($terms as $term){
		$categ .= $term->name;			
   	    /*$ancestors = get_ancestors($term->id, 'product_cat');
   	     $ancestors = array_reverse($ancestors);

        $origin_ancestor = get_term_by("id", $ancestors[0], "product_cat");
        $origin_ancestor_id = $origin_ancestor->term_id;
        //echo $origin_ancestor_id;
     	//$categ_parent .= $term->name;	*/
	}
}
//mostrar Categoria en Articulos y en Subcategorias
//<!--  <a href="<?php //echo get_permalink(get_page_by_slug($category->slug));" style="color:#6f6f6f;"><?php //echo $categ_parent;</a> >-->
?>
<div class="main" role="main">
	<div id="wrapper" class="wrapper row">
	<section id="page-header">
	<article>
		<hgroup>
			
			<a href="<?php echo get_permalink(get_page_by_slug($category->slug));?>" style="color:#6f6f6f;"><?php echo $categ;?></a>
			<h2 class="entry-title"><?php the_title(); ?></h2>
		</hgroup> 
	<?php
	//if sidebar is one the left side
		if(check_position_of_component('sidebar', 'left', smartadapt_option( 'smartadapt_layout' )))
			get_sidebar();
	?>
	<div id="page" role="main" class="<?php echo get_class_of_component('page', smartadapt_option( 'smartadapt_layout' )) ?>">
		<?php
		//smartadapt_header(); //display header info or header image

		?>
		<div id="main" class="row1">
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
	$template = "section-menu.php";
	$options = array('eje' => $_SESSION["eje"]);
	locate_template($template, true, false);
}
?>
        


	

           




        



