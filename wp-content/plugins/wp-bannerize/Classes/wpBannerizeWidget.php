<?php
/**
 * WP Bannerize Wordpress Widget Class support
 *
 * @package            wpBannerize
 * @subpackage         wpBannerizeWidget
 * @author             =undo= <g.fazioli@undolog.com>, <g.fazioli@wpxtre.me>
 * @copyright          Copyright (C) 2008-2013
 * @version            3.0
 *
 */

class WPBannerizeWidget extends WP_Widget {

	/**
	 * Same wp-bannerize_class
	 *
	 * @var string
	 */
	var $table_bannerize = "";
	var $options;

	function WPBannerizeWidget() {
		$this->__construct();
	}

	function __construct() {
		global $wpdb;

		/**
		 * Load localizations if available
		 *
		 * @since 2.4.0
		 */
		load_plugin_textdomain( 'wp-bannerize', false, 'wp-bannerize/localization' );

		/**
		 * Load options
		 *
		 * @since 2.7.0.3
		 */
		$this->options         = get_option( kWPBannerizeOptionsKey );
		$this->table_bannerize = $wpdb->prefix . kWPBannerizeTableName;
		$widget_ops            = array ( 'classname'   => kWPBannerizeWidgetClassName,
		                                 'description' => __( 'Amazing Banner Manager', 'wp-bannerize' ) );
		$control_ops           = array ( 'width'  => 430,
		                                 'height' => 350 );
		$this->WP_Widget( kWPBannerizeShortcodeName, kWPBannerizePluginName, $widget_ops, $control_ops );
	}

	/**
	 * Output Widget; call by Wordpress
	 *
	 * @param $args
	 *   Internal
	 * @param $instance
	 *   Widget parameters
	 *
	 * @return void
	 */
	function widget( $args, $instance ) {
		global $wpBannerizeFrontend;
		$new_args = array_merge( $args, $instance );
		echo $wpBannerizeFrontend->bannerize( $new_args );
	}

	/**
	 * Update Widget options
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 */
	function update( $new_instance, $old_instance ) {
		$default      = array ( 'title'        => '',
		                        'group'        => '',
		                        'random'       => '',
		                        'no_html_wrap' => '0',
		                        'limit'        => '10',
		                        'categories'   => array (),
		                        'before'       => '<div>',
		                        'after'        => '</div>' );
		$new_instance = wp_parse_args( $new_instance, $default );
		$instance     = $old_instance;

		// Wordpress Widget Titile
		$instance['title'] = strip_tags( $new_instance['title'] );

		// Own parameters
		$instance['group']        = strip_tags( $new_instance['group'] );
		$instance['random']       = strip_tags( $new_instance['random'] );
		$instance['no_html_wrap'] = strip_tags( $new_instance['no_html_wrap'] );
		$instance['limit']        = strip_tags( $new_instance['limit'] );
		$instance['categories']   = ( $new_instance['categories'] );

		$instance['before'] = $new_instance['before'];
		$instance['after']  = $new_instance['after'];

		return $instance;
	}

	/**
	 * Build the Widget interface - backend side
	 *
	 * @param array $instance
	 */
	function form( $instance ) {
		$instance     = wp_parse_args( (array)$instance, array ( 'title'        => '',
		                                                         'group'        => '',
		                                                         'random'       => '',
		                                                         'no_html_wrap' => '0',
		                                                         'limit'        => '10',
		                                                         'categories'   => array (),
		                                                         'before'       => '<div>',
		                                                         'after'        => '</div>' ) );
		$title        = strip_tags( $instance['title'] );
		$group        = strip_tags( $instance['group'] );
		$random       = $instance['random'];
		$no_html_wrap = $instance['no_html_wrap'];
		$limit        = strip_tags( $instance['limit'] );
		$categories   = $instance['categories'];
		$before       = $instance['before'];
		$after        = $instance['after'];

		?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wp-bannerize' ); ?>.</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
		       name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
		       value="<?php echo esc_attr( $title ); ?>"/>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'group' ); ?>"><?php _e( 'Group', 'wp-bannerize' ); ?>:</label>
		<?php echo $this->get_group( $group ) ?>

		<label for="<?php echo $this->get_field_id( 'random' ); ?>"><?php _e( 'Random', 'wp-bannerize' ); ?>
			:</label>
		<input <?php checked( $random, '1' ) ?> value="1" type="checkbox"
		                                        name="<?php echo $this->get_field_name( 'random' ); ?>"
		                                        id="<?php echo $this->get_field_id( 'random' ); ?>"/>

		<label for="<?php echo $this->get_field_id( 'no_html_wrap' ); ?>"><?php _e( 'No HTML wrap', 'wp-bannerize' ); ?>
			:</label>
		<input <?php checked( $no_html_wrap, '1' ) ?> value="1" type="checkbox"
		                                              name="<?php echo $this->get_field_name( 'no_html_wrap' ); ?>"
		                                              id="<?php echo $this->get_field_id( 'no_html_wrap' ); ?>"/>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'before' ); ?>"><?php _e( 'HTML Tag before banner', 'wp-bannerize' ); ?>
			:</label>
		<input type="text"
		       size="8"
		       value="<?php echo $before ?>"
		       name="<?php echo $this->get_field_name( 'before' ); ?>"
		       id="<?php echo $this->get_field_id( 'before' ); ?>"/>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'after' ); ?>"><?php _e( 'HTML Tag after banner', 'wp-bannerize' ); ?>
			:</label>
		<input type="text"
		       size="8"
		       value="<?php echo $after ?>"
		       name="<?php echo $this->get_field_name( 'after' ); ?>"
		       id="<?php echo $this->get_field_id( 'after' ); ?>"/>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'categories' ); ?>">
			<strong><?php _e( 'Show only for these Categories', 'wp-bannerize' ); ?>:</strong>
		</label>
	</p>

	<p><?php echo $this->get_categories_checkboxes( $categories ) ?></p>

	<p>
		<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Max', 'wp-bannerize' ); ?>:</label>
		<input style="text-align:right;width:50px" type="text" value="<?php echo $limit ?>"
		       name="<?php echo $this->get_field_name( 'limit' ); ?>"
		       id="<?php echo $this->get_field_id( 'limit' ); ?>"/></p>

	<?php

	}

	/**
	 * Return HTML code (select/option) with all group/key retrive from
	 * database
	 *
	 * @global object $wpdb
	 *
	 * @param string  $group
	 *
	 * @return string
	 */
	function get_group( $group = '' ) {
		global $wpdb;
		$o    = '<select rel="' . $group . '" id="' . $this->get_field_id( 'group' ) . '" name="' .
			$this->get_field_name( 'group' ) . '">' . '<option value=""></option>';
		$q    = "SELECT `group` FROM `" . $this->table_bannerize . "` GROUP BY `group` ORDER BY `group` ";
		$rows = $wpdb->get_results( $q );
		foreach ( $rows as $row ) {
			$sel = ( $group == $row->group ) ? 'selected="selected"' : "";
			$o .= '<option ' . $sel . ' value="' . $row->group . '">' . $row->group . '</option>';
		}
		$o .= '</select>';
		return $o;
	}

	/**
	 * Return HTML code (ul/li) with all Wordpress categories
	 *
	 * @param array $selected_cats
	 *
	 * @return string
	 */
	function get_categories_checkboxes( $selected_cats = null ) {
		$all_categories = get_categories();
		$o              = '<ul style="margin-left:12px">';

		foreach ( $all_categories as $key => $cat ) {
			if ( $cat->parent == "0" ) {
				$o .= $this->_i_show_category( $cat, $selected_cats );
			}
		}
		return $o . '</ul>';
	}

	/**
	 * Internal "iterate" recursive function. For build a tree of category
	 * Parent/Child
	 *
	 * @param object $cat_object
	 * @param array  $selected_cats
	 *
	 * @return string
	 */
	function _i_show_category( $cat_object, $selected_cats = null ) {
		$checked = '';
		if ( !is_null( $selected_cats ) && is_array( $selected_cats ) ) {
			$checked = ( in_array( $cat_object->cat_ID, $selected_cats ) ) ? 'checked="checked"' : "";
		}
		$ou = '<li><label><input ' . $checked . ' type="checkbox" name="' . $this->get_field_name( 'categories' ) .
			'[]" value="' . $cat_object->cat_ID . '" /> ' . $cat_object->cat_name . '</label>';

		$childs = get_categories( 'parent=' . $cat_object->cat_ID );
		foreach ( $childs as $key => $cat ) {
			$ou .= '<ul style="margin-left:12px">' . $this->_i_show_category( $cat, $selected_cats ) . '</ul>';
		}
		$ou .= '</li>';
		return $ou;
	}
}
