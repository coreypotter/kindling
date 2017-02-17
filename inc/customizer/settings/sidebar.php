<?php
/**
 * Sidebar Customizer Options
 *
 * @package Kindling Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kindling_Sidebar_Customizer' ) ) :

	class Kindling_Sidebar_Customizer {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {

			add_action( 'customize_register', 	array( $this, 'customizer_options' ) );
			add_filter( 'kindling_head_css', 		array( $this, 'head_css' ) );

		}

		/**
		 * Customizer options
		 *
		 * @since 1.0.0
		 */
		public function customizer_options( $wp_customize ) {

			/**
			 * Section
			 */
			$section = 'kindling_sidebar_section';
			$wp_customize->add_section( $section , array(
				'title' 			=> esc_html__( 'Sidebar', 'kindling' ),
				'priority' 			=> 210,
			) );

			/**
			 * Sidebar Background
			 */
			$wp_customize->add_setting( 'kindling_sidebar_bg', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_sidebar_bg', array(
				'label'	   				=> esc_html__( 'Background Color', 'kindling' ),
				'section'  				=> $section,
				'settings' 				=> 'kindling_sidebar_bg',
				'priority' 				=> 10,
			) ) );

			/**
			 * Sidebar Padding
			 */
			$wp_customize->add_setting( 'kindling_sidebar_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_sidebar_padding', array(
				'label'	   				=> esc_html__( 'Padding', 'kindling' ),
				'type' 					=> 'text',
				'section'  				=> $section,
				'settings' 				=> 'kindling_sidebar_padding',
				'priority' 				=> 10,
			) ) );

			/**
			 * Widgets Heading
			 */
			$wp_customize->add_setting( 'kindling_widgets_heading', array(
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Heading_Control( $wp_customize, 'kindling_widgets_heading', array(
				'label'    				=> esc_html__( 'Widgets', 'kindling' ),
				'section'  				=> $section,
				'priority' 				=> 10,
			) ) );

			/**
			 * Widgets Background
			 */
			$wp_customize->add_setting( 'kindling_widgets_bg', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_widgets_bg', array(
				'label'	   				=> esc_html__( 'Background Color', 'kindling' ),
				'section'  				=> $section,
				'settings' 				=> 'kindling_widgets_bg',
				'priority' 				=> 10,
			) ) );

			/**
			 * Widgets Padding
			 */
			$wp_customize->add_setting( 'kindling_widgets_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_widgets_padding', array(
				'label'	   				=> esc_html__( 'Padding', 'kindling' ),
				'type' 					=> 'text',
				'section'  				=> $section,
				'settings' 				=> 'kindling_widgets_padding',
				'priority' 				=> 10,
			) ) );

			/**
			 * Widgets Margin Bottom
			 */
			$wp_customize->add_setting( 'kindling_widgets_margin_bottom', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '40',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_widgets_margin_bottom', array(
				'label'	   				=> esc_html__( 'Margin Bottom (px)', 'kindling' ),
				'section'  				=> $section,
				'settings' 				=> 'kindling_widgets_margin_bottom',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Widgets Titles Margin Bottom
			 */
			$wp_customize->add_setting( 'kindling_widgets_titles_margin_bottom', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '20',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_widgets_titles_margin_bottom', array(
				'label'	   				=> esc_html__( 'Titles Margin Bottom (px)', 'kindling' ),
				'section'  				=> $section,
				'settings' 				=> 'kindling_widgets_titles_margin_bottom',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

		}

		/**
		 * Get CSS
		 *
		 * @since 1.0.0
		 */
		public static function head_css( $output ) {
		
			// Global vars
			$sidebar_bg 					= get_theme_mod( 'kindling_sidebar_bg' );
			$sidebar_padding 				= get_theme_mod( 'kindling_sidebar_padding' );
			$widgets_bg 					= get_theme_mod( 'kindling_widgets_bg' );
			$widgets_padding 				= get_theme_mod( 'kindling_widgets_padding' );
			$widgets_margin_bottom 			= get_theme_mod( 'kindling_widgets_margin_bottom', '40' );
			$widgets_titles_margin_bottom 	= get_theme_mod( 'kindling_widgets_titles_margin_bottom', '20' );

			// Define css var
			$css = '';

			// Sidebar background
			if ( ! empty( $sidebar_bg ) ) {
				$css .= '#sidebar{background-color:'. $sidebar_bg .';}';
			}

			// Sidebar padding
			if ( ! empty( $sidebar_padding ) ) {
				$css .= '.widget-area{padding:'. $sidebar_padding .';}';
			}

			// Widgets background
			if ( ! empty( $widgets_bg ) ) {
				$css .= '#sidebar .sidebar-box{background-color:'. $widgets_bg .';}';
			}

			// Widgets padding
			if ( ! empty( $widgets_padding ) ) {
				$css .= '#sidebar .sidebar-box{padding:'. $widgets_padding .';}';
			}

			// Widgets margin bottom
			if ( ! empty( $widgets_margin_bottom ) && '40' != $widgets_margin_bottom ) {
				$css .= '#sidebar .sidebar-box{margin-bottom:'. $widgets_margin_bottom .'px;}';
			}

			// Widgets titles margin bottom
			if ( ! empty( $widgets_titles_margin_bottom ) && '20' != $widgets_titles_margin_bottom ) {
				$css .= '.widget-title{margin-bottom:'. $widgets_titles_margin_bottom .'px;}';
			}
				
			// Return CSS
			if ( ! empty( $css ) ) {
				$output .= '/* Sidebar CSS */'. $css;
			}

			// Return output css
			return $output;

		}

	}

endif;

return new Kindling_Sidebar_Customizer();