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
			add_action( 'save_post', array( $this, 'save_metabox_data' ), 10, 2 );
		}

		/**
		 * Save all metaboxes data only for those users
		 * that can edit a post.
		 *
		 * @since 0.1.0
		 *
		 * @param int       $post_id   The current post id.
		 * @param WP_Post   $post
		 *
		 * @return int|void
		 */
		public function save_metabox_data( $post_id, WP_Post $post ) {
			if ( 'freelance' !== $post->post_type || ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}

			$metaboxes_ids = array(
				'rmr_project_technologies',
				'rmr_project_results',
				'rmr_project_logo_link',
				'rmr_project_overview',
				'rmr_project_location',
				'rmr_project_industry',
				'rmr_project_website',
				'rmr_project_duration',
				'rmr_project_total_lines',
			);

			foreach ( $metaboxes_ids as $metabox_id ) {
				if ( 'revision' === $post->post_type ) {
					break;
				}

				if ( ! isset( $_POST[ $metabox_id ] ) ) {
					continue;
				}

				$metabox_value = is_array( $_POST[ $metabox_id ] ) ? $_POST[ $metabox_id ] : sanitize_text_field( $_POST[ $metabox_id ] );
				update_post_meta( $post_id, $metabox_id, $metabox_value );
			}
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
				'show_ui'              => true,
				'show_in_menu'         => true,
				'supports'             => array( 'title', 'editor' ),
				'register_meta_box_cb' => array( $this, 'add_metaboxes' ),
			);

			register_post_type( 'freelance', $args );
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
				'rmr_project_technologies' => array(
					'title' => 'Technologies Used',
					'args'  => array(
						'type' => 'collapse',
					),
				),
				'rmr_project_logo_link'    => array(
					'title' => 'Logo Link',
					'args'  => array(
						'type' => 'text',
					),
				),
				'rmr_project_overview'     => array(
					'title' => 'Overview',
					'args'  => array(
						'type' => 'text',
					),
				),
				'rmr_project_location'     => array(
					'title' => 'Location',
					'args'  => array(
						'type' => 'text',
					),
				),
				'rmr_project_industry'     => array(
					'title' => 'Industry',
					'args'  => array(
						'type' => 'text',
					),
				),
				'rmr_project_website'      => array(
					'title' => 'Website',
					'args'  => array(
						'type' => 'text',
					),
				),
				'rmr_project_duration'     => array(
					'title' => 'Project Duration',
					'args'  => array(
						'type' => 'text',
					),
				),
				'rmr_project_total_lines'  => array(
					'title' => 'Total Lines of Code',
					'args'  => array(
						'type' => 'number',
					),
				),
				'rmr_project_results'      => array(
					'title' => 'Results',
					'args'  => array(
						'type' => 'collapse',
					),
				),
			);

			foreach ( $metaboxes as $metabox_id => $metabox ) {
				add_meta_box(
					$metabox_id,
					$metabox['title'],
					'rmr_render_field',
					'freelance',
					'normal',
					'default',
					$metabox['args']
				);
			}
		}
	}
}
