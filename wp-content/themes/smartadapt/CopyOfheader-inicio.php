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
</head>

<body <?php body_class(); ?>>
<?php smartadapt_lt_ie7_info(); //display info if IE lower than 7  ?>
<div class="top-bar-outer">
	<?php
	//fixed top bar option
	$fixed = smartadapt_option( 'smartadapt_fixed_topbar' );
	?>

	<div id="top-bar" class="top-bar home-border<?php echo $fixed=='1'? ' fixed-top-bar':'' ?>">
		<div class="row">	
			<div class="columns mobile-three">
				<!--falayout search menu-->
				<?php //smartadapt_searchmenu(); //display search menu ?>	
				<nav id="top-navigation" class="right hide-for-small">
					<?php wp_nav_menu( array( 'theme_location' => 'top_pages', 'menu_class' => 'top-menu' ) ); ?>
				</nav>						
			</div>			
			<div class="columns" style="width:30%;float:right;">				
				 <div style="float:right;padding-top:5px;margin:0" >
					<?php dynamic_sidebar('sidebar-6');?>
				</div>
			</div>			
		</div>		
	</div>		
</div>

<header style="background:#7190C9;height:100px">
	<div style="height:100px;width:100%; margin-left: auto; margin-right: auto"><!-- Header Logo y buscador -->
	
		<div style="float:left;width:55%;padding-top:20px;padding-left: 80px">
			<!--<div style="float:left;width:60%">-->
				<img src="http://localhost/SecyTec/wp-content/uploads/2014/10/logo2.jpg" alt="" style="width:295px;height:65px" />
			<!--  </div>
			<div style="width:40%;height:50px;float:left" >			
				<?php //dynamic_sidebar('sidebar-6');?>			
			</div>	-->
		</div>	
	
	</div>
	
</header>


	

           



