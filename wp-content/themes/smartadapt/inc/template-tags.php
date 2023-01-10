<?php


/**
 *
 * SmartAdapt helper functions.
 *
 * Provides some helper functions, which are used  in the theme as custom template tags.
 *
 * @package    WordPress
 * @subpackage SmartAdapt
 * @since      SmartAdapt 1.0
 */


/**
 * Print breadcrumb trail
 *
 *
 */
function smartadapt_the_bredcrumb() {

	//Get bredcrumb separator
	$sep = ( smartadapt_option( 'breadcrumb_separator' ) ) ? smartadapt_option( 'breadcrumb_separator' ) : ' &raquo; ';


	if ( ! is_front_page() ) {
		echo '<a href="';
		echo home_url();
		echo '">';
		bloginfo( 'name' );
		echo '</a>' . $sep;

		if ( is_category() || is_single() ) {
			the_category( $sep );
		}
		elseif ( is_archive() || is_single() ) {
			if ( is_day() ) {
				printf( __( '%s', 'smartadapt' ), get_the_date() );
			}
			elseif ( is_month() ) {
				printf( __( '%s', 'smartadapt' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'smartadapt' ) ) );
			}
			elseif ( is_year() ) {
				printf( __( '%s', 'smartadapt' ), get_the_date( _x( 'Y', 'yearly archives date format', 'smartadapt' ) ) );
			}
			else {
				_e( 'Blog Archives', 'smartadapt' );
			}
		}

		if ( is_page() ) {
			echo the_title();
		}
	}
}

/**
 *
 * Return column class string by number
 *
 * @param int $number
 *
 * @return mixed
 */

function smartadapt_column_class_by_number( $number = 16 ) {
	$class_array = array(
		'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen'
	);
	return $class_array[$number - 1];
}

/**
 * Output header
 */

function smartadapt_header() {


	$banner_header = get_theme_mod( 'banner_code_header' );

    //Display only on home page/ on all pages
	$banner_display_subpages = get_theme_mod( 'banner_display_subpages' );

    

	if ( is_front_page() ) {

        //Get header image only on frontpage
        $header_image = get_header_image();
        ?>	

	<?php
	}
	/*   cristian*/
	 else {

		?>
	<header class="row" id="breadcrumb">
		<?php
       
        if ( ! empty( $banner_header ) && ( $banner_display_subpages == '1' ) ):

        ?>
		<div class="header-banner">
			<?php echo $banner_header ?>
		</div>
		<?php
	endif;
		?>
		<?php // smartadapt_the_bredcrumb(); ?>
	</header>
	<?php

	}
}


/**
 * Prints HTML with meta information for current post: categories.
 */
function smartadapt_category_line() {

	$categories_list = get_the_category_list( __( ' ', 'smartadapt' ) );
	?>
<div class="category-line">
	<?php echo $categories_list ?>
</div>



<?php

}


/**
 * Print post date
 * @return string
 */

function smartadapt_get_date() {

	$archive_year  = get_the_time( 'Y' );
	$archive_month = get_the_time( 'm' );
	$archive_day   = get_the_time( 'd' );

	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark" class="meta-label meta-date"><i class="icon-left icon-calendar"></i><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_day_link( $archive_year, $archive_month, $archive_day ) ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	return $date;
}


/**
 * Display content nav
 *
 * @param $html_id
 */
function smartadapt_content_nav( $html_id ) {
	global $wp_query;

	$html_id = esc_attr( $html_id );

	if ( $wp_query->max_num_pages > 1 ) : ?>
	<nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
		<h3 class="assistive-text"><?php _e( 'Post navigation', 'smartadapt' ); ?></h3>
		<?php

		if ( smartadapt_option( 'smartadapt_pagination_posts' ) == '1' ) {
			?>
			<div
					class="nav-previous alignleft"><?php next_posts_link( __( '<span class="button"><span class="meta-nav">&larr;</span> Older posts</span>', 'smartadapt' ) ); ?></div>
			<div
					class="nav-next alignright"><?php previous_posts_link( __( '<span class="button">Newer posts <span class="meta-nav">&rarr;</span></span>', 'smartadapt' ) ); ?></div>
			<?php
		}
		else {
			//get custom smartadapt pagination
			smartadapt_pagination_links();
		}
		?>
	</nav><!-- #<?php echo $html_id; ?> .navigation -->
	<?php endif;
}


/**
 * Template for comments and pingbacks.
 */
function smartadapt_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
			// Display trackbacks differently than normal comments.
			?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'smartadapt' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'smartadapt' ), '<span class="edit-link">', '</span>' ); ?></p>
				<?php
			break;
		default :
			// Proceed with normal comments.
			global $post;
			?>
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                    <article id="comment-<?php comment_ID(); ?>" class="comment">
											<header class="comment-meta comment-author vcard">
												<?php
												$user_photo = get_user_meta( $comment->user_id, 'smartadapt_profile_image', true );
												if ( ! empty( $user_photo ) ) {
													?>
													<img src="<?php echo $user_photo?>" alt="User" width="44" height="44" />
													<?php

												}
												else
													echo get_avatar( $comment, 44 );
												printf( '<cite class="fn">%1$s %2$s</cite>',
													get_comment_author_link(),
													// If current post author is also comment author, make it known visually.
													( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'smartadapt' ) . '</span>' : ''
												);
												printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
													esc_url( get_comment_link( $comment->comment_ID ) ),
													get_comment_time( 'c' ),
													/* translators: 1: date, 2: time */
													sprintf( __( '%1$s at %2$s', 'smartadapt' ), get_comment_date(), get_comment_time() )
												);
												?>
											</header>
											<!-- .comment-meta -->

											<?php if ( '0' == $comment->comment_approved ) : ?>
											<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'smartadapt' ); ?></p>
											<?php endif; ?>

											<section class="comment-content comment">
												<?php comment_text(); ?>
												<?php edit_comment_link( __( 'Edit', 'smartadapt' ), '<p class="edit-link">', '</p>' ); ?>
											</section>
											<!-- .comment-content -->

											<div class="reply ">
												<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'smartadapt' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
											</div>
											<!-- .reply -->
										</article><!-- #comment-## -->
				<?php
			break;
	endswitch; // end comment_type check
}

/**
 * Displays navigation to next/previous post on single  page.
 */
function smartadapt_single_nav() {

	?>
<nav class="nav-single">
	<h3 class="assistive-text"><?php _e( 'Post navigation', 'smartadapt' ); ?></h3>
        <span
						class="nav-previous"><?php previous_post_link( '%link', '<span class="button small single-nav" data-width="210" title="Go to: %title">' . _x( '&larr; Previous post link', 'Previous post link', 'smartadapt' ) . '</span>' ); ?></span>
        <span
						class="nav-next"><?php next_post_link( '%link', '<span class="button small single-nav" data-width="210" title="Go to: %title">' . _x( 'Next post link &rarr;', 'Next post link', 'smartadapt' ) . '</span>' ); ?></span>
</nav><!-- .nav-single -->
	<?php
}

/**
 *
 * Modyfication wp_link_pages() - <!--nextpage--> pagination
 *
 * @param string|array $args Optional. Overwrite the defaults.
 *
 * @return string Formatted output in HTML.
 */
function smartadapt_custom_wp_link_pages( $args = '' ) {
	$defaults = array(
		'before'           => '<div id="post-pagination" class="pagination">' . __( 'Pages:', 'smartadapt' ),
		'after'            => '</div>',
		'text_before'      => '',
		'text_after'       => '',
		'next_or_number'   => 'number',
		'nextpagelink'     => __( 'Next page', 'smartadapt' ),
		'previouspagelink' => __( 'Previous page', 'smartadapt' ),
		'pagelink'         => '%',
		'echo'             => 1
	);

	$r = wp_parse_args( $args, $defaults );
	$r = apply_filters( 'wp_link_pages_args', $r );
	extract( $r, EXTR_SKIP );

	global $page, $numpages, $multipage, $more, $pagenow;

	$output = '';
	if ( $multipage ) {
		if ( 'number' == $next_or_number ) {
			$output .= $before;
			for ( $i = 1; $i < ( $numpages + 1 ); $i = $i + 1 ) {
				$j = str_replace( '%', $i, $pagelink );
				$output .= ' ';
				if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) )
					$output .= _wp_link_page( $i );
				else
					$output .= '<span class="current-post-page">';

				$output .= $text_before . $j . $text_after;
				if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) )
					$output .= '</a>';
				else
					$output .= '</span>';
			}
			$output .= $after;
		}
		else {
			if ( $more ) {
				$output .= $before;
				$i = $page - 1;
				if ( $i && $more ) {
					$output .= _wp_link_page( $i );
					$output .= $text_before . $previouspagelink . $text_after . '</a>';
				}
				$i = $page + 1;
				if ( $i <= $numpages && $more ) {
					$output .= _wp_link_page( $i );
					$output .= $text_before . $nextpagelink . $text_after . '</a>';
				}
				$output .= $after;
			}
		}
	}
	if ( is_single() || is_page() ) {
		if ( $echo )
			echo $output;

		return $output;
	}
	else {
		return '';
	}

}

/**
 * Display social buttons
 */
function smartadapt_get_social_buttons() {
	?>
<ul class="no-bullet soical-widgets">
	<?php
	if ( smartadapt_option( 'social_button_facebook' ) ) {
		?>
		<li>
			<div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="box_count"
					 data-width="260" data-show-faces="false"></div>
		</li>
		<?php
	}

	if ( smartadapt_option( 'social_button_gplus' ) ) {
		wp_enqueue_script( 'gplus_script', 'https://apis.google.com/js/plusone.js' );

		?>
		<li>
			<g:plusone size="tall"></g:plusone>
		</li>
		<?php
	}

	if ( smartadapt_option( 'social_button_twitter' ) ) {
		?>
		<li>
			<a href="https://twitter.com/share" style="width:50px" class="twitter-share-button" data-count="vertical"
				 data-dnt="true">Tweet</a>
			<script>!function (d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (!d.getElementById(id)) {
					js = d.createElement(s);
					js.id = id;
					js.src = "//platform.twitter.com/widgets.js";
					fjs.parentNode.insertBefore(js, fjs);
				}
			}(document, "script", "twitter-wjs");</script>
		</li>
		<?php
	}

	if ( smartadapt_option( 'social_button_pinterest' ) ) {
		?>
		<li class="pinterest-button">
			<a data-pin-config="above" href="//pinterest.com/pin/create/button/" data-pin-do="buttonBookmark"><img
					src="//assets.pinterest.com/images/pidgets/pin_it_button.png" /></a>
		</li>
		<?php
	}
	?>
</ul>

	<?php
}

/*
 * Return excerpt with limit
 */
function smartadapt_excerpt_max_charlength( $charlength ) {
	$excerpt = get_the_excerpt();
	$charlength ++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex   = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut   = - ( mb_strlen( $exwords[count( $exwords ) - 1] ) );
		if ( $excut < 0 ) {
			echo mb_substr( $subex, 0, $excut );
		}
		else {
			echo $subex;
		}
		echo '...';
	}
	else {
		echo $excerpt;
	}
}

/*
 * Display smartadapt paginate links
 */
function smartadapt_pagination_links() {
	global $wp_query;

	$big     = 999999999; // This needs to be an unlikely integer
	$current = max( 1, get_query_var( 'paged' ) );
	// For more options and info view the docs for paginate_links()
	// http://codex.wordpress.org/Function_Reference/paginate_links
	$paginate_links = paginate_links( array(
		'base'     => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
		'current'  => $current,
		'total'    => $wp_query->max_num_pages,
		'mid_size' => 5,
		'type'     => 'array'
	) );

	// Display the pagination if more than one page is found
	if ( $paginate_links ) {

		echo '<ul class="pagination">';
		foreach ( $paginate_links as $row ) {

			?>
		<li><?php echo $row ?></li>
		<?php

		}
		echo '</ul><!--// end .pagination -->';
	}
}

/**
 * Return custom theme option
 *
 * @param $key
 *
 * @return string/bool
 */
function smartadapt_option( $key ) {
	$array_options = get_option( 'smartadapt_theme_options' );

	return isset( $array_options[$key] ) ? $array_options[$key] : false;
}


/**
 * Display lt ie7 info
 */

function smartadapt_lt_ie7_info() {
	?>
<!--[if lt IE 7]>
<p class=chromeframe><?php _e( 'Your browser is <em>ancient!</em>', 'smartadapt' )?>
</p>
<![endif]-->
<?php
}

/**
 * Display search menu
 */
function smartadapt_searchmenu() {
	?>
<ul id="top-switches" class="no-bullet right">
	<li>
		<a href="#toggle-search" class="toggle-topbar toggle-button button">
			<span class="icon-search"></span>
		</a>
	</li>
	<li class="show-for-small">
		<a href="#top-navigation" class="toggle-topbar toggle-button button">
			<span class="icon-reorder"></span>
		</a>
	</li>
</ul>
<?php
}

/**
 * Display search form
 */

function smartadapt_searchform() {
	?>
<form action="<?php echo home_url( '/' ); ?>" method="get" role="search">
	<div class="row">
		<div class="columns sixteen mobile-four">
			<input id="search-input" type="text" name="s"
						 placeholder="<?php _e( 'Search for ...', 'smartadapt' ); ?>" value="">
			<input class="button" id="top-searchsubmit" type="submit"
						 value="<?php _e( 'Search', 'smartadapt' ); ?>">
		</div>
	</div>

</form>
<?php
}

/**
 * display Facebook js SDK
 */

function smartadapt_display_facebook_script() {
	?>
<div id="fb-root"></div>
<script>(function (d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s);
	js.id = id;
	js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php
}

/*PRO Layout functions*/

/**
 * Returns an occurrence of the element at a given position
 */

function check_position_of_component( $component, $side, $option ) {
	$options_array = array(
		1 => array(
			'sidebar' => array(
				'left'  => 0,
				'right' => 1
			),
			'menu'    => array(
				'left'  => 1,
				'right' => 0
			)
		),
		2 => array(
			'sidebar' => array(
				'left'  => 1,
				'right' => 0
			),
			'menu'    => array(
				'left'  => 0,
				'right' => 1
			)
		),
		3 => array(
			'sidebar' => array(
				'left'  => 0,
				'right' => 1
			),
			'menu'    => array(
				'left'  => 0,
				'right' => 0
			)
		),
		4 => array(
			'sidebar' => array(
				'left'  => 0,
				'right' => 0
			),
			'menu'    => array(
				'left'  => 1,
				'right' => 0
			)
		)


	);

	if ( isset( $options_array[$option][$component][$side] ) )
		return $options_array[$option][$component][$side];
	else
		return $options_array[1][$component][$side];
	//get default configuration


}

/**
 * Returns the class of the given object
 */

function get_class_of_component( $component, $option ) {
	$class_array = array(
		1  => array(
			'page'    => 'twelve columns',
			'sidebar' => 'four columns',
			'menu'    => 'four columns',
			'content' => 'twelve columns'
		),
		2  => array(
			'page'    => 'twelve columns',
			'sidebar' => 'four columns left-sidebar',
			'menu'    => 'four columns',
			'content' => 'twelve columns'
		),
		3  => array(
			'page'    => 'twelve columns',
			'sidebar' => 'four columns',
			'menu'    => '',
			'content' => 'sixteen columns'
		),
		4  => array(
			'page'    => 'sixteen columns',
			'sidebar' => '',
			'menu'    => 'four columns',
			'content' => 'twelve columns'
		)
	);

	if ( isset( $class_array[$option][$component] ) )
		return $class_array[$option][$component];
	else
		return $class_array[1][$component];
	//get default configuration

}

/**
 * Display first gallery image
 *
 * @param string $size
 */
function get_featured_image( $size = 'full' ) {
	global $post;


	$attachmentimage = '';


	if ( $images = get_children( array(
		'post_parent'    => $post->ID,
		'post_type'      => 'attachment',
		'numberposts'    => 1,
		'post_mime_type' => 'image',
		'order'          => 'DESC',
		'orderby'        => 'menu_order ID'
	) )
	) {
		foreach ( $images as $image ) {

			$attachmentimage = wp_get_attachment_image( $image->ID, $size );
		}

	}
	if ( empty( $attachmentimage ) ) {

		/*if gallery is not attachment*/
		$post_subtitrare = get_post( $post->ID );
		$content         = $post_subtitrare->post_content;

		$pattern         = get_shortcode_regex();


		if(
			    preg_match_all( "/$pattern/s", $content, $matches )
	        && array_key_exists( 2, $matches )
	        && in_array( 'gallery', $matches[2] )
	    ){

			foreach($matches[2] as $key => $row){
				if($row=='gallery'){
					$id = $key;
				}
			}


						$atts    = shortcode_parse_atts( $matches[3][$id] );
						$include = substr( $atts['ids'], 0, strpos( $atts['ids'], ',' ) );

						$attachmentimage = wp_get_attachment_image( $include, $size );

		}




	}


	return $attachmentimage;

}

/**
 * Include the category specific template for the content
 */
function smartadapt_template_category_loop() {

	$category_id     = get_query_var( 'cat' );
	$category_option = get_option( 'category_' . $category_id );

	$category_template = $category_option['layout'] == 2 ? 'loop-2columns' : 'loop';

	return $category_template;
}

/**
 * Display related post
 */
function smartadapt_get_related_post( $category, $post_ID, $display_post_limit, $columns_per_slide = 4 ) {
	global $post;

	$args = array(
		'cat'           => $category,
		'post__not_in'  => array( $post_ID * - 1 ),
		'posts_per_page'=> $display_post_limit
	);


	$query = new WP_Query( $args );
	$limit = $query->found_posts;
	if ( $limit > 0 ) {
		?>
	<section class="related-posts row">
		<div class="columns sixteen"><h3><?php _e( 'Related posts', 'smartadapt' ) ?></h3>

			<div class="slider-container">
				<ul class="related-posts-list slider-list slides">
					<?php
					$i = 1;
					$j = 1;
					while ( $query->have_posts() ) {
						$query->the_post();
						$post_format = get_post_format();
						if ( $i == 1 ) {
							echo '<li><div class="row">';
						}
						?>
						<div class="columns <?php echo smartadapt_column_class_by_number( 4 ) ?> small-box">
							<?php
							if ( '' != get_the_post_thumbnail() ) {
								?>
								<div class="thumbnail-outer-small format-ico <?php echo $post_format . '-ico' ?>">
									<a href="<?php the_permalink(); ?>"
										 title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'smartadapt' ), the_title_attribute( 'echo=0' ) ) ); ?>"
											><?php the_post_thumbnail( 'two-column-thumbnail' ); ?></a></div>

								<?php
							}
							elseif ( $post_format == 'gallery' ) {
								$featured_image = get_featured_image( 'two-column-thumbnail' );

								if ( ! empty( $featured_image ) ) {
									?>

									<div class="thumbnail-outer-small format-ico <?php echo $post_format . 'post-ico' ?>">
										<a href="<?php the_permalink(); ?>"
											 title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'smartadapt' ), the_title_attribute( 'echo=0' ) ) ); ?>"
												><?php echo $featured_image ?></a></div>

									<?php
								}
							}

							?>
							<h4><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h4>
							<?php if ( empty( $featured_image ) && '' == get_the_post_thumbnail() ) { ?>
							<a href="<?php the_permalink() ?>"><?php the_excerpt(); ?></a>
							<?php } ?>
						</div>

						<?php
						if ( $i % $columns_per_slide == 0 || $j == $limit ) {
							echo '</div></li>';
							$i = 1;
						}
						else {
							$i ++;
						}

						$j ++;

					}// end while
					wp_reset_query();
					?>
				</ul>
			</div>
		</div>
		<script type="text/javascript" charset="utf-8">
			(function ($) {
				"use strict";
			$('.slider-container').flexslider();
			})(jQuery);
		</script>
	</section>
	<?php
	}
	//if limit >0

}


?>