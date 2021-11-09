<?php

require_once 'widgets/share.php';

add_action( 'widgets_init', 'rmr_register_widgets' );

/**
 * Register custom widgets for https://roelmagdaleno.com
 * Use an array of widget names to loop it using foreach or array_map.
 *
 * @since 0.2.7
 */
function rmr_register_widgets() {
	$widgets = array(
		'RMR_Share',
	);

	array_map( 'register_widget', $widgets );
}

