<?php
/*
Template Name: Michael
*/
?>
<?php
get_header();
?>
	<div class="container">

		<?php
		while(have_posts()){
			the_post();
			while(have_rows('photo_repeater')){
				the_row();
				?>
			<div class="row">
					<div class="brg_photo_wrap">
						<img src="<?php echo get_sub_field('image'); ?>">
					</div>
			</div>
				<?php
			}
		}
		?>
		</div>
	</div>
<?php get_footer();
