<?php
/**
 * Template for displaying Tag pages.
 */

get_header(); ?>

<div id="content" class="<?php echo get_class_of_component('content', smartadapt_option( 'smartadapt_layout' )) ?>" role="main">

    <?php if (have_posts()) : ?>
    <header class="archive-header">
        <h1 class="archive-title"><?php printf(__('Tag Archives: %s', 'smartadapt'), '<span>' . single_tag_title('', false) . '</span>'); ?></h1>

        <?php if (tag_description()) : // Show an optional tag description ?>
        <div class="archive-meta"><?php echo tag_description(); ?></div>
        <?php endif; ?>
    </header><!-- .archive-header -->

    <?php
    /* Start the Loop */
    while (have_posts()) : the_post();

        /* Include the post format-specific template for the content. If you want to
                   * this in a child theme then include a file called called content-___.php
                   * (where ___ is the post format) and that will be used instead.
                   */
        get_template_part('content', get_post_format());

    endwhile;

    smartadapt_content_nav('nav-below');
    ?>

    <?php else : ?>
    <?php get_template_part('content', 'none'); ?>
    <?php endif; ?>


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
</div><!-- #wrapper -->
<?php get_footer(); ?>