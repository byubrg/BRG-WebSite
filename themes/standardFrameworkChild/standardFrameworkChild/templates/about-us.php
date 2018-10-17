<?php
/*
Template Name: About BRG
*/
?>
<?php
get_header();
the_brand_header();?>
	<div class="container">
		<div class="row">
			<div class="about-us">
				<?php
				if(have_posts()){
					while(have_posts()){
						the_post();
						echo get_the_content();
					}
				}
?>
			</div>
		</div>
	</div>
<?php get_footer();