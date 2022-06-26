<?php

if ( empty( $related_posts ) ) {
	$related_posts = array();
}

?>

<div class="rmr-related-posts__wrap">
	<h3 class="rmr-related-post__main-title">Artículos relacionados</h3>
	<div class="rmr-related-posts">
		<?php

		foreach ( $related_posts as $related_post ) {
			$permalink = get_permalink( $related_post );
			?>

			<div class="rmr-related-post">
				<div class="rmr-related-post__featured-image">
					<a href="<?php echo $permalink; ?>" title="<?php echo $related_post->post_title; ?>">
						<?php echo get_the_post_thumbnail( $related_post, 'medium' ); ?>
					</a>
				</div>
				<div class="rmr-related-post__post">
					<div class="rmr-related-post__title">
						<h4>
							<a href="<?php echo $permalink; ?>" title="<?php echo $related_post->post_title; ?>">
								<?php echo $related_post->post_title; ?>
							</a>
						</h4>
					</div>
					<div class="rmr-related-post__summary">
						<p><?php echo get_the_excerpt( $related_post ); ?></p>
					</div>
				</div>
			</div>

			<?php
		}
		?>
	</div>
</div>
