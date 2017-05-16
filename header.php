<?php
/**
 * The Header for our theme.
 *
 * @package Kindling Theme
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope itemtype="//schema.org/WebPage">

	<?php do_action( 'kindling_before_outer_wrap' ); ?>
	<div id="outer-wrap" class="site clr">

		<?php do_action( 'kindling_before_wrap' ); ?>
		<div id="wrap" class="clr">

			<?php 
			# Top Bar
##			if ( kindling_display_topbar() ) {
##				get_template_part( 'partials/topbar/layout' );
##			}

			# Header
			if ( kindling_display_header() ) {
				get_template_part( 'partials/header/layout' );
			} ?>

			<?php do_action( 'kindling_before_main' ); ?>
			<main id="main" class="site-main clr" <?php echo kindling_main_schema_markup(); ?>>

				<?php
				// Display shortcode if there is one
				if ( $shortcode = kindling_has_shortcode() ) :
					echo do_shortcode( $shortcode );
				endif; ?>

				<?php get_template_part( 'partials/page-header' ); ?>