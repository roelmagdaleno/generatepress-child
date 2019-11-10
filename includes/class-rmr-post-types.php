<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'RMR_Post_Types' ) ) {
	/**
	 * Process all related child theme post types.
	 *
	 * @since 0.1.0
	 */
	class RMR_Post_Types {
		/**
		 * Initialize the actions and filters hooks to setup
		 * the theme child post types.
		 *
		 * @since 0.1.0
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'setup_post_types' ) );
		}

		/**
		 * Register the "Freelance Works" post type.
		 *
		 * This post type will contain only the title, comments and
		 * custom fields. We don't need anything else.
		 *
		 * @since 0.1.0
		 */
		public function setup_post_types() {
			$args = array(
				'public'               => true,
				'label'                => 'Freelance Works',
				'menu_icon'            => 'dashicons-book',
				'supports'             => array( 'title', 'editor' ),
				'register_meta_box_cb' => array( $this, 'add_metaboxes' ),
			);

			register_post_type( 'rmr_freelance', $args );
		}

		/**
		 * Add the "Freelance Works" post type metaboxes.
		 *
		 * It will render the:
		 *
		 * - Project Duration.
		 * - Total Lines of Code.
		 *
		 * @since 0.1.0
		 */
		public function add_metaboxes() {
			$metaboxes = array(
				'rmr_project_duration'    => array(
					'title' => 'Project Duration',
					'args'  => array(
						'type' => 'text',
					),
				),
				'rmr_project_total_lines' => array(
					'title' => 'Total Lines of Code',
					'args'  => array(
						'type' => 'number',
					),
				),
			);

			foreach ( $metaboxes as $metabox_id => $metabox ) {
				add_meta_box(
					$metabox_id,
					$metabox['title'],
					'rmr_render_field',
					'rmr_freelance',
					'normal',
					'default',
					$metabox['args']
				);
			}
		}
	}
}
