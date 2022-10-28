<div class="rmr-entry-meta">
	<div class="meta-author-avatar">
		<img src="https://cdn.roelmagdaleno.com/assets/uploads/2019/08/ZHFS36po_400x400.jpg"
			 loading="lazy"
			 alt="Roel Magdaleno"
			 width="90"
			 height="90"
		>
	</div>

	<div class="entry-post-meta">
		<p class="entry-post__name" itemprop="name">
			<?php echo get_the_author_meta( 'display_name' ); ?>
		</p>

		<div class="rmr-post-date">
			<p class="entry-post__single-post">
				Publicado el <span class="entry-date published"
								   datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"
								   itemprop="datePublished"><?php echo esc_html( get_the_date() ); ?></span>
			</p>

			<?php

			$updated_time   = get_the_modified_time( 'U' );
			$published_time = strtotime( '+1 day', get_the_time( 'U' ) );

			if ( $updated_time > $published_time ) {
				echo '<span class="rmr-post-date__dot">•</span>';
				echo '<p class="entry-post__single-post">Actualizado el <span class="entry-date updated" datetime="' . esc_attr( get_the_modified_date( 'c' ) ) . '" itemprop="dateModified">' . esc_html( get_the_modified_date() ) . '</span></p>';
			}

			?>
		</div>
	</div>
</div>
