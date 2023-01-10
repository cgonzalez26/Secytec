<?php
/**
 * The template used for displaying page content in page.php
 */
?>
<div class="post-box">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <!--  <header class="entry-header">
            <h2 class="entry-title"><?php the_title(); ?></h2>
        </header>-->
		<div class="entry-content">
			<?php the_post_thumbnail('full'); ?>
		</div>
        <div class="entry-content">
            <?php the_content(); ?>
            <?php wp_link_pages(array('before' => '<div class="page-links pagination-centered">' . __('Pages:', 'smartadapt'), 'after' => '</div>')); ?>
        </div>
        <!-- .entry-content -->
        <footer class="entry-meta">
            <?php edit_post_link(__('Edit', 'smartadapt'), '<span class="edit-link">', '</span>'); ?>
        </footer>
        <!-- .entry-meta -->
    </article>
    <!-- #post -->
</div><!-- .post-box -->
