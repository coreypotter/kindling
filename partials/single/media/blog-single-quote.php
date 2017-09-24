<?php
/**
 * Blog single quote format
 *
 * @package Kindling Theme
 */

# Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

# Return if Kindling Extra is not active
if ( ! class_exists( 'Kindling_Extra' ) ) {
	return;
} ?>

<div class="post-quote-wrap">

	<div class="post-quote-content">

		<?php echo wp_kses_post( get_post_meta( get_the_ID(), 'kindling_quote_format', true ) ); ?>

		<span class="post-quote-icon icon-speech"></span>

	</div>

	<div class="post-quote-author"><?php the_title(); ?></div>
	
</div>