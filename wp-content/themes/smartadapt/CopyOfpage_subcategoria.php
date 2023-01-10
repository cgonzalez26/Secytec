<!--?php /* Template Name: page_subcategoria */ ?-->
<?php
/**
 * The template for displaying all pages.
 *
 */
add_filter( 'body_class', 'my_class_names' );
function my_class_names( $classes ) {
	// add 'class-name' to the $classes array
	$classes[] = 'woocommerce woocommerce-page';
	// return the $classes array
	return $classes;
}
get_header('shop'); 

function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

?>

<div id="content" class="<?php echo get_class_of_component('content', smartadapt_option( 'smartadapt_layout' )) ?>" role="main">
	<!--<header class="row" id="breadcrumb">
		<?php
        // cristian
        //if ( ! empty( $banner_header ) && ( $banner_display_subpages == '1' ) ):

        ?>
		<div class="header-banner">
			<?php //echo $banner_header ?>
		</div>
		<?php
		//endif;
		?>
		<?php  //smartadapt_the_bredcrumb(); ?>
	</header>-->

    <?php while (have_posts()) : the_post(); ?>
    <?php get_template_part('content', 'page-eje'); ?>
    <?php //comments_template('', true); ?>
    <?php endwhile; // end of the loop. 
    
    $args = array(
        'child_of' => $_SESSION["categoria_padre"],
        'hide_empty' => 0,
        'hierarchical' => 1,
    );
    $categories = get_categories($args);//Categorias del Menu de cada Eje
    //var_export($categories);
    //obtener el slug de la pagina actual
	$post_id = $wp_query->post->ID;
	$post = get_post( $post_id );
    $slug = $post->post_name;
    //echo $slug;
    //foreach( $categories as $category ) {     
	    //echo wp_list_categories('orderby=id&show_count=1&use_desc_for_title=0&child_of=14');devuelve con LI 
        $args = array( 'post_type' => 'product', 'posts_per_page' => 10, 'product_cat' => $slug, 'orderby' => 'menu_order', 'order' => 'ASC' );
        $loop = new WP_Query( $args );
        //if ( have_posts() ) :
        if( $loop->have_posts() ) :
            ?><!-- #division de sectores de los Ejes -->
            <div style="width:100%"><h3><?php echo $category->name;?></h3></div>
					
			
            <?php 
	        while( $loop->have_posts() ) : $loop->the_post(); global $product; ?>	            	
                  
                    	<!--  <div style="width:100%;background:#E6E7E8;border:1px solid" >-->                    		
                    		<table cellpadding="0" cellspacing="0" style="width:100%">
                    		<tr>
	                    		<td>
		                    		<a rel="nofollow" href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>" >
		                        	<?php //woocommerce_show_product_sale_flash( $post, $product ); 	                        
		                        	//if (has_post_thumbnail( $loop->post->ID )){
		                        	//array(width, height)	                        			
		                        		echo get_the_post_thumbnail($loop->post->ID,'shop_thumbnail'); 
		                        	?></a>
	                        	</td>
	                        	<td>
	                        	 <a rel="nofollow" href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>" >
	                        	 <h4><?php the_title();?></h4></a>
	                        	 <?php echo the_excerpt_max_charlength(120);//echo $loop->post->post_excerpt; ?>
	                        	</td> 
                        	</tr>
                        	</table>
                        	 
                        <!-- </div>                      		-->
                       
                    <?php // woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?>	
               
	    	<?php endwhile; ?>
	   		
		
	    <?
	    endif;
    	wp_reset_query(); 
		   ?>			
		
	<?php //} endforeach?>
</div><!-- #content -->
<?php
//echo "eje";
if(check_position_of_component('menu', 'right', smartadapt_option( 'smartadapt_layout' ))){
	get_template_part('section', 'menu');
}//if menu is one the right side
?>
</div><!-- #main -->

</div><!-- #page -->

<?php
//add sidebar on the right side
if(check_position_of_component('sidebar', 'right', smartadapt_option( 'smartadapt_layout' )))
	get_sidebar();
?>
</article><!-- article -->
</section><!-- #page-header -->
</div><!-- #wrapper -->
</div><!-- .main -->

<?php get_footer(); ?>