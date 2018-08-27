<?php
class Favorites_Widget extends WP_Widget {
	/**
	 * Sets up the widgets name etc
	 * 
	 */
	public function __construct() {
		$args = [
			'name' => 'Favorite records',
			'description' => 'Widget shows favorite records for user',
		];
			
		
		parent::__construct( 'favorites-widget', ' ', $args );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		// outputs the content of the widget
		if(!is_user_logged_in()) return;
		echo $args['before_widget'];
		echo $args['before_title'];
		echo $instance['title'];
		echo $args['after_title'];
		show_dashboard_widget();
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
		extract($instance);
		$title = !empty($title) ? esc_attr($title) : 'your favorites default';
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title') ?>">Title:</label>
			<input type="text" name="<?php echo $this->get_field_name('title') ?>" value="<?php echo $title ?>" id="<?php echo $this->get_field_id('title') ?>" class="widefat">	
		</p>
		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 *
	 * @return array
	 */
//	public function update( $new_instance, $old_instance ) {
//		// processes widget options to be saved
//	}
}
