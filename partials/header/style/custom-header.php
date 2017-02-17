<?php
/**
 * Custom Header Style
 *
 * @package Kindling Theme
 */

namespace Elementor;

# Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

# Get page
$get_page 	= kindling_header_page_id();

# Get page ID
$get_id 	= get_theme_mod( 'kindling_header_page_id' );

# Check if page is Elementor page
$elementor 	= get_post_meta( $get_id, '_elementor_edit_mode', true );

# Add container class
$container 	= get_theme_mod( 'kindling_add_custom_header_container', true );

if ( $container ) {
	$class 	= 'container ';
} else {
	$class 	= '';
}


# Check if there is page for the header
if ( $get_page ) : ?>

    <?php do_action( 'kindling_before_header_inner' ); ?>

	<div id="site-header-inner" class="<?php echo esc_attr( $class ); ?>clr">

	    <?php
	    # If Elementor
	    if ( class_exists( 'Elementor\Plugin' ) && $elementor ) {

			echo Plugin::instance()->frontend->get_builder_content_for_display( $get_id );

    	}

    	# If Beaver Builder
	    else if ( class_exists( 'FLBuilder' ) ) {

			echo do_shortcode( '[fl_builder_insert_layout id="' . $get_id . '"]' );

    	}

    	# Else
    	else {

        	# Display page content
        	echo do_shortcode( $get_page );

        } ?>

    </div>

    <?php do_action( 'kindling_after_header_inner' ); ?>

<?php
endif;