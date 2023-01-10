<?php
/**
 * The template for displaying posts in the Quote post format
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
		<?php endif; ?>
		</header>
        <div class="entry-content">
            <blockquote><?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', 'smartadapt')); ?></blockquote>
        </div>
        <!-- .entry-content -->

        <footer class="entry-meta">
       <?php echo get_the_date(); ?>

            <?php edit_post_link(__('Edit', 'smartadapt'), '<span class="edit-link">', '</span>'); ?>
        </footer>
        <!-- .entry-meta -->
    </article>
    <!-- #post -->
</div><!-- .post-box -->
