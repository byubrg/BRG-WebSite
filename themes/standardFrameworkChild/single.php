<?php
/*
 * Diplays a single post
 * */
get_header();

the_content();
?>
	<div class="container">
		<div class="row">
			<h1 class="post_title"><?php the_title(); ?></h1>
			<div class="the_post">
<?php
the_post();
the_content();
?>
			</div>
		</div>
	</div>
<?php
get_footer();
