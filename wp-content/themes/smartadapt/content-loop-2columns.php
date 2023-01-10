<?php
/**
 * The 2 columns template for displaying content.
 */
?>
<div class="post-box columns eight column-box">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php if (is_sticky() && is_home() && !is_paged()) : ?>
        <div class="featured-post">
            <?php _e('Featured post', 'smartadapt'); ?>
        </div>
        <?php endif; ?>
        <header class="entry-header">


            <div class="top-meta">
                <?php smartadapt_category_line(); ?>
            </div>
            <h2 class="entry-title">
                <a href="<?php the_permalink(); ?>"
                   title="<?php echo esc_attr(sprintf(__('Permalink to %s', 'smartadapt'), the_title_attribute('echo=0'))); ?>"
                   rel="bookmark"><?php the_title(); ?></a>
            </h2>

            <p class="meta-line">
                <?php echo smartadapt_get_date() ?>
                <span
                    class="meta-label meta-publisher vcard"><?php _e('Published by: ', 'smartadapt') ?> <?php the_author_posts_link(); ?> </span>
            </p>
        </header>
        <!-- .entry-header -->
        <div class="row">
            <div class="columns sixteen">
                <?php
							$post_format = get_post_format();


                if ('' != get_the_post_thumbnail()) {
                    ?>
                   <div class="thumbnail-outer format-ico <?php echo $post_format.'-ico' ?>"><a href="<?php the_permalink(); ?>"
																																										 title="<?php echo esc_attr(sprintf(__('Permalink to %s', 'smartadapt'), the_title_attribute('echo=0'))); ?>"
																																										 ><?php the_post_thumbnail('two-column-thumbnail'); ?></a></div>

                    <?php
                }elseif($post_format=='gallery'){
									$featured_image = get_featured_image('two-column-thumbnail');
									if(!empty($featured_image)){
									?>

									<div class="thumbnail-outer format-ico <?php echo $post_format.'post-ico' ?>"><a href="<?php the_permalink(); ?>"
																																												 title="<?php echo esc_attr(sprintf(__('Permalink to %s', 'smartadapt'), the_title_attribute('echo=0'))); ?>"
											><?php echo $featured_image ?></a></div>

									<?php
									}
								}
                if (is_search()) : // Only display Excerpts for Search
                    ?>
                    <div class="entry-summary">
											<a href="<?php the_permalink(); ?>"><?php the_excerpt(); ?></a>
                    </div><!-- .entry-summary -->
                    <?php else : ?>
                    <div class="entry-content">
											<a href="<?php the_permalink(); ?>"><?php the_content(__('Continue reading', 'smartadapt') . ' <i class="icon-arrow-right"></i>'); ?></a>
										 </div><!-- .entry-content -->
                    <?php endif; ?>
            </div>
        </div>

        <!-- .entry-meta -->
    </article>
    <!-- #post -->
</div><!-- .post-box -->
