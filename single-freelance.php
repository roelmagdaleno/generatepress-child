<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

get_header();

$logo_link   = get_post_meta( $post->ID, 'rmr_project_logo_link', true );
$overview    = get_post_meta( $post->ID, 'rmr_project_overview', true );
$location    = get_post_meta( $post->ID, 'rmr_project_location', true );
$industry    = get_post_meta( $post->ID, 'rmr_project_industry', true );
$website     = get_post_meta( $post->ID, 'rmr_project_website', true );
$duration    = get_post_meta( $post->ID, 'rmr_project_duration', true );
$total_lines = get_post_meta( $post->ID, 'rmr_project_total_lines', true );
$results     = get_post_meta( $post->ID, 'rmr_project_results', true );

?>

<header class="rmr-customer__header">
	<div class="rmr-container rmr-mx-auto rmr-no-margin--p">
		<section class="rmr-project__header">
			<img src="<?php echo $logo_link; ?>" alt="Company Logo">

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

    <div class="rmr-results">
        <div class="rmr-collapse-data">
	        <?php

	        foreach ( $results['title'] as $index => $title ) {
		        echo '<div class="rmr-collapsible">';
		        echo '<input type="radio" name="rmr-collapsibles" id="rmr-collapsible--' . $index . '">';
		        echo '<label for="rmr-collapsible--' . $index . '" class="rmr-collapsible__title">' . $title . '</label>';
		        echo '<div class="rmr-collapsible__content"> <p>' . $results['content'][ $index ] . '</p> </div>';
		        echo '</div>';
	        }

	        ?>
        </div>

        <div class="rmr-results--right">
            <div class="rmr-results-totals">
                <div class="rmr-total">
                    <p><?php echo $duration ?></p>
                    <p>DURACIÓN</p>
                </div>

                <div class="rmr-total">
                    <p><?php echo $total_lines ?></p>
                    <p>LÍNEAS DE CÓDIGO</p>
                </div>
            </div>

            <div class="rmr-results-technologies">
                hola
            </div>
        </div>
    </div>
</section>

<?php get_footer();
