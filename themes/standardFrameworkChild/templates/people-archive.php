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
$current = [];
$emeritus = [];
$thequery = new WP_Query( $args );
if ( $thequery->have_posts() ) {
	while ( $thequery->have_posts() ) {
		$thequery->the_post();
		$person = array(
		        'href' => get_permalink(),
                'name' => get_the_title(),
                'picture_url' => get_field( 'portrait')
        );
		$obj = get_the_terms(get_the_ID(),'type');
		if($obj[0]->name == 'current'){
		    array_push($current,$person);
        }else if($obj[0]->name == 'emeritus'){
			array_push($emeritus,$person);
        }
	}
}
sort($current);
sort($emeritus);
?>
	<div class="container">
        <h3 class="member_title">Current Members</h3>
		<div class="row">

<?php
foreach($current as $person){
    ?>
    <div class="portrait_wrapper xlg-col-3 lg-col-3 mlg-col-2 med-col-2 sm-col-2 ssm-col-2">
        <a class="portrait_tag" href="<?php echo $person['href'] ?>">
            <img src="<?php echo $person['picture_url'] ?>">
            <p class="member_name"><?php echo $person['name'] ?></p>
        </a>
    </div>
    <?php
}
?>
		</div>
    <h3 class="member_title">Emeritus Members</h3>
    <div class="row">
<?php
foreach($emeritus as $person){
	?>
    <div class="portrait_wrapper xlg-col-3 lg-col-3 mlg-col-2 med-col-2 sm-col-2 ssm-col-2">
        <a class="portrait_tag" href="<?php echo $person['href'] ?>">
            <img src="<?php echo $person['picture_url'] ?>">
            <p class="member_name"><?php echo $person['name'] ?></p>
        </a>
    </div>
	<?php
}
?>
        </div>
    </div>
<?php get_footer();
