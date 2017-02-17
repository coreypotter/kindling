<?php
/**
 * Post single content
 *
 * @package Kindling Theme
 */

# Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="entry-content clr" itemprop="text">
	<?php the_content();

	wp_link_pages( array(
		'before'      => '<div class="page-links">' . __( 'Pages:', 'kindling' ),
		'after'       => '</div>',
		'link_before' => '<span class="page-number">',
		'link_after'  => '</span>',
	) ); ?>
</div><!-- .entry -->