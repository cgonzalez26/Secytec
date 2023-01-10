<?php
/**
 * The template for displaying posts in the Image post format
 *
 */
?>

<div class="post-box">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
		<?php if ( is_single() ) : ?>
		<h2 class="entry-title"><?php the_title(); ?></h2>
		<?php else : ?>
		<h2 class="entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>
		</header>
		<?php endif; // is_single() ?>
		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'smartadapt' ) ); ?>
		</div>
		<!-- .entry-content -->

		<footer class="entry-meta">
			<?php
			if ( is_single() ) {
				?>
				<h2><?php the_title(); ?></h2>
				<?php
			}
			else {
				?>
				<h2><a href="<?php the_permalink(); ?>"
							 title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'smartadapt' ), the_title_attribute( 'echo=0' ) ) ); ?>"
							 rel="bookmark"><?php the_title(); ?></a></h2>
				<?php
			}
			?>

			<time class="entry-date"
						datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo get_the_date(); ?></time>



			<?php edit_post_link( __( 'Edit', 'smartadapt' ), '<span class="edit-link">', '</span>' ); ?>
		</footer>
		<!-- .entry-meta -->
	</article>
	<!-- #post -->
</div><!-- .post-box -->
