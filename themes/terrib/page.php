<?php get_header(''); ?>

	<div id="blog-content">

<div class="entry-content">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="post" id="post-<?php the_ID(); ?>">

					<p class="taglinetext">Living Well with Learning Disabilities</p>

			<h1><?php the_title(); ?></h1>

			<div class="meta">
				<em>Posted on:</em> <?php the_time('F jS, Y') ?>
				<em>by</em> <?php the_author() ?>
				<br /><?php if ( comments_open() ) : ?>
				<div class="comments-link">
					<?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'twentytwelve' ) . '</span>', __( '1 Reply', 'twentytwelve' ), __( '% Replies', 'twentytwelve' ) ); ?>
				</div><!-- .comments-link -->
			<?php endif; // comments_open() ?>

			</div>

			<div class="entry">

				<?php the_content(); ?>

				<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>

			</div>

			<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>

		</div>

		<?php // comments_template(); ?>

		<?php endwhile; endif; ?>

</div>

<?php get_sidebar(); ?>

<div class="clear"></div>

	</div><!-- content -->

	<div class="clear"></div>

<?php get_footer(''); ?>