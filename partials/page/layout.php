<?php
/**
 * Outputs correct page layout
 *
 * @package Kindling Theme
 */

# Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>

<article class="single-page-article clr">

	<?php
	# Get page entry
	get_template_part( 'partials/page/article' );

	# Display comments
	comments_template(); ?>

</article>