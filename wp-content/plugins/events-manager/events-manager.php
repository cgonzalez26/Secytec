<?php
/*
Plugin Name: Events Manager
Version: 5.5.3.1
Plugin URI: http://wp-events-plugin.com
Description: Event registration and booking management for WordPress. Recurring events, locations, google maps, rss, ical, booking registration and more!
Author: Marcus Sykes
Author URI: http://wp-events-plugin.com
*/

/*
Copyright (c) 2014, Marcus Sykes

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// Setting constants
define('EM_VERSION', 5.53); //self expanatory
define('EM_PRO_MIN_VERSION', 2.377); //self expanatory
define('EM_DIR', dirname( __FILE__ )); //an absolute path to this directory
define('EM_DIR_URI', trailingslashit(plugins_url('',__FILE__))); //an absolute path to this directory
define('EM_SLUG', plugin_basename( __FILE__ )); //for updates

//temporarily disable AJAX by default, future updates will eventually have this turned on as we work out some kinks
if( !defined('EM_AJAX') ){
	define( 'EM_AJAX', get_option('dbem_events_page_ajax', (defined('EM_AJAX_SEARCH') && EM_AJAX_SEARCH)) );
}

if( !defined('EM_CONDITIONAL_RECURSIONS') ) define('EM_CONDITIONAL_RECURSIONS', get_option('dbem_conditional_recursions', 1)); //allows for conditional recursios to be nested

//EM_MS_GLOBAL
if( get_site_option('dbem_ms_global_table') && is_multisite() ){
	define('EM_MS_GLOBAL', true);
}else{
	define('EM_MS_GLOBAL',false);
}

//DEBUG MODE - currently not public, not fully tested
if( !defined('WP_DEBUG') && get_option('dbem_wp_debug') ){
	define('WP_DEBUG',true);
}
function dbem_debug_mode(){
	if( !empty($_REQUEST['dbem_debug_off']) ){
		update_option('dbem_debug',0);
		wp_redirect($_SERVER['HTTP_REFERER']);
	}
	if( current_user_can('activate_plugins') ){
		include_once('em-debug.php');
	}
}
//add_action('plugins_loaded', 'dbem_debug_mode');

// INCLUDES
include('classes/em-object.php'); //Base object, any files below may depend on this
include("em-posts.php"); //set up events as posts
//Template Tags & Template Logic
include("em-actions.php");
include("em-events.php");
include("em-emails.php");
include("em-functions.php");
include("em-ical.php");
include("em-shortcode.php");
include("em-template-tags.php");
include("em-ml.php");
//Widgets
include("widgets/em-events.php");
if( get_option('dbem_locations_enabled') ){
	include("widgets/em-locations.php");
}
include("widgets/em-calendar.php");
include("widgets/em-events-favorites.php");
//Classes
include('classes/em-booking.php');
include('classes/em-bookings.php');
include("classes/em-bookings-table.php") ;
include('classes/em-calendar.php');
include('classes/em-category.php');
include('classes/em-category-taxonomy.php');
include('classes/em-categories.php');
include('classes/em-event.php');
include('classes/em-event-post.php');
include('classes/em-events.php');
include('classes/em-location.php');
include('classes/em-location-post.php');
include('classes/em-locations.php');
include("classes/em-mailer.php") ;
include('classes/em-notices.php');
include('classes/em-people.php');
include('classes/em-person.php');
include('classes/em-permalinks.php');
include('classes/em-tag.php');
include('classes/em-tag-taxonomy.php');
include('classes/em-tags.php');
include('classes/em-ticket-booking.php');
include('classes/em-ticket.php');
include('classes/em-tickets-bookings.php');
include('classes/em-tickets.php');
//Admin Files
if( is_admin() ){
	include('admin/em-admin.php');
	include('admin/em-bookings.php');
	include('admin/em-docs.php');
	include('admin/em-help.php');
	include('admin/em-options.php');
	if( is_multisite() ){
		include('admin/em-ms-options.php');
	}
	//post/taxonomy controllers
	include('classes/em-event-post-admin.php');
	include('classes/em-event-posts-admin.php');
	include('classes/em-location-post-admin.php');
	include('classes/em-location-posts-admin.php');
	include('classes/em-categories-taxonomy.php');
	//bookings folder
		include('admin/bookings/em-cancelled.php');
		include('admin/bookings/em-confirmed.php');
		include('admin/bookings/em-events.php');
		include('admin/bookings/em-rejected.php');
		include('admin/bookings/em-pending.php');
		include('admin/bookings/em-person.php');
}

/* Only load the component if BuddyPress is loaded and initialized. */
function bp_em_init() {
	if ( version_compare( BP_VERSION, '1.3', '>' ) ){
		require( dirname( __FILE__ ) . '/buddypress/bp-em-core.php' );
	}
}
add_action( 'bp_include', 'bp_em_init' );

//Table names
global $wpdb;
if( EM_MS_GLOBAL ){
	$prefix = $wpdb->base_prefix;
}else{
	$prefix = $wpdb->prefix;
}
	define('EM_CATEGORIES_TABLE', $prefix.'em_categories'); //TABLE NAME
	define('EM_EVENTS_TABLE',$prefix.'em_events'); //TABLE NAME
	define('EM_TICKETS_TABLE', $prefix.'em_tickets'); //TABLE NAME
	define('EM_TICKETS_BOOKINGS_TABLE', $prefix.'em_tickets_bookings'); //TABLE NAME
	define('EM_META_TABLE',$prefix.'em_meta'); //TABLE NAME
	define('EM_RECURRENCE_TABLE',$prefix.'dbem_recurrence'); //TABLE NAME
	define('EM_LOCATIONS_TABLE',$prefix.'em_locations'); //TABLE NAME
	define('EM_BOOKINGS_TABLE',$prefix.'em_bookings'); //TABLE NAME

//Backward compatability for old images stored in < EM 5
if( EM_MS_GLOBAL ){
	//If in ms recurrence mode, we are getting the default wp-content/uploads folder
	$upload_dir = array(
		'basedir' => WP_CONTENT_DIR.'/uploads/',
		'baseurl' => WP_CONTENT_URL.'/uploads/'
	);
}else{
	$upload_dir = wp_upload_dir();
}
if( file_exists($upload_dir['basedir'].'/locations-pics' ) ){
	define("EM_IMAGE_UPLOAD_DIR", $upload_dir['basedir']."/locations-pics/");
	define("EM_IMAGE_UPLOAD_URI", $upload_dir['baseurl']."/locations-pics/");
	define("EM_IMAGE_DS",'-');
}else{
	define("EM_IMAGE_UPLOAD_DIR", $upload_dir['basedir']."/events-manager/");
	define("EM_IMAGE_UPLOAD_URI", $upload_dir['baseurl']."/events-manager/");
	define("EM_IMAGE_DS",'/');
}

/**
 * @author marcus
 * Contains functions for loading styles on both admin and public sides.
 */
class EM_Scripts_and_Styles {
	public static function init(){
		if( is_admin() ){
			//Scripts and Styles
			if( (!empty($_GET['page']) && substr($_GET['page'],0,14) == 'events-manager') || (!empty($_GET['post_type']) && in_array($_GET['post_type'], array(EM_POST_TYPE_EVENT,EM_POST_TYPE_LOCATION,'event-recurring'))) ){
				add_action('admin_print_scripts', array('EM_Scripts_and_Styles','admin_enqueue'));
			}else{
				add_action('admin_print_styles-post.php', array('EM_Scripts_and_Styles','admin_enqueue'));
			}
		}else{
			add_action('wp_enqueue_scripts', array('EM_Scripts_and_Styles','public_enqueue'));
		}
	}

	/**
	 * Enqueuing public scripts and styles
	 */
	public static function public_enqueue() {
	    global $wp_query;
		$pages = array( //pages which EM needs CSS or JS
           	'events' => get_option('dbem_events_page'),
           	'edit-events' => get_option('dbem_edit_events_page'),
           	'edit-locations' => get_option('dbem_edit_locations_page'),
           	'edit-bookings' => get_option('dbem_edit_bookings_page'),
           	'my-bookings' => get_option('dbem_my_bookings_page')
        );
		$obj = $wp_query->get_queried_object();
		$obj_id = 0;
		if( is_home() ){
		    $obj_id = '-1';
		}elseif( !empty( $obj->ID ) ){
			$obj_id = $obj->ID;
		}
		
	    //Decide whether or not to include certain JS files and dependencies??
	    $script_deps = array();
        if( get_option('dbem_js_limit') ){
            //determine what script dependencies to include, and which to not include
            if( is_page($pages) ){
                $script_deps['jquery'] = 'jquery';
            }
            if( (!empty($pages['events']) && is_page($pages['events']) &&  get_option('dbem_events_page_search')) || get_option('dbem_js_limit_search') === '0' || in_array($obj_id, explode(',', get_option('dbem_js_limit_search'))) ){ 
                //events page only needs datepickers
                $script_deps['jquery-ui-core'] = 'jquery-ui-core';
                $script_deps['jquery-ui-datepicker'] = 'jquery-ui-datepicker';
                if( get_option('dbem_search_form_geo') ){
                	$script_deps['jquery-ui-autocomplete'] = 'jquery-ui-autocomplete';
                }
            }
            if( (!empty($pages['edit-events']) && is_page($pages['edit-events'])) || get_option('dbem_js_limit_events_form') === '0' || in_array($obj_id, explode(',', get_option('dbem_js_limit_events_form'))) ){
                //submit/edit event pages require
                $script_deps['jquery-ui-core'] = 'jquery-ui-core';
                $script_deps['jquery-ui-datepicker'] = 'jquery-ui-datepicker';
	            if( !get_option('dbem_use_select_for_locations') ){
					$script_deps['jquery-ui-autocomplete'] = 'jquery-ui-autocomplete';
		        }
			}
            if( (!empty($pages['edit-bookings']) && is_page($pages['edit-bookings'])) || get_option('dbem_js_limit_edit_bookings') === '0' || in_array($obj_id, explode(',', get_option('dbem_js_limit_edit_bookings'))) ){
                //edit booking pages require a few more ui scripts
                $script_deps['jquery-ui-core'] = 'jquery-ui-core';
                $script_deps['jquery-ui-widget'] = 'jquery-ui-widget';
                $script_deps['jquery-ui-position'] = 'jquery-ui-position';
                $script_deps['jquery-ui-sortable'] = 'jquery-ui-sortable';
                $script_deps['jquery-ui-dialog'] = 'jquery-ui-dialog';
            }
			if( !empty($obj->post_type) && ($obj->post_type == EM_POST_TYPE_EVENT || $obj->post_type == EM_POST_TYPE_LOCATION) ){
			    $script_deps['jquery'] = 'jquery';
			}
			//check whether to load our general script or not
			if( empty($script_deps) ){
				if( get_option('dbem_js_limit_general') === "0" || in_array($obj_id, explode(',', get_option('dbem_js_limit_general'))) ){
				    $script_deps['jquery'] = 'jquery';
				}
			}
        }else{
            $script_deps = array(
            	'jquery'=>'jquery',
	        	'jquery-ui-core'=>'jquery-ui-core',
	        	'jquery-ui-widget'=>'jquery-ui-widget',
	        	'jquery-ui-position'=>'jquery-ui-position',
	        	'jquery-ui-sortable'=>'jquery-ui-sortable',
	        	'jquery-ui-datepicker'=>'jquery-ui-datepicker',
	        	'jquery-ui-autocomplete'=>'jquery-ui-autocomplete',
	        	'jquery-ui-dialog'=>'jquery-ui-dialog'
            );
        }            			
        $script_deps = apply_filters('em_public_script_deps', $script_deps);
        if( !empty($script_deps) ){ //given we depend on jQuery, there must be at least a jQuery dep for our file to be loaded
			wp_enqueue_script('events-manager', plugins_url('includes/js/events-manager.js',__FILE__), array_values($script_deps), EM_VERSION); //jQuery will load as dependency
			self::localize_script();
    		do_action('em_enqueue_scripts');
        }
        
		//Now decide on showing the CSS file
		if( get_option('dbem_css_limit') ){
			$includes = get_option('dbem_css_limit_include');
			$excludes = get_option('dbem_css_limit_exclude');
			if( (!empty($pages) && is_page($pages)) || (!empty($obj->post_type) && in_array($obj->post_type, array(EM_POST_TYPE_EVENT, EM_POST_TYPE_LOCATION))) || $includes === "0" || in_array($obj_id, explode(',', $includes)) ){
			    $include = true;
			}
			if( $excludes === '0' || (!empty($obj_id) && in_array($obj_id, explode(',', $excludes))) ){
				$exclude = true;
			}
			if( !empty($include) && empty($exclude) ){
			    wp_enqueue_style('events-manager', plugins_url('includes/css/events_manager.css',__FILE__), array(), EM_VERSION); //main css
	    		do_action('em_enqueue_styles');
			}
		}else{
			wp_enqueue_style('events-manager', plugins_url('includes/css/events_manager.css',__FILE__), array(), EM_VERSION); //main css
	    	do_action('em_enqueue_styles');
		}
	}
	
	public static function admin_enqueue(){
	    do_action('em_enqueue_admin_scripts');
		wp_enqueue_script('events-manager', plugins_url('includes/js/events-manager.js',__FILE__), array('jquery', 'jquery-ui-core','jquery-ui-widget','jquery-ui-position','jquery-ui-sortable','jquery-ui-datepicker','jquery-ui-autocomplete','jquery-ui-dialog'), EM_VERSION);
		wp_enqueue_style('events-manager-admin', plugins_url('includes/css/events_manager_admin.css',__FILE__), array(), EM_VERSION);
		self::localize_script();
	}

	/**
	 * Localize the script vars that require PHP intervention, removing the need for inline JS.
	 */
	public static function localize_script(){
		global $em_localized_js;
		$locale_code = substr ( get_locale(), 0, 2 );
		$date_format = get_option('dbem_date_format_js') ? get_option('dbem_date_format_js'):'yy-mm-dd'; //prevents blank datepickers if no option set
		//Localize
		$em_localized_js = array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'locationajaxurl' => admin_url('admin-ajax.php?action=locations_search'),
			'firstDay' => get_option('start_of_week'),
			'locale' => $locale_code,
			'dateFormat' => $date_format,
			'ui_css' => plugins_url('includes/css/ui-lightness.css', __FILE__),
			'show24hours' => get_option('dbem_time_24h'),
			'is_ssl' => is_ssl(),
		);
		if( get_option('dbem_rsvp_enabled') ){
		    $em_localized_js = array_merge($em_localized_js, array(
				'bookingInProgress' => __('Please wait while the booking is being submitted.','dbem'),
				'tickets_save' => __('Save Ticket','dbem'),
				'bookingajaxurl' => admin_url('admin-ajax.php'),
				'bookings_export_save' => __('Export Bookings','dbem'),
				'bookings_settings_save' => __('Save Settings','dbem'),
				'booking_delete' => __("Are you sure you want to delete?",'dbem'),
				//booking button
				'bb_full' =>  get_option('dbem_booking_button_msg_full'),
				'bb_book' => get_option('dbem_booking_button_msg_book'),
				'bb_booking' => get_option('dbem_booking_button_msg_booking'),
				'bb_booked' => get_option('dbem_booking_button_msg_booked'),
				'bb_error' => get_option('dbem_booking_button_msg_error'),
				'bb_cancel' => get_option('dbem_booking_button_msg_cancel'),
				'bb_canceling' => get_option('dbem_booking_button_msg_canceling'),
				'bb_cancelled' => get_option('dbem_booking_button_msg_cancelled'),
				'bb_cancel_error' => get_option('dbem_booking_button_msg_cancel_error')
			));		
		}
		$em_localized_js['txt_search'] = get_option('dbem_search_form_text_label',__('Search','dbem'));
		$em_localized_js['txt_searching'] = __('Searching...','dbem');
		$em_localized_js['txt_loading'] = __('Loading...','dbem');
		
		//logged in messages that visitors shouldn't need to see
		if( is_user_logged_in() || is_page(get_option('dbem_edit_events_page')) ){
		    if( get_option('dbem_recurrence_enabled') ){
				$em_localized_js['event_reschedule_warning'] = __('Are you sure you want to reschedule this recurring event? If you do this, you will lose all booking information and the old recurring events will be deleted.', 'dbem');
				$em_localized_js['event_detach_warning'] = __('Are you sure you want to detach this event? By doing so, this event will be independent of the recurring set of events.', 'dbem');
				$delete_text = ( !EMPTY_TRASH_DAYS ) ? __('This cannot be undone.','dbem'):__('All events will be moved to trash.','dbem');
				$em_localized_js['delete_recurrence_warning'] = __('Are you sure you want to delete all recurrences of this event?', 'dbem').' '.$delete_text;
		    }
			if( get_option('dbem_rsvp_enabled') ){
				$em_localized_js['disable_bookings_warning'] = __('Are you sure you want to disable bookings? If you do this and save, you will lose all previous bookings. If you wish to prevent further bookings, reduce the number of spaces available to the amount of bookings you currently have', 'dbem');
				$em_localized_js['booking_warning_cancel'] = get_option('dbem_booking_warning_cancel');
			}
		}
		//load admin/public only vars
		if( is_admin() ){
			$em_localized_js['event_post_type'] = EM_POST_TYPE_EVENT;
			$em_localized_js['location_post_type'] = EM_POST_TYPE_LOCATION;
			if( !empty($_GET['page']) && $_GET['page'] == 'events-manager-options' ){
			    $em_localized_js['close_text'] = __('Collapse All','dbem');
			    $em_localized_js['open_text'] = __('Expand All','dbem');
			}
		}
		//calendar translations
		$locale_code = get_locale();
		$locale_code_short = substr ( $locale_code, 0, 2 );
		$calendar_languages = array(
			'nl'=>array('closeText'=>'Sluiten','prevText'=>'???','nextText'=>'???','currentText'=>'Vandaag','monthNames'=>array('januari','februari','maart','april','mei','juni','juli','augustus','september','oktober','november','december'),'monthNamesShort'=>array('jan','feb','maa','apr','mei','jun','jul','aug','sep','okt','nov','dec'),'dayNames'=>array('zondag','maandag','dinsdag','woensdag','donderdag','vrijdag','zaterdag'),'dayNamesShort'=>array('zon','maa','din','woe','don','vri','zat'),'dayNamesMin'=>array('zo','ma','di','wo','do','vr','za'),'weekHeader'=>'Wk','dateFormat'=>'dd/mm/yy','firstDay'=>1,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'af'=>array('closeText'=>'Selekteer','prevText'=>'Vorige','nextText'=>'Volgende','currentText'=>'Vandag','monthNames'=>array('Januarie','Februarie','Maart','April','Mei','Junie','Julie','Augustus','September','Oktober','November','Desember'),'monthNamesShort'=>array('Jan','Feb','Mrt','Apr','Mei','Jun','Jul','Aug','Sep','Okt','Nov','Des'),'dayNames'=>array('Sondag','Maandag','Dinsdag','Woensdag','Donderdag','Vrydag','Saterdag'),'dayNamesShort'=>array('Son','Maa','Din','Woe','Don','Vry','Sat'),'dayNamesMin'=>array('So','Ma','Di','Wo','Do','Vr','Sa'),'weekHeader'=>'Wk','dateFormat'=>'dd/mm/yy','firstDay'=>1,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'ar'=>array('closeText'=>'??????????','prevText'=>'<????????????','nextText'=>'????????????>','currentText'=>'??????????','monthNames'=>array('?????????? ????????????','????????','????????','??????????','????????','????????????','????????','????','??????????','?????????? ??????????','?????????? ????????????','?????????? ??????????'),'monthNamesShort'=>array('1','2','3','4','5','6','7','8','9','10','11','12'),'dayNames'=>array('??????????','??????????','??????????????','????????????????','????????????????','????????????','????????????'),'dayNamesShort'=>array('??????','??????','??????????','????????????','????????????','????????','????????'),'dayNamesMin'=>array('??????','??????','??????????','????????????','????????????','????????','????????'),'weekHeader'=>'??????????','dateFormat'=>'dd/mm/yy','firstDay'=>0,'isRTL'=>true,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'az'=>array('closeText'=>'Ba??la','prevText'=>'<Geri','nextText'=>'??r??li>','currentText'=>'Bug??n','monthNames'=>array('Yanvar','Fevral','Mart','Aprel','May','??yun','??yul','Avqust','Sentyabr','Oktyabr','Noyabr','Dekabr'),'monthNamesShort'=>array('Yan','Fev','Mar','Apr','May','??yun','??yul','Avq','Sen','Okt','Noy','Dek'),'dayNames'=>array('Bazar','Bazar ert??si','????r????nb?? ax??am??','????r????nb??','C??m?? ax??am??','C??m??','????nb??'),'dayNamesShort'=>array('B','Be','??a','??','Ca','C','??'),'dayNamesMin'=>array('B','B','??','??','??','C','??'),'weekHeader'=>'Hf','dateFormat'=>'dd.mm.yy','firstDay'=>1,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'bg'=>array('closeText'=>'??????????????','prevText'=>'<??????????','nextText'=>'????????????>','nextBigText'=>'>>','currentText'=>'????????','monthNames'=>array('????????????','????????????????','????????','??????????','??????','??????','??????','????????????','??????????????????','????????????????','??????????????','????????????????'),'monthNamesShort'=>array('??????','??????','??????','??????','??????','??????','??????','??????','??????','??????','??????','??????'),'dayNames'=>array('????????????','????????????????????','??????????????','??????????','??????????????????','??????????','????????????'),'dayNamesShort'=>array('??????','??????','??????','??????','??????','??????','??????'),'dayNamesMin'=>array('????','????','????','????','????','????','????'),'weekHeader'=>'Wk','dateFormat'=>'dd.mm.yy','firstDay'=>1,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'bs'=>array('closeText'=>'Zatvori','prevText'=>'<','nextText'=>'>','currentText'=>'Danas','monthNames'=>array('Januar','Februar','Mart','April','Maj','Juni','Juli','August','Septembar','Oktobar','Novembar','Decembar'),'monthNamesShort'=>array('Jan','Feb','Mar','Apr','Maj','Jun','Jul','Aug','Sep','Okt','Nov','Dec'),'dayNames'=>array('Nedelja','Ponedeljak','Utorak','Srijeda','??etvrtak','Petak','Subota'),'dayNamesShort'=>array('Ned','Pon','Uto','Sri','??et','Pet','Sub'),'dayNamesMin'=>array('Ne','Po','Ut','Sr','??e','Pe','Su'),'weekHeader'=>'Wk','dateFormat'=>'dd.mm.yy','firstDay'=>1,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'ca' => array('closeText'=> 'Tancar','prevText'=> '&#x3c;Ant','nextText'=> 'Seg&#x3e;','currentText'=> 'Avui','monthNames'=> array('Gener','Febrer','Mar&ccedil;','Abril','Maig','Juny','Juliol','Agost','Setembre','Octubre','Novembre','Desembre'),'monthNamesShort'=> array('Gen','Feb','Mar','Abr','Mai','Jun','Jul','Ago','Set','Oct','Nov','Des'),'dayNames'=> array('Diumenge','Dilluns','Dimarts','Dimecres','Dijous','Divendres','Dissabte'),'dayNamesShort'=> array('Dug','Dln','Dmt','Dmc','Djs','Dvn','Dsb'),'dayNamesMin'=> array('Dg','Dl','Dt','Dc','Dj','Dv','Ds'),'weekHeader'=> 'Sm','dateFormat'=> 'dd/mm/yy','firstDay'=> 1,'isRTL'=> false,'showMonthAfterYear'=> false,'yearSuffix'=> ''),
			'cs'=>array('closeText'=>'Zav????t','prevText'=>'<D????ve','nextText'=>'Pozd??ji>','currentText'=>'Nyn??','monthNames'=>array('leden','??nor','b??ezen','duben','kv??ten','??erven','??ervenec','srpen','z??????','????jen','listopad','prosinec'),'monthNamesShort'=>array('led','??no','b??e','dub','kv??','??er','??vc','srp','z????','????j','lis','pro'),'dayNames'=>array('ned??le','pond??l??','??ter??','st??eda','??tvrtek','p??tek','sobota'),'dayNamesShort'=>array('ne','po','??t','st','??t','p??','so'),'dayNamesMin'=>array('ne','po','??t','st','??t','p??','so'),'weekHeader'=>'T??d','dateFormat'=>'dd.mm.yy','firstDay'=>1,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'da'=>array('closeText'=>'Luk','prevText'=>'<Forrige','nextText'=>'N??ste>','currentText'=>'Idag','monthNames'=>array('Januar','Februar','Marts','April','Maj','Juni','Juli','August','September','Oktober','November','December'),'monthNamesShort'=>array('Jan','Feb','Mar','Apr','Maj','Jun','Jul','Aug','Sep','Okt','Nov','Dec'),'dayNames'=>array('S??ndag','Mandag','Tirsdag','Onsdag','Torsdag','Fredag','L??rdag'),'dayNamesShort'=>array('S??n','Man','Tir','Ons','Tor','Fre','L??r'),'dayNamesMin'=>array('S??','Ma','Ti','On','To','Fr','L??'),'weekHeader'=>'Uge','dateFormat'=>'dd-mm-yy','firstDay'=>1,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'de'=>array('closeText'=>'schlie??en','prevText'=>'<zur??ck','nextText'=>'Vor>','currentText'=>'heute','monthNames'=>array('Januar','Februar','M??rz','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember'),'monthNamesShort'=>array('Jan','Feb','M??r','Apr','Mai','Jun','Jul','Aug','Sep','Okt','Nov','Dez'),'dayNames'=>array('Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'),'dayNamesShort'=>array('So','Mo','Di','Mi','Do','Fr','Sa'),'dayNamesMin'=>array('So','Mo','Di','Mi','Do','Fr','Sa'),'weekHeader'=>'Wo','dateFormat'=>'dd.mm.yy','firstDay'=>1,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'el'=>array('closeText'=>'????????????????','prevText'=>'????????????????????????','nextText'=>'????????????????','currentText'=>'???????????? ??????????','monthNames'=>array('????????????????????','??????????????????????','??????????????','????????????????','??????????','??????????????','??????????????','??????????????????','??????????????????????','??????????????????','??????????????????','????????????????????'),'monthNamesShort'=>array('??????','??????','??????','??????','??????','????????','????????','??????','??????','??????','??????','??????'),'dayNames'=>array('??????????????','??????????????','??????????','??????????????','????????????','??????????????????','??????????????'),'dayNamesShort'=>array('??????','??????','??????','??????','??????','??????','??????'),'dayNamesMin'=>array('????','????','????','????','????','????','????'),'weekHeader'=>'??????','dateFormat'=>'dd/mm/yy','firstDay'=>1,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'en_GB'=>array('closeText'=>'Done','prevText'=>'Prev','nextText'=>'Next','currentText'=>'Today','monthNames'=>array('January','February','March','April','May','June','July','August','September','October','November','December'),'monthNamesShort'=>array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'),'dayNames'=>array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'),'dayNamesShort'=>array('Sun','Mon','Tue','Wed','Thu','Fri','Sat'),'dayNamesMin'=>array('Su','Mo','Tu','We','Th','Fr','Sa'),'weekHeader'=>'Wk','dateFormat'=>'dd/mm/yy','firstDay'=>1,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'eo'=>array('closeText'=>'Fermi','prevText'=>'<Anta','nextText'=>'Sekv>','currentText'=>'Nuna','monthNames'=>array('Januaro','Februaro','Marto','Aprilo','Majo','Junio','Julio','A??gusto','Septembro','Oktobro','Novembro','Decembro'),'monthNamesShort'=>array('Jan','Feb','Mar','Apr','Maj','Jun','Jul','A??g','Sep','Okt','Nov','Dec'),'dayNames'=>array('Diman??o','Lundo','Mardo','Merkredo','??a??do','Vendredo','Sabato'),'dayNamesShort'=>array('Dim','Lun','Mar','Mer','??a??','Ven','Sab'),'dayNamesMin'=>array('Di','Lu','Ma','Me','??a','Ve','Sa'),'weekHeader'=>'Sb','dateFormat'=>'dd/mm/yy','firstDay'=>0,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'et'=>array('closeText'=>'Sulge','prevText'=>'Eelnev','nextText'=>'J??rgnev','currentText'=>'T??na','monthNames'=>array('Jaanuar','Veebruar','M??rts','Aprill','Mai','Juuni','Juuli','August','September','Oktoober','November','Detsember'),'monthNamesShort'=>array('Jaan','Veebr','M??rts','Apr','Mai','Juuni','Juuli','Aug','Sept','Okt','Nov','Dets'),'dayNames'=>array('P??hap??ev','Esmasp??ev','Teisip??ev','Kolmap??ev','Neljap??ev','Reede','Laup??ev'),'dayNamesShort'=>array('P??hap','Esmasp','Teisip','Kolmap','Neljap','Reede','Laup'),'dayNamesMin'=>array('P','E','T','K','N','R','L'),'weekHeader'=>'Sm','dateFormat'=>'dd.mm.yy','firstDay'=>1,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'eu'=>array('closeText'=>'Egina','prevText'=>'<Aur','nextText'=>'Hur>','currentText'=>'Gaur','monthNames'=>array('Urtarrila','Otsaila','Martxoa','Apirila','Maiatza','Ekaina','Uztaila','Abuztua','Iraila','Urria','Azaroa','Abendua'),'monthNamesShort'=>array('Urt','Ots','Mar','Api','Mai','Eka','Uzt','Abu','Ira','Urr','Aza','Abe'),'dayNames'=>array('Igandea','Astelehena','Asteartea','Asteazkena','Osteguna','Ostirala','Larunbata'),'dayNamesShort'=>array('Iga','Ast','Ast','Ast','Ost','Ost','Lar'),'dayNamesMin'=>array('Ig','As','As','As','Os','Os','La'),'weekHeader'=>'Wk','dateFormat'=>'yy/mm/dd','firstDay'=>1,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'fa'=>array('closeText'=>'????????','prevText'=>'<????????','nextText'=>'????????>','currentText'=>'??????????','monthNames'=>array('??????????????','????????????????','??????????','??????','??????????','????????????','??????','????????','??????','????','????????','??????????'),'monthNamesShort'=>array('1','2','3','4','5','6','7','8','9','10','11','12'),'dayNames'=>array('????????????','????????????','???????????????','????????????????','??????????????','????????','????????'),'dayNamesShort'=>array('??','??','??','??','??','??','??'),'dayNamesMin'=>array('??','??','??','??','??','??','??'),'weekHeader'=>'????','dateFormat'=>'yy/mm/dd','firstDay'=>6,'isRTL'=>true,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'fi'=>array('closeText'=>'Sulje','prevText'=>'<Edel','nextText'=>'Seur>','currentText'=>'T??n????n','monthNames'=>array('Tammikuu','Helmikuu','Maaliskuu','Huhtikuu','Toukokuu','Kes??kuu','Hein??kuu','Elokuu','Syyskuu','Lokakuu','Marraskuu','Joulukuu'),'monthNamesShort'=>array('Tammi','Helmi','Maalis','Huhti','Touko','Kes??','Hein??','Elo','Syys','Loka','Marras','Joulu'),'dayNames'=>array('Sunnuntai','Maanantai','Tiistai','Keskiviikko','Torstai','Perjantai','Lauantai'),'dayNamesShort'=>array('Su','Ma','Ti','Ke','To','Pe','La'),'dayNamesMin'=>array('Su','Ma','Ti','Ke','To','Pe','La'),'weekHeader'=>'Sm','dateFormat'=>'dd/mm/yy','firstDay'=>1,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'fo'=>array('closeText'=>'Lat aftur','prevText'=>'<Fyrra','nextText'=>'N??sta>','currentText'=>'?? dag','monthNames'=>array('Januar','Februar','Mars','Apr??l','Mei','Juni','Juli','August','September','Oktober','November','Desember'),'monthNamesShort'=>array('Jan','Feb','Mar','Apr','Mei','Jun','Jul','Aug','Sep','Okt','Nov','Des'),'dayNames'=>array('Sunnudagur','M??nadagur','T??sdagur','Mikudagur','H??sdagur','Fr??ggjadagur','Leyardagur'),'dayNamesShort'=>array('Sun','M??n','T??s','Mik','H??s','Fr??','Ley'),'dayNamesMin'=>array('Su','M??','T??','Mi','H??','Fr','Le'),'weekHeader'=>'Vk','dateFormat'=>'dd-mm-yy','firstDay'=>0,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'fr_CH'=>array('closeText'=>'Fermer','prevText'=>'<Pr??c','nextText'=>'Suiv>','currentText'=>'Courant','monthNames'=>array('Janvier','F??vrier','Mars','Avril','Mai','Juin','Juillet','Ao??t','Septembre','Octobre','Novembre','D??cembre'),'monthNamesShort'=>array('Jan','F??v','Mar','Avr','Mai','Jun','Jul','Ao??','Sep','Oct','Nov','D??c'),'dayNames'=>array('Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'),'dayNamesShort'=>array('Dim','Lun','Mar','Mer','Jeu','Ven','Sam'),'dayNamesMin'=>array('Di','Lu','Ma','Me','Je','Ve','Sa'),'weekHeader'=>'Sm','dateFormat'=>'dd.mm.yy','firstDay'=>1,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'fr'=>array('closeText'=>'Fermer','prevText'=>'<Pr??c','nextText'=>'Suiv>','currentText'=>'Courant','monthNames'=>array('Janvier','F??vrier','Mars','Avril','Mai','Juin','Juillet','Ao??t','Septembre','Octobre','Novembre','D??cembre'),'monthNamesShort'=>array('Jan','F??v','Mar','Avr','Mai','Jun','Jul','Ao??','Sep','Oct','Nov','D??c'),'dayNames'=>array('Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'),'dayNamesShort'=>array('Dim','Lun','Mar','Mer','Jeu','Ven','Sam'),'dayNamesMin'=>array('Di','Lu','Ma','Me','Je','Ve','Sa'),'weekHeader'=>'Sm','dateFormat'=>'dd/mm/yy','firstDay'=>1,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'he'=>array('closeText'=>'????????','prevText'=>'<??????????','nextText'=>'??????>','currentText'=>'????????','monthNames'=>array('??????????','????????????','??????','??????????','??????','????????','????????','????????????','????????????','??????????????','????????????','??????????'),'monthNamesShort'=>array('1','2','3','4','5','6','7','8','9','10','11','12'),'dayNames'=>array('??????????','??????','??????????','??????????','??????????','????????','??????'),'dayNamesShort'=>array('??\'','??\'','??\'','??\'','??\'','??\'','??????'),'dayNamesMin'=>array('??\'','??\'','??\'','??\'','??\'','??\'','??????'),'weekHeader'=>'Wk','dateFormat'=>'dd/mm/yy','firstDay'=>0,'isRTL'=>true,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'hu'=>array('closeText'=>'K??sz','prevText'=>'El??z??','nextText'=>'K??vetkez??','currentText'=>'Ma','monthNames'=>array('janu??r','febru??r','m??rcius','??prilis','m??jus','j??nius','j??lius','augusztus','szeptember','okt??ber','november','cecember'),'monthNamesShort'=>array('jan','febr','m??rc','??pr','m??j','j??n','j??l','aug','szept','okt','nov','dec'),'dayNames'=>array('vas??rnap','h??tf??','kedd','szerda','cs??t??rt??k','p??ntek','szombat'),'dayNamesShort'=>array('va','h??','k','sze','cs??','p??','szo'),'dayNamesMin'=>array('v','h','k','sze','cs','p','szo'),'weekHeader'=>'Wk','dateFormat'=>'yy.mm.dd.','firstDay'=>1,'isRTL'=>false,'showMonthAfterYear'=>true,'yearSuffix'=>''),
			'hr'=>array('closeText'=>'Zatvori','prevText'=>'<','nextText'=>'>','currentText'=>'Danas','monthNames'=>array('Sije??anj','Velja??a','O??ujak','Travanj','Svibanj','Lipanj','Srpanj','Kolovoz','Rujan','Listopad','Studeni','Prosinac'),'monthNamesShort'=>array('Sij','Velj','O??u','Tra','Svi','Lip','Srp','Kol','Ruj','Lis','Stu','Pro'),'dayNames'=>array('Nedjelja','Ponedjeljak','Utorak','Srijeda','??etvrtak','Petak','Subota'),'dayNamesShort'=>array('Ned','Pon','Uto','Sri','??et','Pet','Sub'),'dayNamesMin'=>array('Ne','Po','Ut','Sr','??e','Pe','Su'),'weekHeader'=>'Tje','dateFormat'=>'dd.mm.yy.','firstDay'=>1,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'ja'=>array('closeText'=>'?????????','prevText'=>'<???','nextText'=>'???>','currentText'=>'??????','monthNames'=>array('1???','2???','3???','4???','5???','6???','7???','8???','9???','10???','11???','12???'),'monthNamesShort'=>array('1???','2???','3???','4???','5???','6???','7???','8???','9???','10???','11???','12???'),'dayNames'=>array('?????????','?????????','?????????','?????????','?????????','?????????','?????????'),'dayNamesShort'=>array('???','???','???','???','???','???','???'),'dayNamesMin'=>array('???','???','???','???','???','???','???'),'weekHeader'=>'???','dateFormat'=>'yy/mm/dd','firstDay'=>0,'isRTL'=>false,'showMonthAfterYear'=>true,'yearSuffix'=>'???'),
			'ro'=>array('closeText'=>'??nchide','prevText'=>'?? Luna precedent??','nextText'=>'Luna urm??toare ??','currentText'=>'Azi','monthNames'=>array('Ianuarie','Februarie','Martie','Aprilie','Mai','Iunie','Iulie','August','Septembrie','Octombrie','Noiembrie','Decembrie'),'monthNamesShort'=>array('Ian','Feb','Mar','Apr','Mai','Iun','Iul','Aug','Sep','Oct','Nov','Dec'),'dayNames'=>array('Duminic??','Luni','Mar??i','Miercuri','Joi','Vineri','S??mb??t??'),'dayNamesShort'=>array('Dum','Lun','Mar','Mie','Joi','Vin','S??m'),'dayNamesMin'=>array('Du','Lu','Ma','Mi','Jo','Vi','S??'),'weekHeader'=>'S??pt','dateFormat'=>'dd.mm.yy','firstDay'=>1,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'sk'=>array('closeText'=> 'Zavrie??','prevText'=> '&#x3c;Predch??dzaj??ci','nextText'=> 'Nasleduj??ci&#x3e;','currentText'=> 'Dnes','monthNames'=> array('Janu??r','Febru??r','Marec','Apr??l','M??j','J??n','J??l','August','September','Okt??ber','November','December'),'monthNamesShort'=> array('Jan','Feb','Mar','Apr','M??j','J??n','J??l','Aug','Sep','Okt','Nov','Dec'),'dayNames'=> array('Nedel\'a','Pondelok','Utorok','Streda','??tvrtok','Piatok','Sobota'),'dayNamesShort'=> array('Ned','Pon','Uto','Str','??tv','Pia','Sob'),'dayNamesMin'=> array('Ne','Po','Ut','St','??t','Pia','So'),'weekHeader'=> 'Ty','dateFormat'=> 'dd.mm.yy','firstDay'=> 1,'isRTL'=> false,'showMonthAfterYear'=> false,'yearSuffix'=> ''),
			'sq'=>array('closeText'=>'mbylle','prevText'=>'<mbrapa','nextText'=>'P??rpara>','currentText'=>'sot','monthNames'=>array('Janar','Shkurt','Mars','Prill','Maj','Qershor','Korrik','Gusht','Shtator','Tetor','N??ntor','Dhjetor'),'monthNamesShort'=>array('Jan','Shk','Mar','Pri','Maj','Qer','Kor','Gus','Sht','Tet','N??n','Dhj'),'dayNames'=>array('E Diel','E H??n??','E Mart??','E M??rkur??','E Enjte','E Premte','E Shtune'),'dayNamesShort'=>array('Di','H??','Ma','M??','En','Pr','Sh'),'dayNamesMin'=>array('Di','H??','Ma','M??','En','Pr','Sh'),'weekHeader'=>'Ja','dateFormat'=>'dd.mm.yy','firstDay'=>1,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'sr_SR'=>array('closeText'=>'Zatvori','prevText'=>'<','nextText'=>'>','currentText'=>'Danas','monthNames'=>array('Januar','Februar','Mart','April','Maj','Jun','Jul','Avgust','Septembar','Oktobar','Novembar','Decembar'),'monthNamesShort'=>array('Jan','Feb','Mar','Apr','Maj','Jun','Jul','Avg','Sep','Okt','Nov','Dec'),'dayNames'=>array('Nedelja','Ponedeljak','Utorak','Sreda','??etvrtak','Petak','Subota'),'dayNamesShort'=>array('Ned','Pon','Uto','Sre','??et','Pet','Sub'),'dayNamesMin'=>array('Ne','Po','Ut','Sr','??e','Pe','Su'),'weekHeader'=>'Sed','dateFormat'=>'dd/mm/yy','firstDay'=>1,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'sr'=>array('closeText'=>'??????????????','prevText'=>'<','nextText'=>'>','currentText'=>'??????????','monthNames'=>array('????????????','??????????????','????????','??????????','??????','??????','??????','????????????','??????????????????','??????????????','????????????????','????????????????'),'monthNamesShort'=>array('??????','??????','??????','??????','??????','??????','??????','??????','??????','??????','??????','??????'),'dayNames'=>array('????????????','??????????????????','????????????','??????????','????????????????','??????????','????????????'),'dayNamesShort'=>array('??????','??????','??????','??????','??????','??????','??????'),'dayNamesMin'=>array('????','????','????','????','????','????','????'),'weekHeader'=>'??????','dateFormat'=>'dd/mm/yy','firstDay'=>1,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'sv'=>array('closeText'=>'St??ng','prevText'=>'??F??rra','nextText'=>'N??sta??','currentText'=>'Idag','monthNames'=>array('Januari','Februari','Mars','April','Maj','Juni','Juli','Augusti','September','Oktober','November','December'),'monthNamesShort'=>array('Jan','Feb','Mar','Apr','Maj','Jun','Jul','Aug','Sep','Okt','Nov','Dec'),'dayNamesShort'=>array('S??n','M??n','Tis','Ons','Tor','Fre','L??r'),'dayNames'=>array('S??ndag','M??ndag','Tisdag','Onsdag','Torsdag','Fredag','L??rdag'),'dayNamesMin'=>array('S??','M??','Ti','On','To','Fr','L??'),'weekHeader'=>'Ve','dateFormat'=>'yy-mm-dd','firstDay'=>1,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'ta'=>array('closeText'=>'????????????','prevText'=>'???????????????????????????','nextText'=>'????????????????????????','currentText'=>'???????????????','monthNames'=>array('??????','????????????','?????????????????????','????????????????????????','??????????????????','?????????','?????????','????????????','???????????????????????????','??????????????????','??????????????????????????????','?????????????????????'),'monthNamesShort'=>array('??????','????????????','?????????','????????????','????????????','?????????','?????????','??????','?????????','?????????','????????????','????????????'),'dayNames'=>array('?????????????????????????????????????????????','????????????????????????????????????','?????????????????????????????????????????????','??????????????????????????????','????????????????????????????????????','???????????????????????????????????????','??????????????????????????????'),'dayNamesShort'=>array('??????????????????','?????????????????????','????????????????????????','???????????????','?????????????????????','??????????????????','?????????'),'dayNamesMin'=>array('??????','??????','??????','??????','??????','??????','???'),'weekHeader'=>'????','dateFormat'=>'dd/mm/yy','firstDay'=>1,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'th'=>array('closeText'=>'?????????','prevText'=>'????????????????','nextText'=>'???????????????????','currentText'=>'??????????????????','monthNames'=>array('??????????????????','??????????????????????????????','??????????????????','??????????????????','?????????????????????','????????????????????????','?????????????????????','?????????????????????','?????????????????????','??????????????????','???????????????????????????','?????????????????????'),'monthNamesShort'=>array('???.???.','???.???.','??????.???.','??????.???.','???.???.','??????.???.','???.???.','???.???.','???.???.','???.???.','???.???.','???.???.'),'dayNames'=>array('?????????????????????','??????????????????','??????????????????','?????????','????????????????????????','???????????????','???????????????'),'dayNamesShort'=>array('??????.','???.','???.','???.','??????.','???.','???.'),'dayNamesMin'=>array('??????.','???.','???.','???.','??????.','???.','???.'),'weekHeader'=>'Wk','dateFormat'=>'dd/mm/yy','firstDay'=>0,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'tr'=>array('closeText' => 'kapat', 'prevText' => '&#x3c;geri', 'nextText' => 'ileri&#x3e', 'currentText' => 'bug??n', 'monthNames' => array('Ocak','??ubat','Mart','Nisan','May??s','Haziran','Temmuz','A??ustos','Eyl??l','Ekim','Kas??m','Aral??k'),'monthNamesShort' => array('Oca','??ub','Mar','Nis','May','Haz','Tem','A??u','Eyl','Eki','Kas','Ara'),'dayNames' => array('Pazar','Pazartesi','Sal??','??ar??amba','Per??embe','Cuma','Cumartesi'),'dayNamesShort' => array('Pz','Pt','Sa','??a','Pe','Cu','Ct'),'dayNamesMin' => array('Pz','Pt','Sa','??a','Pe','Cu','Ct'),'weekHeader' => 'Hf','dateFormat' => 'dd.mm.yy','firstDay' => 1,'isRTL' => false,'showMonthAfterYear' => false,'yearSuffix' => ''),
			'vi'=>array('closeText'=>'????ng','prevText'=>'<Tr?????c','nextText'=>'Ti???p>','currentText'=>'H??m nay','monthNames'=>array('Th??ng M???t','Th??ng Hai','Th??ng Ba','Th??ng T??','Th??ng N??m','Th??ng S??u','Th??ng B???y','Th??ng T??m','Th??ng Ch??n','Th??ng M?????i','Th??ng M?????i M???t','Th??ng M?????i Hai'),'monthNamesShort'=>array('Th??ng 1','Th??ng 2','Th??ng 3','Th??ng 4','Th??ng 5','Th??ng 6','Th??ng 7','Th??ng 8','Th??ng 9','Th??ng 10','Th??ng 11','Th??ng 12'),'dayNames'=>array('Ch??? Nh???t','Th??? Hai','Th??? Ba','Th??? T??','Th??? N??m','Th??? S??u','Th??? B???y'),'dayNamesShort'=>array('CN','T2','T3','T4','T5','T6','T7'),'dayNamesMin'=>array('CN','T2','T3','T4','T5','T6','T7'),'weekHeader'=>'Tu','dateFormat'=>'dd/mm/yy','firstDay'=>0,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'zh-TW'=>array('closeText'=>'??????','prevText'=>'<??????','nextText'=>'??????>','currentText'=>'??????','monthNames'=>array('??????','??????','??????','??????','??????','??????','??????','??????','??????','??????','?????????','?????????'),'monthNamesShort'=>array('???','???','???','???','???','???','???','???','???','???','??????','??????'),'dayNames'=>array('?????????','?????????','?????????','?????????','?????????','?????????','?????????'),'dayNamesShort'=>array('??????','??????','??????','??????','??????','??????','??????'),'dayNamesMin'=>array('???','???','???','???','???','???','???'),'weekHeader'=>'???','dateFormat'=>'yy/mm/dd','firstDay'=>1,'isRTL'=>false,'showMonthAfterYear'=>true,'yearSuffix'=>'???'),
			'es'=>array('closeText'=>'Cerrar','prevText'=>'<Ant','nextText'=>'Sig>','currentText'=>'Hoy','monthNames'=>array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'),'monthNamesShort'=>array('Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'),'dayNames'=>array('Domingo','Lunes','Martes','Mi??rcoles','Jueves','Viernes','S??bado'),'dayNamesShort'=>array('Dom','Lun','Mar','Mi??','Juv','Vie','S??b'),'dayNamesMin'=>array('Do','Lu','Ma','Mi','Ju','Vi','S??'),'weekHeader'=>'Sm','dateFormat'=>'dd/mm/yy','firstDay'=>1,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>''),
			'it'=>array('closeText'=>'Fatto','prevText'=>'Precedente','nextText'=>'Prossimo','currentText'=>'Oggi','monthNames'=>array('Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'),'monthNamesShort'=>array('Gen','Feb','Mar','Apr','Mag','Giu','Lug','Ago','Set','Ott','Nov','Dic'),'dayNames'=>array('Domenica','Luned??','Marted??','Mercoled??','Gioved??','Venerd??','Sabato'),'dayNamesShort'=>array('Dom','Lun','Mar','Mer','Gio','Ven','Sab'),'dayNamesMin'=>array('Do','Lu','Ma','Me','Gi','Ve','Sa'),'weekHeader'=>'Wk','dateFormat'=>'dd/mm/yy','firstDay'=>1,'isRTL'=>false,'showMonthAfterYear'=>false,'yearSuffix'=>'')
		);
		if( array_key_exists($locale_code, $calendar_languages) ){
			$em_localized_js['locale_data'] = $calendar_languages[$locale_code];
		}elseif( array_key_exists($locale_code_short, $calendar_languages) ){
			$em_localized_js['locale_data'] = $calendar_languages[$locale_code_short];
		}		
		wp_localize_script('events-manager','EM', apply_filters('em_wp_localize_script', $em_localized_js));
	}
}
EM_Scripts_and_Styles::init();
function em_enqueue_public(){ EM_Scripts_and_Styles::public_enqueue(); } //In case ppl used this somewhere

/**
 * Perform plugins_loaded actions
 */
function em_plugins_loaded(){
	//Capabilities
	global $em_capabilities_array;
	$em_capabilities_array = apply_filters('em_capabilities_array', array(
		/* Booking Capabilities */
		'manage_others_bookings' => sprintf(__('You do not have permission to manage others %s','dbem'),__('bookings','dbem')),
		'manage_bookings' => sprintf(__('You do not have permission to manage %s','dbem'),__('bookings','dbem')),
		/* Event Capabilities */
		'publish_events' => sprintf(__('You do not have permission to publish %s','dbem'),__('events','dbem')),
		'delete_others_events' => sprintf(__('You do not have permission to delete others %s','dbem'),__('events','dbem')),
		'delete_events' => sprintf(__('You do not have permission to delete %s','dbem'),__('events','dbem')),
		'edit_others_events' => sprintf(__('You do not have permission to edit others %s','dbem'),__('events','dbem')),
		'edit_events' => sprintf(__('You do not have permission to edit %s','dbem'),__('events','dbem')),
		'read_private_events' => sprintf(__('You cannot read private %s','dbem'),__('events','dbem')),
		/*'read_events' => sprintf(__('You cannot view %s','dbem'),__('events','dbem')),*/
		/* Recurring Event Capabilties */
		'publish_recurring_events' => sprintf(__('You do not have permission to publish %s','dbem'),__('recurring events','dbem')),
		'delete_others_recurring_events' => sprintf(__('You do not have permission to delete others %s','dbem'),__('recurring events','dbem')),
		'delete_recurring_events' => sprintf(__('You do not have permission to delete %s','dbem'),__('recurring events','dbem')),
		'edit_others_recurring_events' => sprintf(__('You do not have permission to edit others %s','dbem'),__('recurring events','dbem')),
		'edit_recurring_events' => sprintf(__('You do not have permission to edit %s','dbem'),__('recurring events','dbem')),
		/* Location Capabilities */
		'publish_locations' => sprintf(__('You do not have permission to publish %s','dbem'),__('locations','dbem')),
		'delete_others_locations' => sprintf(__('You do not have permission to delete others %s','dbem'),__('locations','dbem')),
		'delete_locations' => sprintf(__('You do not have permission to delete %s','dbem'),__('locations','dbem')),
		'edit_others_locations' => sprintf(__('You do not have permission to edit others %s','dbem'),__('locations','dbem')),
		'edit_locations' => sprintf(__('You do not have permission to edit %s','dbem'),__('locations','dbem')),
		'read_private_locations' => sprintf(__('You cannot read private %s','dbem'),__('locations','dbem')),
		'read_others_locations' => sprintf(__('You cannot view others %s','dbem'),__('locations','dbem')),
		/*'read_locations' => sprintf(__('You cannot view %s','dbem'),__('locations','dbem')),*/
		/* Category Capabilities */
		'delete_event_categories' => sprintf(__('You do not have permission to delete %s','dbem'),__('categories','dbem')),
		'edit_event_categories' => sprintf(__('You do not have permission to edit %s','dbem'),__('categories','dbem')),
		/* Upload Capabilities */
		'upload_event_images' => __('You do not have permission to upload images','dbem')
	));
	// LOCALIZATION
	load_plugin_textdomain('dbem', false, dirname( plugin_basename( __FILE__ ) ).'/includes/langs');
	//WPFC Integration
	if( defined('WPFC_VERSION') ){
		function load_em_wpfc_plugin(){
			if( !function_exists('wpfc_em_init') ) include('em-wpfc.php');	
		}
		add_action('init', 'load_em_wpfc_plugin', 200);
	}
	//bbPress
	if( class_exists( 'bbPress' ) ) include('em-bbpress.php');
}
add_filter('plugins_loaded','em_plugins_loaded');

/**
 * Perform init actions
 */
function em_init(){
	//Hard Links
	global $EM_Mailer, $wp_rewrite;
	if( get_option("dbem_events_page") > 0 ){
		define('EM_URI', get_permalink(get_option("dbem_events_page"))); //PAGE URI OF EM
	}else{
		if( $wp_rewrite->using_permalinks() ){
			define('EM_URI', trailingslashit(home_url()). EM_POST_TYPE_EVENT_SLUG.'/'); //PAGE URI OF EM
		}else{
			define('EM_URI', trailingslashit(home_url()).'?post_type='.EM_POST_TYPE_EVENT); //PAGE URI OF EM
		}
	}
	if( $wp_rewrite->using_permalinks() ){
		define('EM_RSS_URI', trailingslashit(home_url()). EM_POST_TYPE_EVENT_SLUG.'/feed/'); //RSS PAGE URI via CPT archives page
	}else{
		define('EM_RSS_URI', em_add_get_params(home_url(), array('post_type'=>EM_POST_TYPE_EVENT, 'feed'=>'rss2'))); //RSS PAGE URI
	}
	$EM_Mailer = new EM_Mailer();
	//Upgrade/Install Routine
	if( is_admin() && current_user_can('list_users') ){
		if( EM_VERSION > get_option('dbem_version', 0) || (is_multisite() && !EM_MS_GLOBAL && get_option('em_ms_global_install')) ){
			require_once( dirname(__FILE__).'/em-install.php');
			em_install();
		}
	}
	//add custom functions.php file
	locate_template('plugins/events-manager/functions.php', true);
}
add_filter('init','em_init',1);

/**
 * This function will load an event into the global $EM_Event variable during page initialization, provided an event_id is given in the url via GET or POST.
 * global $EM_Recurrences also holds global array of recurrence objects when loaded in this instance for performance
 * All functions (admin and public) can now work off this object rather than it around via arguments.
 * @return null
 */
function em_load_event(){
	global $EM_Event, $EM_Recurrences, $EM_Location, $EM_Person, $EM_Booking, $EM_Category, $EM_Ticket, $current_user;
	if( !defined('EM_LOADED') ){
		$EM_Recurrences = array();
		if( isset( $_REQUEST['event_id'] ) && is_numeric($_REQUEST['event_id']) && !is_object($EM_Event) ){
			$EM_Event = new EM_Event($_REQUEST['event_id']);
		}elseif( isset($_REQUEST['post']) && (get_post_type($_REQUEST['post']) == 'event' || get_post_type($_REQUEST['post']) == 'event-recurring') ){
			$EM_Event = em_get_event($_REQUEST['post'], 'post_id');
		}elseif ( !empty($_REQUEST['event_slug']) && EM_MS_GLOBAL && is_main_site() && !get_site_option('dbem_ms_global_events_links')) {
			// single event page for a subsite event being shown on the main blog
			global $wpdb;
			$matches = array();
			if( preg_match('/\-([0-9]+)$/', $_REQUEST['event_slug'], $matches) ){
				$event_id = $matches[1];
			}else{
				$event_id = $wpdb->get_var('SELECT event_id FROM '.EM_EVENTS_TABLE." WHERE event_slug='{$_REQUEST['event_slug']}' AND blog_id!=".get_current_blog_id());
			}
			$EM_Event = em_get_event($event_id);
		}
		if( isset($_REQUEST['location_id']) && is_numeric($_REQUEST['location_id']) && !is_object($EM_Location) ){
			$EM_Location = new EM_Location($_REQUEST['location_id']);
		}elseif( isset($_REQUEST['post']) && get_post_type($_REQUEST['post']) == 'location' ){
			$EM_Location = em_get_location($_REQUEST['post'], 'post_id');
		}elseif ( !empty($_REQUEST['location_slug']) && EM_MS_GLOBAL && is_main_site() && !get_site_option('dbem_ms_global_locations_links')) {
			// single event page for a subsite event being shown on the main blog
			global $wpdb;
			$matches = array();
			if( preg_match('/\-([0-9]+)$/', $_REQUEST['location_slug'], $matches) ){
				$location_id = $matches[1];
			}else{
				$location_id = $wpdb->get_var('SELECT location_id FROM '.EM_LOCATIONS_TABLE." WHERE location_slug='{$_REQUEST['location_slug']}' AND blog_id!=".get_current_blog_id());
			}
			$EM_Location = em_get_location($location_id);
		}
		if( is_user_logged_in() || (!empty($_REQUEST['person_id']) && is_numeric($_REQUEST['person_id'])) ){
			//make the request id take priority, this shouldn't make it into unwanted objects if they use theobj::get_person().
			if( !empty($_REQUEST['person_id']) ){
				$EM_Person = new EM_Person( $_REQUEST['person_id'] );
			}else{
				$EM_Person = new EM_Person( get_current_user_id() );
			}
		}
		if( isset($_REQUEST['booking_id']) && is_numeric($_REQUEST['booking_id']) && !is_object($_REQUEST['booking_id']) ){
			$EM_Booking = em_get_booking($_REQUEST['booking_id']);
		}
		if( isset($_REQUEST['category_id']) && is_numeric($_REQUEST['category_id']) && !is_object($_REQUEST['category_id']) ){
			$EM_Category = new EM_Category($_REQUEST['category_id']);
		}elseif( isset($_REQUEST['category_slug']) && !is_object($EM_Category) ){
			$EM_Category = new EM_Category( $_REQUEST['category_slug'] );
		}
		if( isset($_REQUEST['ticket_id']) && is_numeric($_REQUEST['ticket_id']) && !is_object($_REQUEST['ticket_id']) ){
			$EM_Ticket = new EM_Ticket($_REQUEST['ticket_id']);
		}
		define('EM_LOADED',true);
	}
}
add_action('template_redirect', 'em_load_event', 1);
if(is_admin()){ add_action('init', 'em_load_event', 2); }

/**
 * Catches various option names and returns a network-wide option value instead of the individual blog option. Uses the magc __call function to catch unprecedented names.
 * @author marcus
 *
 */
class EM_MS_Globals {
	function __construct(){ add_action( 'init', array(&$this, 'add_filters'), 1); }
	function add_filters(){
		foreach( $this->get_globals() as $global_option_name ){
			add_filter('pre_option_'.$global_option_name, array(&$this, 'pre_option_'.$global_option_name), 1,1);
			add_filter('pre_update_option_'.$global_option_name, array(&$this, 'pre_update_option_'.$global_option_name), 1,2);
			add_action('add_option_'.$global_option_name, array(&$this, 'add_option_'.$global_option_name), 1,1);
		}
	}
	function get_globals(){
		$globals = array(
			//multisite settings
			'dbem_ms_global_table', 'dbem_ms_global_caps',
			'dbem_ms_global_events', 'dbem_ms_global_events_links','dbem_ms_events_slug',
			'dbem_ms_global_locations','dbem_ms_global_locations_links','dbem_ms_locations_slug','dbem_ms_mainblog_locations',
			//mail
			'dbem_rsvp_mail_port', 'dbem_mail_sender_address', 'dbem_smtp_password', 'dbem_smtp_username','dbem_smtp_host', 'dbem_mail_sender_name','dbem_smtp_html','dbem_smtp_html_br','dbem_smtp_host','dbem_rsvp_mail_send_method','dbem_rsvp_mail_SMTPAuth',
			//images
			'dbem_image_max_width','dbem_image_max_height','dbem_image_max_size'
		);
		if( EM_MS_GLOBAL ){
			$globals[] = 'dbem_taxonomy_category_slug';
		}
		return apply_filters('em_ms_globals', $globals);
	}
	function __call($filter_name, $value){
		if( strstr($filter_name, 'pre_option_') !== false ){
			$return = get_site_option(str_replace('pre_option_','',$filter_name));
			return $return;
		}elseif( strstr($filter_name, 'pre_update_option_') !== false ){
			if( is_super_admin() ){
				update_site_option(str_replace('pre_update_option_','',$filter_name), $value[0]);
			}
			return $value[1];
		}elseif( strstr($filter_name, 'add_option_') !== false ){
			if( is_super_admin() ){
				update_site_option(str_replace('add_option_','',$filter_name),$value[0]);
			}
			delete_option(str_replace('pre_option_','',$filter_name));
			return;
		}
		return $value[0];
	}
}
if( defined('MULTISITE') && MULTISITE ){
	global $EM_MS_Globals;
	$EM_MS_Globals = new EM_MS_Globals();
}

/**
 * Works much like <a href="http://codex.wordpress.org/Function_Reference/locate_template" target="_blank">locate_template</a>, except it takes a string instead of an array of templates, we only need to load one.
 * @param string $template_name
 * @param boolean $load
 * @uses locate_template()
 * @return string
 */
function em_locate_template( $template_name, $load=false, $args = array() ) {
	//First we check if there are overriding tempates in the child or parent theme
	$located = locate_template(array('plugins/events-manager/'.$template_name));
	if( !$located ){
		if ( file_exists(EM_DIR.'/templates/'.$template_name) ) {
			$located = EM_DIR.'/templates/'.$template_name;
		}
	}
	$located = apply_filters('em_locate_template', $located, $template_name, $load, $args);
	if( $located && $load ){
		if( is_array($args) ) extract($args);
		include($located);
	}
	return $located;
}

/**
 * Quick class to dynamically catch wp_options that are EM formats and need replacing with template files.
 * Since the options filter doesn't have a catchall filter, we send all filters to the __call function and figure out the option that way.
 */
class EM_Formats {
	function __construct(){ add_action( 'template_redirect', array(&$this, 'add_filters')); }
	function add_filters(){
		//you can hook into this filter and activate the format options you want to override by supplying the wp option names in an array, just like in the database.
		$formats = apply_filters('em_formats_filter', array());
		foreach( $formats as $format_name ){
			add_filter('pre_option_'.$format_name, array(&$this, $format_name), 1,1);
		}
	}
	function __call( $name, $value ){
		$format = em_locate_template( 'formats/'.substr($name, 5).'.php' );
		if( $format ){
			ob_start();
			include($format);
			$value[0] = ob_get_clean();
		}
		return $value[0];
	}
}
global $EM_Formats;
$EM_Formats = new EM_Formats();

/**
 * Catches the event rss feed requests
 */
function em_rss() {
	global $post, $wp_query, $wpdb;
	//check if we're meant to override the feeds - we only check EM's taxonomies because we can't guarantee (well, not without more coding) that it's not being used by other CPTs
	if( is_feed() && $wp_query->get(EM_TAXONOMY_CATEGORY) ){
		//event category feed
		$args = array('category' => $wp_query->get(EM_TAXONOMY_CATEGORY));
	}elseif( is_feed() && $wp_query->get(EM_TAXONOMY_TAG) ){
		//event tag feed
		$args = array('tag' => $wp_query->get(EM_TAXONOMY_TAG));
	}elseif( is_feed() && $wp_query->get('post_type') == EM_POST_TYPE_LOCATION && $wp_query->get(EM_POST_TYPE_LOCATION) ){
		//location feeds
		$location_id = $wpdb->get_var('SELECT location_id FROM '.EM_LOCATIONS_TABLE." WHERE location_slug='".$wp_query->get(EM_POST_TYPE_LOCATION)."' AND location_status=1 LIMIT 1");
		if( !empty($location_id) ){
			$args = array('location'=> $location_id);
		}
	}elseif( is_feed() && $wp_query->get('post_type') == EM_POST_TYPE_EVENT ) {
		//events feed - show it all
		$args = array();
	}
	if( isset($args) ){
		$wp_query->is_feed = true; //make is_feed() return true AIO SEO fix
		ob_start();
		em_locate_template('templates/rss.php', true, array('args'=>$args));
		echo apply_filters('em_rss', ob_get_clean());
		die();
	}
}
add_action ( 'template_redirect', 'em_rss' );

/**
 * Monitors event saves and changes the rss pubdate and a last modified option so it's current
 * @param boolean $result
 * @return boolean
 */
function em_modified_monitor($result){
	if($result){
	    update_option('em_last_modified', current_time('timestamp', true));
	}
	return $result;
}
add_filter('em_event_save', 'em_modified_monitor', 10,1);
add_filter('em_location_save', 'em_modified_monitor', 10,1);

function em_admin_bar_mod($wp_admin_bar){
	$wp_admin_bar->add_menu( array(
		'parent' => 'network-admin',
		'id'     => 'network-admin-em',
		'title'  => __( 'Events Manager','dbem' ),
		'href'   => network_admin_url('admin.php?page=events-manager-options'),
	) );
}
add_action( 'admin_bar_menu', 'em_admin_bar_mod', 21 );

function em_delete_blog( $blog_id ){
	global $wpdb;
	$prefix = $wpdb->get_blog_prefix($blog_id);
	$wpdb->query('DROP TABLE '.$prefix.'em_events');
	$wpdb->query('DROP TABLE '.$prefix.'em_bookings');
	$wpdb->query('DROP TABLE '.$prefix.'em_locations');
	$wpdb->query('DROP TABLE '.$prefix.'em_tickets');
	$wpdb->query('DROP TABLE '.$prefix.'em_tickets_bookings');
	$wpdb->query('DROP TABLE '.$prefix.'em_meta');
	//delete events if MS Global
	if( EM_MS_GLOBAL ){
	    EM_Events::delete(array('limit'=>0, 'blog'=>$blog_id));
	    EM_Locations::delete(array('limit'=>0, 'blog'=>$blog_id));
	}
}
add_action('delete_blog','em_delete_blog');

function em_activate() {
	update_option('dbem_flush_needed',1);
}
register_activation_hook( __FILE__,'em_activate');

/* Creating the wp_events table to store event data*/
function em_deactivate() {
	global $wp_rewrite;
   	$wp_rewrite->flush_rules();
}
register_deactivation_hook( __FILE__,'em_deactivate');

/**
 * Fail-safe compatibility checking of EM Pro 
 */
function em_check_pro_compatability(){
	if( defined('EMP_VERSION') && EMP_VERSION < EM_PRO_MIN_VERSION && (!defined('EMP_DISABLE_CRITICAL_WARNINGS') || !EMP_DISABLE_CRITICAL_WARNINGS) ){
		include('em-pro-compatibility.php');
	}
}
add_action('plugins_loaded','em_check_pro_compatability', 1);
?>