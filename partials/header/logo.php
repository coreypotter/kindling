<?php
/**
 * Header Logo
 *
 * @package Kindling Theme
 */

# Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

<?php do_action( 'kindling_before_logo' ); ?>
<div id="site-logo" class="<?php echo esc_attr( kindling_header_logo_classes() ); ?>" itemscope itemtype="//schema.org/Brand">

	<?php do_action( 'kindling_before_logo_inner' ); ?>
	<div id="site-logo-inner" class="clr">

		<?php
		# Custom site-wide image logo
		if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
			# Default logo
			the_custom_logo();
		} else { ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="site-title site-logo-text"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>
		<?php
		} ?>

	</div><!-- #site-logo-inner -->
	<?php do_action( 'kindling_after_logo_inner' ); ?>

</div><!-- #site-logo -->
<?php do_action( 'kindling_after_logo' ); ?>