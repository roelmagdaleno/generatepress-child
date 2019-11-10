<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

get_header();

$overview    = get_post_meta( $post->ID, 'rmr_project_overview', true );
$location    = get_post_meta( $post->ID, 'rmr_project_location', true );
$industry    = get_post_meta( $post->ID, 'rmr_project_industry', true );
$website     = get_post_meta( $post->ID, 'rmr_project_website', true );
$duration    = get_post_meta( $post->ID, 'rmr_project_duration', true );
$total_lines = get_post_meta( $post->ID, 'rmr_project_total_lines', true );

?>

<header class="rmr-customer__header">
	<div class="rmr-container rmr-mx-auto rmr-no-margin--p">
		<section class="rmr-project__header">
			<img src="https://www.scadip.com/wp-content/uploads/2019/03/log1-180x82.png" alt="Scadip Logo">

			<p class="rmr-project__header-description">
                <?php echo $overview; ?>
			</p>
		</section>

		<section class="rmr-project__meta">
			<div class="rmr-project__meta__data">
				<p>Ubicación</p>
				<p><?php echo $location; ?></p>
			</div>

			<div class="rmr-project__meta__data">
				<p>Industria</p>
				<p><?php echo $industry; ?></p>
			</div>

			<div class="rmr-project__meta__data">
				<p>Sitio Web</p>
				<p>
					<a href="https://<?php echo $website; ?>" target="_blank"><?php echo $website; ?></a>
				</p>
			</div>
		</section>
	</div>
</header>

<section class="rmr-container rmr-mx-auto rmr-body">
	<?php echo wpautop( $post->post_content ); ?>
</section>

<?php get_footer();
