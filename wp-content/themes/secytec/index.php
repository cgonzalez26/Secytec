<?php get_header(); ?>

<?php do_action( 'bp_before_content' ) ?>

<!-- CONTENT START -->
<div class="content">
<div class="content-inner">

<?php do_action( 'bp_before_blog_home' ) ?>

<!-- POST ENTRY START -->
<div id="post-entry">
<section class="post-entry-inner">

<?php if( !is_home() ) { get_template_part( 'lib/templates/headline' ); } ?>

<?php $oddpost = 'alt-post'; $postcount = 1; if (have_posts()) : while (have_posts()) :  the_post(); ?>

<?php do_action( 'bp_before_blog_post' ) ?>

<!-- POST START -->
<article <?php post_class('home-post ' . $oddpost); ?> id="post-<?php the_ID(); ?>">

<div class="post-top">
<div class="calendar-wrap">
<span class="cdate"><?php the_time('d'); ?></span>
<span class="cmonth"><?php the_time('M'); ?></span>
</div>
<h1 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
</div>

<?php echo get_featured_post_image("<div class='post-thumb in-archive'>", "</div>", 350, 200, "alignleft", "medium", 'image-'.get_the_ID() ,get_the_title(), false); ?>

<?php echo get_featured_post_image("<div class='post-thumb in-mobile'>", "</div>", 768, 380, "alignleft", "full", 'image-'.get_the_ID() ,get_the_title(), false); ?>

<?php get_template_part( 'lib/templates/post-meta-home' ); ?>
<div class="sharebox-wrap">
<?php get_template_part( 'lib/templates/share-box' ); ?>
</div>

<div class="post-content">
<?php get_the_featured_excerpt($excerpt_length=25); ?>
<!--<div class="post-more"><a href="<?php the_permalink(); ?>" title="<?php _e('Continue reading', TEMPLATE_DOMAIN); ?> <?php the_title(); ?>"><?php _e('Continue Reading &raquo;', TEMPLATE_DOMAIN); ?></a></div>-->
</div>


</article>
<!-- POST END -->

<?php do_action( 'bp_after_blog_post' ) ?>

<?php $get_google_code = get_theme_option('adsense_post'); if($get_google_code == '') { ?>
<?php } else { ?>
<?php if( 2 == $postcount ||  4 == $postcount ){ ?>
<div class="adsense-post">
<?php echo stripcslashes($get_google_code); ?>
</div>
<?php } ?>
<?php } ?>

<?php if( 2 == $postcount ||  4 == $postcount || 6 == $postcount ||  8 == $postcount || 10 == $postcount ||  12 == $postcount){ ?>
<div class="separator"></div>
<?php } ?>

<?php ($oddpost == "alt-post") ? $oddpost="" : $oddpost="alt-post"; $postcount++; ?>

<?php endwhile; ?>

<?php comments_template( '', true ); ?>

<?php else: ?>

<?php get_template_part( 'lib/templates/result' ); ?>

<?php endif; ?>

<?php get_template_part( 'lib/templates/paginate' ); ?>

</section>
</div>
<!-- POST ENTRY END -->

<?php do_action( 'bp_after_blog_home' ) ?>

</div><!-- CONTENT INNER END -->
</div><!-- CONTENT END -->

<?php do_action( 'bp_after_content' ) ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>