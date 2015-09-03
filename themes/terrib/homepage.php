<?php /* Template Name: Homepage */ ?>

<?php get_header('homepage'); ?>

	<div id="content">

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

	<?php the_content(); ?>

	<?php endwhile; ?>

	<?php else: ?>

	<h2><?php _e( 'No posts to display', 'twentytwelve' ); ?></h2>

	<?php endif; ?>

	</div><!-- content -->

	<div class="clear"></div>

<?php get_footer(); ?>

