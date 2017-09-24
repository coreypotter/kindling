<?php
/**
 * Footer layout
 *
 * @package Kindling Theme
 */

# Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>

<footer id="footer" class="<?php echo esc_attr( kindling_footer_classes() ); ?>" itemscope itemtype="//schema.org/WPFooter">

    <?php do_action( 'kindling_before_footer_inner' ); ?>

    <div id="footer-inner" class="clr">

        <?php
        # Display the footer page id if enabled
        if ( kindling_footer_page_id() ) {
        	get_template_part( 'partials/footer/widgets' );
        }

        # Display the footer bottom if enabled
        if ( kindling_display_footer_bottom() ) {
        	get_template_part( 'partials/footer/copyright' );
        } ?>
        
    </div>

    <?php do_action( 'kindling_after_footer_inner' ); ?>

</footer><!-- #footer -->