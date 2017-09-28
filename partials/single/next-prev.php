<?php
/**
 * The next/previous links to go to another post.
 *
 * @package Kindling Theme
 */

# Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

# Previous post link title
$prev_post_link_title = '%title';
$prev_post_link_title = apply_filters( 'kindling_prev_post_link_title', $prev_post_link_title );

# Next post link title
$next_post_link_title = '%title';
$next_post_link_title = apply_filters( 'kindling_next_post_link_title', $next_post_link_title );

# Just Use Default Behavior.
$prev_link  = get_previous_post_link( '%link', $prev_post_link_title );
$next_link  = get_next_post_link( '%link', $next_post_link_title );
?>

<?php if ( $prev_link || $next_link ) : ?>

    <div class="post-pagination-wrap clr">
        <ul class="post-pagination clr">

            <?php if ( $prev_link ) : ?>
                <li class="post-prev"><span class="title"><i class="fa fa-long-arrow-left"></i><?php esc_html_e( 'Previous Post', 'kindling' ); ?></span><?php echo wp_kses_post( $prev_link ); ?></li>
            <?php endif; ?>

            <?php if ( $next_link ) : ?>
                <li class="post-next"><span class="title"><i class="fa fa-long-arrow-right"></i><?php esc_html_e( 'Next Post', 'kindling' ); ?></span><?php echo wp_kses_post( $next_link ); ?></li>
            <?php endif; ?>
            
        </ul><!-- .post-post-pagination -->
    </div><!-- .post-pagination-wrap -->

<?php endif; ?>