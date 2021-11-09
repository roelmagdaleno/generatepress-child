<?php

class RMR_Share extends WP_Widget {
	/**
	 * Initialize share widget functionality.
	 *
	 * @since 0.2.7
	 */
	public function __construct() {
		$widget_options = array(
			'description' => 'Simple way to render share buttons.',
		);

		parent::__construct( 'rmr_share', 'Share Buttons', $widget_options );
	}

	/**
	 * Echoes the widget content.
	 *
	 * Subclasses should override this function to generate their widget code.
	 *
	 * @since 0.2.7
	 *
	 * @param array   $args       Display arguments.
	 * @param array   $instance   The settings for the particular instance of the widget.
	 */
	public function widget( $args, $instance ) {
		if ( is_home() ) {
			return;
		}

		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $args['before_widget'];

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		include_once dirname( __DIR__ ) . '/views/share.php';
		echo $args['after_widget'];
	}

	/**
	 * Outputs the settings update form.
	 *
	 * @since 0.2.7
	 *
	 * @param  array   $instance   Current settings.
	 */
	public function form( $instance ) {
		$title = $instance['title'] ?? 'New Title';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php _e( 'Title:' ); ?>
			</label>
			<input class="widefat"
			       id="<?php echo $this->get_field_id( 'title' ); ?>"
			       name="<?php echo $this->get_field_name( 'title' ); ?>"
			       type="text"
			       value="<?php echo esc_attr( $title ); ?>"
			/>
		</p>
		<?php
	}

	/**
	 * Updates a particular instance of a widget.
	 *
	 * This function should check that `$new_instance` is set correctly. The newly-calculated
	 * value of `$instance` should be returned. If false is returned, the instance won't be
	 * saved/updated.
	 *
	 * @since  0.2.7
	 *
	 * @param  array   $new_instance New settings for this instance as input by the user via WP_Widget::form().
	 * @param  array   $old_instance Old settings for this instance.
	 * @return array   Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) : array {
		$instance          = array();
		$instance['title'] = ! empty( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}
}
