<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http:#codex.wordpress.org/Template_Hierarchy
 *
 * @package Kindling Theme
 */

get_header(); ?>

<?php do_action( 'kindling_before_content_wrap' ); ?>
<div id="content-wrap" class="container clr">

	<?php do_action( 'kindling_before_primary' ); ?>
	<div id="primary" class="content-area clr">

		<?php do_action( 'kindling_before_content' ); ?>
		<div id="content" class="site-content clr">

			<?php do_action( 'kindling_before_content_inner' );
			# Check if posts exist
			if ( have_posts() ) : ?>
			
				<div id="blog-entries" class="<?php kindling_blog_wrap_classes(); ?>">
					<?php
					# Define counter for clearing floats
					$kindling_count = 0;
					
					# Loop through posts
					while ( have_posts() ) : the_post();
						# Add to counter
						$kindling_count++;
						
						# Get post entry content
						get_template_part( 'partials/entry/layout' ); 
						
						# Reset counter to clear floats
						if ( kindling_blog_entry_columns() == $kindling_count ) {
							$kindling_count=0;
						}
					endwhile; ?>
				</div><!-- #blog-entries -->

				<?php
				# Display post pagination
				kindling_blog_pagination();
				
			# No posts found
			else :
				# Display no post found notice
				get_template_part( 'partials/none' );
			endif;
			
			do_action( 'kindling_after_content_inner' ); ?>

		</div><!-- #content -->
		<?php do_action( 'kindling_after_content' ); ?>

	</div><!-- #primary -->
	<?php do_action( 'kindling_after_primary' ); ?>

	<?php get_sidebar(); ?>

</div><!-- #content-wrap -->
<?php do_action( 'kindling_after_content_wrap' ); ?>

<?php get_footer(); ?>