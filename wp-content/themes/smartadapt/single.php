<?php
/**
 * The Template for displaying all single posts.
 */
get_header();
$category = get_the_category();
?>

<div id="content" class="<?php echo get_class_of_component('content', smartadapt_option( 'smartadapt_layout' )) ?>" role="main">

    <?php while (have_posts()) : the_post(); ?>

    <?php
    if (get_post_format()) {
        get_template_part('content', get_post_format());
		
    } else {
        get_template_part('content', 'single');
    }
    ?>

    <?php //smartadapt_single_nav(); ?>

	   <?php //smartadapt_get_related_post($category[0]->cat_ID, get_the_ID(), 8, 4); ?>

    <?php comments_template('', true); ?>

    <?php endwhile; // end of the loop. ?>

</div><!-- #content -->
<?php
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