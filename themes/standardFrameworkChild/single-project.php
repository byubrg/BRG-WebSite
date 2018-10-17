<?php
get_header();
the_brand_header();
echo 'hey';
if(have_rows("members")){
	while(have_rows()){
		the_row();
		echo 'this ';
	}
}
?>
	<div class="portrait_wrapper xlg-col-3 lg-col-3 mlg-col-2 med-col-2 sm-col-1-gutter-1 sm-offset-left-col-0-gutter-2 ssm-offset-left-col-0-gutter-2 ssm-col-1-gutter-0-inner-1">
		<img src="<?php echo get_field( 'portrait' ) ?>">
	</div>
<?php get_footer();