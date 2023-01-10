<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 */
?>
<div class="post-box <?php echo (is_sticky() && is_home()) ? 'featured-content' : ''; ?>">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php if (is_sticky() && is_home() && !is_paged()) : ?>
        <div class="featured-post">
            <?php _e('Featured post', 'smartadapt'); ?>
        </div>
        <?php endif; ?>
        <header class="entry-header">

            <?php if (is_single()) : ?>
            <h2 class="entry-title"><?php the_title(); ?></h2>
            <?php else : ?>
            <div class="top-meta">
                <?php smartadapt_category_line(); ?>
            </div>
            <h2 class="entry-title">
                <a href="<?php the_permalink(); ?>"
                   title="<?php echo esc_attr(sprintf(__('Permalink to %s', 'smartadapt'), the_title_attribute('echo=0'))); ?>"
                   rel="bookmark"><?php the_title(); ?></a>
            </h2>
            <?php endif; // is_single() ?>
            <p class="meta-line">
                <?php echo smartadapt_get_date() ?>
                <span
                    class="meta-label meta-publisher vcard"><?php _e('Publicado por: ', 'smartadapt') ?> <?php the_author_posts_link(); ?> </span>
            </p>
        </header>
        <!-- .entry-header -->
        <div class="row">
            <div class="columns sixteen">
                <?php
							$featured_image = get_featured_image( 'single-post-small' );
							$post_format = get_post_format();
                if ('' != get_the_post_thumbnail()) {
                    ?>
                    <div class="thumbnail-outer format-ico <?php echo $post_format.'post-ico' ?>"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('single-post-small'); ?></a></div>

                    <?php
                }else if ( ! empty( $featured_image ) ) {
									?>
									  <div class="thumbnail-outer format-ico <?php echo $post_format.'post-ico' ?>"><a href="<?php the_permalink(); ?>"><?php echo $featured_image; ?></a></div>
										<?php
								}


                if (is_search()) : // Only display Excerpts for Search
                    ?>
                    <div class="entry-summary">
                        <?php the_excerpt(); ?>
                    </div><!-- .entry-summary -->
                    <?php else : ?>
                    <div class="entry-content">
                        <?php the_content(__('Continue reading', 'smartadapt') . ' <i class="icon-arrow-right"></i>'); ?>
                        <?php smartadapt_custom_wp_link_pages(); ?>
                    </div><!-- .entry-content -->
                    <?php endif; ?>
            </div>
        </div>

        <?php
        if (is_single()) {
            ?>
            <div class="row">
               <?php if(has_tag()): ?>
                <div class="left columns sixteen tags-article"><i
                    class="icon-tags icon-left"></i> <?php the_tags(__('Tags: ', ', ')); ?></div>
							 <?php endif; ?>
            </div>

            <?php
        }
        ?>



        <footer class="entry-meta">
            <?php edit_post_link(__('Edit', 'smartadapt'), '<span class="edit-link">', '</span>'); ?>
            <?php if (is_singular() && get_the_author_meta('description') && is_multi_author()) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries. ?>
            <div class="author-info">
									<?php get_template_part( 'views/snippets/author_info' ); ?>
            </div><!-- .author-info -->
            <?php endif; ?>
        </footer>
        <!-- .entry-meta -->
    </article>
    <!-- #post -->
</div><!-- .post-box -->
