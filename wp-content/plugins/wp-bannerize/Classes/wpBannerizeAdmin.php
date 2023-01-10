<?php
/**
 * Class for Manage Admin (back-end)
 *
 * @package            wpBannerize
 * @subpackage         wpBannerizeAdmin
 * @author             =undo= <g.fazioli@undolog.com>, <g.fazioli@wpxtre.me>
 * @copyright          Copyright (C) 2008-2013
 *
 */

/**
 * Outputs the html inline style attribute with display.
 *
 * Compares the first two arguments and if not identical marks as display none
 *
 * @since    3.0.0
 *
 * @param       $display
 * @param mixed $current (true) The other value to compare if not just true
 * @param bool  $echo    Whether to echo or just return the string
 *
 * @internal param mixed $checked One of the values to compare
 * @return string html attribute or empty string
 */
function hidden( $display, $current = true, $echo = true )
{
  if ( (string)$display !== (string)$current ) {
    $result = " style='display:none'";
  }
  else {
    $result = '';
  }

  if ( $echo ) {
    echo $result;
  }

  return $result;
}


class WPBannerizeAdmin extends WPBannerizeClass {

  var $pageMain;
  var $pageAddBanner;
  var $pageSettings;
  var $pageTools;

  /**
   * Keep the default CSS sample rules
   *
   * @var string
   */
  var $cssRulesSample = '';

  function WPBannerizeAdmin( $__file__ )
  {
    $this->__construct( $__file__ );
  }

  function __construct( $__file__ )
  {
    // super
    parent::WPBannerizeClass( $__file__ );

    // Foo string for PoEdit
    $foo_publish = __( 'Publish', 'wp-bannerize' );

    add_action( 'plugins_loaded', array( $this, 'init' ), 1 );
  }

  /**
   * Init the default plugin options and re-load from WP
   *
   * @since 2.2.2
   */
  function init()
  {
    // Load localizations if available; @since 2.4.0
    load_plugin_textdomain( 'wp-bannerize', false, 'wp-bannerize/localization' );

    $this->cssRulesSample = $this->cssRulesSample();
    // Add version control in options
    $this->options = $this->defaultOptions();
    add_option( $this->options_key, $this->options );

    $this->options = get_option( $this->options_key );

    // Add option menu in Wordpress backend
    add_action( 'admin_menu', array( $this, 'admin_menu' ) );

    add_filter( 'screen_layout_columns', array( &$this, 'on_screen_layout_columns' ), 10, 2 );

    // Update version control in options
    update_option( $this->options_key, $this->options );
  }

  /**
   * Comodity: echo common WP Bannerize header
   *
   * @return void
   */
  function commonHeader()
  {
    ?>
    <div class="wp_common_box">
    <a class="wp_common_logo" href="https://wpxtre.me">
			<?php echo $this->plugin_name ?> ver. <?php echo $this->version ?>
		</a>
    <p>This plugin version is no longer updated and supported  <a class="button button-primary button-small" href="https://wpxtre.me/product/bannerize" target="_blank">Check the new version here</a></p>
    </div><?php
  }

  function on_screen_layout_columns( $columns, $screen )
  {
    if ( $screen == $this->pageSettings ) {
      $columns[$this->pageSettings] = 1;
    }
    else {
      if ( $screen == $this->pageTools ) {
        $columns[$this->pageTools] = 2;
      }
    }
    return $columns;
  }

  /**
   * Return css rules sample
   *
   * @return string
   */
  function cssRulesSample()
  {
    ob_start();
    require_once( 'wpBannerizeCssRulesSample.css' );
    $result = ob_get_contents();
    ob_end_clean();
    return $result;
  }

  /**
   * Return and setting default options values
   *
   * @return mixed
   */
  function defaultOptions()
  {
    $this->options = array(
      'wp_bannerize_version'           => $this->version,
      'clickCounterEnabled'            => '1',
      'impressionsEnabled'             => '1',
      'supportWPBannerize'             => '1',
      'comboWindowModeFlash'           => 'Window',
      'linkDescription'                => '0',
      'wpBannerizeStyleDefault'        => 'default',
      'wpBannerizeStyle'               => kWPBannerizeBannerStyleDefault,
      'wpBannerizeStyleCustom'         => $this->cssRulesSample,
      'wpBannerizeNoBannerHTMLMessage' => '<p>No Banner to display</p>'
    );
    return $this->options;
  }

  /**
   * Reset options to default values
   *
   * @return void
   */
  function resetOptionsToDefault()
  {
    $this->options = $this->defaultOptions();
    update_option( $this->options_key, $this->options );
  }

  /**
   * Contextual Help
   *
   * @return void
   */
  function contextualHelp()
  {
    $this->admin_enqueue_scripts();

    // Add contextual Help
    $screen = get_current_screen();

    if ( $screen ) {
      ob_start();
      require_once( 'wpBannerizeHelp.php' );
      $help = ob_get_contents();
      $help = str_replace( "\t", "", $help );
      $help = trim( $help );
      ob_end_clean();

      $help_tab = array(
        'id'       => 'wp-bannerize',
        'title'    => kWPBannerizePluginName,
        'content'  => $help,
        'callback' => false
      );
      $screen->add_help_tab( $help_tab );

    }
  }

  /**
   * Execute when plugin is showing on backend
   *
   * @since 2.4.9
   * @return void
   */
  function admin_enqueue_scripts()
  {
    // ThickBox
    add_thickbox();

    wp_enqueue_script( 'common' );
    wp_enqueue_script( 'postbox' );
    wp_enqueue_script( 'wp-lists' );

    // Add wp_enqueue_script for jquery library
    wp_enqueue_script( 'jquery-ui-sortable' );

    wp_enqueue_script( 'WPBannerizeJavascriptAdmin', $this->uri . kWPBannerizeJavascriptAdmin, array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'media-upload', 'thickbox' ), kWPBannerizeVersion, true );

    //wp_enqueue_script( 'wp_bannerize_jquery_dp_js', $this->uri . '/js/jquery-ui.min.js', array( 'jquery' ), kWPBannerizeVersion, true );
    wp_enqueue_script( 'wp_bannerize_timepicker_js', $this->uri . '/js/jquery.timepicker.min.js', array( 'WPBannerizeJavascriptAdmin' ), kWPBannerizeVersion, true );

    // Add main admin javascript
    wp_localize_script( 'WPBannerizeJavascriptAdmin', 'wpBannerizeJavascriptLocalization', array(
                                                                                                'wpBannerizeFormAction'       => kWPBannerizeFormAction,
                                                                                                'ajaxURL'                     => $this->ajaxURL,
                                                                                                'messageConfirm'              => __( 'WARINING!! Do you want delete this banner?', 'wp-bannerize' ),
                                                                                                'messageTruncateConfirm'      => __( 'WARINING!! Do you have to check `Confirm unreversible action` ', 'wp-bannerize' ),
                                                                                                'messageTruncateConfirmAgain' => __( 'WARINING!! Are you sure to erase all WP Bannerize Database Table? ', 'wp-bannerize' ),
                                                                                                'timeOnlyTitle'               => __( 'Choose Time', 'wp-bannerize' ),
                                                                                                'timeText'                    => __( 'Time', 'wp-bannerize' ),
                                                                                                'hourText'                    => __( 'Hour', 'wp-bannerize' ),
                                                                                                'minuteText'                  => __( 'Minute', 'wp-bannerize' ),
                                                                                                'secondText'                  => __( 'Seconds', 'wp-bannerize' ),
                                                                                                'currentText'                 => __( 'Now', 'wp-bannerize' ),
                                                                                                'dayNamesMin'                 => __( 'Su,Mo,Tu,We,Th,Fr,Sa', 'wp-bannerize' ),
                                                                                                'monthNames'                  => __( 'January,February,March,April,May,June,July,August,September,October,November,December', 'wp-bannerize' ),
                                                                                                'closeText'                   => __( 'Close', 'wp-bannerize' ),
                                                                                                'dateFormat'                  => __( 'mm/dd/yy', 'wp-bannerize' )
                                                                                           ) );
    wp_enqueue_style( 'WPBannerizeBannerStyleAdmin', $this->uri . kWPBannerizeBannerStyleAdmin, array(), kWPBannerizeVersion );
    wp_enqueue_style( 'wp-bannerize-jqueryui-css', $this->uri . '/css/ui-lightness/jquery-ui.custom.css', array(),  kWPBannerizeVersion );

  }

  function didToolsLoadPage()
  {
    $this->admin_enqueue_scripts();

    add_meta_box( 'wp_bannerize_tools_editor', __( 'PHP Function and Shortcode Editor', 'wp-bannerize' ), array( &$this, 'boxTools' ), $this->pageTools, 'normal', 'core' );
    add_meta_box( 'wp_bannerize_tools_database', __( 'Database', 'wp-bannerize' ), array( &$this, 'boxToolsDatabase' ), $this->pageTools, 'side', 'core' );
  }

  function didSettingsLoadPage()
  {
    $this->admin_enqueue_scripts();

    add_meta_box( kWPBannerizeMetaBoxSettingsKey, __( 'Settings', 'wp-bannerize' ), array( &$this, 'boxSettings' ), $this->pageSettings, 'normal', 'core' );
  }

  function boxSettings()
  {
    require_once( 'wpBannerizeSettings.php' );
  }

  function boxTools()
  {
    require_once( 'wpBannerizeTools.php' );
  }

  function boxToolsDatabase()
  {
    require_once( 'wpBannerizeDatabase.php' );
  }

  /**
   * Draw Settings Panel
   */
  function settings()
  {
    global $screen_layout_columns;

    /**
     * Any error flag
     */
    $any_error   = '';
    $this->error = false;

    if ( isset( $_POST['command_action'] ) ) {
      if ( $_POST['command_action'] == "updateSettings" && !isset( $_POST['tools'] ) ) {

        $this->options['clickCounterEnabled']     = ( isset( $_POST['clickCounterEnabled'] ) ) ? '1' : '0';
        $this->options['impressionsEnabled']      = ( isset( $_POST['impressionsEnabled'] ) ) ? '1' : '0';
        $this->options['supportWPBannerize']      = ( isset( $_POST['supportWPBannerize'] ) ) ? '1' : '0';
        $this->options['comboWindowModeFlash']    = ( isset( $_POST['comboWindowModeFlash'] ) ) ? $_POST['comboWindowModeFlash'] : 'Window';
        $this->options['linkDescription']         = ( isset( $_POST['linkDescription'] ) ) ? '1' : '0';
        $this->options['wpBannerizeStyleDefault'] = ( isset( $_POST['wpBannerizeStyleDefault'] ) ) ? $_POST['wpBannerizeStyleDefault'] : 'default';

        $this->options['wpBannerizeStyleCustom'] = ( isset( $_POST['wpBannerizeStyleCustom'] ) ) ? $_POST['wpBannerizeStyleCustom'] : $this->options['wpBannerizeStyleCustom'];

        $this->options['wpBannerizeStyle'] = ( isset( $_POST['wpBannerizeStyle'] ) ) ? $_POST['wpBannerizeStyle'] : kWPBannerizeBannerStyleDefault;

        $this->options['wpBannerizeNoBannerHTMLMessage'] = ( isset( $_POST['wpBannerizeNoBannerHTMLMessage'] ) ) ? $_POST['wpBannerizeNoBannerHTMLMessage'] : '';

        update_option( $this->options_key, $this->options );

        $any_error = __( 'Settings update succesfully!', 'wp-bannerize' );
      }
      else {
        if ( $_POST['tools'] == "resetToDefault" ) {
          $this->resetOptionsToDefault();
          $any_error = __( 'Settings Reset to default succesfully!', 'wp-bannerize' );
        }
      }
    }

    ?>

    <div class="wrap">

		<?php $this->commonHeader(); ?>

      <?php if ( $any_error != '' ) : ?>
        <div id="message" class="<?php echo $this->error ? 'error' : 'updated' ?> fade"><p><?php echo $any_error ?></p>
		</div>
      <?php endif; ?>

      <div id="poststuff"
           class="metabox-holder<?php echo 2 == $screen_layout_columns ? ' has-right-sidebar' : ''; ?>">
			<div id="side-info-column" class="inner-sidebar">
				<?php do_meta_boxes( $this->pageSettings, 'side', "" ); ?>
			</div>
			<div id="post-body" class="has-sidebar">
				<div id="post-body-content" class="has-sidebar-content">
					<?php do_meta_boxes( $this->pageSettings, 'normal', "" ); ?>
				</div>
			</div>
			<br class="clear" />
		</div>

		<script type="text/javascript">
			//<![CDATA[
      jQuery( document ).ready( function ()
      {
        // close postboxes that should be closed
        jQuery( '.if-js-closed' ).removeClass( 'if-js-closed' ).addClass( 'closed' );
        // postboxes setup
        postboxes.add_postbox_toggles( '<?php echo $this->pageSettings; ?>' );

      } );
      //]]>
		</script>
	</div>

  <?php

  }

  /**
   * Draw Tools Panel
   */
  function tools()
  {
    global $screen_layout_columns;

    /**
     * Any error flag
     */
    $any_error = '';

    if ( isset( $_POST[kWPBannerizeFormSender] ) && $_POST[kWPBannerizeFormSender] == kWPBannerizeMetaBoxToolsKey
    ) {
      if ( isset( $_POST[kWPBannerizeFormAction] ) && isset( $_POST['securityConfirm'] ) &&
        $_POST[kWPBannerizeFormAction] == kWPBannerizeFormActionTruncateTable
      ) {
        $this->truncateTable();
        $any_error = __( 'WP Bannerize Table was erase succesfully!', 'wp-bannerize' );
      }
    }
    ?>

    <div class="wrap">

		<?php $this->commonHeader(); ?>

      <?php if ( $any_error != '' ) : ?>
        <div id="message" class="<?php echo $this->error ? 'error' : 'updated' ?> fade"><p><?php echo $any_error ?></p>
		</div>
      <?php endif; ?>

      <div id="poststuff"
           class="metabox-holder<?php echo 2 == $screen_layout_columns ? ' has-right-sidebar' : ''; ?>">
			<div id="side-info-column" class="inner-sidebar">
				<?php do_meta_boxes( $this->pageTools, 'side', "" ); ?>
			</div>
			<div id="post-body" class="has-sidebar">
				<div id="post-body-content" class="has-sidebar-content">
					<?php do_meta_boxes( $this->pageTools, 'normal', "" ); ?>
				</div>
			</div>
			<br class="clear" />
		</div>

		<script type="text/javascript">
			//<![CDATA[
      jQuery( document ).ready( function ()
      {
        // close postboxes that should be closed
        jQuery( '.if-js-closed' ).removeClass( 'if-js-closed' ).addClass( 'closed' );
        // postboxes setup
        postboxes.add_postbox_toggles( '<?php echo $this->pageTools; ?>' );

      } );
      //]]>
		</script>
	</div>

  <?php

  }


  /**
   * Setup main init: add hook for backend
   */
  function admin_menu()
  {

    if ( function_exists( 'add_menu_page' ) ) {
      $plugin_page = add_menu_page( $this->plugin_name, $this->plugin_name, kWPBannerizeUserCapabilitiy,
        $this->directory . '-mainshow', array( &$this, 'show_banners' ), $this->uri . "/css/images/wp-bannerize-16x16.png" );
    }
    if ( function_exists( 'add_submenu_page' ) ) {

      $this->pageMain = add_submenu_page( $this->directory .
        '-mainshow', __( 'Edit', 'wp-bannerize' ), __( 'Edit', 'wp-bannerize' ), kWPBannerizeUserCapabilitiy,
        $this->directory . '-mainshow', array( &$this, 'show_banners' ) );

      $this->pageAddBanner = add_submenu_page( $this->directory .
        '-mainshow', __( 'Add New', 'wp-bannerize' ), __( 'Add New', 'wp-bannerize' ), kWPBannerizeUserCapabilitiy,
        $this->directory . '-addnew', array( &$this, 'add_new_banner' ) );

      $this->pageSettings = add_submenu_page( $this->directory .
        '-mainshow', __( 'Settings', 'wp-bannerize' ), __( 'Settings', 'wp-bannerize' ), kWPBannerizeUserCapabilitiy,
        $this->directory . '-settings', array( &$this, 'settings' ) );

      $this->pageTools = add_submenu_page( $this->directory .
        '-mainshow', __( 'Tools', 'wp-bannerize' ), __( 'Tools', 'wp-bannerize' ), kWPBannerizeUserCapabilitiy,
        $this->directory . '-tools', array( &$this, 'tools' ) );

      add_action( 'load-' . $this->pageSettings, array( &$this, 'didSettingsLoadPage' ) );
      add_action( 'load-' . $this->pageTools, array( &$this, 'didToolsLoadPage' ) );

      add_action( 'load-' . $this->pageMain, array( $this, 'contextualHelp' ) );
      add_action( 'load-' . $this->pageAddBanner, array( $this, 'contextualHelp' ) );
      add_action( 'load-' . $this->pageSettings, array( $this, 'contextualHelp' ) );
      add_action( 'load-' . $this->pageTools, array( $this, 'contextualHelp' ) );
    }
  }

  /**
   * Add new banner Panel
   *
   * @return void
   */
  function add_new_banner()
  {
    $any_error = '';

    if ( isset( $_POST['command_action'] ) && $_POST['command_action'] == "insert" ) {
      $any_error = $this->insertBanner();
    }
    ?>

    <div class="wrap">
		<?php $this->commonHeader(); ?>

      <?php if ( $any_error != '' ) : ?>
        <div id="message" class="<?php echo $this->error ? 'error' : 'updated' ?> fade"><p><?php echo $any_error ?></p>
		</div>
      <?php endif; ?>

      <div id="poststuff" class="metabox-holder">

			<div class="sm-padded">
				<div class="postbox">
					<h3><span><?php _e( 'Insert a new banner', 'wp-bannerize' ) ?></span></h3>

					<div class="inside">
						<form class="wpBannerizeForm" name="insert_bannerize" method="post" action=""
                  enctype="multipart/form-data">
							<input type="hidden" name="command_action" value="insert" />
							<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo kWPBannerizeMaxFileSize ?>" />

							<table class="form-table wp_bannerize">
								<tr>
									<th scope="row">
										<label for="filename"><?php _e( 'Banner', 'wp-bannerize' ) ?>:</label>
									</th>
									<td colspan="2">
										<fieldset>
											<legend>
												<input type="radio" name="wpBannerizeBannerType" value="1"
                               checked="checked" /> <?php _e( 'From local', 'wp-bannerize' ) ?>
                        <input type="radio" name="wpBannerizeBannerType"
                               value="2" /> <?php _e( 'By URL o Media Library', 'wp-bannerize' ) ?>
                        <input type="radio" name="wpBannerizeBannerType"
                               value="3" /> <?php _e( 'Free HTML', 'wp-bannerize' ) ?>
											</legend>
											<div class="wpBannerizeBannerType1"><input type="file" name="filename"
                                                                 id="filename" /></div>
											<div style="display:none" class="wpBannerizeBannerType2"><input size="32"
                                                                                      type="text"
                                                                                      name="filenameFromURL"
                                                                                      id="filenameFromURL"
                                                                                      value="http://" />
												<input id="wpBannerizeButtonFromMediaLibrary" type="button"
                               class="button-secondary"
                               value="<?php _e( 'Media Library Image', 'wp-bannerize' ) ?>" />
											</div>
											<div style="display:none" class="wpBannerizeBannerType3"><textarea
                          name="freeHTML" id="freeHTML" rows="2" cols="50"></textarea></div>
										</fieldset>
									</td>
								</tr>

								<tr>
									<th scope="row">
										<label for="start_date"><?php _e( 'Start Date', 'wp-bannerize' ) ?>:</label>
									</th>
									<td>
										<input class="date" type="text" name="start_date" id="start_date" size="18" />
										<span class="eraser" onclick="jQuery('input#start_date').val('')"></span>
										<label for="end_date"><?php _e( 'End Date', 'wp-bannerize' ) ?>:</label>
										<input class="date" type="text" name="end_date" id="end_date" size="18" />
										<span class="eraser" onclick="jQuery('input#end_date').val('')"></span>
										(<?php _e( 'Leave empty to always visible', 'wp-bannerize' ) ?>)
										<strong><?php _e( 'Server Date/time', 'wp-bannerize' ); ?>
                      : <?php echo date_i18n( $this->getPHPDateFormat() ) ?></strong>
									</td>
								</tr>

								<tr>
									<th scope="row">
										<label for="group"><?php _e( 'Group', 'wp-bannerize' ) ?>:</label>
									</th>
									<td>
										<input type="text" maxlength="128" name="group" id="group"
                           value="group" /> <?php echo $this->get_combo_group() ?>
                    (<?php _e( 'Insert a key max 128 chars', 'wp-bannerize' ) ?>)
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label for="description"><?php _e( 'Description', 'wp-bannerize' ) ?>:</label>
									</th>
									<td>
										<input type="text" name="description" id="description" /> <input type="checkbox"
                                                                                     name="use_description"
                                                                                     value="1" /> <?php _e( 'Use this description in output', 'wp-bannerize' ) ?>
									</td>
								</tr>
								<tr>
									<th scope="row"><label for="url"><?php _e( 'URL', 'wp-bannerize' ) ?>:</label></th>
									<td>
										<input type="text" name="url" id="url" /> <label
                      for="target"><?php _e( 'Target', 'wp-bannerize' ) ?>
                      :</label> <?php echo $this->get_target_combo() ?>
									</td>
								</tr>

								<tr>
									<th scope="row"><label
                      for="maxImpressions"><?php _e( 'Max Impressions', 'wp-bannerize' ) ?>:</label>
									</th>
									<td>
										<input type="text" name="maxImpressions" id="maxImpressions" value="0"
                           size="4" />
										(<?php _e( 'When Impressions are great than this value then this banner is set to hidden', 'wp-bannerize' ) ?>
                    )
									</td>
								</tr>

								<tr>
									<th scope="row"><label
                      for="nofollow"><?php _e( 'Add "nofollow" attribute', 'wp-bannerize' ) ?></label>
									</th>
									<td><input type="checkbox" name="nofollow" id="nofollow" value="1"
                             checked="checked" /></td>
								</tr>
							</table>
							<p class="submit">
								<input class="button-primary" type="submit"
                       value="<?php _e( 'Insert', 'wp-bannerize' ) ?>" />
							</p>
						</form>

					</div>
				</div>
			</div>
		</div>
	</div>
  <?php

  }

  /**
   * Draw Options Panel
   */
  function show_banners()
  {
    global $wpdb;

    if ( isset( $_POST['command_action'] ) && $_POST['command_action'] != "" ) {
      switch ( $_POST['command_action'] ) {
        case "trash":
          $any_error = $this->setBannerToTrash();
          break;
        case "untrash":
          $any_error = $this->unsetBannerToTrash();
          break;
        case "delete":
          $any_error = $this->deleteBanner();
          break;
        case "update":
          $any_error = $this->updateBanner();
          break;
      }
    }
    ?>

    <div class="wrap">

		<?php $this->commonHeader(); ?>

    <p style="text-align:right;"><a class="button-primary"
                                    href="?page=wp-bannerize-addnew"><?php _e( 'Add New', 'wp-bannerize' ) ?></a></p>
    <?php
    // Group Actions
    $action = -1;
    if ( isset( $_POST['groupAction'] ) && $_POST['groupAction'] != '-1' ) {
      $action = $_POST['groupAction'];
    }
    elseif ( isset( $_POST['groupAction2'] ) && $_POST['groupAction2'] != '-1' ) {
      $action = $_POST['groupAction2'];
    }
    elseif ( isset( $_GET['groupAction'] ) && $_GET['groupAction'] != '-1' ) {
      $action = $_GET['groupAction'];
    }
    elseif ( isset( $_GET['groupAction2'] ) && $_GET['groupAction2'] != '-1' ) {
      $action = $_GET['groupAction2'];
    }
    switch ( $action ) {
      case "trash-selected":
        if ( isset( $_POST['image_record'] ) ) {
          $id        = implode( ",", $_POST['image_record'] );
          $any_error = $this->setBannerToTrash( $id );
        }
        break;
      case "delete-selected":
        if ( isset( $_POST['image_record'] ) ) {
          if ( is_array( $_POST['image_record'] ) ) {
            foreach ( $_POST['image_record'] as $id ) {
              $any_error = $this->deleteBanner( $id );
            }
          }
        }
        break;
      case "restore-selected":
        if ( isset( $_POST['image_record'] ) ) {
          $id        = implode( ",", $_POST['image_record'] );
          $any_error = $this->unsetBannerToTrash( $id );
        }
        break;
    }

    $any_error = '';
    $pagenum = isset( $_GET['pagenum'] ) ? ( ( $_GET['pagenum'] == '' ? 1 : $_GET['pagenum'] ) ) : '1';
    $limit = isset( $_REQUEST['combo_pagination_filter'] ) ? $_REQUEST['combo_pagination_filter'] : '10';
    $where = "1";
    $count = array();

    // Build where condictions
    if ( isset( $_GET['trash'] ) && $_GET['trash'] != "" ) {
      $where = sprintf( "%s AND trash = '%s'", $where, $_GET['trash'] );
    }
    else {
      $where = "1 AND trash = '0'";
    }

    if ( isset( $_REQUEST['combo_group_filter'] ) && $_REQUEST['combo_group_filter'] != "" ) {
      $where = sprintf( "%s AND `group` = '%s'", $where, $_REQUEST['combo_group_filter'] );
    }

    // All Total records
    $sql = sprintf( "SELECT COUNT(*) AS all_record FROM %s", $this->table_bannerize );
    $result = $wpdb->get_row( $sql );
    $count['All'] = intval( $result->all_record );

    // Trash
    $sql = sprintf( "SELECT COUNT(*) AS trashed FROM %s WHERE trash = '1'", $this->table_bannerize );
    $result = $wpdb->get_row( $sql );
    $count['Trash'] = intval( $result->trashed );

    $count['Publish'] = $count['All'] - $count['Trash'];

    // Count record with where conditions
    $sql = sprintf( "SELECT COUNT(*) AS showing FROM %s WHERE %s", $this->table_bannerize, $where );
    $result = $wpdb->get_row( $sql );
    $count['showing'] = $result->showing;

    $num_pages = ceil( $count['showing'] / $limit );

    // GET query fields
    $query_search = array(
      'trash'                   => isset( $_GET['trash'] ) ? $_GET['trash'] : 0,
      'combo_group_filter'      => isset( $_REQUEST['combo_group_filter'] ) ? $_REQUEST['combo_group_filter'] : '',
      'combo_pagination_filter' => $limit
    );

    $arraytolink = array_merge( array(
                                     'edit'    => null,
                                     'pagenum' => '%#%'
                                ), $query_search );

    $page_links = paginate_links( array(
                                       'base'    => add_query_arg( $arraytolink ),
                                       'format'  => 'page=wp-bannerize-mainshow',
                                       'total'   => $num_pages,
                                       'current' => $pagenum
                                  ) );
    ?>

    <?php if ( $any_error != '' ) : ?>
      <div id="message" class="<?php echo $this->error ? 'error' : 'updated' ?> fade"><p><?php echo $any_error ?></p>
	</div>
    <?php endif; ?>

    <form name="form_show"
          class="wpBannerizeForm"
          method="post"
          action=""
          id="posts-filter"
          enctype="multipart/form-data">
		<input type="hidden" name="id" />
		<input type="hidden" name="action" value="" />
		<input type="hidden" name="command_action" value="" />
		<input type="hidden" name="page" value="wp-bannerize-mainshow" />
		<input type="hidden" name="status" value="<?php echo( isset( $_GET['trash'] ) ? $_GET['trash'] : "" ) ?>" />
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo kWPBannerizeMaxFileSize ?>" />

		<ul class="subsubsub">
			<?php
      $links = array();
      $status_links = array(
        "Publish" => "0",
        "Trash"   => "1"
      );
      foreach ( $status_links as $status => $value ) {
        if ( $count[$status] > 0 ) {
          $current = "";
          $addurl  = "";
          if ( ( isset( $_GET['trash'] ) && $_GET['trash'] == $value ) || ( !isset( $_GET['trash'] ) && $value == "0" )
          ) {
            $current = 'class="current"';
          }
          if ( $value != "" ) {
            $addurl = "&trash=" . $value;
          }
          $links[] = sprintf( "<li><a %s href=\"?page=wp-bannerize-mainshow%s\">%s <span class=\"count\">(%s)</span></a>", $current, $addurl, __( $status, 'wp-bannerize' ), $count[$status] );
        }
      }
      $output = implode( '| </li>', $links ) . '</li>';
      echo $output;
      ?>
		</ul>

      <?php if ( $count["showing"] > 0 ) : ?>

        <div class="tablenav">

			<div class="alignleft actions">
				<select name="groupAction">
					<option value="-1"><?php _e( 'Actions', 'wp-bannerize' ) ?></option>
          <?php if ( !isset( $_GET['trash'] ) || $_GET['trash'] == "0" ) : ?>
            <option value="trash-selected"><?php _e( 'Trash', 'wp-bannerize' ) ?></option>
          <?php elseif ( isset( $_GET['trash'] ) && $_GET['trash'] == "1" ) : ?>
            <option value="restore-selected"><?php _e( 'Restore', 'wp-bannerize' ) ?></option>
            <option value="delete-selected"><?php _e( 'Delete', 'wp-bannerize' ) ?></option>
          <?php endif; ?>
				</select>
				<input type="submit" class="button-secondary action" id="doaction" name="doaction"
               value="<?php _e( 'Apply', 'wp-bannerize' ) ?>" />

        <?php echo $this->combo_group_filter();
        $this->combo_pagination_filter() ?> <input type="submit"
                                                   class="button-secondary action"
                                                   value="<?php _e( 'Filter', 'wp-bannerize' ) ?>" />

			</div>

			<div class="tablenav-pages">
					<span class="displaying-num"><?php printf( __( "Showing %s-%s of %s", 'wp-bannerize' ), $pagenum, ( $count['showing'] >
            $limit ? $limit : $count['showing'] ), $count['showing'] ) ?></span>
        <?php echo $page_links ?>
			</div>
			<div class="clear"></div>
		</div>

        <div class="clear"></div>

        <table rel="<?php echo $pagenum . "," . $limit ?>" id="wp_bannerize_list" cellspacing="0" class="widefat">
			<thead>
			<tr>
				<th class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox" /></th>
				<th class="manage-column" scope="col"></th>
				<th class="manage-column column-image" scope="col"><?php _e( 'Image', 'wp-bannerize' ) ?></th>
				<th class="manage-column column-key" scope="col"><?php _e( 'Group', 'wp-bannerize' ) ?></th>
				<th class="manage-column column-description"
            scope="col"><?php _e( 'Description', 'wp-bannerize' ) ?></th>
				<th class="manage-column column-clickcount num" scope="col">
					<div class="clickcounter" title="<?php _e( 'Click Counter', 'wp-bannerize' ) ?>"></div>
				</th>
				<th class="manage-column column-clickcount num" scope="col">
					<div class="impressions" title="<?php _e( 'Impressions', 'wp-bannerize' ) ?>"></div>
				</th>
				<th class="manage-column column-clickcount num" scope="col">
					CTR
				</th>
			</tr>
			</thead>

			<tfoot>
			<tr>
				<th class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox" /></th>
				<th class="manage-column" scope="col"></th>
				<th class="manage-column column-image" scope="col"><?php _e( 'Image', 'wp-bannerize' ) ?></th>
				<th class="manage-column column-key" scope="col"><?php _e( 'Group', 'wp-bannerize' ) ?></th>
				<th class="manage-column column-description"
            scope="col"><?php _e( 'Description', 'wp-bannerize' ) ?></th>
				<th class="manage-column column-clickcount num" scope="col">
					<div class="clickcounter"></div>
				</th>
				<th class="manage-column column-clickcount num" scope="col">
					<div class="impressions"></div>
				</th>
				<th class="manage-column column-clickcount num" scope="col">
					CTR
				</th>
			</tr>
			</tfoot>

			<tbody>
				<?php
        $alt = 0;
        $sql = sprintf( "SELECT *, IF( (`start_date` < NOW() OR `start_date` = '0000-00-00 00:00:00') AND (`end_date` > NOW() OR `end_date` = '0000-00-00 00:00:00') AND (`maximpressions` = 0 OR `impressions` < `maximpressions`), 'enabled', 'disabled' ) AS status FROM %s WHERE %s ORDER BY `sorter`, `group` ASC LIMIT %s,%s", $this->table_bannerize, $where, ( ( $pagenum -
            1 ) * $limit ), $limit );
        $row = $wpdb->get_results( $sql );
        foreach ( $row as $item ) : ?>
          <tr <?php echo ( $alt++ % 2 ) ? 'class="alternate"' : "" ?> id="item_<?php echo $item->id ?>">
					<?php $this->rowWithItem( $item ) ?>
				</tr>
        <?php endforeach;
        ?>
			</tbody>
		</table>

        <div class="tablenav">

			<div class="alignleft actions">
				<select name="groupAction2">
					<option value="-1"><?php _e( 'Actions', 'wp-bannerize' ) ?></option>
          <?php if ( !isset( $_GET['trash'] ) || $_GET['trash'] == "0" ) : ?>
            <option value="trash-selected"><?php _e( 'Trash', 'wp-bannerize' ) ?></option>
          <?php elseif ( isset( $_GET['trash'] ) && $_GET['trash'] == "1" ) : ?>
            <option value="restore-selected"><?php _e( 'Restore', 'wp-bannerize' ) ?></option>
            <option value="delete-selected"><?php _e( 'Delete', 'wp-bannerize' ) ?></option>
          <?php endif; ?>
				</select>
				<input type="submit" class="button-secondary action" id="doaction2" name="doaction"
               value="<?php _e( 'Apply', 'wp-bannerize' ) ?>" />
			</div>

			<div class="tablenav-pages">
					<span class="displaying-num"><?php printf( __( "Showing %s-%s of %s", 'wp-bannerize' ), $pagenum, ( $count['showing'] >
            $limit ? $limit : $count['showing'] ), $count['showing'] ) ?></span>
        <?php echo $page_links ?>
			</div>
			<div class="clear"></div>
		</div>

      <?php else : ?>
        <div class="clear"></div>
        <p><?php _e( 'No Banner found!', 'wp-bannerize' ) ?></p>
      <?php endif; ?>
	</form>

	<form name="wp_bannerize_action" id="wp_bannerize_action" class="wpBannerizeForm" method="post" action="">
		<input type="hidden" name="command_action" value="" />
		<input type="hidden" name="id" />
	</form>

	</div>
  <?php
  }

  /**
   * Retrive a single item row for a specify ID
   *
   * @param $id
   *   Banner ID
   *
   * @return html
   *   HTML for a row
   */
  function rowItemWithID( $id )
  {
    global $wpdb;
    $sql = sprintf( "SELECT *, IF( (`start_date` < NOW() OR `start_date` = '0000-00-00 00:00:00') AND (`end_date` > NOW() OR `end_date` = '0000-00-00 00:00:00') AND (`maximpressions` = 0 OR `impressions` < `maximpressions`), 'enabled', 'disabled' ) AS status FROM `%s` WHERE id = %s", $this->table_bannerize, $id );
    $row = $wpdb->get_row( $sql );
    $this->rowWithItem( $row );
  }


  /**
   * Compute HTML for a row
   *
   * @param $item
   *   Result set of a query
   *
   * @return void
   */
  function rowWithItem( $item )
  {
    $thickbox = '';
    ?>
    <th class="check-column" scope="row">
      <input type="checkbox" value="<?php echo $item->id ?>" name="image_record[]" /></th>
    <th scope="row">
		<div class="arrow"></div>
	</th>
    <td class="wp-bannerize-thumbnail">
		<?php if ( $item->banner_type == kWPBannerizeBannerTypeFromLocal || $item->banner_type == kWPBannerizeBannerTypeByURL ) : ?>

      <?php if ( $item->mime == "application/x-shockwave-flash" ) : ?>
        <?php $thickbox = '?TB_iframe' ?>
        <a class="thickbox wp_bannerize_flash" rel="wp-bannerize-gallery-thumbnail"
           title="<?php echo $item->description ?>" href="<?php echo $item->filename ?><?php echo $thickbox ?>"></a>
      <?php else : ?>

        <a class="thickbox" rel="wp-bannerize-gallery-thumbnail"
           href="<?php echo $item->filename ?>" title="<?php echo $item->description ?>"><img
           alt="<?php echo $item->description ?>" border="0"
           src="<?php echo $item->filename ?>" />
        </a>

      <?php endif; ?>

    <?php else : ?>
      <img alt="<?php echo $item->description ?>" border="0"
           src="<?php echo $this->url . '/css/images/shellscript.png' ?>" />
    <?php endif; ?>
	</td>
    <td nowrap="nowrap"><?php echo $item->group ?></td>
    <td width="100%">
		<div class="wpBannerizeSwitch <?php echo ( $item->enabled == '1' ) ? 'on' : '' ?>"
         id="wpBannerizeSwitch_<?php echo $item->id ?>">
			<div></div>
		</div>
      <?php if ( $item->start_date != '0000-00-00 00:00:00' || $item->end_date != '0000-00-00 00:00:00' ) : ?>
        <p>
			<span class="start_date <?php echo $item->status ?>"><?php echo ( $this->mysql_date( $item->start_date ) ==
          '0000-00-00 00:00:00' ) ? __( 'Always', 'wp-bannerize' ) : $this->mysql_date( $item->start_date ) ?></span>
			<span class="end_date <?php echo $item->status ?>"><?php echo ( $this->mysql_date( $item->end_date ) ==
          '0000-00-00 00:00:00' ) ? __( 'Always', 'wp-bannerize' ) : $this->mysql_date( $item->end_date ) ?></span>
		</p>
      <?php endif; ?>

      <?php if ( $item->url != '' ) : ?>
        <p class="clear">
			<span class="wpBannerizeURL"><a title="<?php echo $item->url ?>"
                                      target="_blank"
                                      href="<?php echo $item->url ?>"><?php echo $this->stringCut( $item->url ) ?></a></span>
		</p>
      <?php endif; ?>

      <?php if ( $item->description != '' ) : ?>
        <div class="wpBannerizeDescription"><?php echo $item->description ?></div>
      <?php endif; ?>

      <div class="row-actions">
			<?php if ( $item->trash == "0" ) : ?>
        <span class="edit">

          <a href="#"
             class="edit_<?php echo $item->id ?>"
             title="<?php _e( 'Edit', 'wp-bannerize' ) ?>"
             onclick="WPBannerizeJavascript.displayEdit(<?php echo $item->id ?>)"><?php _e( 'Edit', 'wp-bannerize' ) ?>
          </a> | </span>

        <span class="trash">
          <a class="<?php echo $item->id ?>"
             title="<?php _e( 'Trash', 'wp-bannerize' ) ?>"
             href="#"><?php _e( 'Trash', 'wp-bannerize' ) ?>
          </a> | </span>

        <span class="view">
          <a class="thickbox submitview"
             rel="wp-bannerize-gallery"
             title="<?php echo $item->description ?>"
             href="<?php echo $item->filename ?><?php echo $thickbox ?>">
            <?php _e( 'View', 'wp-bannerize' ) ?>
          </a>
        </span>

      <?php else : ?>
        <span class="delete"><a class="<?php echo $item->id ?>"
                                title="<?php _e( 'Delete', 'wp-bannerize' ) ?>"
                                href="#"><?php _e( 'Delete', 'wp-bannerize' ) ?></a> | </span>
        <span class="restore"><a class="<?php echo $item->id ?>"
                                 title="<?php _e( 'Restore', 'wp-bannerize' ) ?>"
                                 href="#"><?php _e( 'Restore', 'wp-bannerize' ) ?></a></span>
      <?php endif; ?>
		</div>
		<div id="edit_<?php echo $item->id ?>"></div>
	</td>
    <td class="comments column-comments">
		<div class="post-com-count-wrapper">
			<div class="post-com-count">
				<span><?php echo $item->clickcount ?></span>
			</div>
		</div>
	</td>
    <td class="comments column-comments">
		<div class="post-com-count-wrapper">
			<div class="post-com-count">
				<span><?php echo $item->impressions ?></span>
			</div>
		</div>
	</td>
    <td class="comments column-comments">
		<div class="post-com-count-wrapper">
			<div class="post-com-count">
				<span>
					<?php
          if ( $item->impressions > 0 ) {
            echo intval( ( $item->clickcount / $item->impressions ) * 100 ) . '%';
          }
          else {
            echo '0%';
          }
          ?></span>
			</div>
		</div>
	</td>
  <?php
  }

  /**
   * Show hide form for inline edit in banner list
   *
   * @param  $id
   *   ID row
   *
   * @return void
   */
  function inlineEdit( $id )
  {

    global $wpdb;

    $sql = sprintf( 'SELECT * FROM `%s` WHERE `id` = %s', $this->table_bannerize, $id );
    $row = $wpdb->get_row( $sql );

    ob_start(); ?>
    <div class="inline-edit" style="display:none">

    <label for="filename"><?php _e( 'Banner', 'wp-bannerize' ) ?>:</label>
		<fieldset>
			<legend>
				<input type="radio" name="wpBannerizeBannerType" value="1" <?php checked( $row->banner_type, 1 ) ?>
               checked="checked" /> <?php _e( 'From local', 'wp-bannerize' ) ?>
        <input type="radio" name="wpBannerizeBannerType" <?php checked( $row->banner_type, 2 ) ?>
               value="2" /> <?php _e( 'By URL o Media Library', 'wp-bannerize' ) ?>
        <input type="radio" name="wpBannerizeBannerType"
               value="3" <?php checked( $row->banner_type, 3 ) ?> /> <?php _e( 'Free HTML', 'wp-bannerize' ) ?>
			</legend>
			<div <?php hidden( $row->banner_type, 1 ) ?> class="wpBannerizeBannerType1"><input type="file"
                                                                                         name="filename"
                                                                                         id="filename" /></div>
			<div <?php hidden( $row->banner_type, 2 ) ?> class="wpBannerizeBannerType2">
				<input value="<?php echo $row->filename ?>"
               size="32" type="text" name="filenameFromURL"
               id="filenameFromURL" value="http://" />
				<input id="wpBannerizeButtonFromMediaLibrary" type="button" class="button-secondary"
               value="<?php _e( 'Media Library Image', 'wp-bannerize' ) ?>" /></div>
			<div <?php hidden( $row->banner_type, 3 ) ?> class="wpBannerizeBannerType3"><textarea name="freeHTML"
                                                                                            id="freeHTML"
                                                                                            rows="2"
                                                                                            cols="50"><?php echo stripslashes( $row->free_html ) ?></textarea>
			</div>
		</fieldset>
		<br style="clear:both" />

		<p>
			<label for="start_date"><?php _e( 'Start Date', 'wp-bannerize' ) ?>:</label> <input class="date"
                                                                                          type="text"
                                                                                          name="start_date"
                                                                                          id="start_date"
                                                                                          size="18"
                                                                                          value="<?php echo( ( $row->start_date ==
                                                                                            "" || $row->start_date ==
                                                                                            "0000-00-00 00:00:00" ) ? '' : $this->mysql_date( $row->start_date ) ) ?>" />
			<span class="eraser" onclick="jQuery('input#start_date').val('')"></span>
			<label for="end_date"
             style="float:none;display:inline;margin-left:16px"><?php _e( 'End Date', 'wp-bannerize' ) ?>:</label>
			<input class="date" type="text" name="end_date" id="end_date" size="18"
             value="<?php echo( ( $row->end_date == "" ||
               $row->end_date == "0000-00-00 00:00:00" ) ? '' : $this->mysql_date( $row->end_date ) ) ?>" />
			<span class="eraser" onclick="jQuery('input#end_date').val('')"></span>
			<strong style="color:#888"><?php _e( 'Server Date/time', 'wp-bannerize' ); ?>
        : <?php echo date_i18n( $this->getPHPDateFormat() ) ?></strong>
		</p>

		<p>
			<label><?php _e( 'Group', 'wp-bannerize' ) ?>:</label> <input size="8" type="text" id="group" name="group"
                                                                    value="<?php echo $row->group ?>" /> <?php echo $this->get_combo_group() ?>
		</p>

		<p>
			<label><?php _e( 'Description', 'wp-bannerize' ) ?>:</label> <input size="32" type="text" name="description"
                                                                          value="<?php echo $row->description ?>" />
			<input <?php echo( ( $row->use_description == '1' ) ? 'checked="checked"' : '' ) ?> type="checkbox"
                                                                                          name="use_description"
                                                                                          value="1" /> <?php _e( 'Use this description in output', 'wp-bannerize' ) ?>
		</p>

		<p>
			<label><?php _e( 'URL', 'wp-bannerize' ) ?>:</label> <input type="text" name="url" size="32"
                                                                  value="<?php echo $row->url ?>" />
			<label style="float:none;display:inline;margin-left:16px"><?php _e( 'Target', 'wp-bannerize' ) ?>
        :</label> <?php echo $this->get_target_combo( $row->target ) ?>
		</p>

		<p>
			<label for="clickcount" style="float:none;display:inline"><?php _e( 'Click Counter', 'wp-bannerize' ) ?>
        :</label>
			<input size="4" class="number" type="text" name="clickcount" id="clickcount"
             value="<?php echo $row->clickcount ?>" />
			<label for="impressions"
             style="float:none;display:inline;margin-left:16px"><?php _e( 'Impressions', 'wp-bannerize' ) ?>
        :</label>
			<input class="number"
             type="text"
             name="impressions"
             id="iImpressions"
             value="<?php echo $row->impressions ?>"
             size="8" />
			<label for="maxImpressions"
             style="float:none;display:inline;margin-left:16px"><?php _e( 'Max Impressions', 'wp-bannerize' ) ?>
        :</label>
			<input class="number"
             type="text"
             name="maxImpressions"
             id="maxImpressions"
             value="<?php echo $row->maximpressions ?>"
             size="4" />
		</p>

		<p>
			<label for="nofollow"
             style="float:none;display:inline"><?php _e( 'Add nofollow attribute', 'wp-bannerize' ) ?></label>
			<input <?php echo( ( $row->nofollow == '1' ) ? 'checked="checked"' : '' ) ?> type="checkbox"
                                                                                   name="nofollow"
                                                                                   id="nofollow"
                                                                                   value="1" />
			<label for="width" style="float:none;display:inline;margin-left:16px"><?php _e( 'Width', 'wp-bannerize' ) ?>
        :</label>
			<input size="4" type="text" name="width" id="width" value="<?php echo $row->width ?>" />
			<label for="height"
             style="float:none;display:inline;margin-left:16px"><?php _e( 'Height', 'wp-bannerize' ) ?>:</label>
			<input size="4" type="text" name="height" id="height" value="<?php echo $row->height ?>" />
		</p>

		<p class="submit inline-edit-save">
			<a onclick="WPBannerizeJavascript.hideInlineEdit(<?php echo $row->id ?>)"
         class="button-secondary cancel alignleft" title="<?php _e( 'Cancel', 'wp-bannerize' ) ?>" href="#"
         accesskey="c"><?php _e( 'Cancel', 'wp-bannerize' ) ?></a>
			<a onclick="WPBannerizeJavascript.update(<?php echo $row->id ?>)" class="button-primary save alignright"
         title="<?php _e( 'Update', 'wp-bannerize' ) ?>" href="#"
         accesskey="s"><?php _e( 'Update', 'wp-bannerize' ) ?></a><span style="display:none"
                                                                        class="wpBannerizeAjaxLoader"></span>
		</p>
    </div><?php
    $result = ob_get_contents();
    ob_end_clean();
    return $result;
  }

  /**
   * Build the select/option filter group
   *
   * @return void
   */
  function combo_group_filter()
  {
    global $wpdb;
    $o    =
      '<select name="combo_group_filter">' . '<option value="">' . __( 'All groups', 'wp-bannerize' ) . '</option>';
    $q    = "SELECT `group` FROM `" . $this->table_bannerize . "` GROUP BY `group` ORDER BY `group` ";
    $rows = $wpdb->get_results( $q );
    foreach ( $rows as $row ) {
      if ( isset( $_REQUEST['combo_group_filter'] ) && $_REQUEST['combo_group_filter'] == $row->group ) {
        $sel = 'selected="selected"';
      }
      else {
        $sel = "";
      }
      $o .= '<option ' . $sel . 'value="' . $row->group . '">' . $row->group . '</option>';
    }
    $o .= '</select>';
    echo $o;
  }

  function groupMenu( $name = "wpBannerizeGroupMenu", $selected = "", $firstItem = "" )
  {
    global $wpdb;
    ob_start();
    ?>
    <select name="<?php echo $name ?>" id="<?php echo $name ?>">
		<?php
    $sql = sprintf( "SELECT `group` FROM `%s` GROUP BY `group` ORDER BY `group` ", $this->table_bannerize );
    $rows = $wpdb->get_results( $sql );
    if ( $firstItem != '' ) : ?>
      <option value=""><?php echo $firstItem ?></option>
    <?php endif;
    foreach ( $rows as $row ) : ?>
      <option <?php selected( $row->group, $selected ) ?> value="<?php echo $row->group ?>"><?php echo $row->group ?></option>
    <?php endforeach;
    ?>
	</select>
    <?php
    $result = ob_get_contents();
    ob_end_clean();
    return $result;
  }

  function combo_pagination_filter()
  {
    $pagination = isset( $_REQUEST['combo_pagination_filter'] ) ? $_REQUEST['combo_pagination_filter'] : '';
    ?>
    <select name="combo_pagination_filter">
		<option <?php selected( $pagination, 10 ) ?> value="10">10</option>
		<option <?php selected( $pagination, 20 ) ?> value="20">20</option>
		<option <?php selected( $pagination, 30 ) ?> value="30">30</option>
	</select>
  <?php

  }

  /**
   * Show Adobe Flash Window mode combo for settings
   *
   * @param null $param
   */
  function comboWindowModeFlash( $param = null )
  {
    if ( is_null( $param ) ) {
      $param = $_REQUEST['comboWindowModeFlash'];
    }
    ?>
    <select id="comboWindowModeFlash" name="comboWindowModeFlash">
		<option <?php echo ( $param == "Window" ) ? 'selected="selected"' : "" ?> value="Window">Window</option>
		<option <?php echo ( $param == "Opaque" ) ? 'selected="selected"' : "" ?> value="Opaque">Opaque</option>
		<option <?php echo ( $param == "Transparent" ) ? 'selected="selected"' : "" ?> value="Transparent">Transparent
		</option>
		<option <?php echo ( $param == "Direct" ) ? 'selected="selected"' : "" ?> value="Direct">Direct</option>
		<option <?php echo ( $param == "GPU" ) ? 'selected="selected"' : "" ?> value="GPU">GPU</option>
	</select>
  <?php

  }

  /**
   * Build combo group
   *
   * @return string
   */
  function get_combo_group()
  {
    global $wpdb;
    $o    = '<select id="group_filter">' . '<option value=""></option>';
    $q    = "SELECT `group` FROM `" . $this->table_bannerize . "` GROUP BY `group` ORDER BY `group` ";
    $rows = $wpdb->get_results( $q );
    foreach ( $rows as $row ) {
      $o .= '<option value="' . $row->group . '">' . $row->group . '</option>';
    }
    $o .= '</select>';
    return $o;
  }

  /**
   * Get Select Checked Categories
   *
   * @param null $cats
   *
   * @return string
   */
  function get_categories_checkboxes( $cats = null )
  {
    if ( !is_null( $cats ) ) {
      $cat_array = explode( ",", $cats );
    }
    $res = get_categories();
    $o   = "";
    foreach ( $res as $cat ) {
      $checked = "";
      if ( !is_null( $cats ) ) {
        if ( in_array( $cat->cat_ID, $cat_array ) ) {
          $checked = 'checked="checked"';
        }
      }
      $o .=
        '<label><input ' . $checked . ' type="checkbox" name="categories[]" id="categories[]" value="' . $cat->cat_ID .
        '" /> ' . $cat->cat_name . '</label> ';
    }
    return $o;
  }

  /**
   * Build combo menu for target
   *
   * @param string $sel
   *
   * @return string
   */
  function get_target_combo( $sel = "_blank" )
  {
    $o = '<select name="target" id="target">' . '<option></option>' . '<option ' .
      ( ( $sel == '_blank' ) ? 'selected="selected"' : '' ) . '>_blank</option>' . '<option ' .
      ( ( $sel == '_parent' ) ? 'selected="selected"' : '' ) . '>_parent</option>' . '<option ' .
      ( ( $sel == '_self' ) ? 'selected="selected"' : '' ) . '>_self</option>' . '<option ' .
      ( ( $sel == '_top' ) ? 'selected="selected"' : '' ) . '>_top</option>' . '</select>';
    return $o;
  }

  /**
   * Insert banner into the database table
   *
   * @return bool|string|void
   */
  function insertBanner()
  {
    $wpBannerizeBannerType = intval( $_POST['wpBannerizeBannerType'] );
    switch ( $wpBannerizeBannerType ) {
      case 1:
        return $this->addBannerFromLocal();
        break;
      case 2:
        return $this->addBannerFromURL();
        break;
      case 3:
        return $this->addBannerWithFreeHTML();
        break;
      default:
        break;
    }
    return false;
  }

  function addBannerWithFreeHTML()
  {
    global $wpdb;

    $group           = $_POST['group'];
    $description     = $_POST['description'];
    $use_description = isset( $_POST['use_description'] ) ? $_POST['use_description'] : 0;
    $url             = $_POST['url'];
    $target          = $_POST['target'];
    $nofollow        = isset( $_POST['nofollow'] ) ? $_POST['nofollow'] : 0;

    $start_date = $this->mysql_date( $_POST['start_date'] );
    $end_date   = $this->mysql_date( $_POST['end_date'] );

    $wpdb->show_errors();
    $rows = $wpdb->insert( $this->table_bannerize, array(
                                                        'banner_type'     => $_POST['wpBannerizeBannerType'],
                                                        'group'           => $group,
                                                        'description'     => $description,
                                                        'use_description' => $use_description,
                                                        'url'             => $url,
                                                        'target'          => $target,
                                                        'nofollow'        => $nofollow,
                                                        'start_date'      => $start_date,
                                                        'end_date'        => $end_date,
                                                        'maximpressions'  => $_POST['maxImpressions'],
                                                        'free_html'       => $_POST['freeHTML']

                                                   ) );
    if ( $rows !== false ) {
      $this->error = false;
      return __( 'Banner added succesfully!', 'wp-bannerize' );
    }
    else {
      $this->error = true;
      return __( 'Error on insert Free HTML banner type', 'wp-bannerize' );
    }
  }

  function addBannerFromURL()
  {
    global $wpdb;

    $dimensions = array(
      $_POST['width'],
      $_POST['height']
    );
    $mime       = "";

    if ( function_exists( 'getimagesize' ) ) {
      $dimensions = @getimagesize( $_POST['filenameFromURL'] );
      if ( !isset( $dimensions ) ) {
        $dimensions = array(
          '0',
          '0'
        );
      }
      else {
        $mime = $dimensions['mime'];
      }
    }

    $group           = $_POST['group'];
    $description     = $_POST['description'];
    $use_description = isset( $_POST['use_description'] ) ? $_POST['use_description'] : 0;
    $url             = $_POST['url'];
    $target          = $_POST['target'];
    $nofollow        = isset( $_POST['nofollow'] ) ? $_POST['nofollow'] : 0;

    $start_date = $this->mysql_date( $_POST['start_date'] );
    $end_date   = $this->mysql_date( $_POST['end_date'] );

    $wpdb->show_errors();
    $rows = $wpdb->insert( $this->table_bannerize, array(
                                                        'banner_type'     => $_POST['wpBannerizeBannerType'],
                                                        'group'           => $group,
                                                        'description'     => $description,
                                                        'use_description' => $use_description,
                                                        'url'             => $url,
                                                        'filename'        => $_POST['filenameFromURL'],
                                                        'target'          => $target,
                                                        'nofollow'        => $nofollow,
                                                        'start_date'      => $start_date,
                                                        'end_date'        => $end_date,
                                                        'maximpressions'  => $_POST['maxImpressions'],
                                                        'mime'            => $mime,
                                                        'width'           => $dimensions[0],
                                                        'height'          => $dimensions[1],
                                                        'free_html'       => ''

                                                   ) );
    if ( $rows !== false ) {
      $this->error = false;
      return __( 'Banner added succesfully!', 'wp-bannerize' );
    }
    else {
      $this->error = false;
      return __( 'Error on insert URL banner type', 'wp-bannerize' );
    }
  }

  function addBannerFromLocal()
  {
    global $wpdb;

    // check post error
    if ( is_uploaded_file( $_FILES['filename']['tmp_name'] ) ) {
      //$size = floor($_FILES['filename']['size'] / (1024 * 1024));
      $mime = $_FILES['filename']['type'];
      $name = $_FILES['filename']['name'];
      $temp = $_FILES['filename']['tmp_name'];

      $group           = $_POST['group'];
      $description     = $_POST['description'];
      $use_description = isset( $_POST['use_description'] ) ? $_POST['use_description'] : 0;
      $url             = $_POST['url'];
      $target          = $_POST['target'];
      $nofollow        = isset( $_POST['nofollow'] ) ? $_POST['nofollow'] : 0;
      $dimensions      = array(
        '0',
        '0'
      );

      $start_date = $this->mysql_date( $_POST['start_date'] );
      $end_date   = $this->mysql_date( $_POST['end_date'] );

      $uploads = wp_upload_bits( strtolower( $name ), null, '' );

      if ( move_uploaded_file( $temp, $uploads['file'] ) ) {
        if ( function_exists( 'getimagesize' ) ) {
          $dimensions = @getimagesize( $uploads['file'] );
          if ( !isset( $dimensions ) ) {
            $dimensions = array(
              '0',
              '0'
            );
          }
        }

        $wpdb->show_errors();
        $rows = $wpdb->insert( $this->table_bannerize, array(
                                                            'banner_type'     => $_POST['wpBannerizeBannerType'],
                                                            'group'           => $group,
                                                            'description'     => $description,
                                                            'use_description' => $use_description,
                                                            'url'             => $url,
                                                            'filename'        => $uploads['url'],
                                                            'target'          => $target,
                                                            'nofollow'        => $nofollow,
                                                            'mime'            => $mime,
                                                            'realpath'        => $uploads['file'],
                                                            'width'           => $dimensions[0],
                                                            'height'          => $dimensions[1],
                                                            'start_date'      => $start_date,
                                                            'end_date'        => $end_date,
                                                            'maximpressions'  => $_POST['maxImpressions'],
                                                            'free_html'       => ''

                                                       ) );
        if ( $rows !== false ) {
          $this->error = false;
          return __( 'Banner added succesfully!', 'wp-bannerize' );
        }
        else {
          $this->error = true;
          return __( 'Error on insert local banner type', 'wp-bannerize' );
        }
      }
      else {
        $this->error = true;
        $error       = sprintf( __( 'Error while copying [%s] [%s bytes] - [%s]', 'wp-bannerize' ), $_FILES['filename']['name'], $_FILES['filename']['size'], $_FILES['filename']['error'] );
        return $error;
      }
    }
    else {
      $this->error = true;
      $error       = sprintf( __( 'No file to upload! - [%s]', 'wp-bannerize' ), $_FILES['filename']['error'] );
      return $error;
    }
  }

  /**
   * Set one or more banner in trash mode: trash = "1"
   *
   * @param  $id    string|array
   *
   * @return string|void
   */
  function setBannerToTrash( $id = null )
  {
    global $wpdb;
    $id  = ( is_null( $id ) ) ? $_POST['id'] : $id;
    $sql = sprintf( "UPDATE `%s` SET trash = '1' WHERE id IN(%s)", $this->table_bannerize, $id );
    $wpdb->query( $sql );
    $this->error = false;
    return __( 'Banner sent to trash succesfully!', 'wp-bannerize' );
  }

  /**
   * Set one or more banner in publish mode: trash = "0"
   *
   * @param  $id    string|array
   *
   * @return void
   */
  function unsetBannerToTrash( $id = null )
  {
    global $wpdb;
    $id  = ( is_null( $id ) ) ? $_POST['id'] : $id;
    $sql = sprintf( "UPDATE `%s` SET trash = '0' WHERE id IN(%s)", $this->table_bannerize, $id );
    $wpdb->query( $sql );
    $this->error = false;
    return __( 'Banner restore from trash succesfully!', 'wp-bannerize' );
  }

  /**
   * Delete (permanently) a banner from Database and filesystem. Because a banner is delete from disk, this method
   * is call from loop for delete more banner
   *
   * @param null $id
   *
   * @return string|void
   */
  function deleteBanner( $id = null )
  {
    global $wpdb;

    $id = ( is_null( $id ) ) ? $_POST['id'] : $id;

    // Delete from disk only local banner.
    $wpBannerizeBannerType = $wpdb->get_var( "SELECT `banner_type` FROM `" . $this->table_bannerize .
    "` WHERE `id` = " . $id );

    if ( $wpBannerizeBannerType == '1' ) {
      $filename = $wpdb->get_var( "SELECT `realpath` FROM `" . $this->table_bannerize . "` WHERE `id` = " . $id );
      @unlink( $filename );
    }

    $q = "DELETE FROM `" . $this->table_bannerize . "` WHERE `id` = " . $id;
    $wpdb->query( $q );

    $this->error = false;
    return __( 'Banner delete succesfully!', 'wp-bannerize' );
  }

  /**
   * Update a banner data and image
   *
   * @return bool|string|void Information message
   */
  function updateBanner()
  {
    $wpBannerizeBannerType = intval( $_POST['wpBannerizeBannerType'] );
    switch ( $wpBannerizeBannerType ) {
      case 1:
        return $this->updateBannerFromLocal();
        break;
      case 2:
        return $this->updateBannerFromURL();
        break;
      case 3:
        return $this->updateBannerWithFreeHTML();
        break;
      default:
        break;
    }
    return false;
  }

  function updateBannerWithFreeHTML()
  {
    global $wpdb;

    $dimensions = array(
      $_POST['width'],
      $_POST['height']
    );
    $mime       = "";

    $values = array(
      'banner_type'     => $_POST['wpBannerizeBannerType'],
      'group'           => $_POST['group'],
      'start_date'      => $this->mysql_date( $_POST['start_date'] ),
      'end_date'        => $this->mysql_date( $_POST['end_date'] ),
      'maximpressions'  => $_POST['maxImpressions'],
      'impressions'     => $_POST['impressions'],
      'description'     => $_POST['description'],
      'url'             => $_POST['url'],
      'target'          => $_POST['target'],
      'use_description' => isset( $_POST['use_description'] ) ? $_POST['use_description'] : 0,
      'nofollow'        => $_POST['nofollow'],
      'clickcount'      => $_POST['clickcount'],
      'width'           => $dimensions[0],
      'height'          => $dimensions[1],
      'filename'        => $_POST['filenameFromURL'],
      'mime'            => $mime,
      'free_html'       => $_POST['freeHTML']
    );
    $where  = array( 'id' => $_POST['id'] );
    $wpdb->show_errors();
    $result = $wpdb->update( $this->table_bannerize, $values, $where );
    if ( $result !== false ) {
      $this->error = false;
      return __( 'Banner update succesfully!', 'wp-bannerize' );
    }
    else {
      $this->error = true;
      return __( 'Error while update free HTML Banner!', 'wp-bannerize' );
    }
  }

  function updateBannerFromLocal()
  {
    global $wpdb;

    // Retrive image info
    $sql = sprintf( "SELECT * FROM `%s` WHERE id = %s", $this->table_bannerize, $_POST['id'] );
    $row = $wpdb->get_row( $sql );

    $filename   = $row->filename;
    $mime       = $row->mime;
    $realpath   = $row->realpath;
    $dimensions = array(
      $_POST['width'],
      $_POST['height']
    );

    if ( isset( $_FILES['filename'] ) && is_uploaded_file( $_FILES['filename']['tmp_name'] ) ) {
      //$size = floor($_FILES['filename']['size'] / (1024 * 1024));
      $mime = $_FILES['filename']['type'];
      $name = $_FILES['filename']['name'];
      $temp = $_FILES['filename']['tmp_name'];

      $dimensions = array(
        '0',
        '0'
      );

      $uploads = wp_upload_bits( strtolower( $name ), null, '' );

      if ( move_uploaded_file( $temp, $uploads['file'] ) ) {
        if ( function_exists( 'getimagesize' ) ) {
          $dimensions = @getimagesize( $uploads['file'] );
          if ( !isset( $dimensions ) ) {
            $dimensions = array(
              '0',
              '0'
            );
          }
        }
        // Delete old image
        @unlink( $realpath );

        $filename = $uploads['url'];
        $realpath = $uploads['file'];
      }
    }
    $values = array(
      'banner_type'     => $_POST['wpBannerizeBannerType'],
      'group'           => $_POST['group'],
      'start_date'      => $this->mysql_date( $_POST['start_date'] ),
      'end_date'        => $this->mysql_date( $_POST['end_date'] ),
      'maximpressions'  => $_POST['maxImpressions'],
      'impressions'     => $_POST['impressions'],
      'description'     => $_POST['description'],
      'url'             => $_POST['url'],
      'target'          => $_POST['target'],
      'use_description' => isset( $_POST['use_description'] ) ? $_POST['use_description'] : 0,
      'nofollow'        => $_POST['nofollow'],
      'clickcount'      => $_POST['clickcount'],
      'width'           => $dimensions[0],
      'height'          => $dimensions[1],
      'filename'        => $filename,
      'realpath'        => $realpath,
      'mime'            => $mime
    );
    $where  = array( 'id' => $_POST['id'] );
    $wpdb->show_errors();
    $result = $wpdb->update( $this->table_bannerize, $values, $where );
    if ( $result !== false ) {
      $this->error = false;
      return __( 'Banner update succesfully!', 'wp-bannerize' );
    }
    else {
      $this->error = true;
      return __( 'Error while update local Banner!', 'wp-bannerize' );
    }
  }

  function updateBannerFromURL()
  {
    global $wpdb;

    $dimensions = array(
      $_POST['width'],
      $_POST['height']
    );
    $mime       = "";

    if ( function_exists( 'getimagesize' ) ) {
      $dimensions = @getimagesize( $_POST['filenameFromURL'] );
      if ( !isset( $dimensions ) ) {
        $dimensions = array(
          '0',
          '0'
        );
      }
      else {
        $mime = $dimensions['mime'];
      }
      if ( !( $_POST['width'] == '0' || $_POST['height'] == '0' || $_POST['width'] == '' || $_POST['height'] == '' )
      ) {
        $dimensions[0] = $_POST['width'];
        $dimensions[1] = $_POST['height'];
      }
    }

    $values = array(
      'banner_type'     => $_POST['wpBannerizeBannerType'],
      'group'           => $_POST['group'],
      'start_date'      => $this->mysql_date( $_POST['start_date'] ),
      'end_date'        => $this->mysql_date( $_POST['end_date'] ),
      'maximpressions'  => $_POST['maxImpressions'],
      'impressions'     => $_POST['impressions'],
      'description'     => $_POST['description'],
      'url'             => $_POST['url'],
      'target'          => $_POST['target'],
      'use_description' => isset( $_POST['use_description'] ) ? $_POST['use_description'] : 0,
      'nofollow'        => $_POST['nofollow'],
      'clickcount'      => $_POST['clickcount'],
      'width'           => $dimensions[0],
      'height'          => $dimensions[1],
      'filename'        => $_POST['filenameFromURL'],
      'mime'            => $mime
    );
    $where  = array( 'id' => $_POST['id'] );
    $wpdb->show_errors();
    $result = $wpdb->update( $this->table_bannerize, $values, $where );
    if ( $result !== false ) {
      $this->error = false;
      return __( 'Banner update succesfully!', 'wp-bannerize' );
    }
    else {
      $this->error = true;
      return __( 'Error while update local Banner!', 'wp-bannerize' );
    }
  }

  /**
   * Attach settings in Wordpress Plugins list
   *
   * @param $pluginfile
   */
  function register_plugin_settings( $pluginfile )
  {
    $this->plugin_file = $pluginfile;
    add_action( 'plugin_action_links_' . basename( dirname( $pluginfile ) ) . '/' . basename( $pluginfile ), array(
                                                                                                                  &$this,
                                                                                                                  'plugin_settings'
                                                                                                             ), 10, 4 );
    add_filter( 'plugin_row_meta', array(
                                        &$this,
                                        'add_plugin_links'
                                   ), 10, 2 );
  }

  /**
   * Add link to Plugin list page
   *
   * @param  $links
   *
   * @return string
   */
  function plugin_settings( $links )
  {
    $settings_link = '<a href="admin.php?page=wp-bannerize-mainshow">' . __( 'Settings' ) . '</a>';
    array_unshift( $links, $settings_link );
    return $links;
  }

  /**
   * Add links on installed plugin list
   *
   * @param $links
   * @param $file
   *
   * @return array
   */
  function add_plugin_links( $links, $file )
  {
    if ( $file == plugin_basename( $this->plugin_file ) ) {
      $links[] = '<strong style="color:#fa0">' .
        __( 'For more info visit', 'wp-bannerize' ) . ' <a href="https://wpxtre.me/product/bannerize">wpXtreme</a></strong>';
    }
    return $links;
  }

  /**
   * Call on Plugin Activation
   *
   * @since 2.5.0
   *
   * @return void
   */
  function pluginDidActive()
  {
    // Table doesn't exists: create it
    $this->createTable();

    // Rename tabel if needed
    $this->renameTable();
  }

  function pluginDidDeactive()
  {
  }


  /**
   * Check if previous database table name exists.
   *
   * @return void
   */
  function previousDatabaseTableNameExists()
  {
    global $wpdb;
    $sql = sprintf( "SHOW TABLES LIKE '%s'", $this->prev_table_bannerize );
    if ( $wpdb->get_var( $sql ) != $this->prev_table_bannerize ) {
      // table does not exist!
      return false;
    }
    return true;
  }

  /**
   * Create the WP Bannerize table. This method use Wordpress dbDelta() function for check if table exists and update
   * table if needed.
   *
   * @since 2.1.0
   *
   * @return void
   */
  function createTable()
  {
    if ( !function_exists( 'dbDelta' ) ) {
      require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    }
    ob_start();
    require_once( 'wpBannerizeTable.sql' );
    $sql = sprintf( ob_get_contents(), ( $this->previousDatabaseTableNameExists() ) ? $this->prev_table_bannerize : $this->table_bannerize );
    @dbDelta( $sql );
    ob_end_clean();
  }

  /**
   * Rename previous databsse table name if needed
   *
   * @return void
   */
  function renameTable()
  {
    global $wpdb;
    if ( $this->previousDatabaseTableNameExists() ) {
      $sql = sprintf( "RENAME TABLE `%s` TO `%s`", $this->prev_table_bannerize, $this->table_bannerize );
      $wpdb->query( $sql );
    }
  }

  /**
   * Truncate WP bannerize Database Table
   *
   * @return void
   */
  function truncateTable()
  {
    global $wpdb;
    $sql = sprintf( "TRUNCATE TABLE `%s`", $this->table_bannerize );
    $wpdb->query( $sql );
  }

  /**
   * Get WP Bannerize table information. Display number of row and table size.
   *
   * @param bool $echo
   *   True (default) display output, else return an Object with table status information
   *
   * @return Object with table status information if $echo param is true
   */
  function tableInformation( $echo = true )
  {
    global $wpdb;
    $sql    = sprintf( "SHOW TABLE STATUS LIKE '%s'", $this->table_bannerize );
    $result = $wpdb->get_row( $sql );
    $data   = intval( $result->Data_length );
    $index  = intval( $result->Index_length );
    $size   = round( ( $data + $index ) / 1024, 3 );
    $gain   = round( floatval( $result->Data_free ) / 1024, 2 );

    if ( $echo ) :  ?>
      <p><strong><?php _e( 'Numer of rows', 'wp-bannerize' ) ?>:</strong> <?php echo $result->Rows ?></p>
      <p><strong><?php _e( 'Size', 'wp-bannerize' ) ?>:</strong> <?php echo $size ?> Kb
        <?php if ( $gain > 0 ) : ?>
          <strong style="color:#c00">(<?php echo $gain ?> Kb)</strong>
        <?php endif; ?>
		</p>
    <?php
    else :
      return $result;
    endif;
  }

  /**
   * Cut a string
   *
   * @param        $s String to cut
   * @param int    $l Length
   * @param string $f Append string
   *
   * @return string
   */
  function stringCut( $s, $l = 32, $f = "..." )
  {
    if ( strlen( $s ) > $l ) {
      return substr( $s, 0, ( $l - strlen( $f ) ) / 2 ) . $f .
      substr( $s, -( $l - strlen( $f ) ) / 2, ( $l - strlen( $f ) ) / 2 );
    }
    else {
      return $s;
    }
  }

  /**
   * Reformatting a date
   *
   * @param $s
   *   String date
   *
   * @return string
   *   Format date or "0000-00-00 00:00:00" for default
   */
  function mysql_date( $s )
  {
    $result = "0000-00-00 00:00:00";
    $f      = __( 'mm/dd/yy', 'wp-bannerize' ) . ' H:i';
    if ( $s != "" && $s != $result ) {
      if ( substr( $s, 4, 1 ) == '-' ) {
        if ( substr( $f, 0, 1 ) == "m" ) {
          $fa = "m/d/Y H:i";
        }
        else {
          $fa = "d/m/Y H:i";
        }
        $date   = date_create( $s );
        $result = date_format( $date, $fa );
      }
      else {
        $a = explode( ' ', $s );
        $d = explode( '/', $a[0] );
        if ( substr( $f, 0, 1 ) == 'm' ) { // mm/dd/yyyy hh:mm
          $result = sprintf( '%s-%s-%s %s:00', $d[2], $d[0], $d[1], $a[1] );
        }
        else {
          if ( substr( $f, 0, 1 ) == 'd' ) { // dd/mm/yyyy hh:mm
            $result = sprintf( '%s-%s-%s %s:00', $d[2], $d[1], $d[0], $a[1] );
          }
        }
      }
    }
    return $result;
  }

  /**
   * Return the localized date format in accordance with the language selected
   *
   * @return string
   *   Localized date format in accordance with the language selected
   */
  function getPHPDateFormat()
  {
    $f = __( 'mm/dd/yy', 'wp-bannerize' );
    if ( substr( $f, 0, 1 ) == "m" ) {
      $result = "m/d/Y H:i";
    }
    else {
      $result = "d/m/Y H:i";
    }
    return $result;
  }

  /**
   * Return HTML code (ul/li) with all Wordpress categories
   *
   * @param array $selected
   *
   * @return string
   */
  function categoriesTree( $selected = null )
  {

    $allCategories = get_categories();
    $o             = '<ul style="margin-left:12px">';

    foreach ( $allCategories as $cat ) {
      if ( $cat->parent == '0' ) {
        $o .= $this->_iterateCategory( $cat, $selected );
      }
    }
    return $o . '</ul>';
  }

  /**
   * Internal "iterate" recursive function. For build a tree of category
   * Parent/Child
   *
   * @param object $cat_object
   * @param array  $selected
   *
   * @return string
   */
  function _iterateCategory( $cat_object, $selected = null )
  {
    $checked = "";
    if ( !is_null( $selected ) && is_array( $selected ) ) {
      $checked = ( in_array( $cat_object->cat_ID, $selected ) ) ? 'checked="checked"' : "";
    }
    $ou = '<li><label><input ' . $checked .
      ' type="checkbox" name="wpBannerizeCategoriesTree[]" class="wpBannerizeCategoriesTree" value="' .
      $cat_object->cat_ID . '" /> ' . $cat_object->cat_name . '</label>';

    $childs = get_categories( 'parent=' . $cat_object->cat_ID );
    foreach ( $childs as $cat ) {
      $ou .= '<ul style="margin-left:12px">' . $this->_iterateCategory( $cat, $selected ) . '</ul>';
    }
    $ou .= '</li>';
    return $ou;
  }

} // end of class