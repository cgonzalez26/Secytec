<?php
/**
 * The template for displaying posts in the Aside post format
 */
?>
<div class="post-box">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<div class="aside">

					<?php if ( is_single() ) : ?>
					<h2 class="entry-title"><?php the_title(); ?></h2>
					<?php else : ?>
					<h2 class="entry-title">
						<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h2>
					<?php endif; // is_single() ?>

            <div class="entry-content">
                <?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', 'smartadapt')); ?>
            </div>
            <!-- .entry-content -->
        </div>
        <!-- .aside -->

        <footer class="entry-meta">
            <p class="meta-line"><?php echo smartadapt_get_date() ?></p>
            <?php edit_post_link(__('Edit', 'smartadapt'), '<span class="edit-link">', '</span>'); ?>
        </footer>
        <!-- .entry-meta -->
    </article>
    <!-- #post -->
</div><!-- .post-box -->