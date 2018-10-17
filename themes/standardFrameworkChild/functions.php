<?php

add_action( 'wp_enqueue_scripts', 'start_enqueue_scripts' );
function start_enqueue_scripts() {

	$css_dir = get_stylesheet_directory_uri() . '/lib/css';
	$js_dir = get_stylesheet_directory_uri() . '/lib/js';

	// For all of the pages
	wp_enqueue_script( 'json2', null, null, false, true );
	wp_enqueue_script( 'jquery', null, array( ' json2 ' ), false, true );
	wp_enqueue_style( 'general-css', $css_dir . '/general.css',null, $version_number );
	wp_enqueue_style( 'sub-page-css', $css_dir . '/child-pages.css',null, $version_number );

	// Use accordion from PG_Standard_Framework_Parent
	pgsf_use_accordion();
	pgsf_use_accordion_skin( array( 1 ) );
	if ( true === is_404() || true === is_page( array( 'home', 'Home' ) ) ) {
		wp_enqueue_style( 'front-page-css', $css_dir . '/front-page.css',null, $version_number );
		wp_enqueue_script( 'byu_terms-js', $js_dir . '/pages/byu_terms.js', array( 'jquery' ), $version_number, true );
	}// End if().
    wp_enqueue_style( 'people-archive-css', $css_dir . '/people-archive.css',null, time() );
}
// Remove support for emojis from the site since they aren't needed and require additional js.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/**
 * Display the correct page header based on the page being displayed
 */
function the_brand_header() {

	$post_ID = get_the_ID();
	$parent_id = wp_get_post_parent_id( $post_ID );
	$parent_title = get_the_title( $parent_id );

	if ( true === is_page( array( 'home', 'Home' ) ) ) {?>
		<section class="brand_header_section">
			<?php $hero = get_field( 'header_image' ); ?>
			<div class="brand_page-header__image-wrap">
				<img src="<?php echo esc_url( $hero['url'] ); ?>" alt="<?php esc_attr( $hero['alt'] ); ?>">
			</div>
			<div class="brand_home_header_title_wrap">
				<center><h1>Bioinformatics Research Group</h1></center>
			</div>
		</section>
		<?php
	} else { ?>
		<section class="brand_page-header">
			<?php $hero = get_field( 'header_image' ); ?>
			<div class="brand_page-header__image-wrap">
				<img src="<?php echo esc_url( $hero['url'] ); ?>" alt="<?php esc_attr( $hero['alt'] ); ?>">
			</div>

			<?php // Note that this is duplicated so that there can lower opacity in the background and keep full opacity in the Text ?>
			<div class="brand_page-header__title-wrap brand_page-header__title-wrap--transparent">
				<?php if ( $parent_title !== get_the_title() ) {  ?><h2> <?php echo esc_html( $parent_title ); ?> </h2> <?php } ?>
				<h1><?php echo esc_html( get_the_title() ); ?></h1>
			</div>
			<div class="brand_page-header__title-wrap brand_page-header__title-wrap--text">
				<?php if ( $parent_title !== get_the_title() ) {  ?><h2> <?php echo esc_html( $parent_title ); ?> </h2> <?php } ?>
				<h1><?php echo esc_html( get_the_title() ); ?></h1>
			</div>
		</section>

	<?php
	}
}

function the_sub_page_tabs( $page_names, $current_url ) {
	?>
	<section>
		<div class="container
                    ssm-no-padding
                    sm-no-padding">
			<nav class="nav-buttons">
				<?php
				foreach ( $page_names as $page_title => $url ) {
					if ( $current_url === $url ) {
						?>
						<a class='nav-buttons__button nav-buttons__button--byu-blue' href='<?php echo esc_html( $url ); ?>'><?php echo esc_attr( $page_title ); ?></a>
					<?php } else { ?>
						<a class='nav-buttons__button' href='<?php echo esc_html( $url ); ?>'><?php echo esc_attr( $page_title ); ?></a>
					<?php }
				} ?>
			</nav>
		</div>
	</section>
	<?php
}

/**
 * Takes id of parent page, access it's ACF field for navigation to it's children and returns the page title & page link as a key value array
 * @param $parent_id the id of the page whose links you need
 *
 * @return array of children pages of the $parent_id parameter, format: title => url;
 */
function get_siblings( $parent_id ) {
	if(have_rows('divider_page_links', $parent_id)) {
        while(have_rows('divider_page_links', $parent_id )) {
            the_row();
	        $sibling_pages[ get_sub_field( 'link_text') ] = get_sub_field( 'box_link_url');
        }
	}
	return $sibling_pages;
}
// registers and add supports to Speaker post type
add_action( 'init', 'add_people' );
function add_people() {
	flush_rewrite_rules();
	$singleUppercase = "Person";
	$pluralUppercase = "People";

	$pluralLowercase = "people";

	$labels = array(
		'add_new_item'       => 'Add New ' . $singleUppercase,
		'new_item'           => 'New ' . $singleUppercase,
		'edit_item'          => 'Edit ' . $singleUppercase,
		'view_item'          => 'View ' . $singleUppercase,
		'all_items'          => 'All ' . $pluralUppercase,
		'search_items'       => 'Search ' . $pluralUppercase,
		'parent_item_colon'  => 'Parent ' . $pluralUppercase . ':',
		'not_found'          => 'No ' . $pluralLowercase . ' found.',
		'not_found_in_trash' => 'No ' . $pluralLowercase . ' found in Trash.'
	);

	$args = array(
		'label' => $pluralUppercase,
		'labels' => $labels,
		'public' => true,
		'supports' => array('thumbnail', 'title', 'editor'),
		'taxonomies' => array(),
		'menu_icon' => 'dashicons-businessman',
		'hierarchical' => false,
		'menu_position' => 5,
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'people'),
	);
	register_post_type( 'people', $args );
}

/* START
Managing the columns and the filtering of the main dashboard menus of the CPT "Speech"
*/

/* NEW
* Registers new admin columns
*/
add_filter('manage_speaker_posts_columns', 'manage_speaker_table_head');
function manage_speaker_table_head( $defaults ) {
	$defaults['portrait'] = 'portrait';
	return $defaults;
}

/* NEW
* Registers Method for finding the data for the new admin columns
*/
add_action( 'manage_speaker_posts_custom_column', 'manage_speaker_table_content', 10, 2 );
function manage_speaker_table_content( $column_name, $post_id ) {
	if ($column_name == 'portrait') {
		$image = wp_get_attachment_url( get_post_thumbnail_id($post_id) );
		if($image) { ?>
            <img width="100" src="<?php echo $image; ?>">
			<?php
		}
	}

}

add_action( 'init', 'add_project' );
function add_project() {

	$singleUppercase = "Project";
	$pluralUppercase = "Projects";

	$pluralLowercase = "projects";

	$labels = array(
		'add_new_item'       => 'Add New ' . $singleUppercase,
		'new_item'           => 'New ' . $singleUppercase,
		'edit_item'          => 'Edit ' . $singleUppercase,
		'view_item'          => 'View ' . $singleUppercase,
		'all_items'          => 'All ' . $pluralUppercase,
		'search_items'       => 'Search ' . $pluralUppercase,
		'parent_item_colon'  => 'Parent ' . $pluralUppercase . ':',
		'not_found'          => 'No ' . $pluralLowercase . ' found.',
		'not_found_in_trash' => 'No ' . $pluralLowercase . ' found in Trash.'
	);

	$args = array(
		'label' => $pluralUppercase,
		'labels' => $labels,
		'public' => true,
		'supports' => array('thumbnail', 'title', 'editor'),
		'taxonomies' => array(),
		'menu_icon' => 'dashicons-businessman',
		'hierarchical' => false,
		'menu_position' => 5,
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'projects'),
	);
	register_post_type( 'projects', $args );
}

add_action( 'init', 'add_type_taxonomy', 0 );
function add_type_taxonomy() {

	$singleUppercase = 'Type';
	$pluralUppercase = 'Types';

	$singleLowercase = 'type';
	$pluralLowercase = 'types';

	$labels = array(
		'name'                       => _x( $singleUppercase, 'taxonomy general name' ),
		'singular_name'              => _x( $singleLowercase, 'taxonomy singular name' ),
		'search_items'               => __( 'Search ' . $pluralUppercase ),
		'popular_items'              => __( 'Popular ' . $pluralUppercase ),
		'all_items'                  => __( 'All ' . $pluralUppercase ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit ' . $singleUppercase ),
		'update_item'                => __( 'Update ' . $singleUppercase ),
		'add_new_item'               => __( 'Add New ' . $singleUppercase ),
		'new_item_name'              => __( 'New ' . $singleUppercase . ' Name' ),
		'separate_items_with_commas' => __( 'Separate ' . $pluralUppercase . ' with commas' ),
		'add_or_remove_items'        => __( 'Add or remove ' . $singleLowercase ),
		'choose_from_most_used'      => __( 'Choose from the most used ' . $pluralLowercase ),
		'not_found'                  => __( 'No ' . $pluralLowercase . ' found.' ),
		'menu_name'                  => __( $singleUppercase ),
	);
	$args = array(
		'hierarchical'          => true, // This being true makes this taxonomy behave like a category, with a heirarchy, false is a like a tag
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'type' ),
	);
	$types = array('people'); // A list of the CPT's that are to use this taxonomy
	register_taxonomy( 'type', $types, $args );
}