<?php /* Template Name: Webpage */ ?>

<?php get_header('webpage'); ?>

	<div id="content">

	<?php get_sidebar('leftcol'); ?>

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

	<?php the_content(); ?>

	<?php endwhile; ?>

	<?php else: ?>

	<h2><?php _e( 'No posts to display', 'twentytwelve' ); ?></h2>

	<?php endif; ?>

	<?php get_sidebar('rightcol'); ?>

	<div class="clear"></div>

	</div><!-- content -->

	<div class="clear"></div>

<?php get_footer(); ?>

