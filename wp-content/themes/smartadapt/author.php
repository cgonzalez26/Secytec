<?php
/**
 * Template for displaying Author Archive pages.
 *
 */

get_header(); ?>

<div id="content" class="<?php echo get_class_of_component('content', smartadapt_option( 'smartadapt_layout' )) ?>" role="main">

    <?php if (have_posts()) : ?>

    <?php

    the_post();
    ?>

    <header class="archive-header">
        <h2 class="archive-title"><?php printf(__('Author Archives: %s', 'smartadapt'), '<span class="vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta("ID"))) . '" title="' . esc_attr(get_the_author()) . '" rel="me">' . get_the_author() . '</a></span>'); ?></h2>
    </header><!-- .archive-header -->

    <?php
    /* Since we called the_post() above, we need to
                  * rewind the loop back to the beginning that way
                  * we can run the loop properly, in full.
                  */
    rewind_posts();
    ?>

    <?php
    // If a user has filled out their description, show a bio on their entries.
    if (get_the_author_meta('description')) : ?>
        <div class="author-info">
					<div class="author-avatar">
						<?php
						$user_image = get_the_author_meta( 'smartadapt_profile_image',get_the_author_meta( 'ID' ) );
						if(!empty($user_image)){
							?>
							<img src="<?php echo $user_image ?>" alt="<?php printf( __( 'About %s', 'smartadapt' ), get_the_author() ); ?>" />
							<?php
						}else
							echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'smartadapt_author_bio_avatar_size', 68 ) ); ?>
					</div>
            <!-- .author-avatar -->
            <div class="author-description">
                <h2><?php printf(__('About %s', 'smartadapt'), get_the_author()); ?></h2>

                <p><?php the_author_meta('description'); ?></p>
            </div>
            <!-- .author-description	-->
        </div><!-- .author-info -->
        <?php endif; ?>

    <?php /* Start the Loop */ ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('content','loop'); ?>
        <?php endwhile; ?>

    <?php smartadapt_content_nav('nav-below'); ?>

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