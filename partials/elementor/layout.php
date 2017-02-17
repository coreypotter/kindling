<?php
/**
 * Outputs correct library layout
 *
 * @package Kindling Theme
 */

# Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>

<article class="single-library-article clr">

	<div class="entry clr" itemprop="text">
		<?php the_content(); ?>
	</div>

</article>