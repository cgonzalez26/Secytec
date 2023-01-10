<?php
/**
 * Smartadapt Theme Customizer Class
 *
 * Contains methods for customizing the theme customization screen.
 *
 *
 * @package    WordPress
 * @subpackage SmartAdapt
 * @since      SmartAdapt 1.0
 */





class smartadapt_Customize {

	/**
	 * Identifier, namespace
	 */
	public static $theme_key = 'smartadapt';
	public static $pro_link = 'http://netbiel.pl/smartadapt/smartadaptpro.html';

	/**
	 * The option value in the database will be based on get_stylesheet()
	 * so child themes don't share the parent theme's option value.
	 */
	public static $option_key = 'smartadapt_theme_options';

	/**
	 * Array of default theme options
	 */

	/*public static $default_theme_options = array(
		'link_color'                      => '#6491A1',
		'link_color_hover'                      => '#6491A0',
		'main_font_color' => '#444',
		'breadcrumb_separator'            => ' &raquo; ',
		'sidebar_color'                   => '#385A72',
		'header_color'                    => '#404040',
		'top_bar_outer_color'             => '#404040',
		'top_bar_menu_color'              => '#212121',
		'top_bar_menu_link_color'         => '#ffffff',
		'top_bar_menu_link_background'    => '#404040',
		'smartadapt_logo'                 => '',
		'smartadapt_pagination_posts'     => '1',
		'custom_code_header'              => '',
		'custom_code_footer'              => '',
		'social_button_facebook'          => '0',
		'social_button_gplus'             => '0',
		'social_button_twitter'           => '0',
		'social_button_pinterest'         => '0',
		'layout_options'                  => '1',
		'smartadapt_layout_width'         => '1280',
		'title_tagline_footer' =>'',
     'smartadapt_favicon' => '',
        'smartadapt_general_fonts'=>'merriweather-sans',

	);cristian*/
	public static $default_theme_options = array(
		'link_color'                      => '#D8D8D8',
		'link_color_hover'                      => '#D8D8D8',
		'main_font_color' => '#444',
		'breadcrumb_separator'            => ' &raquo; ',
		'sidebar_color'                   => '#FFF',
		'header_color'                    => '#404040',
		'top_bar_outer_color'             => '#404040',
		'top_bar_menu_color'              => '#212121',
		'top_bar_menu_link_color'         => '#ffffff',
		'top_bar_menu_link_background'    => '#404040',
		'smartadapt_logo'                 => '',
		'smartadapt_pagination_posts'     => '1',
		'custom_code_header'              => '',
		'custom_code_footer'              => '',
		'social_button_facebook'          => '0',
		'social_button_gplus'             => '0',
		'social_button_twitter'           => '0',
		'social_button_pinterest'         => '0',
		'layout_options'                  => '1',
		'smartadapt_layout_width'         => '1280',
		'title_tagline_footer' =>'',
     'smartadapt_favicon' => '',
        'smartadapt_general_fonts'=>'merriweather-sans',

	);


	/**
	 * This will output the custom WordPress settings to the live theme's WP head.
	 *
	 */
	public static function header_output() {
		?>
	<!--Customizer CSS-->
<style type="text/css">
	/*body{background-color: #D8D8D8; daniel*/
	}
<?php self::generate_css( 'body, body p', 'color', 'main_font_color' );  ?>
<?php //self::generate_css( 'a', 'color', 'link_color' );cristian 
self::generate_css( 'a', 'color', '#D8D8D8' ); ?>
<?php self::generate_css( 'a:hover, a:focus', 'color', 'link_color_hover' );  ?>
<?php self::generate_css( '#sidebar .widget-title', 'background-color', '#FFF' );  ?>
<?php self::generate_css( '#top-bar', 'background-color', 'top_bar_outer_color' );  ?>
<?php self::generate_css( '#top-bar > .row', 'background-color', 'top_bar_menu_color' );  ?>
<?php self::generate_css( '#top-bar .top-menu  a', 'color', 'top_bar_menu_link_color' );  ?>
<?php self::generate_css( '#top-navigation li:hover a, #top-navigation .current_page_item a,#top-navigation li:hover ul', 'background-color', 'top_bar_menu_link_background' );  ?>
<?php self::generate_css( 'h1, h2 a, h2, h3, h4, h5, h6', 'color', 'header_color' ); ?>
<?php self::generate_layout_css();	?>
</style>
<?php self::get_header_output_fonts() ?>

	<?php
	}


	/**
	 * This will generate a line of CSS for use in header output. If the setting
	 * ($mod_name) has no defined value, the CSS will not be output.
	 *
	 * @uses  get_theme_mod()
	 *
	 * @param string $selector CSS selector
	 * @param string $style    The name of the CSS *property* to modify
	 * @param string $mod_name The name of the 'theme_mod' option to fetch
	 * @param string $prefix   Optional. Anything that needs to be output before the CSS property
	 * @param string $postfix  Optional. Anything that needs to be output after the CSS property
	 * @param bool   $echo     Optional. Whether to print directly to the page (default: true).
	 *
	 * @return string Returns a single line of CSS with selectors and a property.
	 * @since SmartAdapt 1.0
	 */
	public static function generate_css( $selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = true ) {
		$return = '';
		$mod    = get_option( self::$option_key );

		if ( ! empty( $mod[$mod_name] ) ) {
			$return = sprintf( '%s { %s:%s; }',
				$selector,
				$style,
					$prefix . $mod[$mod_name] . $postfix
			);
			if ( $echo ) {
				echo $return . "\n";
			}
		}
		return $return;
	}

/**
* Generate layout css.
 *
* @since SmartAdapt Pro 1.0
*/
	public static function generate_layout_css(){

		$width = self::get_smartadapt_option( 'smartadapt_layout_width' );
    $sidebar_width = self::get_smartadapt_option( 'smartadapt_sidebar_resize' );
    //layout resize
		$layout_width = ! empty($width)?$width:1280;
		echo '@media only screen and (min-width: '.($layout_width+25).'px){'."\n";
		if(! empty($width)){
			echo 'body{min-width:'.$layout_width.'px}'."\n";
			echo '.row, #wrapper{ width:'.$layout_width.'px }'."\n";
		}

		if(!empty($sidebar_width)){
			echo '#sidebar{ width:'.$sidebar_width.'px }'."\n";
		}
		//if sidebar exists change page size
		$layot_option = self::get_smartadapt_option( 'smartadapt_layout' );
		if (!empty($layot_option) && $layot_option != '4' )
			echo '#page { width:'.($layout_width - self::get_smartadapt_option( 'smartadapt_sidebar_resize' ) ) . 'px }'."\n";
		echo '}'."\n";
	}

	/*Get single smartadapt option*/

	public static function get_smartadapt_option( $option_name ) {
		$mod = get_option( self::$option_key );
		return isset( $mod[$option_name] ) ? $mod[$option_name] : 0;
	}

	/*Get header font styles*/

	public static function get_header_output_fonts() {

		$mod           = get_option( self::$option_key );
		$fonts         = self::get_smartadapt_available_fonts();
		$font_variants = array( 'smartadapt_general_fonts' );

		/*first: load fonts - lazy include*/
		echo "\n" . '<style>'."\n";
		echo "\n" .'/*CUSTOM FONTS*/'."\n"."\n";
		/*if options are not empty*/
		echo "\n" . $fonts['open-sans-condesed']['import'];
		if(!empty($mod['smartadapt_general_fonts'])){

			echo "\n" . $fonts[$mod['smartadapt_general_fonts']]['import'];


		/*second: add font styles*/
		foreach ( $font_variants as $row ) { //$row = smartadapt_general_fonts or smartadapt_headers_fonts
			if ( isset( $fonts[$mod[$row]] ) ) {




				//if general font
				if($row == 'smartadapt_general_fonts')
					echo "\n" . 'body{ ' . $fonts[$mod[$row]]['css'] . ' } ';


			}


		}


		}else{
			/* Add default Google Web Fonts */
			echo "\n" . $fonts['merriweather-sans']['import'];
			echo "\n" . $fonts['open-sans-condesed']['import'];
		}
		echo "\n" . '</style>';
	}

	/**
	 * Implement theme options into Theme Customizer on Frontend
	 *
	 * @see   examples for different input fields https://gist.github.com/2968549
	 * @since 08/09/2012
	 *
	 * @param $wp_customize Theme Customizer object
	 *
	 * @return void
	 */
	public static function  register( $wp_customize ) {

		$defaults = self::$default_theme_options;

// defaults, import for live preview with js helper
		$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';


		//add section: logo
		$wp_customize->add_section( 'smartadapt_logo', array(
			'title'    => __( 'Logo', 'smartadapt' ),
			'priority' => 20,
		) );
		//add section: breadcrumb
		$wp_customize->add_section( 'smartadapt_breadcrumb', array(
			'title'    => __( 'Breadcrumb', 'smartadapt' ),
			'priority' => 70,
		) );

		//add section: pagination
		$wp_customize->add_section( 'smartadapt_pagination_posts', array(
			'title'    => __( 'Pagination', 'smartadapt' ),
			'priority' => 90,
		) );
		//add section: social buttons
		$wp_customize->add_section( 'smartadapt_social_buttons', array(
			'title'    => __( 'Social buttons', 'smartadapt' ),
			'priority' => 120,
		) );

		//add section: custom code

		$wp_customize->add_section( 'smartadapt_custom_code', array(
			'title'    => __( 'Custom Code', 'smartadapt' ),
			'priority' => 80,
		) );


		//add footer text


		$wp_customize->add_setting( self::$option_key . '[title_tagline_footer]', array(
			'default'    => $defaults['title_tagline_footer'],
			'type'       => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( self::$option_key . '_title_tagline_footer', array(
			'label'      => __( 'Footer text', 'smartadapt' ),
			'section'    => 'title_tagline',
			'settings'   => self::$option_key . '[title_tagline_footer]',
			'type'       => 'text',

		) );

		//add setting pagination

		$wp_customize->add_setting( self::$option_key . '[smartadapt_pagination_posts]', array(
			'default'    => '1',
			'type'       => 'option',
			'capability' => 'edit_theme_options',
		) );


		$wp_customize->add_control( self::$option_key . '_pagination_posts', array(
			'label'      => __( 'Pagination', 'smartadapt' ),
			'section'    => 'smartadapt_pagination_posts',
			'settings'   => self::$option_key . '[smartadapt_pagination_posts]',
			'type'       => 'radio',
			'choices'    => array(
				'1' => __( 'Older posts/Newer posts', 'smartadapt' ),
				'2' => __( 'Paginate links', 'smartadapt' )
			)

		) );

		//add setting breadcrumb_separator

		$wp_customize->add_setting( self::$option_key . '[breadcrumb_separator]', array(
			'default'    => $defaults['breadcrumb_separator'],
			'type'       => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( self::$option_key . '_breadcrumb_separator', array(
			'label'      => __( 'Separator', 'smartadapt' ),
			'section'    => 'smartadapt_breadcrumb',
			'settings'   => self::$option_key . '[breadcrumb_separator]',
			'type'       => 'text',

		) );


		$wp_customize->add_setting( self::$option_key . '[main_font_color]', array(
			'default'           => $defaults['main_font_color'],
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, self::$option_key . '_main_font_color', array(
			'label'    => __( 'Main Font Color', 'smartadapt' ),
			'section'  => 'colors',
			'settings' => self::$option_key . '[main_font_color]',
		) ) );
		//add header color

		$wp_customize->add_setting( self::$option_key . '[header_color]', array(
			'default'           => $defaults['header_color'],
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, self::$option_key . '_header_color', array(
			'label'    => __( 'Headers Text Color', 'smartadapt' ),
			'section'  => 'colors',
			'settings' => self::$option_key . '[header_color]',
		) ) );

		//sidebar color
		$wp_customize->add_setting( self::$option_key . '[sidebar_color]', array(
			'default'           => $defaults['sidebar_color'],
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, self::$option_key . '_sidebar_color', array(
			'label'    => __( 'Sidebar Color', 'smartadapt' ),
			'section'  => 'colors',
			'settings' => self::$option_key . '[sidebar_color]',
		) ) );

		// Link Color (added to Color Scheme section in Theme Customizer)
		$wp_customize->add_setting( self::$option_key . '[link_color]', array(
			'default'           => $defaults['link_color'],
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, self::$option_key . '_link_color', array(
			'label'    => __( 'Link Color', 'smartadapt' ),
			'section'  => 'colors',
			'settings' => self::$option_key . '[link_color]',
		) ) );

		$wp_customize->add_setting( self::$option_key . '[link_color_hover]', array(
			'default'           => $defaults['link_color_hover'],
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
		) );

		$wp_customize->add_control( new smartadapt_Customize_ColorReadonly_Control( $wp_customize, self::$option_key . '_link_color_hover', array(
			'label'    => __( 'Link Hover Color', 'smartadapt' ),
			'section'  => 'colors',
			'settings' => self::$option_key . '[link_color_hover]',
		) ) );

		/*LOGO*/
		$wp_customize->add_setting( self::$option_key . '[smartadapt_logo]', array(
			'default'    => $defaults['smartadapt_logo'],
			'type'       => 'option',
			'capability' => 'edit_theme_options',
		) );


		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, self::$option_key . '_logo', array(
			'label'    => __( 'Upload', 'smartadapt' ),
			'section'  => 'smartadapt_logo',
			'settings' => self::$option_key . '[smartadapt_logo]',
		) ) );

		/* Favicon */

		$wp_customize->add_setting( self::$option_key . '[smartadapt_favicon]', array(
			'default'    => $defaults['smartadapt_favicon'],
			'type'       => 'option',
			'capability' => 'edit_theme_options',
		) );


		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, self::$option_key . '_favicon', array(
			'label'    => __( 'Upload favicon', 'smartadapt' ),
			'section'  => 'smartadapt_logo',
			'settings' => self::$option_key . '[smartadapt_favicon]',
		) ) );

		//add social buttons settings

		//Facebook
		$wp_customize->add_setting( 'smartadapt_theme_options[social_button_facebook]', array(
			'capability' => 'edit_theme_options',
			'type'       => 'option',
		) );

		$wp_customize->add_control( self::$option_key . '_social_button_facebook', array(
			'settings' => self::$option_key . '[social_button_facebook]',
			'label'    => __( 'Facebook Like', 'smartadapt' ),
			'section'  => 'smartadapt_social_buttons',
			'type'     => 'checkbox',
		) );
		//Twitter
		$wp_customize->add_setting( self::$option_key . '[social_button_twitter]', array(
			'capability' => 'edit_theme_options',
			'type'       => 'option',
		) );

		$wp_customize->add_control( self::$option_key . '_social_button_twitter', array(
			'settings' => self::$option_key . '[social_button_twitter]',
			'label'    => __( 'Twitter Button ', 'smartadapt' ),
			'section'  => 'smartadapt_social_buttons',
			'type'     => 'checkbox',
		) );

		//Google +1
		$wp_customize->add_setting( self::$option_key . '[social_button_gplus]', array(
			'capability' => 'edit_theme_options',
			'type'       => 'option',
		) );

		$wp_customize->add_control( self::$option_key . '_social_button_gplus', array(
			'settings' => self::$option_key . '[social_button_gplus]',
			'label'    => __( 'Google +1', 'smartadapt' ),
			'section'  => 'smartadapt_social_buttons',
			'type'     => 'checkbox',
		) );

		//Pinterest
		$wp_customize->add_setting( self::$option_key . '[social_button_pinterest]', array(
			'capability' => 'edit_theme_options',
			'type'       => 'option',
		) );

		$wp_customize->add_control( self::$option_key . '_social_button_pinterest', array(
			'settings' => self::$option_key . '[social_button_pinterest]',
			'label'    => __( 'Pinterest', 'smartadapt' ),
			'section'  => 'smartadapt_social_buttons',
			'type'     => 'checkbox',
		) );

		//add costom code setting

		$wp_customize->add_setting( self::$option_key . '[custom_code_header]', array(
			'default'    => '',
			'type'       => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_setting( self::$option_key . '[custom_code_footer]', array(
			'default'    => '',
			'type'       => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( new smartadapt_Customize_Textarea_Control( $wp_customize, self::$option_key . '_custom_code_header', array(
			'label'      => __( 'Custom Scripts for Header [header.php]', 'smartadapt' ),
			'section'    => 'smartadapt_custom_code',
			'capability' => 'edit_theme_options',
			'settings'   => self::$option_key . '[custom_code_header]'

		) ) );

		$wp_customize->add_control( new smartadapt_Customize_Textarea_Control( $wp_customize, self::$option_key . '_custom_code_footer', array(
			'label'      => __( 'Custom Scripts for Footer [footer.php]', 'smartadapt' ),
			'section'    => 'smartadapt_custom_code',
			'capability' => 'edit_theme_options',
			'settings'   => self::$option_key . '[custom_code_footer]'

		) ) );

		/*ADD PREMIUM SECTIONS*/
		//add section: layout
		$wp_customize->add_section( 'smartadapt_layout', array(
			'title'    => __( 'Layout', 'smartadapt' ),
			'priority' => 40,
		) );


		$wp_customize->add_setting( self::$option_key . '[smartadapt_layout]', array(
			'default'    => 1,
			'type'       => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( new smartadapt_Customize_Layout_Control( $wp_customize, self::$option_key .  '_smartadapt_layout', array(
			'settings'   => self::$option_key . '[smartadapt_layout]',
			'label'      => __( 'Layout variants:', 'smartadapt' ),
			'section'    => 'smartadapt_layout',
			'type'       => 'text'



		)) );

		//fixed top bar option

		$wp_customize->add_setting( self::$option_key . '[smartadapt_fixed_topbar]', array(
			'default'    => 1,
			'type'       => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( self::$option_key . '_smartadapt_fixed_topbar', array(
			'label'      => __( 'Fixed Top Bar', 'smartadapt' ),
			'section'    => 'smartadapt_layout',
			'settings'   => self::$option_key . '[smartadapt_fixed_topbar]',
			'type'       => 'checkbox',


		) );

		//add section sidebar
		$wp_customize->add_section( 'smartadapt_sidebar_resize', array(
			'title'    => __( 'Resize components', 'smartadapt' ),
			'priority' => 60,
		) );

		$wp_customize->add_setting( self::$option_key . '[smartadapt_layout_width]', array(
			'default'    => '1280',
			'type'       => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_setting( self::$option_key . '[smartadapt_sidebar_resize]', array(
			'default'    => 320,
			'type'       => 'option',
			'capability' => 'edit_theme_options',
		) );


		$wp_customize->add_control( new smartadapt_Customize_Range_Control( $wp_customize, self::$option_key . '_smartadapt_layout_width', array(
			'settings' => self::$option_key . '[smartadapt_layout_width]',
			'label'    => __( 'Layout Width ', 'smartadapt' ),
			'section'  => 'smartadapt_sidebar_resize',
			'type'     => 'text',

		) ) );

		$wp_customize->add_control( new smartadapt_Customize_RangeReadonly_Control( $wp_customize, self::$option_key . '_smartadapt_sidebar_resize', array(
			'label'      => __( 'Sidebar Width', 'smartadapt' ),
			'section'    => 'smartadapt_sidebar_resize',
			'settings'   => self::$option_key . '[smartadapt_sidebar_resize]',
			'type'       => 'text',

		)) );

		//add font section
		$wp_customize->add_section( 'smartadapt_fonts', array(
			'title'    => __( 'Typography options', 'smartadapt' ),
			'priority' => 90,
		) );

		$wp_customize->add_setting( self::$option_key . '[smartadapt_general_fonts]', array(
            'default'    => $defaults['smartadapt_general_fonts'],
			'type'       => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( self::$option_key . '_smartadapt_general_fonts', array(
			'label'      => __( 'Primary font', 'smartadapt' ),
			'section'    => 'smartadapt_fonts',
			'settings'   => self::$option_key . '[smartadapt_general_fonts]',
			'type'       => 'select',
			'choices'    => self::get_smartadapt_choices_fonts()

		) );






		//Fixed vertical menu settings
		$wp_customize->add_setting( self::$option_key . '[smartadapt_menu_fixed]', array(

			'type'       => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( self::$option_key . '_smartadapt_menu_fixed', array(
			'label'      => __( 'Fixed vertical menu', 'smartadapt' ),
			'section'    => 'nav',
			'settings'   => self::$option_key . '[smartadapt_menu_fixed]',
			'type'       => 'checkbox',


		) );


	}

	/**
	 * Live preview javascript
	 *
	 * @since  SmartAdapt 1.0
	 * @return void
	 */
	public function customize_preview_js() {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '.dev' : '';

		wp_register_script(
			self::$theme_key . '-customizer',
				get_template_directory_uri() . '/js/theme-customizer' . $suffix . '.js',
			array( 'customize-preview' ),
			FALSE,
			TRUE
		);

		wp_enqueue_script( self::$theme_key . '-customizer' );
	}

	/**
	 * Get available fonts
	 *
	 * @since  SmartAdapt 1.1
	 * @return array
	 */
	public static function get_smartadapt_available_fonts() {
		$fonts = array(
			'arial'             => array(
				'name'   => 'Arial',
				'import' => '',
				'css'    => "font-family: Arial, sans-serif;"
			),
			'cantarell'         => array(
				'name'   => 'Cantarell',
				'import' => '@import url(http://fonts.googleapis.com/css?family=Cantarell);',
				'css'    => "font-family: 'Cantarell', sans-serif;"
			),
			'droid'             => array(
				'name'   => 'Droid Sans',
				'import' => '@import url(http://fonts.googleapis.com/css?family=Droid+Sans);',
				'css'    => "font-family: 'Droid Sans', sans-serif;"
			),
			'lato'              => array(
				'name'   => 'Lato',
				'import' => '@import url(http://fonts.googleapis.com/css?family=Lato);',
				'css'    => "font-family: 'Lato', sans-serif;"
			),
			'merriweather-sans' => array(
				'name'   => 'Merriweather Sans',
				'import' => '@import url(http://fonts.googleapis.com/css?family=Merriweather+Sans:400,700&amp;subset=latin,latin-ext);',
				'css'    => "font-family: 'Merriweather Sans', sans-serif;"
			),
			'open-sans'         => array(
				'name'   => 'Open Sans',
				'import' => '@import url(http://fonts.googleapis.com/css?family=Open+Sans);',
				'css'    => "font-family: 'Open Sans', sans-serif;"
			),
			'open-sans-condesed'=> array(
				'name'   => 'Open Sans Condensed',
				'import' => '@import url(http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700&amp;subset=latin,latin-ext);',
				'css'    => "font-family: 'Open Sans Condensed', sans-serif;"
			),
			'roboto'            => array(
				'name'   => 'Roboto',
				'import' => '@import url(http://fonts.googleapis.com/css?family=Roboto&subset=latin,latin-ext);',
				'css'    => "font-family: 'Roboto', sans-serif;"
			),
			'source-sans-pro'   => array(
				'name'   => 'Source Sans Pro',
				'import' => '@import url(http://fonts.googleapis.com/css?family=Source+Sans+Pro&subset=latin,latin-ext);',
				'css'    => "font-family: 'Source Sans Pro', sans-serif;"
			),
			'Tahoma'            => array(
				'name'   => 'Tahoma',
				'import' => '',
				'css'    => "font-family: Tahoma, sans-serif;"
			),
			'vollkorn'          => array(
				'name'   => 'Vollkorn',
				'import' => '@import url(http://fonts.googleapis.com/css?family=Vollkorn);',
				'css'    => "font-family: 'Vollkorn', serif;"
			),

		);

		return apply_filters( 'smartadapt_available_fonts', $fonts );
	}

	/**
	 * Get array of fonts -> wp_customize control select
	 *
	 * @since  SmartAdapt 1.1
	 * @return array
	 */
	public static function get_smartadapt_choices_fonts() {
		$font_array   = self::get_smartadapt_available_fonts();
		$font_choices = array();

		foreach ( $font_array as $key=> $row ) {
			$font_choices[$key] = $row['name'];
		}
		return $font_choices;
	}
}


/**
 * Customize for textarea, extend the WP customizer
 *
 * @package    WordPress
 * @subpackage SmartAdapt
 * @since      SmartAdapt 1.0
 */
if (class_exists('WP_Customize_Control'))
{
class smartadapt_Customize_Textarea_Control extends WP_Customize_Control {
	public $type = 'textarea';

	public function render_content() {
		?>
	<label>
		<?php echo esc_html( $this->label ); ?></label>
	<textarea rows="5"
						style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>

	<?php
	}
}
}
/**
 * Customize for input range field, extend the WP customizer
 *
 * @package    WordPress
 * @subpackage SmartAdapt
 * @since      SmartAdapt 1.0
 */
if (class_exists('WP_Customize_Control'))
{
class smartadapt_Customize_Range_Control extends WP_Customize_Control {
	public $type = 'text';

	public function render_content() {
		?>
	<fieldset class="range-fieldset">
		<label for="<?php echo $this->id ?>">
			<?php echo esc_html( $this->label ); ?></label>
		<input type="text" class="slider-range-input" readonly="readonly" id="<?php echo $this->id ?>" class="range-customize-input" <?php $this->link(); ?> value="<?php echo esc_textarea( $this->value() ); ?>" /><span>px</span>

		<div class="noUiSlider <?php echo $this->id ?>" rel="<?php echo $this->id ?>"></div>
	</fieldset>
	<?php
	}
}

	class smartadapt_Customize_RangeReadonly_Control extends WP_Customize_Control {
		public $type = 'text';
		public static $pro_link = 'http://netbiel.pl/smartadapt/smartadaptpro.html';
		public function render_content() {
			?>
					<div class="smartadapt-form-proversion-info-outer">
				<div class="smartadapt-form-proversion-info-inner"><a href="<?php echo self::$pro_link ?>" target="_blank" class="smartadapt-proversion-link"><?php _e('Available in pro version &#187;', 'smartadapt');?> </a></div>

		<div class="smartadapt-resize-readonly-image"></div>
				</div>
		<?php
		}
	}

	class smartadapt_Customize_FontsPro_Control extends WP_Customize_Control {
		public $type = 'text';
		public static $pro_link = 'http://netbiel.pl/smartadapt/smartadaptpro.html';
		public function render_content() {
			?>
		<div class="smartadapt-form-proversion-info-outer">
			<div class="smartadapt-form-proversion-info-inner"><a href="<?php echo self::$pro_link ?>" target="_blank" class="smartadapt-proversion-link"><?php _e('Available in pro version &#187;', 'smartadapt');?></a></div>

			<div class="smartadapt-resize-font-pro-image"></div>
		</div>
		<?php
		}
	}
	class smartadapt_Customize_Layout_Control extends WP_Customize_Control {
		public $type = 'text';
		public static $pro_link = 'http://netbiel.pl/smartadapt/smartadaptpro.html';
		public function render_content() {
			?>
		<li id="customize-control-smartadapt_theme_options_smartadapt_layout" class="customize-control customize-control-radio">
			<div class="smartadapt-form-proversion-info-outer">
				<div class="smartadapt-form-proversion-info-inner"><a href="<?php echo self::$pro_link ?>" target="_blank" class="smartadapt-proversion-link"><?php _e('Available in pro version &#187;', 'smartadapt');?></a></div>
			<span class="customize-control-title"><?php _e('Layout variants:', 'smartadapt') ; ?></span>
			<label>
				<input type="radio" value="1" name="_customize-radio-smartadapt_theme_options_smartadapt_layout" data-customize-setting-link="smartadapt_theme_options[smartadapt_layout]" checked="checked">
				<?php _e('Left menu &amp; right sidebar', 'smartadapt'); ?><br>
			</label>
			<label>
				<input type="radio" value="2" name="_customize-radio-smartadapt_theme_options_smartadapt_layout" data-customize-setting-link="smartadapt_theme_options[smartadapt_layout]">
				<?php _e('Left sidebar &amp; right menu' , 'smartadapt') ;?><br>
			</label>
			<label>
				<input type="radio" value="3" name="_customize-radio-smartadapt_theme_options_smartadapt_layout" data-customize-setting-link="smartadapt_theme_options[smartadapt_layout]">
				<?php _e('Right sidebar without menu', 'smartadapt') ;?><br>
			</label>
			<label>
				<input type="radio" value="4" name="_customize-radio-smartadapt_theme_options_smartadapt_layout" data-customize-setting-link="smartadapt_theme_options[smartadapt_layout]">
				<?php _e('Left menu without sidebar', 'smartadapt') ;?><br>
			</label>
			</div>
		</li>
		<?php
		}
	}


class smartadapt_Customize_ColorReadonly_Control extends WP_Customize_Control {
	public $type = 'text';
	public static $pro_link = 'http://netbiel.pl/smartadapt/smartadaptpro.html';
	public function render_content() {
		?>
	<li id="customize-control-smartadapt_theme_options_smartadapt_layout" class="customize-control customize-control-radio">
		<div class="smartadapt-form-proversion-info-outer">
			<div class="smartadapt-form-proversion-info-inner"><a href="<?php echo self::$pro_link ?>" target="_blank" class="smartadapt-proversion-link"><?php _e('Available in pro version &#187;', 'smartadapt');?></a></div>
			<div class="smartadapt-color-readonly-image"></div>
		</div>
	<?php
	}
}
}
//Setup the Theme Customizer settings and controls
add_action( 'customize_register', array( 'smartadapt_Customize', 'register' ) );

//Output custom CSS to live site
add_action( 'wp_head', array( 'smartadapt_Customize', 'header_output' ) );

//Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init', array( 'smartadapt_Customize', 'customize_preview_js' ) );







