<?php

require_once 'widgets/share.php';

add_action( 'widgets_init', 'rmr_register_widgets' );
function rmr_register_widgets() {
	$widgets = array(
		'RMR_Share',
	);

	array_map( 'register_widget', $widgets );
}

