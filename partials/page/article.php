<?php
/**
 * Outputs page article
 *
 * @package Kindling Theme
 */

# Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>

<div class="entry clr" itemprop="text">
	<?php the_content();

	wp_link_pages( array(
		'before' => '<div class="page-links">' . __( 'Pages:', 'kindling' ),
		'after'  => '</div>',
	) ); ?>
</div>