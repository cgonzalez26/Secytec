<!--?php /* Template Name: page_eje */ ?-->
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
get_header(); 

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
		<?php // smartadapt_the_bredcrumb(); ?>
	</header>-->

    <?php while (have_posts()) : the_post(); ?>
    <?php get_template_part('content', 'page-eje'); ?>
    <?php //comments_template('', true); ?>
    <?php endwhile; // end of the loop. 
    
    $args = array(
        //'child_of' => $_SESSION["categoria_padre"],
        'parent' => $_SESSION["categoria_padre"],
        'hide_empty' => 0,
        'hierarchical' => 1,
    );
    $categories = get_categories($args);//Categorias del Menu de cada Eje
    //var_export($categories);
    
    foreach( $categories as $category ) {  
    	//echo $category->slug;   
	    //echo wp_list_categories('orderby=id&show_count=1&use_desc_for_title=0&child_of=14');devuelve con LI 
        $args = array( 'post_type' => 'product', 'posts_per_page' => 3, 'product_cat' => $category->slug, 'orderby' => 'menu_order', 'order' => 'ASC' );
        $loop = new WP_Query( $args );
        //if ( have_posts() ) :
        if( $loop->have_posts() ) :
            ?><!-- #division de sectores de los Ejes --> <!-- daniel 15/12/14 -->
            <div style="width:100%; margin-bottom:30px; padding-top:10px; border-top: 1px #dfdfdf solid"><!-- daniel 13/01/15 -->
            	<a href="<?php echo get_permalink(get_page_by_slug($category->slug));?>" class="title-category"><?php echo $category->name;?></a></div>
			<div style="width:100%">		
			<ul class="products">
            <?php 
	        while( $loop->have_posts() ) : $loop->the_post(); global $product; ?>	            	
                <!--  <li class="post-20 product type-product status-publish shipping-taxable product-type-simple product-cat-cursos instock" style="margin:0 2% 0 0;border:1px solid #D8D8D8">-->
                <li class="product">  <!--style="margin:0 2% 0 0;border:1px solid #D8D8D8" daniel-->    
                    	<div class="related-post-headline">
                    		<a rel="nofollow" href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>" >
                        <?php //woocommerce_show_product_sale_flash( $post, $product ); 	                        
                        if (has_post_thumbnail( $loop->post->ID )){	                        			
                        	echo the_title()."</a></div>
                        	<div style='height:3px;background:".$_SESSION["color_eje"]."'></div>
                        	<div style='width:100%;line-height:0px'>";                      		
                        	//echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog');
                        	echo get_the_post_thumbnail($loop->post->ID, 'shop_single')."</div>"; 
                        }else{ 
                        	//echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="150px" height="150px" class="woocommerce-placeholder wp-post-image"/>'; 
                       		echo  the_title()."</div>";
                       		//echo "<div style='font-size:0.8em;height:155px'>".apply_filters( 'woocommerce_short_description', $post->post_excerpt )."</div>";
                        }
                       ?> 	                                       	
                    <?php //woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?>	
                </li>
	
	    	<?php endwhile; ?>
	   		</ul><!--/.products-->
		</div>
	    <?php
	    endif;
    	wp_reset_query(); 
		   ?>			
		
	<?php }?>
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