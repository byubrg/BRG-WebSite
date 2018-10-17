<?php
/*
Template Name: The Projects
*/
?>
<?php
get_header();
the_brand_header();
$args = array(
	'post_type' => 'projects',
	'posts_per_page' => -1
);

$thequery = new WP_Query( $args );
?>
	<div class="container">
		<div class="row">

			<?php
			if ( $thequery->have_posts() ) {
				while ( $thequery->have_posts() ) {
					$thequery->the_post();
					?>
					<div class="portrait_wrapper xlg-col-3 lg-col-3 mlg-col-2 med-col-2 sm-col-2 ssm-col-2">
						<a class="portrait_tag" href="<?php echo get_permalink() ?>">
							<img src="<?php echo get_field( 'portrait') ?>">
							<p class="member_name"><?php echo get_the_title() ?></p>
						</a>
					</div>
					<?php
				}
			}
			?>
		</div>
	</div>
<?php get_footer();
