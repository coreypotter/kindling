<?php
/**
 * Displays the post entry thumbmnail
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

</div><!-- .thumbnail -->