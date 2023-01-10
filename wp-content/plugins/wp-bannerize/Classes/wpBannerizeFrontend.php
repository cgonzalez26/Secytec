<?php
/**
 * Class for front-end
 *
 * @package             wpBannerize
 * @subpackage          wpBannerizeFrontend
 * @author			  =undo= <g.fazioli@undolog.com>, <g.fazioli@wpxtre.me>
 * @copyright		   Copyright (C) 2008-2013
 *
 */

class WPBannerizeFrontend extends WPBannerizeClass {

	function WPBannerizeFrontend( $__file__ ) {
		$this->__construct( $__file__ );
	}

	function __construct( $__file__ ) {
		// super
		parent::WPBannerizeClass( $__file__ );

		// Load configurations options
		$this->options = get_option( $this->options_key );

    add_action( 'wp_head', array( &$this, 'wp_enqueue_script' ) );
    add_action( 'wp_head', array( &$this, 'customCSS' ) );

    // @deprecated from 3.0.0
		add_shortcode( "wp-bannerize", array ( $this, "bannerize" ) );

		// Added @since 3.0.0
		add_shortcode( kWPBannerizeShortcodeName, array ( $this, "bannerize" ) );
	}

  public function wp_enqueue_script()
  {
    wp_enqueue_script( 'wp_bannerize_frontend_js', $this->uri . kWPBannerizeJavascriptFrontend, array( 'jquery' ), kWPBannerizeVersion, true );
    wp_localize_script( 'wp_bannerize_frontend_js', 'wpBannerizeJavascriptLocalization', array( 'ajaxURL' => $this->ajaxURL ) );
  }

  function customCSS()
  {
    if ( $this->options['wpBannerizeStyleDefault'] == 'default' ) {
      wp_enqueue_style( kWPBannerizeBannerStyleDefault, $this->uri . '/css/' . $this->options['wpBannerizeStyle'] );
    }
    else {
      ?>
      <!-- WP bannerize Custom CSS -->
      <style type="text/css">
			<?php
			echo $this->options['wpBannerizeStyleCustom'];
			?>
	</style>
      <!-- WP bannerize Custom CSS -->
    <?php
    }
  }

	/**
	 * Build HTML output
	 *
	 * @param $theArgs
	 *   Array from comand line or widget
	 *
	 * group				If '' show all group, else code of group (default '')
	 * no_html_wrap			Set to 1 for display only link and image tags
	 * before				Before tag banner open (default <div>)
	 * after				After tag banner close (default </div>)
	 * random				Show random banner sequence (default '')
	 * categories			Category ID separated by commas. (default '')
	 * limit				Limit rows number (default '' - show all rows)
	 *
	 * @return mixed|string
	 *   HTML Output: banner list to display
	 *
	 */
	function bannerize( $theArgs ) {
		global $wpdb;

		// Default args key/value
		$default = array ( 'group'        => '',
		                   'no_html_wrap' => '0',
		                   'random'       => '',
		                   'categories'   => '',
		                   'limit'        => '',
		                   'before'       => '<div>',
		                   'after'        => '</div>' );

		// Merge
		$args = wp_parse_args( $theArgs, $default );

		// Check first for category
		$categoriesID = $args['categories'];
		if ( !is_array( $categoriesID ) ) {
			if ( $categoriesID != '' ) {
				$categoriesID = explode( ',', $args['categories'] );
			}
		}
		// Fixed by http://wordpress.org/support/profile/schattenmann
		if ( is_array( $categoriesID ) && count( $categoriesID ) > 0 && !is_category( $categoriesID ) &&
			!in_category( $categoriesID )
		) {
			return;
		}

		$sql = "SELECT * FROM `" . $this->table_bannerize . "` WHERE `enabled` = '1' AND `trash` = '0' AND " .
			"(`maximpressions` = 0 OR `impressions` < `maximpressions`) AND " .
			"( (`start_date` < NOW() OR `start_date` = '0000-00-00 00:00:00' ) AND (`end_date` > NOW() OR `end_date` = '0000-00-00 00:00:00') ) ";

		// group
		if ( $args['group'] != '' ) {
			$sql .= " AND `group` = '" . $args['group'] . "'";
		}

		// random
		if ( $args['random'] != '' ) {
			$sql .= ' ORDER BY RAND()';
		} else {
			$sql .= ' ORDER BY `sorter` ASC';
		}

		// limit
		if ( $args['limit'] != '' ) {
			$sql .= " LIMIT 0," . $args['limit'];
		}

		// Query
		$rows = $wpdb->get_results( $sql );

		// Start buffering output
		ob_start();
		if ( count( $rows ) > 0 ) {
			?>
		<?php // Widget
			if ( isset( $args['before_widget'] ) ) : ?>
			<?php
				echo $args['before_widget'];
				$title = apply_filters( 'widget_title', $args['title'] );
				if ( $title != '' ) {
					echo $args['before_title'] . $title . $args['after_title'];
				}
				?>
			<?php endif; ?>
		<?php if ( $args['no_html_wrap'] == '0' ) : ?>
				<div class="wp_bannerize <?php if ( $args['group'] != '' ) {
					echo $args['group'];
				} ?>">
			<?php endif; ?>
			<?php foreach ( $rows as $row ) : ?>
				<?php // Impressions
				if ( $this->options['impressionsEnabled'] == "1" ) {
          $wpdb->query( $wpdb->prepare( 'UPDATE `' . $this->table_bannerize . '` SET `impressions` = `impressions`+1 WHERE `id` = %d', $row->id ) );
        } ?>
				<?php // Javascript Click count
				$javascriptClickCounter = ( $this->options['clickCounterEnabled'] == '1' ) ?
					' onclick="WPBannerizeJavascript.incrementClickCount(' . $row->id . ')" ' : '';
				?>
				<?php // Check for Adobe Flash, Image or free HTML text
				if ( $row->banner_type == kWPBannerizeBannerTypeFromLocal ||
					$row->banner_type == kWPBannerizeBannerTypeByURL
				) :
					if ( $row->mime == "application/x-shockwave-flash" ) : ?>
						<div style="position:relative; z-index:0">
							<a <?php echo $javascriptClickCounter ?> style="width:<?php echo $row->width ?>px; height:<?php echo $row->height ?>px;  position:absolute; z-index:999"
							                                         href="<?php echo $row->url ?>" <?php echo ( (
								$row->nofollow == '1' ) ? 'rel="nofollow"' : '' )  ?> <?php echo ( (
								$row->target != '' ) ? 'target="' . $row->target . '"' : '' )  ?>></a>
							<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
							        width="<?php echo $row->width ?>"
							        height="<?php echo $row->height ?>">
								<param name="movie" value="<?php echo $row->filename ?>"/>
								<param value="<?php echo $this->options['comboWindowModeFlash'] ?>" name="wmode"/>
								<!--[if !IE]> -->
								<object data="<?php echo $row->filename ?>"
								        width="<?php echo $row->width ?>"
								        height="<?php echo $row->height ?>"
								        type="application/x-shockwave-flash">
									<param value="<?php echo $this->options['comboWindowModeFlash'] ?>" name="wmode"/>
								</object>
								<!--<![endif]-->
							</object>
							<?php if ( $row->use_description == '1' ) : ?>
							<br/>
							<span>
									<?php if ( $this->options['linkDescription'] && $row->url != '' ) : ?>
								<a <?php echo $javascriptClickCounter ?> href="<?php echo $row->url ?>" <?php echo ( (
									$row->nofollow == '1' ) ? 'rel="nofollow"' : '' )  ?> <?php echo ( (
									$row->target != '' ) ? 'target="' . $row->target . '"' : '' )  ?>>
									<?php echo $row->description ?>
								</a>
								<?php else : echo $row->description;
							endif; ?>
								</span>
							<?php endif; ?>
						</div>
						<?php else: ?>
						<?php if ( $args['no_html_wrap'] == '0' ) {
							echo $args['before'];
						} ?>
						<?php if ( $row->url != '' ) : ?>
							<a <?php echo $javascriptClickCounter ?> href="<?php echo $row->url ?>" <?php echo ( (
								$row->nofollow == '1' ) ? 'rel="nofollow"' : '' )  ?> <?php echo ( (
								$row->target != '' ) ? 'target="' . $row->target . '"' : '' )  ?>>
							<?php endif; //cristian?>
						<img src="<?php echo $row->filename ?>" alt="<?php echo $row->description ?>" <?php echo ( (
							$row->width == 0 || $row->height ==
								0 ) ? '' : sprintf( 'width="%s" height="%s"', $row->width, $row->height ) );?> style="<?php echo ( (
							$row->width == 0 || $row->height ==
								0 ) ? '' : sprintf( 'width:%spx; height:%spx;box-shadow: 0 0 1em rgba(0,0,0,0.5);', $row->width, $row->height ) );?>"/>
						<?php if ( $row->url != '' ) : ?>
							</a>
							<?php endif; ?>
						<?php if ( $row->use_description == '1' ) : ?>
							<div class="description">
								<?php if ( $this->options['linkDescription'] && $row->url != '' ) : ?>
								<a <?php echo $javascriptClickCounter ?> href="<?php echo $row->url ?>" <?php echo ( (
									$row->nofollow == '1' ) ? 'rel="nofollow"' : '' )  ?> <?php echo ( (
									$row->target != '' ) ? 'target="' . $row->target . '"' : '' )  ?>>
									<?php echo $row->description ?>
								</a>
								<?php else : echo $row->description;
							endif; ?>
							</div>
							<?php endif; ?>
						<?php if ( $args['no_html_wrap'] == '0' )
								{
									echo $args['after'];
								} ?>
						<?php endif; ?>
					<?php elseif ( $row->banner_type == kWPBannerizeBannerTypeFreeHTML ) : ?>
					<div><?php echo stripslashes( $row->free_html ); ?></div>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php if ( $args['no_html_wrap'] == '0' ) : ?>
				</div>
			<?php endif; ?>
		<?php if ( $this->options['supportWPBannerize'] == '1' ) : ?>
			<p class="wp-bannerize-support"><a style="font-size:11px;text-align:center"
			                                   href="https://wpxtre.me/product/bannerize/"
			                                   target="_blank"><span>Powered by WP Bannerize</span></a></p>
			<?php endif; ?>
		<?php // Widget
			if ( isset( $args['after_widget'] ) ) : ?>
			<?php echo $args['after_widget'] ?>
			<?php endif; ?>
		<?php
		} else {
			// Show form general setting something for NO Banner to display
			echo $this->options['wpBannerizeNoBannerHTMLMessage'];
		}
		$result = ob_get_contents();
		$result = str_replace( "\t", '', $result );
		$result = trim( $result );
		ob_end_clean();
		return $result;
	}

} // end of class