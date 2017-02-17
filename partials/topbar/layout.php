<?php
/**
 * Topbar layout
 *
 * @package Kindling Theme
 */

# Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<?php do_action( 'kindling_before_top_bar' ); ?>

<div id="top-bar-wrap" class="<?php echo kindling_topbar_classes(); ?>">

	<?php do_action( 'kindling_before_top_bar_inner' ); ?>

	<div id="top-bar" class="clr container">

		<?php
		# Get content
		get_template_part( 'partials/topbar/content' );

		# Get social
		if ( true == get_theme_mod( 'kindling_top_bar_social', true ) )  {
			get_template_part( 'partials/topbar/social' );
		} ?>

	</div><!-- #top-bar -->

	<?php do_action( 'kindling_after_top_bar_inner' ); ?>

</div><!-- #top-bar-wrap -->

<?php do_action( 'kindling_after_top_bar' ); ?>