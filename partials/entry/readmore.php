<?php
/**
 * Displays post entry read more
 *
 * @package Kindling Theme
 */

# Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

# Text
$text = esc_html__( 'Continue Reading', 'kindling' );

# Apply filters for child theming
$text = apply_filters( 'kindling_post_readmore_link_text', $text );

if ( 'post' == get_post_type() ) : ?>

    <div class="blog-entry-readmore clr">
        <a href="<?php the_permalink(); ?>" title="<?php echo $text ?>"><?php echo $text ?><i class="fa fa-angle-right"></i></a>
    </div><!-- .blog-entry-readmore -->

<?php endif; ?>