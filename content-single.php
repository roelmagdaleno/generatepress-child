<?php
/**
 * The template for displaying single posts.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php generate_do_microdata( 'article' ); ?>>
	<div class="inside-article">
		<?php
		/**
		 * generate_before_content hook.
		 *
		 * @since 0.1
		 *
		 * @hooked generate_featured_page_header_inside_single - 10
		 */
		do_action( 'generate_before_content' );

		if ( generate_show_entry_header() ) :
			?>
			<header class="entry-header">
				<?php
				/**
				 * generate_before_entry_title hook.
				 *
				 * @since 0.1
				 */
				do_action( 'generate_before_entry_title' );

				if ( generate_show_title() ) {
					$params = generate_get_the_title_parameters();

					the_title( $params['before'], $params['after'] );
				}

				/**
				 * generate_after_entry_title hook.
				 *
				 * @since 0.1
				 *
				 * @hooked generate_post_meta - 10
				 */
				// do_action( 'generate_after_entry_title' );
				?>

				<div class="rmr-entry-meta">
					<div class="meta-author-avatar">
						<img src="https://cdn.roelmagdaleno.com/assets/2019/08/ZHFS36po_400x400.jpg"
							 loading="lazy"
							 alt="Roel Magdaleno"
							 width="90"
							 height="90"
						>
					</div>

					<div class="entry-post-meta">
						<span class="entry-post__name" itemprop="name">
							<?php echo get_the_author_meta( 'display_name' ); ?>
						</span>

						<p class="entry-post__single-post">
							Publicado el <span class="entry-date published" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" itemprop="datePublished"><?php echo esc_html( get_the_date() ); ?></span>
						</p>

						<div class="entry-post__misc">
							<div class="entry-author__social">
								<a href="https://github.com/roelmagdaleno/" target="_blank" rel="noreferrer noopener">
									<svg class="octicon octicon-mark-github v-align-middle" height="20" viewBox="0 0 16 16" width="20" aria-hidden="true"><path fill-rule="evenodd" d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0016 8c0-4.42-3.58-8-8-8z"></path></svg>
								</a>

								<a href="https://twitter.com/roelmagdaleno/" target="_blank" rel="noreferrer noopener">
									<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
								</a>
							</div>
							<div class="entry-author__est">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="25" height="25">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
								</svg>

								<span>
									<?php echo rmr_get_estimated_reading_time( get_the_content() ); ?> min de lectura
								</span>
							</div>
						</div>
					</div>
				</div>
			</header>
		<?php
		endif;

		/**
		 * generate_after_entry_header hook.
		 *
		 * @since 0.1
		 *
		 * @hooked generate_post_image - 10
		 */
		do_action( 'generate_after_entry_header' );

		$itemprop = '';

		if ( 'microdata' === generate_get_schema_type() ) {
			$itemprop = ' itemprop="text"';
		}
		?>

		<div class="entry-content"<?php echo $itemprop; // phpcs:ignore -- No escaping needed. ?>>
			<?php
			the_content();

			?>

			<div class="rmr-author-bio">
				<div class="rmr-author-bio__avatar">
					<img src="https://cdn.roelmagdaleno.com/assets/2019/08/ZHFS36po_400x400.jpg"
						 loading="lazy"
						 alt="Roel Magdaleno"
						 width="90"
						 height="90"
					>
				</div>
				<div class="rmr-author-bio__bio">
					<strong class="rmr-author-bio__written-by">
						Escrito por <?php echo get_the_author_meta( 'display_name' ); ?>
					</strong>
					<p><?php echo get_the_author_meta( 'description' ); ?></p>
				</div>
			</div>

			<?php

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'generatepress' ),
					'after'  => '</div>',
				)
			);
			?>
		</div>

		<?php
		/**
		 * generate_after_entry_content hook.
		 *
		 * @since 0.1
		 *
		 * @hooked generate_footer_meta - 10
		 */
		do_action( 'generate_after_entry_content' );

		/**
		 * generate_after_content hook.
		 *
		 * @since 0.1
		 */
		do_action( 'generate_after_content' );
		?>
	</div>
</article>
