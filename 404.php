<?php
/**
 * The template for displaying 404 pages.
 *
 * @package Kindling Theme
 */

get_header(); ?>

<?php do_action( 'kindling_before_content_wrap' ); ?>
<div id="content-wrap" class="container clr">

	<?php do_action( 'kindling_before_primary' ); ?>
	<div id="primary" class="content-area clr">

		<?php do_action( 'kindling_before_content' ); ?>
		<div id="content" class="clr site-content">

			<?php do_action( 'kindling_before_content_inner' ); ?>
			<article class="entry clr">

				<div class="error404-content clr">
					<h1 class="error-title"><?php esc_html_e( 'This page could not be found!', 'kindling' ) ?></h1>
					<p class="error-text"><?php esc_html_e( 'We are sorry. But the page you are looking for is not available.', 'kindling' ); ?><br /><?php esc_html_e( 'Perhaps you can try a new searching.', 'kindling' ); ?></p>
					<?php get_search_form(); ?>
					<a class="error-btn button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back To Homepage', 'kindling' ) ?></a>
				</div><!-- .error404-content -->

			</article><!-- .entry -->
			<?php do_action( 'kindling_after_content_inner' ); ?>

		</div><!-- #content -->
		<?php do_action( 'kindling_after_content' ); ?>

	</div><!-- #primary -->
	<?php do_action( 'kindling_after_primary' ); ?>

</div><!--#content-wrap -->
<?php do_action( 'kindling_after_content_wrap' ); ?>

<?php get_footer(); ?>
