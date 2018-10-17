<?php
/*
Template Name: Colors
*/

function display_colow_row__square() {
	while ( have_rows( 'colors' ) ) { the_row();
		$background_color = 'background-color:' . get_sub_field( 'hex' ) . ';';
		$font_color = 'color:' . get_sub_field( 'font_display_color' ) . ';';
		$outline = '';
		if ( get_sub_field( 'outline' ) ) {
			$outline = 'border:1px solid #9B9B9B;';
		}
		$hex_color = 'Hex# ' . str_replace( '#', '', get_sub_field( 'hex' ) );
		$rgb_color = 'RGB: R ' . get_sub_field( 'red' ) . ' G ' . get_sub_field( 'green' ) . ' B ' . get_sub_field( 'blue' );
		$cmyk_color = 'CMYK: ' . get_sub_field( 'cyan' ) . ' | ' . get_sub_field( 'magenta' ) . ' | ' . get_sub_field( 'yellow' ) . ' | ' . get_sub_field( 'black' );
		?>

		<article class="color-row__color color-row__color--square" style="<?php echo esc_attr( $background_color . $font_color . $outline ); ?>">
			<h3 class="color-row__color__name" style="<?php echo esc_attr( $font_color ); ?>"><?php the_sub_field( 'color_name' ); ?></h3>
			<span class="color-row__color__hex"><?php echo esc_html( $hex_color ); ?></span><br>
			<span class="color-row__color__rgb"><?php echo esc_html( $rgb_color ); ?></span><br>
			<span class="color-row__color__cmyk"><?php echo esc_html( $cmyk_color ); ?></span>
		</article>

		<?php
	}
}
function display_colow_row__opacity_circle() {
	while ( have_rows( 'colors' ) ) { the_row();
		$background_color = 'background-color:' . get_sub_field( 'hex' ) . ';';
		$outline = '';
		if ( get_sub_field( 'outline' ) ) {
			$outline = 'border:1px solid #9B9B9B;';
		}
		$opacity = 'opacity:.2;';
		$hex_color = get_sub_field( 'hex' );
		$opacity_hex = get_sub_field( 'opacity_hex' );
		?>

		<article class="color-row__color color-row__color--opacity-circle">
			<div class="color-row__color__info-wrap--opacity-circle-desktop">
				<h3 class="color-row__color__name"><?php the_sub_field( 'color_name' ); ?></h3>
				<span class="color-row__color__hex"><?php echo esc_html( $hex_color ); ?></span>
			</div>
			<div class="color-row__color__circle" style="<?php echo esc_attr( $background_color . $outline ); ?>"></div>
			<div class="color-row__color__sub-square--mobile">
				<div class="color-row__color__sub-square" style="<?php echo esc_attr( $background_color . $outline . $opacity ); ?>"></div>
				<div class="color-row__color__sub-square-label">
					<span><b><em>Opacity</em></b> <br><?php echo $opacity_hex; ?></span>
				</div>

				<div class="color-row__color__info-wrap--opacity-circle-mobile
				sm-col-1 sm-offset-left-col-1
				ssm-col-1 ssm-offset-left-col-1-gutter-2">
					<h3 class="color-row__color__name"><?php the_sub_field( 'color_name' ); ?></h3>
					<span class="color-row__color__hex"><?php echo esc_html( $hex_color ); ?></span>
				</div>
				<span class="color-row__color__info-wrap--opacity-circle-mobile__divider
				 sm-col-0-gutter-2 sm-offset-left-col-2-gutter-2
				ssm-col-0-gutter-2 ssm-offset-left-col-2-gutter-0-inner-1" />

			</div>

		</article>

		<?php
	}
}
function display_colow_row__circle() {
	while ( have_rows( 'colors' ) ) { the_row();
		$background_color = 'background-color:' . get_sub_field( 'hex' ) . ';';
		$outline = '';
		if ( get_sub_field( 'outline' ) ) {
			$outline = 'border:1px solid #9B9B9B;';
		}
		$opacity = 'opacity:.2;';
		$hex_color = get_sub_field( 'hex' );
		?>

		<article class="color-row__color color-row__color--circle">
			<div class="color-row__color__info-wrap">
			<h3 class="color-row__color__name"><?php the_sub_field( 'color_name' ); ?></h3>
			<span class="color-row__color__hex"><?php echo esc_html( $hex_color ); ?></span>
			</div>
			<div class="color-row__color__circle" style="<?php echo esc_attr( $background_color . $outline ); ?>"></div>
		</article>

		<?php
	}
}

?>
<?php get_header();
the_brand_header();


/* Get the pages sibling pages in order to populate the sub-nav */
$post_id = get_the_ID();
$parent_id = wp_get_post_parent_id( $post_id );
$siblings = get_siblings( $parent_id );
$current_url = get_the_permalink( $post_id );

?>
	<section class="sibling-page-tabs
xlg-col-10 xlg-offset-right-col-1
lg-col-10 lg-offset-right-col-1
mlg-col-6 mlg-offset-right-col-0-gutter-1
ssm-no-padding
sm-no-padding">
		<div class="container
ssm-no-padding
sm-no-padding">
			<?php the_sub_page_tabs( $siblings, $current_url ); ?>
		</div>
	</section>


<section class="lg-offset-left-col-1-gutter-2 lg-col-10">
<?php
if ( get_field( 'intro_text' ) && get_field( 'intro_text' ) !== '' ) { ?>
	<section class="standard-text-section">
		<div class="container standard-body-copy">
			<?php the_field( 'intro_text' ); ?>
		</div>
	</section>
	<?php
} ?>

	<section class="color-rows">
		<div class="container">

			<?php
			if ( have_rows( 'color_rows' ) ) { ?>
				<?php
				while ( have_rows( 'color_rows' ) ) { the_row(); ?>

					<section class="color-row">
						<span class="standard-body-copy"><h2 class="color-row__heading"><?php the_sub_field( 'row_heading' ); ?></h2></span>
						<div class="color-row__text-wrap standard-body-copy">
							<?php //the_sub_field( 'row_content' ); ?>
						</div>

						<div class="color-row__colors-wrap">

							<?php
							if ( get_row_layout() === 'square' ) {

								display_colow_row__square();

							} elseif ( get_row_layout() === 'opacity_circle' ) {

								display_colow_row__opacity_circle();

							} elseif ( get_row_layout() === 'circle' ) {

								display_colow_row__circle();

							}
							?>
						</div>

						<?php
						if ( get_sub_field( 'row_content_after' ) && get_sub_field( 'row_content_after' ) !== '' ) { ?>
							<div class="color-row__text-wrap standard-body-copy">
								<?php //the_sub_field( 'row_content_after' ); ?>
							</div>
							<?php
						} ?>

					</section>

					<?php
				}// End while().
	?>
				<?php
			}// End if().
	?>
			<div>
	</section>
</section>

<?php get_footer();
