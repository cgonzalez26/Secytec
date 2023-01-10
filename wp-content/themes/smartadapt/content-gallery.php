<?php
/**
 * The default template for displaying single content.
 *
 */
?>
<div class="post-box">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
		<div class="featured-post">
			<?php _e( 'Featured post', 'smartadapt' ); ?>
		</div>
		<?php endif; ?>
		<header class="entry-header">

			<?php if ( is_single() ) : ?>
			<h2 class="entry-title"><?php the_title(); ?></h2>
			<?php else : ?>
			<h2 class="entry-title">
				<a href="<?php the_permalink(); ?>"
					 title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'smartadapt' ), the_title_attribute( 'echo=0' ) ) ); ?>"
					 rel="bookmark"><?php the_title(); ?></a>
			</h2>
			<?php endif; // is_single() ?>
			<div class="meta-line"><?php echo smartadapt_get_date() ?> <?php smartadapt_category_line(); ?></div>
		</header>
		<!-- .entry-header -->
		<div class="row">
			<?php get_template_part('views/snippets/gallery_social_area'); ?>
		</div>
		<div class="row">
			<?php if ( has_tag() ): ?>
			<div class="left columns sixteen tags-article"><i
					class="icon-tags icon-left"></i> <?php the_tags( __( 'Tags: ', 'smartadapt' ), ', ' ); ?></div>
			<?php endif ?>
		</div>

		<div class="entry-content">
			<?php the_content(__('Continue reading', 'smartadapt') . ' <i class="icon-arrow-right"></i>'); ?>
			<?php smartadapt_custom_wp_link_pages(); ?>
		</div>
		<!-- .entry-content -->

		<footer class="entry-meta">
			<?php edit_post_link( __( 'Edit', 'smartadapt' ), '<span class="edit-link">', '</span>' ); ?>
			<?php if ( is_singular() && get_the_author_meta( 'description' ) && is_multi_author() ) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries. ?>
			<div class="author-info">
				<?php get_template_part( 'views/snippets/author_info' ); ?>
			</div><!-- .author-info -->
			<?php endif; ?>
		</footer>
		<!-- .entry-meta -->
	</article>
	<!-- #post -->
</div><!-- .post-box -->
