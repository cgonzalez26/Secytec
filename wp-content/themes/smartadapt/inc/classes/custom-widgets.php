<?php


/**
 * Smartadapt Widgets Classes
 *
 * Theme's widgets extends the default WordPress
 * widgets by giving users highly-customizable widget settings.
 *
 * @package    WordPress
 * @subpackage SmartAdapt
 * @since      SmartAdapt 1.0
 */


/**
 * Custom Search widget class
 *
 * @since 1.0
 */

class WP_Widget_Search_smartadapt extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_search', 'description' => __( "A search form for your site", 'smartadapt' ) );
		parent::__construct( 'search', __( 'SmartAdapt: Search', 'smartadapt' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

// Use current theme search form if it exists
		get_search_form();

		echo $after_widget;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title    = $instance['title'];
		?>
	<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'smartadapt' ); ?>
		<input class="widefat"
					 id="<?php echo $this->get_field_id( 'title' ); ?>"
					 name="<?php echo $this->get_field_name( 'title' ); ?>"
					 type="text"
					 value="<?php echo esc_attr( $title ); ?>" /></label>
	</p>
	<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$new_instance      = wp_parse_args( (array) $new_instance, array( 'title' => '' ) );
		$instance['title'] = strip_tags( $new_instance['title'] );
		return $instance;
	}

}

/**
 * Recent_Posts widget class
 *
 * @since 1.0
 *
 */
class WP_Widget_Recent_Posts_smartadapt extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_recent_entries_smartadapt', 'description' => __( "The most recent posts on your site (extended contorls)", 'smartadapt' ) );
		parent::__construct( 'recent-posts-smartadapt', __( 'SmartAdapt: Extended Recent Posts', 'smartadapt' ), $widget_ops );
		$this->alt_option_name = 'widget_recent_entries_smartadapt';

		add_action( 'save_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );
	}

	function widget( $args, $instance ) {

		$cache = wp_cache_get( 'widget_recent_posts', 'widget' );

		if ( ! is_array( $cache ) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract( $args );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Recent Posts', 'smartadapt' ) : $instance['title'], $instance, $this->id_base );
		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
			$number = 10;
		$show_date           = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
		$show_post_thumbnail = isset( $instance['show_post_thumbnail'] ) ? $instance['show_post_thumbnail'] : false;
		$show_post_author    = isset( $instance['show_post_author'] ) ? $instance['show_post_author'] : false;

		$r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
		if ( $r->have_posts() ) :
			?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul class="no-bullet">
			<?php while ( $r->have_posts() ) : $r->the_post(); ?>
			<li>
				<a href="<?php the_permalink() ?>"
					 title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>">
					<?php
					if ( $show_post_thumbnail ) {
						?>



								<?php
								$featured_image = get_featured_image( 'small-image' );
								if ( '' != get_the_post_thumbnail() ) {
									?>
									<span class="widget-image-outer format-ico gallerypost-ico">
									<?php the_post_thumbnail('small-image') ?>
									 </span>
									<?php
								}
								else if ( ! empty( $featured_image ) ) {
									?>
								<?php echo $featured_image ?>
									<?php

								}
								?>


						<?php
					}
					?>
					<span class="widget-post-title"><?php if ( get_the_title() ) the_title();
					else the_ID(); ?></span>

				</a>

				<div class="bottom-container">

					<?php if ( $show_date ) : ?>
					<span class="meta-date"><?php echo get_the_date(); ?></span>
					<?php endif; ?>


					<?php if ( $show_post_author ) : ?>
					<span class="meta-publisher"><?php echo get_the_author(); ?></span>
					<?php endif; ?>

				</div>
			</li>
			<?php endwhile; ?>
		</ul>
		<?php echo $after_widget; ?>
		<?php
			// Reset the global $the_post as this query will have stomped on it
			wp_reset_postdata();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set( 'widget_recent_posts', $cache, 'widget' );
	}

	function update( $new_instance, $old_instance ) {
		$instance                        = $old_instance;
		$instance['title']               = strip_tags( $new_instance['title'] );
		$instance['number']              = (int) $new_instance['number'];
		$instance['show_date']           = (bool) $new_instance['show_date'];
		$instance['show_post_thumbnail'] = (bool) $new_instance['show_post_thumbnail'];
		$instance['show_post_author']    = (bool) $new_instance['show_post_author'];

		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_recent_entries'] ) )
			delete_option( 'widget_recent_entries' );

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete( 'widget_recent_posts', 'widget' );
	}

	function form( $instance ) {


		$title               = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number              = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date           = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
		$show_post_thumbnail = isset( $instance['show_post_thumbnail'] ) ? (bool) $instance['show_post_thumbnail'] : true;
		$show_post_author    = isset( $instance['show_post_author'] ) ? (bool) $instance['show_post_author'] : true;
		?>
	<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'smartadapt' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
					 name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

	<p>
		<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', 'smartadapt' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>"
					 type="text" value="<?php echo $number; ?>" size="3" /></p>

	<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?>
						id="<?php echo $this->get_field_id( 'show_date' ); ?>"
						name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?', 'smartadapt' ); ?></label>
	</p>

	<p><input class="checkbox" type="checkbox" <?php checked( $show_post_thumbnail ); ?>
						id="<?php echo $this->get_field_id( 'show_post_thumbnail' ); ?>"
						name="<?php echo $this->get_field_name( 'show_post_thumbnail', 'smartadapt' ); ?>" />
		<label
				for="<?php echo $this->get_field_id( 'show_post_thumbnail' ); ?>"><?php _e( 'Display post thumbnail?', 'smartadapt' ); ?></label>
	</p>

	<p><input class="checkbox" type="checkbox" <?php checked( $show_post_author ); ?>
						id="<?php echo $this->get_field_id( 'show_post_author' ); ?>"
						name="<?php echo $this->get_field_name( 'show_post_author' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_post_author' ); ?>"><?php _e( 'Display post author?', 'smartadapt' ); ?></label>
	</p>
	<?php
	}
}

add_action( 'widgets_init', create_function( '', 'return register_widget("WP_Widget_Recent_Posts_smartadapt");' ) );

/**
 * One author info widget
 *
 * @since 1.0
 *
 */

class WP_Widget_One_Author_Widget_smartadapt extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'one_author_smartadapt', 'description' => __( "Short  info & avatar", 'smartadapt' ) );
		parent::__construct( 'one-author-smartadapt', __( 'SmartAdapt:  One Author Profile', 'smartadapt' ), $widget_ops );
		$this->alt_option_name = 'one-author-smartadapt';

		add_action( 'save_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );
	}

	function widget( $args, $instance ) {

		wp_reset_query();
		$title = apply_filters( 'widget_title', $instance['title'] );

		extract( $args );

		$author = get_userdata( $instance['user_id'] );


		$name = $author->display_name;
    
		$avatar      = get_avatar( $instance['user_id'], $instance['size'] );
		$description = get_the_author_meta( 'description', $instance['user_id'] );
		$author_link = get_author_posts_url( $instance['user_id'] );


		?>

	<?php echo $before_widget; ?>
	<?php if ( $title ) echo $before_title . $title . $after_title; ?>
	<span class="widget-image-outer"><?php echo $avatar ?></span>
	<h4><a href="<?php echo $author_link ?>"><?php echo $name ?></a></h4>
	<p class="description-widget"><?php echo $description ?></p>
	<?php echo $after_widget; ?>
	<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance            = $old_instance;
		$instance['title']   = strip_tags( $new_instance['title'] );
		$instance['size']    = strip_tags( $new_instance['size'] );
		$instance['user_id'] = strip_tags( $new_instance['user_id'] );

		return $instance;
	}

	function form( $instance ) {
		if ( array_key_exists( 'title', $instance ) ) {
			$title = esc_attr( $instance['title'] );
		}
		else {
			$title = '';
		}

		if ( array_key_exists( 'user_id', $instance ) ) {
			$user_id = esc_attr( $instance['user_id'] );
		}
		else {
			$user_id = 1;
		}

		if ( array_key_exists( 'size', $instance ) ) {
			$size = esc_attr( $instance['size'] );
		}
		else {
			$size = 64;
		}

		?>
	<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'smartadapt' ); ?>
		<input class="widefat"
					 id="<?php echo $this->get_field_id( 'title' ); ?>"
					 name="<?php echo $this->get_field_name( 'title' ); ?>"
					 type="text"
					 value="<?php echo $title; ?>" /></label>
	</p>
	<p><label for="<?php echo $this->get_field_id( 'user_id' ); ?>"><?php _e( 'Authot Name:', 'smartadapt' ); ?>
		<select id="<?php echo $this->get_field_id( 'user_id' ); ?>"
						name="<?php echo $this->get_field_name( 'user_id' ); ?>" value="<?php echo $user_id; ?>">
			<?php

			$args = array(
				'order' => 'ASC'
			);

			$users = get_users( $args );;

			foreach ( $users as $row ) {
				echo "<option value='$row->ID' " . ( $row->ID == $user_id ? "selected='selected'" : '' ) . ">$row->user_nicename</option>";
			}
			?>
		</select></label></p>
	<p><label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Avatar Size:', 'smartadapt' ); ?>
		<select id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>"
						value="<?php echo $size; ?>">
			<?php
			for ( $i = 16; $i <= 256; $i += 16 ) {
				echo "<option value='$i' " . ( $size == $i ? "selected='selected'" : '' ) . ">$i</option>";
			}
			?>
		</select></label></p>
	<?php
	}

	function flush_widget_cache() {
		wp_cache_delete( 'one_author_smartadapt', 'widget' );
	}
}

add_action( 'widgets_init', create_function( '', 'return register_widget("WP_Widget_One_Author_Widget_smartadapt");' ) );

/**
 * Add social profile icons -  widget
 *
 * @since 1.0
 *
 */

class WP_Widget_SmartAdapt_Social_Icons_smartadapt extends WP_Widget {

	public $form_args;

	function __construct() {
		$widget_ops = array( 'classname' => 'social_icons_smartadapt', 'description' => __( "Add social profile icons", 'smartadapt' ) );
		parent::__construct( 'social-icons-smartadapt', __( 'SmartAdapt: Social Icons', 'smartadapt' ), $widget_ops );
		$this->alt_option_name = 'social-icons-smartadapt';

		add_action( 'save_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );

		$this->form_args = array(
			'title',
			'facebook',
			'google-plus',
			'twitter',
			'youtube',
			'pinterest',
			'linkedin'
		);
	}

	function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		extract( $args );
		echo $before_widget;
		?>
	<?php if ( $title ) echo $before_title . $title . $after_title; ?>
	<ul class="menu social-buttons-list">
		<?php
		foreach ( $this->form_args as $row ) {
			if ( isset( $instance[$row] ) && ! empty( $instance[$row] ) && $row != 'title' ) {
				?>
				<li class="social_<?php echo $row ?>"><a href="<?php echo $instance[$row]  ?>"><span class="icon-<?php echo $row ?>"></span></a></li>
				<?php
			}
		}?>
	</ul>
	<?php
		echo $after_widget; ?>
	<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		foreach ( $this->form_args as $row ) {
			$instance[$row] = strip_tags( $new_instance[$row] );
		}

		return $instance;
	}

	function form( $instance ) {

		$form_values = array();

		foreach ( $this->form_args as $row ) {
			if ( array_key_exists( $row, $instance ) ) {
				$form_values[$row] = $instance[$row];
			}else{
				$form_values[$row] = '';
			}
		}

		?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Short Title:', 'smartadapt' ); ?>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $form_values['title']; ?>" /></label>
	<hr />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e( 'Facebook:', 'smartadapt' ); ?>
			<input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" type="text" value="<?php echo $form_values['facebook']; ?>" /></label>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'google-plus' ); ?>"><?php _e( 'Google+:', 'smartadapt' ); ?>
			<input class="widefat" id="<?php echo $this->get_field_id( 'google-plus' ); ?>" name="<?php echo $this->get_field_name( 'google-plus' ); ?>" type="text" value="<?php echo $form_values['google-plus']; ?>" /></label>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?php _e( 'Youtube:', 'smartadapt' ); ?>
			<input class="widefat" id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" type="text" value="<?php echo $form_values['youtube']; ?>" /></label>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e( 'Twitter:', 'smartadapt' ); ?>
			<input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" type="text" value="<?php echo $form_values['twitter']; ?>" /></label>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'pinterest' ); ?>"><?php _e( 'Pinterest:', 'smartadapt' ); ?>
			<input class="widefat" id="<?php echo $this->get_field_id( 'pinterest' ); ?>" name="<?php echo $this->get_field_name( 'pinterest' ); ?>" type="text" value="<?php echo $form_values['pinterest']; ?>" /></label>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'linkedin' ); ?>"><?php _e( 'LinkedIn:', 'smartadapt' ); ?>
			<input class="widefat" id="<?php echo $this->get_field_id( 'linkedin' ); ?>" name="<?php echo $this->get_field_name( 'linkedin' ); ?>" type="text" value="<?php echo $form_values['linkedin']; ?>" /></label>
	</p>


	<?php
	}

	function flush_widget_cache() {
		wp_cache_delete( 'one_author_smartadapt', 'widget' );
	}
}

add_action( 'widgets_init', create_function( '', 'return register_widget("WP_Widget_SmartAdapt_Social_Icons_smartadapt");' ) );


/**
 * Add Video Widget
 *
 * @since 1.0
 *
 */

class WP_Widget_SmartAdapt_Video_smartadapt extends WP_Widget {


	function __construct() {
		$widget_ops = array( 'classname' => 'video_widget_smartadapt', 'description' => __( "Add Video Widget", 'smartadapt' ) );
		parent::__construct( 'video-widget-smartadapt', __( 'SmartAdapt: Video Widget', 'smartadapt' ), $widget_ops );
		$this->alt_option_name = 'video-widget-smartadapt';

		add_action( 'save_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );


	}

	function widget( $args, $instance ) {
		$title      = apply_filters( 'widget_title', $instance['title'] );
		$embed_code = $instance['embed_code'];
		$more_text  = $instance['more_text'];
		$link       = $instance['more_text'];


		extract( $args );
		echo $before_widget;
		?>
	<?php if ( $title ) echo $before_title . $title . $after_title; ?>

				<div class="video-box-container">
					<?php echo $embed_code ?>

		<?php
		if ( strlen( $more_text ) > 0 ) {
			?>
			<a href="<?php echo $link?>" class="more-link"><?php echo $more_text ?></a>
				</div>
			<?php
		}
		?>
	</div>
	<?php
		echo $after_widget; ?>
	<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance               = $old_instance;
		$instance['title']      = strip_tags( $new_instance['title'] );
		$instance['embed_code'] = $new_instance['embed_code'];
		$instance['more_text']  = $new_instance['more_text'];
		$instance['link']       = $new_instance['link'];

		return $instance;
	}

	function form( $instance ) {

		$form_values = array();

		if ( array_key_exists( 'title', $instance ) ) {
			$title = esc_attr( $instance['title'] );
		}
		else {
			$title = '';
		}

		if ( array_key_exists( 'embed_code', $instance ) ) {
			$embed_code = esc_attr( $instance['embed_code'] );
		}
		else {
			$embed_code = '';
		}

		if ( array_key_exists( 'more_text', $instance ) ) {
			$more_text = esc_attr( $instance['more_text'] );
		}
		else {
			$more_text = '';
		}
		if ( array_key_exists( 'link', $instance ) ) {
			$link = esc_attr( $instance['link'] );
		}
		else {
			$link = '';
		}

		?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'smartadapt' ); ?>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></label>
	<hr />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'embed_code' ); ?>"><?php _e( 'Embed code:', 'smartadapt' ); ?><br />
			<textarea id="<?php echo $this->get_field_id( 'embed_code' ); ?>" name="<?php echo $this->get_field_name( 'embed_code' ); ?>" rows="5" cols="40"><?php echo $embed_code; ?></textarea></label>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'more_text' ); ?>"><?php _e( 'More text:', 'smartadapt' ); ?>
			<input class="widefat" id="<?php echo $this->get_field_id( 'more_text' ); ?>" name="<?php echo $this->get_field_name( 'more_text' ); ?>" type="text" value="<?php echo $more_text; ?>" /></label>

	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link:', 'smartadapt' ); ?>
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo $link; ?>" /></label>

	</p>

	<?php
	}

	function flush_widget_cache() {
		wp_cache_delete( 'video-widget-smartadapt', 'widget' );
	}
}

add_action( 'widgets_init', create_function( '', 'return register_widget("WP_Widget_SmartAdapt_Video_smartadapt");' ) );

/**
 * Add Video Widget
 *
 * @since 1.0
 *
 */

class WP_Widget_SmartAdapt_Recent_Videos_smartadapt extends WP_Widget {


	function __construct() {
		$widget_ops = array( 'classname' => 'video_widget_smartadapt', 'description' => __( "Displays last posts from the video post format", 'smartadapt' ) );
		parent::__construct( 'recent-videos-widget-smartadapt', __( 'SmartAdapt:  Recent Videos', 'smartadapt' ), $widget_ops );
		$this->alt_option_name = 'recent-videos-widget-smartadapt';

		add_action( 'save_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );


	}

	function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		$limit = is_int($instance['video_limit'])?$instance['video_limit']:4;


		extract( $args );
		echo $before_widget;
		?>
	<?php if ( $title ) echo $before_title . $title . $after_title;


		$query = new WP_Query(
			array(
				'posts_per_page' => $limit,
				'tax_query'      => array(
					array(
						'taxonomy' => 'post_format',
						'field'    => 'slug',
						'terms'    => array( 'post-format-video' )
					)
				)
			)
		);
		if ( $query->have_posts() ) {
			?>

		<div class="recent-videos-box-container">
			<div class="row">
				<?php
				while ( $query->have_posts() ) {
					$query->the_post();
?>
					<div class="columns eight">

							<div class="thumbnail-outer format-ico video-ico"><a href="<?php the_permalink(); ?>"><?php if(has_post_thumbnail()){ the_post_thumbnail('medium-image');}else{ echo '<img src="'.get_template_directory_uri().'/images/placeholder.gif" alt="Video Placeholder" width="130" height="130" />';} ?></a></div>

					</div>

<?php
				}
				?></div>
		</div>

		<?php
		}
		wp_reset_query();
	echo $after_widget; ?>
	<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance               = $old_instance;
		$instance['title']      = strip_tags( $new_instance['title'] );
		$instance['video_limit']       = $new_instance['video_limit'];

		return $instance;
	}

	function form( $instance ) {

		$form_values = array();

		if ( array_key_exists( 'title', $instance ) ) {
			$title = esc_attr( $instance['title'] );
		}
		else {
			$title = '';
		}

		if ( array_key_exists( 'video_limit', $instance ) ) {
			$limit = esc_attr( $instance['video_limit'] );
		}
		else {
			$limit = '';
		}



		?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'smartadapt' ); ?>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></label>

	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'video_limit' ); ?>"><?php _e( 'Limit:', 'smartadapt' ); ?>
			<input class="widefat" id="<?php echo $this->get_field_id( 'video_limit' ); ?>" name="<?php echo $this->get_field_name( 'video_limit' ); ?>" type="text" value="<?php echo $limit; ?>" /></label>

	</p>

	<?php
	}

	function flush_widget_cache() {
		wp_cache_delete( 'recent-videos-widget-smartadapt', 'widget' );
	}
}

add_action( 'widgets_init', create_function( '', 'return register_widget("WP_Widget_SmartAdapt_Recent_Videos_smartadapt");' ) );


/**
 * Add Recent Gallery Widget
 *
 * @since 1.0
 *
 */

class WP_Widget_SmartAdapt_Recent_Gallery_smartadapt extends WP_Widget {


	function __construct() {
		$widget_ops = array( 'classname' => 'gallery_recent_widget_smartadapt', 'description' => __( "Displays last posts from the gallery post format", 'smartadapt' ) );
		parent::__construct( 'recent-gallery-widget-smartadapt', __( 'SmartAdapt:  Recent Galleries', 'smartadapt' ), $widget_ops );
		$this->alt_option_name = 'gallery_recent_widget_smartadapt';

		add_action( 'save_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );


	}

	function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		$limit = is_int($instance['gallery_limit'])?$instance['gallery_limit']:4;


		extract( $args );
		echo $before_widget;
		?>
	<?php if ( $title ) echo $before_title . $title . $after_title;


		$query = new WP_Query(
			array(
				'posts_per_page' => $limit,
				'tax_query'      => array(
					array(
						'taxonomy' => 'post_format',
						'field'    => 'slug',
						'terms'    => array( 'post-format-gallery' )
					)
				)
			)
		);
		if ( $query->have_posts() ) {
			?>

		<div class="recent-gallery-box-container">
			<div class="row">
								<?php
			while ( $query->have_posts() ) {

				$query->the_post();

				?>
				<div class="columns eight">
					<div class="thumbnail-outer format-ico gallerypost-ico">
						<?php
						$featured_image = get_featured_image( 'medium-image' );
						if ( '' != get_the_post_thumbnail() ) {
							?>
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium-image') ?></a>
							<?php
						}
						else if ( ! empty( $featured_image ) ) {
							?>
							<a href="<?php the_permalink(); ?>"><?php echo $featured_image ?></a>
							<?php

						}
						?></div>
		</div>

		<?php
		}
		wp_reset_query();
		?>
		</div>
		</div>
		<?php
		echo $after_widget; ?>
	<?php
	}
	}
	function update( $new_instance, $old_instance ) {
		$instance               = $old_instance;
		$instance['title']      = strip_tags( $new_instance['title'] );
		$instance['gallery_limit']       = $new_instance['gallery_limit'];

		return $instance;
	}

	function form( $instance ) {

		$form_values = array();

		if ( array_key_exists( 'title', $instance ) ) {
			$title = esc_attr( $instance['title'] );
		}
		else {
			$title = '';
		}

		if ( array_key_exists( 'gallery_limit', $instance ) ) {
			$limit = esc_attr( $instance['gallery_limit'] );
		}
		else {
			$limit = '';
		}



		?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'smartadapt' ); ?>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></label>

	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'gallery_limit' ); ?>"><?php _e( 'Limit:', 'smartadapt' ); ?>
			<input class="widefat" id="<?php echo $this->get_field_id( 'gallery_limit' ); ?>" name="<?php echo $this->get_field_name( 'gallery_limit' ); ?>" type="text" value="<?php echo $limit; ?>" /></label>

	</p>

	<?php
	}

	function flush_widget_cache() {
		wp_cache_delete( 'recent-gallery-widget-smartadapt', 'widget' );
	}

}

add_action( 'widgets_init', create_function( '', 'return register_widget("WP_Widget_SmartAdapt_Recent_Gallery_smartadapt");' ) );