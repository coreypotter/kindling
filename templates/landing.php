<?php
/**
 * Template Name: Landing Page
 *
 * @package Kindling Theme
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<!-- Begin Body -->
<body <?php body_class(); ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">

<?php do_action( 'kindling_before_outer_wrap' ); ?>

<div id="outer-wrap" class="site clr">

	<?php do_action( 'kindling_before_wrap' ); ?>

	<div id="wrap" class="clr">

		<?php do_action( 'kindling_before_main' ); ?>

		<main id="main" class="site-main clr" <?php echo kindling_main_schema_markup(); ?>>

			<?php do_action( 'kindling_before_content_wrap' ); ?>

			<div id="content-wrap" class="container clr">

				<?php do_action( 'kindling_before_primary' ); ?>

				<section id="primary" class="content-area clr">

					<?php do_action( 'kindling_before_content' ); ?>

					<div id="content" class="site-content clr">

						<?php do_action( 'kindling_before_content_inner' ); ?>

						<?php while ( have_posts() ) : the_post(); ?>

							<div class="entry-content entry clr">
								<?php the_content(); ?>
							</div><!-- .entry-content -->

						<?php endwhile; ?>

						<?php do_action( 'kindling_after_content_inner' ); ?>

					</div><!-- #content -->

					<?php do_action( 'kindling_after_content' ); ?>

				</section><!-- #primary -->

				<?php do_action( 'kindling_after_primary' ); ?>

			</div><!-- #content-wrap -->

			<?php do_action( 'kindling_after_content_wrap' ); ?>

        </main><!-- #main-content -->

        <?php do_action( 'kindling_after_main' ); ?>
                
    </div><!-- #wrap -->

    <?php do_action( 'kindling_after_wrap' ); ?>

</div><!-- .outer-wrap -->

<?php do_action( 'kindling_after_outer_wrap' ); ?>

<?php wp_footer(); ?>

</body>
</html>