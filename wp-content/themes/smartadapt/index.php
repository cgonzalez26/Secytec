<?php
/**
 * SmartAdapt main template file.
 *
 * @package    WordPress
 * @subpackage SmartAdapt
 * @since      SmartAdapt 1.0
 */

get_header(); ?>


<div id="content" class="<?php echo get_class_of_component('content', smartadapt_option( 'smartadapt_layout' )) ?>" role="main">
	<?php if ( have_posts() ) : ?>

	<?php /* start the loop */ ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'content'); ?>
		<?php endwhile;

	smartadapt_content_nav( 'nav-below' );

	?>
	<?php else : ?>
	<article id="post-0" class="post no-results not-found">

		<?php if ( current_user_can( 'edit_posts' ) ) :
		// show a different message to a logged-in user who can add posts.
		?>
		<header class="entry-header">
			<h2 class="entry-title"><?php _e( 'no posts to display', 'smartadapt' ); ?></h2>
		</header>

		<div class="entry-content">
			<p><?php printf( __( 'ready to publish your first post? <a href="%s">get started here</a>.', 'smartadapt' ), admin_url( 'post-new.php' ) ); ?></p>
		</div><!-- .entry-content -->

		<?php
	else :
		// show the default message to everyone else.
		?>
		<header class="entry-header">
			<h2 class="entry-title"><?php _e( 'nothing found', 'smartadapt' ); ?></h2>
		</header>

		<div class="entry-content">
			<p><?php _e( 'apologies, but no results were found. perhaps searching will help find a related post.', 'smartadapt' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
		<?php endif; // end current_user_can() check ?>

	</article><!-- #post-0 -->

	<?php endif; // end have_posts() check ?>

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
