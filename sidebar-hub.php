<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;

$args = array(
	'posts_per_page' => -1,
	'post_parent'    => $post->post_parent,
	'post_type'      => 'hub',
	'order'          => 'ASC',
	'orderby'        => 'menu_order',
);

$children = get_children( $args );

?>

<div id="right-sidebar" <?php generate_do_element_classes( 'right_sidebar' ); ?>>
	<div class="inside-right-sidebar">
		<div class="rmr-hub-sidebar">
			<aside class="widget inner-padding">
				<h2 class="widget-title">Recursos</h2>

				<ul class="rmr-hub-resources">
					<?php

					foreach ( $children as $child ) {
						$current = $child->ID === $post->ID ? 'rmr-hub-current' : '';
						?>

						<li class="<?php echo esc_attr( $current ); ?>">
							<svg xmlns="http://www.w3.org/2000/svg" class="rmr-hub-chevron" viewBox="0 0 20 20" fill="currentColor">
								<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
							</svg>
							<a href="<?php echo esc_attr( get_permalink( $child ) ); ?>">
								<?php echo esc_html( $child->post_title ); ?>
							</a>
						</li>

						<?php
					}

					?>
				</ul>
			</aside>

			<aside class="widget inner-padding widget_a2a_share_save_widget">
				<h2 class="widget-title">¿Aprendiste? ¡Compártelo!</h2>

				<?php

				if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) {
					ADDTOANY_SHARE_SAVE_KIT();
				}

				?>
			</aside>
		</div>
	</div>
</div>
