<?php
/*
Template Name: All Posts
*/
get_header();
the_brand_header();
?>
<div class="container">
	<div class="row">
<?php
$args = array(
	'post_type' => 'post',
	'posts_per_page' => -1
);
$thequery = new WP_Query( $args );
while($thequery->have_posts()){
	$thequery->the_post();
	?>
    <a href="<?php echo get_the_permalink(); ?>"><h3 class="archive_post_title"><?php echo get_the_title() . ' | ' . get_the_date() ?></h3></a>
	<?php
}
?>
	</div>
</div>
<?php
get_footer();