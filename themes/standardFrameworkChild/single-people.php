<?php
get_header();
the_brand_header();

?>
<div class="container">
	<div class="row">
		<div class="portrait_wrapper xlg-col-4 xlg-offset-left-col-1 lg-col-3  lg-offset-left-col-1 mlg-col-2 mlg-offset-left-col-2 med-col-2 med-offset-left-col-2 sm-col-4 ssm-col-4">
			<img src="<?php echo get_field( 'portrait' ) ?>">
		</div>
		<div class="person-info xlg-col-6 lg-col-6 mlg-col-4 mlg-offset-left-col-1 med-col-2 med-offset-left-col-1 sm-col-4 ssm-col-4">
			<h2 class="name"><?php echo get_field('full_name') ?></h2>
			<h3 class="email"><?php echo get_field('email') ?></h3>
			<h3 class="phone"><?php echo get_field('phone') ?></h3>
			<?php
			$projects = get_field('projects');

            if(count($projects) > 0 ){
	            ?><h3 class="project_list_title">Project(s):</h3> <?php
	            foreach($projects as $project){
                    ?><a class="project_link" href="<?php echo get_permalink($project) ?>"><p><?php echo get_the_title($project) ?></p></a> <?php
	            }
            }
			?>
		</div>

		<div class="person-bio xlg-col-10 xlg-offset-left-col-1 lg-col-10 lg-offset-left-col-1 mlg-col-4 mlg-offset-left-col-1 med-col-4 med-offset-left-col-1 sm-col-4 ssm-col-4">


	<?php
	the_post();
	echo get_the_content();


	?>
		</div>
	</div>
</div>
<?php get_footer();