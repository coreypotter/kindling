<?php
/**
 * The template for displaying the footer.
 *
 * @package Kindling Theme
 */ 
?>
        </main><!-- #main-content -->

        <?php do_action( 'kindling_after_main' ); ?>
        <?php do_action( 'kindling_before_footer' ); ?>

        <?php # Display the footer if the footer widgets and bottom are enabled
        if ( kindling_display_footer_widgets() || kindling_display_footer_bottom() ) {
        	get_template_part( 'partials/footer/layout' );
        } ?>

        <?php do_action( 'kindling_after_footer' ); ?>

	</div><!-- #wrap -->
    <?php do_action( 'kindling_after_wrap' ); ?>

</div><!-- .outer-wrap -->
<?php do_action( 'kindling_after_outer_wrap' ); ?>

<?php get_template_part( 'partials/mobile-search' ); ?>

<?php
# If is not sticky footer
if ( ! class_exists( 'kindling_Sticky_Footer' ) ) {
    get_template_part( 'partials/scroll-top' );
} ?>

<?php get_template_part( 'partials/header/mobile-sidr-close' ); ?>

<?php wp_footer(); ?>
</body>
</html>