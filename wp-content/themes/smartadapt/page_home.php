<!--?php /* Template Name: page_home */ ?-->
<?php
/**
 * The template for displaying all pages.
 *
 */

get_header('sinmenu'); ?>

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
    <?php get_template_part('content', 'page'); ?>
    <?php //comments_template('', true); ?>
    <?php endwhile; // end of the loop. ?>


</div><!-- #content -->
<?php
if(check_position_of_component('menu', 'right', smartadapt_option( 'smartadapt_layout' ))){
	//get_template_part('section', 'menu');
}//if menu is one the right side
?>
</div><!-- #main -->

</div><!-- #page -->

<?php
//add sidebar on the right side
//if(check_position_of_component('sidebar', 'right', smartadapt_option( 'smartadapt_layout' )))
	//get_sidebar();
?>
</div><!-- #wrapper -->
<?php get_footer('inicio'); ?>