<?php
/**
 *
 * SmartAdapt plugin functions.
 *
 * Provides some  functions, which are used  to extend theme functionality.
 *
 * @package    WordPress
 * @subpackage SmartAdapt
 * @since      SmartAdaptPro 1.0
 */


/**
 * Adds new profile fields
 * @param $profile_fields
 *
 * @return array
 */
function smartadapt_contact_link($profile_fields) {

	// Add new fields
	$profile_fields['twitter'] = 'Twitter Username';
	$profile_fields['facebook'] = 'Facebook URL';
	$profile_fields['gplus'] = 'Google+ URL';
	$profile_fields['pinterest'] = 'Pinterest URL';
	$profile_fields['linkedin'] = 'LinkedIn URL';
	$profile_fields['youtube'] = 'YouTube URL';

	return $profile_fields;

}
add_filter('user_contactmethods', 'smartadapt_contact_link');

/**
 * Return user profile fields - Google headshot support
 * @return array
 */
function smartadapt_get_user_profile_fields()

{
	$field_width_values = array();
	$social_array = array(
		'twitter', 'facebook', 'gplus', 'pinterest', 'linkedin', 'youtube'
	);

	foreach($social_array as $row){
		$value = get_the_author_meta($row);
		$rel = '';
		if(!empty($value)){
			if($row=='gplus'){ //check author rel (google headshot)
			  $parse_array =  parse_url($value);

				if(isset($parse_array['query'])){
					 parse_str($parse_array['query'], $output);

					if(!isset($output['rel']))
					$rel = '?rel=author';
				}else{
					$rel = '?rel=author';
				}
			}
			$field_width_values[$row] = $value.$rel;
		}
	}
	return $field_width_values;
}

add_action( 'show_user_profile', 'smartadapt_image_profile_field' );
add_action( 'edit_user_profile', 'smartadapt_image_profile_field' );

/**
 * Display image user profile field
 *
 * @param $user
 */
function smartadapt_image_profile_field( $user ) {
	if(current_user_can('upload_files')){
	$user_image = get_the_author_meta( 'smartadapt_profile_image', $user->ID );
	?>

<h3><?php _e("User profile picture", 'smartadapt') ?><br /><br /></h3>
	<div class="smartadapt-form-proversion-info-outer">
		<div class="smartadapt-form-proversion-info-inner"><a href="<?php echo $pro_link ?>" target="_blank" class="smartadapt-proversion-link"><?php _e('Available in pro version &#187;', 'smartadapt');?></a></div>
		<div class="smartadapt-userphoto-readonly-image"></div>
	</div>
<?php
}
}





add_action( 'admin_enqueue_scripts', 'smartadapt_admin_area_enqueue_scripts'  );

/**
 * Enqueue admin script
 */
function smartadapt_admin_area_enqueue_scripts() {
	if(current_user_can('upload_files')){
	wp_enqueue_media(); //add uploader files


	//add common script
	wp_enqueue_script( 'smartadapt_admin_area_plugin', get_template_directory_uri() . '/admin/js/plugin-scripts.js', array( 'jquery' ), '1.0', false );
	}
}

add_action( 'admin_print_styles', 'smartadapt_admin_area_enqueue_styles'  );

function smartadapt_admin_area_enqueue_styles(){
	wp_enqueue_style( 'smartadapt_admin_area_enqueue_styles',get_template_directory_uri() . '/admin/css/css-admin-mod.css', array(), '1.0', false );
}


