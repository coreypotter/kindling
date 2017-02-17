<?php
/**
 * Topbar social profiles
 *
 * @package Kindling Theme
 */

# Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

# Get social options array
$social_options = kindling_social_options();

# Return if $social_options array is empty
if ( empty( $social_options ) ) {
	return;
}

# Add classes based on topbar style
$classes = '';
$topbar_style = get_theme_mod( 'kindling_top_bar_style', 'one' );
if ( 'one' == $topbar_style ) {
	$classes = 'top-bar-right';
} elseif ( 'two' == $topbar_style ) {
	$classes = 'top-bar-left';
} elseif ( 'three' == $topbar_style ) {
	$classes = 'top-bar-centered';
}

# Display Social alternative
if ( $social_alt = kindling_top_bar_social_alt() ) : ?>

	<div id="top-bar-social-alt" class="clr <?php echo $classes; ?>">
		<?php echo do_shortcode( $social_alt ); ?>
	</div><!-- #top-bar-social-alt -->

<?php return; endif; ?>

<?php
# Return if there aren't any profiles defined and define var
if ( ! $profiles = get_theme_mod( 'kindling_top_bar_social_profiles' ) ) {
	return;
}

# Get theme mods
$link_target = get_theme_mod( 'kindling_top_bar_social_target', 'blank' );
$link_target = ( 'blank' == $link_target || '_blank' == $link_target ) ? ' target="_blank"' : ''; ?>

<div id="top-bar-social" class="clr <?php echo $classes; ?>">

	<ul>

		<?php
		# Loop through social options
		foreach ( $social_options as $key => $val ) {

			# Get URL from the theme mods
			$url = isset( $profiles[$key] ) ? $profiles[$key] : '';

			# Display if there is a value defined
			if ( $url ) {

				# Escape URL except for the following keys
				if ( ! in_array( $key, array( 'skype', 'email' ) ) ) {
					$url = esc_url( $url );
				}

				# Display link
				echo '<li class="kindling-'. $key .'">';

					echo '<a href="'. $url .'" title="'. $val['label'] .'" '. $link_target .'>';

						echo '<span class="'. $val['icon_class'] .'"></span>';

					echo '</a>';

				echo '</li>';

			} # End url check

		} # End loop ?>

	</ul>

</div><!-- #top-bar-social -->