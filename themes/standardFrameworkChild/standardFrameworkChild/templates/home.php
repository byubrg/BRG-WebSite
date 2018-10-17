<?php
/*
Template Name: Home
*/
?>
<?php
get_header();
the_brand_header();
?>
<div class="container">
    <div class="row">
        <section class="brand_home_about_brand_section">
            <span class="brand_home_about_brand_text"><?php the_field( 'home_page_text' ); ?></span>
        </section>
    </div>
    <div class="row">
        <div class="mid_page_buttons
                    xlg-col-6 xlg-offset-left-col-3 xlg-offset-right-col-3
                    lg-col-6 lg-offset-left-col-3 lg-offset-right-col-3
                    mlg-col-4 mlg-offset-left-col-1 mlg-offset-right-col-1
                    med-col-4 med-offset-left-col-1 med-offset-right-col-1
                    sm-col-3 sm-offset-left-col-0p5 sm-offset-right-col-0p5
                    sm-col-3 sm-offset-left-col-0p5 sm-offset-right-col-0p5">
            <a class="mid_page_nav" id="first" href="members/"><h2 class="mid_page_nav_title">Members</h2></a>
            <a class="mid_page_nav" id="second" href="all-projects/"><h2 class="mid_page_nav_title">Projects</h2></a>
        </div>
    </div>
    <div class="row">
        <div class="inner_row">
            <?php
            $blocks = array();
            $i = 0;
            if ( have_posts() ) {
                while ( have_posts() ) {
                    the_post();
                    if ( have_rows( 'boxed_links' ) ) {
                        while ( have_rows( 'boxed_links' ) ) {
                            the_row();
	                        $block = array();
                            $block['title_top'] = get_sub_field( 'box_title' );
                            $block['title_bottom'] = get_sub_field( 'box_title_part_2' );
                            $block['image'] = get_sub_field( 'box_background_image' );
	                        $block['mobile_image'] = get_sub_field( 'box_background_image_mobile' );
	                        $block['img_alt_text'] = get_sub_field( 'image_alt_text' );
                            $block['links'] = array();
                            if ( have_rows('box_links') ) {
                                while ( have_rows('box_links') ) {
                                    the_row();
                                    $link = array();
                                    $link['url'] = get_sub_field('box_link_url');
	                                $link['text'] = get_sub_field('box_link_text');
                                    array_push($block['links'],$link);
                                }
                            }
                            array_push($blocks,$block);
                            $i++;
                        }
                    }
                }
            }
            $i = 0;
            foreach ( $blocks as $block ) { ?>
	            <div class="card" style="background-image:url(<?php echo $block['image'] ?>);">
                    <div class="card_screen" id="brand_home_screen_<?php echo $i + 1; ?>"></div>
                    <div class="card_inner">
                        <h3 class="card_title card_title_top"><?php echo $block['title_top']?></h3>
                        <h3 class="card_title card_title_bottom"><?php echo $block['title_bottom']?></h3>
                        <ul>
                            <?php
                            foreach( $block['links'] as $link) {
	                            ?>
                                <a href="<?php echo $link['url']; ?>">
                                    <li class="card_item"><?php echo $link['text']; ?></li>
                                </a>
	                            <?php
                            } ?>
                        </ul>
                    </div>
                </div>
	            <?php
                    if ( $i == 1 ) { ?>
                        </div>
                        <div class="inner_row"><?php
                    }
                $i++;
            }

            ?>
        </div>
    </div>

</div>
<?php get_footer();
