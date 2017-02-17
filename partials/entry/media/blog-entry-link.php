<?php
/**
 * Blog entry link format media
 *
 * @package Kindling Theme
 */

# Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

# Return if there isn't a thumbnail defined
if ( ! has_post_thumbnail() ) {
	return;
}

# Add images size if blog grid
if ( 'grid-entry' == kindling_blog_entry_style() ) {
	$size = kindling_blog_entry_images_size();
} else {
	$size = 'full';
} ?>

<div class="thumbnail">

	<a href="<?php the_permalink(); ?>" class="thumbnail-link">

		<?php
		# Display post thumbnail
		the_post_thumbnail( $size, array(
			'alt'		=> get_the_title(),
			'itemprop' 	=> 'image',
		) ); ?>

		<span class="overlay"></span>

	</a>

	<div class="link-entry clr">

		<a href="<?php echo esc_url( get_post_meta( get_the_ID(), 'kindling_link_format', true ) ); ?>" target="_<?php echo esc_attr( get_post_meta( get_the_ID(), 'kindling_link_format_target', true ) ); ?>"><i class="icon-link"></i></a>
		
	</div>

</div>