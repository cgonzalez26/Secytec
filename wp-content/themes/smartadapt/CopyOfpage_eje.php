<!--?php /* Template Name: page_eje */ ?-->
<?php
/**
 * The template for displaying all pages.
 *
 */

get_header(); ?>

<div id="content" class="<?php echo get_class_of_component('content', smartadapt_option( 'smartadapt_layout' )) ?>" role="main">
	<header class="row" id="breadcrumb">
		<?php
        // cristian
        if ( ! empty( $banner_header ) && ( $banner_display_subpages == '1' ) ):

        ?>
		<div class="header-banner">
			<?php echo $banner_header ?>
		</div>
		<?php
		endif;
		?>
		<?php  smartadapt_the_bredcrumb(); ?>
	</header>

    <?php while (have_posts()) : the_post(); ?>
    <?php get_template_part('content', 'page-eje'); ?>
    <?php //comments_template('', true); ?>
    <?php endwhile; // end of the loop. 
    
    $args = array(
        'child_of' => 24,
        'hide_empty' => 0,
        'hierarchical' => 1,
    );
    $categories = get_categories($args);
    var_export($categories);
    ?>
	
	<!-- #division de sectores de los Ejes -->
	<div style="height:210px;margin-top:10px">
		<article class="post-35 page type-page status-publish hentry">
			<div style="width:100%">Sector 1</div>
			<div style="width:100%">	
				<div style="background:#FFF;padding:10px;width:30%;height:200px;float:left;border:1px solid #000">
					<center>
					    <img src="./wp-includes/images/no_image.gif" alt="" border="1" style="height:140px;width:100%;" /><br />
					    Articulo 1<br />
					  				    
					 </center>
				</div>
				<div style="width:5%;height:270px;float:left;"></div>
				<div style="background:#FFF;padding:10px;width:30%;height:200px;float:left;border:1px solid #000">
					<center>
						<img src="./wp-includes/images/no_image.gif"  alt="" border="1" style="height:140px;width:100%;" /><br />
						Articulo 2<br />											   
					</center>
				</div>
				<div style="width:5%;height:270px;float:left;"></div>
				<div style="background:#FFF;padding:10px;width:30%;height:200px;float:right;border:1px solid #000">
					<center>
						<img src="./wp-includes/images/no_image.gif"  alt="" border="1" style="height:140px;width:100%;" /><br />
						Articulo 3<br>
					</center>
				</div>
			</div>
		</article>	
	</div>
	
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
</div><!-- #wrapper -->

<div id="divBanners" style="height:180px;background:#E6E7E8;text-align:center"> <!-- #banners -->
   Banners
</div>

<div id="divNavegacion" style="height:120px;background:#52658C;text-align:center"> <!-- #links -->
   Mapa de Navegacion
</div>

<?php get_footer('page'); ?>