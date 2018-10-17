<?php
get_header();
the_brand_header();
$people = get_field('members');
?>
	<div class="container">
		<div class="row">
			<div class="person-bio xlg-col-10 xlg-offset-left-col-1 lg-col-10 lg-offset-left-col-1 mlg-col-4 mlg-offset-left-col-1 med-col-4 med-offset-left-col-1 sm-col-4 ssm-col-4">
				<?php the_field('description') ?>
			</div>
<?php
foreach($people as $person){
	?>
			<div class="portrait_wrapper xlg-col-3 lg-col-3 mlg-col-2 med-col-2 sm-col-1-gutter-1 sm-offset-left-col-0-gutter-2 ssm-offset-left-col-0-gutter-2 ssm-col-1-gutter-0-inner-1">
				<a class="portrait_tag" href="<?php echo get_permalink($person) ?>">
					<img src="<?php echo get_field( 'portrait',$person) ?>">
					<p class="member_name"><?php echo get_the_title($person) ?></p>
				</a>
			</div>
			<?php
}
?>
		</div>
	</div>
<?php get_footer();