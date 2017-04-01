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

<footer id="footer" class="<?php echo kindling_footer_classes(); ?>" itemscope="itemscope" itemtype="http:#schema.org/WPFooter">

    <?php do_action( 'kindling_before_footer_inner' ); ?>

    <div id="footer-inner" class="clr">

        <?php
        # Display the footer widgets if enabled
        if ( kindling_display_footer_widgets() && kindling_footer_page_id() ) {
        	get_template_part( 'partials/footer/widgets' );
        }

        # Display the footer bottom if enabled
        if ( kindling_display_footer_bottom() ) {
        	get_template_part( 'partials/footer/copyright' );
        } ?>
        
    </div><!-- #footer-widgets -->

    <?php do_action( 'kindling_after_footer_inner' ); ?>

</footer><!-- #footer -->