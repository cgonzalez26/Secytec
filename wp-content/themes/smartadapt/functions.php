<?php
if (!session_id()) {
    session_start();
}
/**
 *
 * SmartAdapt functions and definitions.
 *
 * The functions file is used to initialize everything in the theme.
 * It sets up the supported features, default actions  and filters.
 *
 * @package    WordPress
 * @subpackage SmartAdapt
 * @since      SmartAdapt 1.0
 */
global $pro_link;
$pro_link = 'http://netbiel.pl/smartadapt/smartadaptpro.html';
// include customize class
require( get_template_directory() . '/inc/classes/theme-options-class.php' );

/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */

if ( ! isset( $content_width ) )
	$content_width = 625;

/**
 * Sets up theme defaults and registers the various WordPress features
 */

function smartadapt_setup() {

	// Load external function - helpers

	require( get_template_directory() . '/inc/template-tags.php' );

	// Load external widget classes

	require( get_template_directory() . '/inc/classes/custom-widgets.php' );

	// Load theme plugin functions

	require( get_template_directory() . '/inc/plugin.php' );

	//Load text domain
	load_theme_textdomain( 'smartadapt', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// This theme supports a variety of post formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status', 'video', 'gallery' ) );

	// add custom header suport
	$args = array(
		'width'       => 964,
		'height'      => 110,
		'uploads'     => true,
		'header-text' => false
	);
	add_theme_support( 'custom-header', $args );

	// This theme two wp_nav_menu() in one location.
	register_nav_menu( 'top_pages', __( 'Top Menu', 'smartadapt' ) );
	register_nav_menu( 'footer_pages', __( 'Bottom Menu', 'smartadapt' ) );
	register_nav_menu( 'categories', __( 'Vertical Menu', 'smartadapt' ) );
	/*
									 * This theme supports custom background color and image, and here
									 * we also set up the default background color.
									 */
	add_theme_support( 'custom-background', array(
		'default-color' => 'D8D8D8',
	) );

	/**
	 * POSTS THUMBNAILS
	 */
	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop
	add_image_size( 'small-image', 90, 90, true );
	add_image_size( 'medium-image', 130, 130, true );
	add_image_size( 'single-post', 500, 200, true );
	add_image_size( 'single-post-small', 266, 200, true );
	add_image_size( 'wide-image', 1000, 380, true );
	add_image_size( 'two-column-thumbnail', 330, 190, true );


}

add_action( 'after_setup_theme', 'smartadapt_setup' );


/**
 * Enqueues scripts and styles for front-end.
 */
function smartadapt_scripts_styles() {
	global $wp_styles;

	/*
									 * Adds JavaScript to pages with the comment form to support
									 * sites with threaded comments (when in use).
									 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'modernizr-foundation', get_template_directory_uri() . '/js/foundation/modernizr.foundation.js', array( 'jquery' ), '1.0', false );
	wp_enqueue_script( 'smartadapt-navigation', get_template_directory_uri() . '/js/foundation/jquery.foundation.navigation.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'foundation-buttons', get_template_directory_uri() . '/js/foundation/jquery.foundation.buttons.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'foundation-topbar', get_template_directory_uri() . '/js/foundation/jquery.foundation.topbar.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'foundation-tooltips', get_template_directory_uri() . '/js/foundation/jquery.foundation.tooltips.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'smartadapt-photoswipe-lib', get_template_directory_uri() . '/js/photoswipe/lib/klass.min.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'smartadapt-photoswipe', get_template_directory_uri() . '/js/photoswipe/code.photoswipe.jquery-3.0.5.min.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'smartadapt-flexslider', get_template_directory_uri() . '/js/flexslider/jquery.flexslider-min.js', array( 'jquery' ), '1.0', false );
	wp_enqueue_script( 'smartadapt-responsive-tables', get_template_directory_uri() . '/js/responsive-tables.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'smartadapt-main', get_template_directory_uri() . '/js/main.js', array( 'jquery' ), '1.0', false );


	/* Adds foundation app.js*/

	wp_enqueue_script( 'app-foundation', get_template_directory_uri() . '/js/foundation/app.js', array(), '1.0', true );

	/*register pinterest script*/
	wp_register_script( 'pinterest', '//assets.pinterest.com/js/pinit.js' );


	/* Loads foundation stylesheet. */

	wp_enqueue_style( 'smartadapt-foundation', get_template_directory_uri() . '/css/foundation.min.css' );


	/* Loads font stylesheet.*/


	wp_enqueue_style( 'smartadapt-font-icon', get_template_directory_uri() . '/font/css/font-awesome.min.css' );

	wp_enqueue_style( 'smartadapt-photoswipe-css', get_stylesheet_directory_uri() . '/css/photoswipe/photoswipe.css', array( 'smartadapt-foundation' ) );
	wp_enqueue_style( 'smartadapt-flexslider', get_stylesheet_directory_uri() . '/css/flexslider/flexslider.css' );

	/*load responsive tables css*/

	wp_enqueue_style( 'smartadapt-responsive-tables', get_stylesheet_directory_uri() . '/css/responsive-tables.css' );

	/* Loads structure stylesheet. */


	wp_enqueue_style( 'smartadapt-structure', get_stylesheet_directory_uri() . '/style.css', array( 'smartadapt-foundation' ) );

}

add_action( 'wp_enqueue_scripts', 'smartadapt_scripts_styles' );


/**
 * Return title tag content
 *
 * @param string $title Default title text for current view.
 * @param string $sep   Optional separator.
 *
 * @return string Filtered title.
 */
function smartadapt_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}
	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'smartadapt' ), max( $paged, $page ) );
	}
	return $title;
}

add_filter( 'wp_title', 'smartadapt_wp_title', 10, 2 );


/**
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since SmartAdapt 1.0
 *
 */
function smartadapt_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) ) {
		$args['show_home'] = true;
	}
	return $args;
}

add_filter( 'wp_page_menu_args', 'smartadapt_page_menu_args' );


/**
 * Registers widgets area
 *
 * @since SmartAdapt 1.0
 */
function smartadapt_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Main Sidebar', 'smartadapt' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Appears on  Front Page template', 'smartadapt' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="widget-title"><span>',
		'after_title'   => '</span></h5>', /* daniel 17/12/14 */
	) );
	register_sidebar( array(
		'name'          => __( 'SmartAdapt: Category Page Sidebar', 'smartadapt' ),
		'id'            => 'sidebar-4',
		'description'   => __( 'Appears on Category page', 'smartadapt' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="widget-title"><span>',
		'after_title'   => '</span></h5>',/* daniel 17/12/14 */
	) );

	register_sidebar( array(
		'name'          => __( 'SmartAdapt: Single Page Sidebar', 'smartadapt' ),
		'id'            => 'sidebar-5',
		'description'   => __( 'Appears on Single page', 'smartadapt' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="widget-title"><span>',
		'after_title'   => '</span></h5>',/* daniel 17/12/14 */
	) );

	register_sidebar( array(
		'name'          => __( 'SmartAdapt: Footer Front Page Widget Area', 'smartadapt' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Appears on Frontpage in the footer', 'smartadapt' ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '<hr /></li>',
		'before_title'  => '<h5 class="widget-title"><em>',
		'after_title'   => '</em></h5>',/* daniel 17/12/14 */
	) );

	register_sidebar( array(
		'name'          => __( 'SmartAdapt: Footer Single Page Widget Area', 'smartadapt' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Appear on a Single Page in the footer', 'smartadapt' ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '<hr /></li>',
		'before_title'  => '<h5 class="widget-title"><em>',
		'after_title'   => '</em></h5>',/* daniel 17/12/14 */
	) );
	/*Cristian*/
	register_sidebar( array(
		'name'          => __( 'SmartAdapt: Header Page Sidebar', 'smartadapt' ),
		'id'            => 'sidebar-6',
		'description'   => __( 'Appears on Header page', 'smartadapt' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="widget-title"><span>',
		'after_title'   => '</span></h5>', /* daniel 17/12/14 */
	) );
}

add_action( 'widgets_init', 'smartadapt_widgets_init' );


/*
 * Add sub menu page to the Appearance menu
 *
 * @since SmartAdapt 1.0
*/

function smartadapt_add_customize_to_admin_menu() {
	add_theme_page( __( 'Customize', 'smartadapt' ), 'Customize', 'edit_theme_options', 'customize.php' );
}

add_action( 'admin_menu', 'smartadapt_add_customize_to_admin_menu' );


/**
 * Add admin library to customize page
 *
 * @since SmartAdapt Pro 1.0
 */

function smartadapt_enqueue_admin_libraries() {
	wp_register_script( 'noUiSlider-jquery', get_stylesheet_directory_uri() . '/admin/js/noUislider/jquery.nouislider.min.js', array( 'jquery' ), '3.0', false );
	wp_register_script( 'customize-script', get_stylesheet_directory_uri() . '/admin/js/customize-script.js', array( 'jquery' ), '3.0', false );
	wp_enqueue_script( 'noUiSlider-jquery' );
	wp_enqueue_script( 'customize-script' );

	wp_enqueue_style( 'noUiSlider', get_stylesheet_directory_uri() . '/admin/js/noUislider/nouislider.fox.css' );
	wp_enqueue_style( 'smartadapt-admin-mod', get_stylesheet_directory_uri() . '/admin/css/css-admin-mod.css' );
}

add_action( 'customize_controls_print_styles', 'smartadapt_enqueue_admin_libraries' );


/*
 *  Add dynamic select menus  for mobile device navigation * *
 *
 * @since SmartAdapt 1.0
 * @link: http://kopepasah.com/tutorials/creating-dynamic-select-menus-in-wordpress-for-mobile-device-navigation/
 *
 * @param array $args
 *
*/

function smartadapt_wp_nav_menu_select( $args = array() ) {

	$menu = array();

	$defaults = array(
		'theme_location' => '',
		'menu_class'     => 'mobile-menu',
	);

	$args           = wp_parse_args( $args, $defaults );
	$menu_locations = get_nav_menu_locations();
	if ( isset( $menu_locations[$args['theme_location']] ) ) {
		$menu = wp_get_nav_menu_object( $menu_locations[$args['theme_location']] );
	}

	if ( count( $menu ) > 0 && isset( $menu->term_id ) ) {


		$menu_items = wp_get_nav_menu_items( $menu->term_id );

		$children = array();
		$parents  = array();

		foreach ( $menu_items as $id => $data ) {
			if ( empty( $data->menu_item_parent ) ) {
				$top_level[$data->ID] = $data;
			}
			else {
				$children[$data->menu_item_parent][$data->ID] = $data;
			}
		}

		foreach ( $top_level as $id => $data ) {
			foreach ( $children as $parent => $items ) {
				if ( $id == $parent ) {
					$menu_item[$id] = array(
						'parent'   => true,
						'item'     => $data,
						'children' => $items,
					);
					$parents[]      = $parent;
				}
			}
		}

		foreach ( $top_level as $id => $data ) {
			if ( ! in_array( $id, $parents ) ) {
				$menu_item[$id] = array(
					'parent' => false,
					'item'   => $data,
				);
			}
		}

		uksort( $menu_item, 'smartadapt_wp_nav_menu_select_sort' );

		?>
	<select id="menu-<?php echo $args['theme_location'] ?>" class="<?php echo $args['menu_class'] ?>">
		<option value=""><?php _e( '- Select -', 'smartadapt' ); ?></option>
		<?php foreach ( $menu_item as $id => $data ) : ?>
		<?php if ( $data['parent'] == true ) : ?>
				<option value="<?php echo $data['item']->url ?>"><?php echo $data['item']->title ?></option>		
				<?php foreach ( $data['children'] as $id => $child ) : ?>
					<option value="<?php echo $child->url ?>" class="optionSubcategoria">&nbsp;&nbsp;&nbsp;<?php echo $child->title ?></option>
				<?php endforeach; ?>
			<?php else : ?>
			<option value="<?php echo $data['item']->url ?>"><?php echo $data['item']->title ?></option>
			<?php endif; ?>
		<?php endforeach; ?>
	</select>
	<?php


	}
	else {
		?>
	<select class="menu-not-found">
		<option value=""><?php _e( 'Menu Not Found', 'smartadapt' ); ?></option>
	</select>
		<?php

	}
}


/*
 * Sort helper function
 */
function smartadapt_wp_nav_menu_select_sort( $a, $b ) {
	return $a = $b;
}


/**
 * Add mobile menu script
 *
 * @since SmartAdapt 1.0
 *
 */

function smartadapt_wp_nav_menu_select_scripts() {
	wp_enqueue_script( 'select-menu', get_stylesheet_directory_uri() . '/js/mobile-menu.js', array( 'jquery' ), '', true );
}

add_action( 'wp_enqueue_scripts', 'smartadapt_wp_nav_menu_select_scripts' );


/**
 * Custom form password
 *
 * @since SmartAdapt 1.0
 *
 * @return string
 */

function smartadapt_password_form() {
	global $post;
	$label = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );
	$o     = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post" class="password-form"><div class="row"><div class="columns sixteen"><i class="icon-lock icon-left"></i>' . __( "To view this protected post, enter the password below:", 'smartadapt' ) . '</div><label for="' . $label . '" class="columns four mobile-four">' . __( "Password:", 'smartadapt' ) . ' </label><div class="columns eight mobile-four"><input name="post_password" id="' . $label . '" type="password" size="20" /></div><div class="columns four mobile-four"><input type="submit" name="Submit" value="' . esc_attr__( "Submit", 'smartadapt' ) . '" /></div>
    </div></form>
    ';
	return $o;
}

add_filter( 'the_password_form', 'smartadapt_password_form' );


/**
 * W3C validation - fix the rel=”category tag”
 *
 * @since SmartAdapt 1.0
 */

add_filter( 'the_category', 'smartadapt_replace_cat_tag' );

function smartadapt_replace_cat_tag( $text ) {
	$text = str_replace( 'rel="category tag"', "", $text );
	return $text;
}

/**
 * add IE 7 & IE 8 CSS3 Box-sizing support
 *
 * @since SmartAdapt 1.0
 *
 */

function smartadapt_ie_support() {

	?><!--[if IE 7]>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/font/css/font-awesome-ie7.min.css">
<![endif]-->
<!--[if IE 7]>
<style>
	* {
	* behavior : url (<?php echo get_template_directory_uri(); ?>/js/boxsize-fix.htc );
	}
</style>
<![endif]-->
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php

}

add_action( 'wp_head', 'smartadapt_ie_support' );


/**
 * add external social & user's scripts
 *
 * @since SmartAdapt 1.0
 *
 */
function smartadapt_additional_footer_scripts() {
	if ( smartadapt_option( 'social_button_facebook' )
	) :
		//Load FB
		smartadapt_display_facebook_script();
	endif;

	//Load pinterest
	if ( smartadapt_option( 'social_button_pinterest' ) ) :
		wp_enqueue_script( 'pinterest' );
	endif;


	//display custom footer code (Theme Customization)
	echo smartadapt_option( 'custom_code_footer' );
}

add_action( 'wp_footer', 'smartadapt_additional_footer_scripts' );


/**
 * Return custom_code_header
 *
 * @return string
 */
function smartadapt_option_custom_code_header() {
	smartadapt_option( 'custom_code_header' );
}

//display custom header code (Theme Customization)
add_action( 'wp_head', 'smartadapt_option_custom_code_header' );


/**
 * Adds  new extended info  section to post page
 */

function smartadapt_add_extended_box() {

	$post_type = array( 'post', 'page' );

	foreach ( $post_type as $type ) {

		add_meta_box(
			'smartadapt_extended_info',
			__( 'SmartAdapt: Post additional content', 'smartadapt' ),
			'smartadapt_display_extended_info',
			$type
		);
	}
}

add_action( 'add_meta_boxes', 'smartadapt_add_extended_box' );


/**
 * Prints the extended info content.
 *
 * @param WP_Post $post The object for the current post/page.
 *
 * @since SmartAdapt 1.0
 */

function smartadapt_display_extended_info( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'smartadapt_display_extended_info', 'smartadapt_display_extended_info_nonce' );
	$video_link = get_post_meta( $post->ID, '_smartadapt_video_link', true );

	echo '<fieldset class="smartadapt-fieldset"><h4>' . __( 'Video:', 'smartadapt' ) . '</h4><div class="smartadapt-form-block"><label for="embed_code_field">';
	_e( "Embed code:", 'smartadapt' );
	echo '</label> ';
	echo '<textarea id="embed_code_field" name="embed_code_field" rows="5" cols="150">' . esc_attr( $video_link ) . '</textarea><p class="smartadapt-prompt">' . __( 'You can embed video from YouTube, Vimeo, DailyMotion or from another service', 'smartadapt' ) . '</p></div></fieldset>';
}


/**
 * Saves smartadapt custom data
 *
 * @param $post_id The ID of the post being saved.
 *
 * @return mixed
 *
 * @since SmartAdapt 1.0
 */
function smartadapt_save_extend_data( $post_id ) {


	// Check if our nonce is set.
	if ( ! isset( $_POST['smartadapt_display_extended_info_nonce'] ) ) {
		return $post_id;
	}
	$nonce = $_POST['smartadapt_display_extended_info_nonce'];

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $nonce, 'smartadapt_display_extended_info' ) ) {
		return $post_id;
	}
	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}
	// Check the user's permissions.
	if ( 'post' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}
	}
	else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {


			return $post_id;
		}
	}
	// Sanitize user input.
	$form_data = $_POST['embed_code_field'];
	// Update the meta field in the database.
	update_post_meta( $post_id, '_smartadapt_video_link', $form_data );
}

add_action( 'save_post', 'smartadapt_save_extend_data' );

//add extra fields to category edit form hook
add_action( 'edit_category_form_fields', 'smartadapt_extra_category_fields' );
add_action( 'category_add_form_fields', 'smartadapt_extra_category_fields' );


//add extra fields to category edit form callback function
function smartadapt_extra_category_fields( $tag ) { //check for existing featured ID
	$cat_extra_data['layout'] = 1;
if(is_object($tag)){
	$term_id        = $tag->term_id;
	$cat_extra_data = get_option( 'category_' . $term_id );
}
	?>
<fieldset class="smartadapt-fieldset">

	<h4 style="margin-bottom: 40px"><?php _e( 'Category layout', 'smartadapt' ); ?></h4>
	<div class="smartadapt-form-proversion-info-outer">
		<div class="smartadapt-form-proversion-info-inner"><a href="<?php echo $pro_link ?>" target="_blank" class="smartadapt-proversion-link"><?php _e('Available in pro version &#187;', 'smartadapt');?></a></div>
	<div class="smartadapt-form-block">
		<div class="smartadapt-form-line">
			<label for="cat_extra_data_1" class="smartadapt-radio-label"><?php _e( 'One column', 'smartadapt' ); ?></label><input type="radio" name="cat_extra_data[layout]" id="cat_extra_data_1" style="float: left; width: auto" value="1" <?php echo $cat_extra_data['layout'] == 1 ? 'checked=checked' : ''; ?>><br />
		</div>
		<div class="smartadapt-form-line">
			<label for="cat_extra_data_2" class="smartadapt-radio-label"><?php _e( 'Two columns', 'smartadapt' ); ?></label><input type="radio" name="cat_extra_data[layout]" id="cat_extra_data_2" style="float: left; width: auto" value="2" <?php echo $cat_extra_data['layout'] == 2 ? 'checked=checked' : ''; ?>><br />
		</div>
	</div>
 </div>
</fieldset>
<?php
}


//change excerpt length
add_filter( 'excerpt_length', 'smartadapt_excerptLength' );
function smartadapt_excerptLength( $length ) {
	return 20;
}

/**
 * Display favicon
 *
 * @since SmartAdaptPro 1.0
 */

function smartadapt_display_favicon() {
	$favico = smartadapt_option( 'smartadapt_favicon' );
	if ( ! empty( $favico ) ) {
		$extension = substr( $favico, strrpos( $favico, '.' ) + 1, 3 );
		?>
	<link rel="icon" type="image/<?php echo $extension ?>" href="<?php echo $favico ?>" />
	<?php
	}
}

add_action( 'wp_head', 'smartadapt_display_favicon' );


/*
 * add smartadapt custom header options hook
 */
add_action( 'custom_header_options', 'smartadapt_banner_code_header' );

/* Adds banner code text area */
function smartadapt_banner_code_header() {
	?>

<fieldset class="smartadapt-fieldset">

	<h4 style="margin-bottom: 40px"><?php _e( 'Header Banner', 'smartadapt' ) ?></h4>
	<div class="smartadapt-form-proversion-info-outer" style="height: 250px; max-width: 100%;">
		<div class="smartadapt-form-proversion-info-inner" style="width: 100%"><a href="<?php echo $pro_link ?>" target="_blank" class="smartadapt-proversion-link"><?php _e('Available in pro version &#187;', 'smartadapt');?></a></div>
	<table class="form-table">
		<tbody>
		<tr valign="top" class="hide-if-no-js">
			<th scope="row"><?php _e( 'Banner code:', 'smartadapt' ); ?></th>
			<td>
				<p>

					<textarea name="banner_code_header" style="width: 60%;height: 100px;"><?php echo esc_attr( get_theme_mod( 'banner_code_header' ) ); ?></textarea>
				</p>

				<p>
					<?php _e( 'You can add a banner code to the <strong>header</strong> of page', 'smartadapt' ) ?>
				</p>
			</td>
		</tr>

		</tbody>
	</table>
	<?php $banner_display_subpages = get_theme_mod( 'banner_display_subpages' ); ?>
	<p style="width: 13%; float: left; text-align: center;">
		<label for="display_subpage_1"><?php _e( 'Display banner only on home page', 'smartadapt' ) ?></label><input id="display_subpage_1" type="radio" name="banner_display_subpages" value="0" <?php echo isset( $banner_display_subpages ) && $banner_display_subpages != '1' ? 'checked="checked"' : '';?> <?php echo ! isset( $banner_display_subpages ) ? 'checked="checked"' : '' ?>>
	</p>

	<p style="width: 13%; float: left; text-align: center;">
		<label for="display_subpage_2"><?php _e( 'Display banner on all pages', 'smartadapt' ) ?></label><input id="display_subpage_2" type="radio" name="banner_display_subpages" value="1" <?php echo isset( $banner_display_subpages ) && $banner_display_subpages == '1' ? 'checked="checked"' : '';?>>
	</p>
		</div>
</fieldset>
<?php
}

add_action('admin_menu', 'smartadapt_pro_menu');

function smartadapt_pro_menu() {
	add_theme_page('SmartAdapt Pro', 'SmartAdapt Pro', 'edit_theme_options', 'smartadapt-pro', 'smartadaptpro_function');
}
function smartadaptpro_function(){
	?>
		<div class="wrap">
			<div id="icon-tools"class="icon32"><br></div>
	<h2>SmartAdapt Pro version</h2>
			<h3>Need extensive documentation and theme support? Learn more about SmartAdapt Pro!</h3>
			<p><a href="<?php echo $pro_link ?>">SmartAdapt Pro</a> adds exciting new customization features to the Theme Customizer and other powerful customization tools like shortcodes or layout options. </p>
			<div style="float: left; width: 50%"><p><img src="http://netbiel.pl/smartadaptpro/files/layout-variants.png" alt=""></p></div>
      <div style="float: left; width: 40%; margin-left: 5%; ">
				<div id="submitdiv" class="postbox " style="margin-top: 40px;height: 265px;">
					<h3 class="hndle" style="padding: 9px 10px;"><span><strong>SmartAdapt Pro version</strong></span></h3>
				<div class="inside">
<div style="float: left;width: 60%">
<ul style="list-style: square; margin:15px 20px 30px 40px;">
	<li>Options to alter the layout: 4 layout combinations</li>
	<li>Customizable width of the layout and sidebar</li>
	<li>Built-in useful Shortcodes</li>
	<li>Easily customize elements colors using color picker</li>
	<li>Advertising space in the header area</li>
	<li>Two Category Templates</li>
	<li>User profile picture</li>
	<li>Extensive documentation and theme support</li>
</ul>
</div>
					<div style="float: left;width: 40%">
					<img src="http://netbiel.pl/smartadaptpro/wp-content/uploads/2013/11/logo-premium.png" style="max-width: 100%; margin-top: 15px;" alt="SmartAdapt Pro Demo">
					</div>

						<a href="http://www.mojo-themes.com/item/smartadapt-pro-clean-responsive-wordpress-theme/" class="button button-primary" style="clear: both; margin-top: 110px" target="_blank"><strong>More info &raquo;</strong></a>
					</div>

				</div>
				<div class="float: left: clear: both; width: 100%"></div>
			</div>


			<div style="width: 100%; clear: both"></div>
			<p><img src="http://netbiel.pl/smartadaptpro/files/theme-customizer-resize-2.png" alt=""></p>
			<p><img src="http://netbiel.pl/smartadaptpro/files/shortcodes-presentation-2.png" alt=""></p>
<div style="width: 100%; clear: both; float: left"></div>
</div>

		<?php
}

//funciones cristian
function get_category_depth($id = 0) {
    $args = array(
        'child_of' => $id,
        'hide_empty' => 0,
        'hierarchical' => 1,
    );
    $categories = get_categories($args);

    if (empty($categories))
        return 0;

    $depth = 1;
    $lines = explode("\n", print_r($categories, true));

    foreach ($lines as $line)
        $depth = max(
            $depth,
            (strlen($line) - strlen(ltrim($line))) / 4
        );

    return ceil(($depth - 1) / 2) + 1;
} // function get_category_depth


// Detectar e imprimir la ruta de la plantilla activa
function ruta_plantilla() {
     global $template;
     echo '<div id="ruta_plantilla" style="background-color: #900; color: #fafafa; font-size: 11px; height: 30px; line-height: 30px; padding: 0 10px; position: absolute; top: 0; right: 0; text-align: right;  width: auto; z-index: 99999;">'.print_r($template).'</div>';
}

//agregar categorias y tag a paginas
function mostrar_cats_y_tags_en_paginas() {
    register_taxonomy_for_object_type( 'category', 'page');

    register_taxonomy_for_object_type( 'post_tag', 'page');
}
add_action( 'admin_menu', 'mostrar_cats_y_tags_en_paginas');

function get_the_term_list_nuevo($id, $taxonomy, $before = '', $sep = '', $after = '' ){
		// Get categories
		$terms = wp_get_post_terms( $id, 'product_cat' );
		foreach ( $terms as $term ) {
			//$link = get_term_link( $term, 'page_id' );
			$subCategoria=0;
			switch($term->term_id){
				//eje1
				case 20:$subCategoria=70;break;//institucionales
				case 21:$subCategoria=55;break;//zonales
				case 22:$subCategoria=66;break;//provinciales
				case 23:$subCategoria=42;break;//nacionales
				case 29:$subCategoria=97;break;//oli-fisica
				case 30:$subCategoria=99;break;//oli-mate
				case 31:$subCategoria=101;break;//oli-filosofia
				case 32:$subCategoria=103;break;//oli-otros
				case 33:$subCategoria=110;break;//cursos-fisica
				case 34:$subCategoria=112;break;//cursos-robotica
				case 35:$subCategoria=114;break;//cursos-extra
				//eje2
				case 38:$subCategoria=119;break;//anpcyt
				case 35:$subCategoria=121;break;//cofecyt
				case 35:$subCategoria=123;break;//otros fondos
				case 35:$subCategoria=125;break;//difusion
				case 35:$subCategoria=127;break;//oficinas de articulacion
				case 35:$subCategoria=129;break;//crecyt- noa
			}
			$link = "?page_id=".$subCategoria;
			//$cats_array[] = $term->term_id;
			$term_links[] = '<a href="' . $link  . '" rel="tag">' . $term->name . '</a>';
		}			
		return $before . join( $sep, $term_links ) . $after;
	}
	
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class($classes, $item){
    if( in_array('current-menu-item', $classes) ){
            $classes[] = 'active ';
    }
    return $classes;
}	

function the_excerpt_max_charlength($charlength) {
	$excerpt = get_the_excerpt();
	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			echo mb_substr( $subex, 0, $excut );
		} else {
			echo $subex;
		}
		return ' <a class="read-more" href="'. get_permalink( get_the_ID() ) . '"> ... [ Leer más ]</a>';//daniel 09/01/15
	} else {
		echo $excerpt;
	}
}

function get_page_by_slug($page_slug,$output=OBJECT,$post_type='page'){
	global $wpdb;
	$page = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_name=%s AND post_type=%s",$page_slug,$post_type));
	if($page)
		return get_post($page,$output);
	return null;	 
}

//end funciones cristian


