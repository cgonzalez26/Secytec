<?php
/**
 * The template for displaying posts in the Status post format
 */
?>
<div class="post-box">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="entry-header">
					<header class="entry-header">
     		<?php if ( is_single() ) : ?>

     	<h2 class="entry-title"><?php the_title(); ?></h2>
     	<?php else : ?>

     	<h2 class="entry-title">
     		<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
     	</h2>
     		<?php endif; ?>
     		</header>
           <?php echo get_avatar(get_the_author_meta('ID'), apply_filters('smartadapt_status_avatar', '48')); ?>	<h5><?php the_author(); ?></h5>
        </div>
        <!-- .entry-header -->

        <div class="entry-content">
            <?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', 'smartadapt')); ?>
        </div>
        <!-- .entry-content -->

        <footer class="entry-meta">

            <?php edit_post_link(__('Edit', 'smartadapt'), '<span class="edit-link">', '</span>'); ?>
        </footer>
        <!-- .entry-meta -->
    </article>
    <!-- #post -->
</div><!-- .post-box -->