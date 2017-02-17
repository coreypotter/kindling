<?php
/**
 * The template for displaying Search Results pages.
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

			get_template_part( 'partials/archive', 'header' );

			if ( have_posts() ) :
				while ( have_posts() ) : the_post();
					get_template_part( 'partials/entry/layout' );
				endwhile;

				kindling_pagination();
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