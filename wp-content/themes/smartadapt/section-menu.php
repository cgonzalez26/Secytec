<div class="<?php echo get_class_of_component('menu', smartadapt_option( 'smartadapt_layout' )) ?>">
<nav id="site-navigation" class="main-navigation hide-for-small" role="navigation">

<a class="assistive-text" href="#content"
		title="<?php esc_attr_e( 'Skip to content', 'smartadapt' ); ?>"><?php _e( 'Skip to content', 'smartadapt' ); ?></a>
	<?php
	//fixed menu option
	$fixed = smartadapt_option( 'smartadapt_menu_fixed' );
?>
<div class="nav-menu tabs vertical<?php echo $fixed=='1'? ' fixed-menu':'' ?>">
	<?php //Cristian
	if ( !empty( $eje ) )
    	add_filter( 'wp_nav_menu_objects', 'wpse_82194_add_param' );
	
	/**
	 * Add a parameter to item URLs.
	 *
	 * @wp-hook wp_nav_menu_objects
	 * @param   array $items
	 * @return  array
	 */
	function wpse_82194_add_param( $items )	{
	    $out = array ();	
	    foreach ( $items as $item ) {
	        $item->url = add_query_arg( 'eje', $eje, $item->url );
	        $out[] = $item;
	    }	
	    return $items;
	}
	
	//wp_nav_menu( array( 'theme_location' => 'categories', 'container' => false ) );
	
	if($pagina_institucional == 1){
		wp_nav_menu(array("menu"=>"Menu Institucional"));
	}else{
		switch($eje){
			case "1":
				wp_nav_menu(array("menu"=>"Menu Eje1"));
				break;
			case "2":
				wp_nav_menu(array("menu"=>"Menu Eje2"));
				break;
			case "3":
				wp_nav_menu(array("menu"=>"Menu Eje3"));
				break;
			/*default:
				wp_nav_menu(array("menu"=>"Menu Institucional"));
				break;*/	
		}
	}
	//wp_nav_menu(array("menu"=>"Menu Eje2")); 
	?>
</div>
</nav>

<!-- #site-navigation -->
</div>