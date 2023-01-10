<!--?php /* Template Name: page_categoria */ ?-->
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

?>

<div id="content" class="<?php echo get_class_of_component('content', smartadapt_option( 'smartadapt_layout' )) ?>" role="main">
	<!--  <header class="row" id="breadcrumb">
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
    
    //obtener el slug de la pagina actual(Categoria)
    global $wp_query;
	$post_id = $wp_query->post->ID;
	$post = get_post( $post_id );
    $slug = $post->post_name;
	//var_export($post);
	
    //# getting the main category of the page
    $idObj = get_category_by_slug($slug); 
 	$catid = $idObj->term_id;
   
    $args = array(
        'child_of' => $catid,
        'hide_empty' => 0,
        'hierarchical' => 1,
    );
    $categories = get_categories($args);//Categorias del Menu de cada Eje    
	$post_categories = get_the_category($post_id);
	
	$category = get_the_category($post_id);
	$parent = $category[0]->term_id;
	//echo $parent;
	
    foreach( $categories as $category ) {   
    	var_export($category);
    	//echo get_category_parents($category->id,true);
        $args = array('post_type' => 'product','posts_per_page' => 10,'product_cat' => $category->slug,'orderby' => 'rand' );
        $loop = new WP_Query( $args );
        //if ( have_posts() ) :
        if( $loop->have_posts() ) :
            ?><!-- #division de sectores de los Ejes -->
            <div style="width:100%; margin-bottom:5%; padding-top:2%; border-top: 1px #eee solid">
            	<h5><a href="<?php echo get_permalink(get_page_by_slug($category->slug));?>"><?php echo $category->name;?></a></h5>
            </div>
			<!-- daniel 15/12/14 -->
            <?php 
	        while( $loop->have_posts() ) : $loop->the_post(); global $product; ?>	            	
                  
                    	<!--  <div style="width:100%;height:105px;background:#E6E7E8;margin-bottom:10px;padding:8px;" >
                    		
                    		<div style="width:100px;height:90px;float:left">-->
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
	                        <!--  </div>
                        	<div style="height:90px;float:left">-->
                        	 <a rel="nofollow" href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>" >
                        	 <h4><?php  the_title();?></h4></a>
                        	  <?php echo the_excerpt_max_charlength(120);?>
                        	 <!--  </div> 
                        	 
                        </div>     -->
                        	</td> 
                        </tr>
                        </table>                 		
                       
                    <?php // woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?>	
               
	    	<?php endwhile; ?>
	   		
		
	    <?
	    endif;
    	wp_reset_query(); 
		   ?>			
		
	<?php } //endforeach?>
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

<?php get_footer('page'); ?>