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
    <link rel="stylesheet" href="http://localhost/SecyTec/wp-content/themes/smartadapt/aplicacion.css?ver=4.0" type="text/css">
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
	
#masthead nav {
margin-left: 210px;/*daniel*/
}
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
}*/

#navigation-secondary li {
padding-right: 60px;
position: relative;
}

#masthead li {
display: inline;
float: left;
}
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
}*/

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
}
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
}*/

#masthead .search-form {
display: inline;
float: right;
margin: 33px 0 0 40px;
width: 20%;
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
	</style>
</head>

<body <?php body_class(); ?>>
<!--  <div id="page" class="hfeed site">-->
		<header id="masthead" class="site-header" role="banner">
			<div class="wrapper">
				<hgroup><h1><a href="http://localhost/Secretaria/">Secretaria</a></h1>
			</hgroup>
			<nav id="navigation-secondary">
			<ul>
				<?php wp_nav_menu( array( 'theme_location' => 'top_pages', 'menu_class' => 'top-menu' ) ); ?>
			</ul></nav>
			<div class="search-wrapper">
			<div class="search-mobile"></div>
				<div class="search-form">
				<?php dynamic_sidebar('sidebar-6');?>
				<!-- <form method="get" action="/search/">
				<input type="search" name="keywords" placeholder="Buscar..." value="">
				<input type="hidden" name="sections" title="Enter search terms" value="exhibitions,events,pages,online-resources,articles,speech,milestone,geo_milestone,person,timeline,trail,history">
				<button type="submit"><span></span>Search</button>
				</form> -->
				</div>
			</div>
			<nav id="navigation-main">
			<ul>
            	<li class="explore"><span>Explora nuestros ejes</span></li>
				<li id="nav-visiting" class="has-children"><a href="?page_id=35&eje=1">Vocación Científica</a></li>
				<li id="nav-whats-on"><a href="?page_id=50&eje=2">Articulación Tecnológica</a></li>
				<li id="nav-collection" class="has-children"><a href="?page_id=52&eje=3">Desarrollo Científico</a></li>
			</ul>
			</nav>
			</div>

			
		</header><!-- #masthead -->

		<div id="main" class="site-main">
		



	

           



