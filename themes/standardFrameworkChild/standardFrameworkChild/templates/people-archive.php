<?php
/*
Template Name: People
*/
?>
<?php
get_header();
the_brand_header();
$args = array(
	'post_type' => 'people',
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
		<div class="portrait_wrapper xlg-col-3 lg-col-3 mlg-col-2 med-col-2 sm-col-1-gutter-1 sm-offset-left-col-0-gutter-2 ssm-offset-left-col-0-gutter-2 ssm-col-1-gutter-0-inner-1">
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
