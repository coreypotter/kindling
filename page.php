<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
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
			
			# Start loop
			while ( have_posts() ) : the_post();
				get_template_part( 'partials/page/layout' );
			endwhile; ?>

			<?php do_action( 'kindling_after_content_inner' ); ?>

		</div><!-- #content -->
		<?php do_action( 'kindling_after_content' ); ?>

	</div><!-- #primary -->
	<?php do_action( 'kindling_after_primary' ); ?>

	<?php get_sidebar(); ?>

</div><!-- #content-wrap -->
<?php do_action( 'kindling_after_content_wrap' ); ?>

<?php get_footer(); ?>