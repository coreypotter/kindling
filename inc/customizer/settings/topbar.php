<?php
/**
 * Top Bar Customizer Options
 *
 * @package Kindling Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kindling_Top_Bar_Customizer' ) ) :

	class Kindling_Top_Bar_Customizer {

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
			 * Panel
			 */
			$panel = 'kindling_topbar_panel';
			$wp_customize->add_panel( $panel , array(
				'title' 			=> esc_html__( 'Top Bar', 'kindling' ),
				'priority' 			=> 210,
			) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'kindling_topbar_general' , array(
				'title' 			=> esc_html__( 'General', 'kindling' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Top Bar
			 */
			$wp_customize->add_setting( 'kindling_top_bar', array(
				'default'           	=> true,
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_top_bar', array(
				'label'	   				=> esc_html__( 'Enable Top Bar', 'kindling' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'kindling_topbar_general',
				'settings' 				=> 'kindling_top_bar',
				'priority' 				=> 10,
			) ) );

			/**
			 * Top Bar Style
			 */
			$wp_customize->add_setting( 'kindling_top_bar_style', array(
				'default'           	=> 'one',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_top_bar_style', array(
				'label'	   				=> esc_html__( 'Style', 'kindling' ),
				'type' 					=> 'select',
				'section'  				=> 'kindling_topbar_general',
				'settings' 				=> 'kindling_top_bar_style',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_topbar',
				'choices' 				=> array(
					'one' 		=> esc_html__( 'Left Content & Right Social', 'kindling' ),
					'two' 		=> esc_html__( 'Left Social & Right Content', 'kindling' ),
					'three' 	=> esc_html__( 'Centered Content & Social', 'kindling' ),
				),
			) ) );

			/**
			 * Top Bar Top Padding
			 */
			$wp_customize->add_setting( 'kindling_top_bar_top_padding', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '8',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_top_bar_top_padding', array(
				'label'	   				=> esc_html__( 'Top Padding (px)', 'kindling' ),
				'section'  				=> 'kindling_topbar_general',
				'settings' 				=> 'kindling_top_bar_top_padding',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_topbar',
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Top Bar Bottom Padding
			 */
			$wp_customize->add_setting( 'kindling_top_bar_bottom_padding', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '8',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_top_bar_bottom_padding', array(
				'label'	   				=> esc_html__( 'Bottom Padding (px)', 'kindling' ),
				'section'  				=> 'kindling_topbar_general',
				'settings' 				=> 'kindling_top_bar_bottom_padding',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_topbar',
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Top Bar Background Color
			 */
			$wp_customize->add_setting( 'kindling_top_bar_bg', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#ffffff',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_top_bar_bg', array(
				'label'	   				=> esc_html__( 'Background Color', 'kindling' ),
				'section'  				=> 'kindling_topbar_general',
				'settings' 				=> 'kindling_top_bar_bg',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_topbar',
			) ) );

			/**
			 * Top Bar Border Color
			 */
			$wp_customize->add_setting( 'kindling_top_bar_border_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#f1f1f1',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_top_bar_border_color', array(
				'label'	   				=> esc_html__( 'Border Color', 'kindling' ),
				'section'  				=> 'kindling_topbar_general',
				'settings' 				=> 'kindling_top_bar_border_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_topbar',
			) ) );

			/**
			 * Top Bar Text Color
			 */
			$wp_customize->add_setting( 'kindling_top_bar_text_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#929292',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_top_bar_text_color', array(
				'label'	   				=> esc_html__( 'Text Color', 'kindling' ),
				'section'  				=> 'kindling_topbar_general',
				'settings' 				=> 'kindling_top_bar_text_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_topbar',
			) ) );

			/**
			 * Top Bar Link Color
			 */
			$wp_customize->add_setting( 'kindling_top_bar_link_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#555555',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_top_bar_link_color', array(
				'label'	   				=> esc_html__( 'Link Color', 'kindling' ),
				'section'  				=> 'kindling_topbar_general',
				'settings' 				=> 'kindling_top_bar_link_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_topbar',
			) ) );

			/**
			 * Top Bar Link Color Hover
			 */
			$wp_customize->add_setting( 'kindling_top_bar_link_color_hover', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#13aff0',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_top_bar_link_color_hover', array(
				'label'	   				=> esc_html__( 'Link Color: Hover', 'kindling' ),
				'section'  				=> 'kindling_topbar_general',
				'settings' 				=> 'kindling_top_bar_link_color_hover',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_topbar',
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'kindling_topbar_content' , array(
				'title' 			=> esc_html__( 'Content', 'kindling' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Top Bar Content
			 */
			$wp_customize->add_setting( 'kindling_top_bar_content', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '<i class="icon-phone"></i> 1-555-645-324 <i class="icon-user"></i> <a href="#">sign in</a>',
				'sanitize_callback' 	=> 'wp_kses_post',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_top_bar_content', array(
				'label'	   				=> esc_html__( 'Content', 'kindling' ),
				'type' 					=> 'textarea',
				'section'  				=> 'kindling_topbar_content',
				'settings' 				=> 'kindling_top_bar_content',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_topbar',
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'kindling_topbar_social' , array(
				'title' 			=> esc_html__( 'Social', 'kindling' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Top Bar Social
			 */
			$wp_customize->add_setting( 'kindling_top_bar_social', array(
				'default'           	=> true,
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_top_bar_social', array(
				'label'	   				=> esc_html__( 'Enable Social', 'kindling' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'kindling_topbar_social',
				'settings' 				=> 'kindling_top_bar_social',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_topbar',
			) ) );

			/**
			 * Top Bar Social Alternative
			 */
			$wp_customize->add_setting( 'kindling_top_bar_social_alt', array(
				'default' 				=> '',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Dropdown_Pages( $wp_customize, 'kindling_top_bar_social_alt', array(
				'label'	   				=> esc_html__( 'Social Alternative', 'kindling' ),
				'description'	   		=> esc_html__( 'Choose a page to display the content of such page.', 'kindling' ),
				'type' 					=> 'select',
				'section'  				=> 'kindling_topbar_social',
				'settings' 				=> 'kindling_top_bar_social_alt',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_topbar',
			) ) );

			/**
			 * Top Bar Social Alternative
			 */
			$wp_customize->add_setting( 'kindling_top_bar_social_target', array(
				'transport'           	=> 'postMessage',
				'default'           	=> 'blank',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_top_bar_social_target', array(
				'label'	   				=> esc_html__( 'Social Link Target', 'kindling' ),
				'type' 					=> 'select',
				'section'  				=> 'kindling_topbar_social',
				'settings' 				=> 'kindling_top_bar_social_target',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_topbar_social',
				'choices' 				=> array(
					'blank' => esc_html__( 'New Window', 'kindling' ),
					'self' 	=> esc_html__( 'Same Window', 'kindling' ),
				),
			) ) );

			/**
			 * Top Bar Social Link Color
			 */
			$wp_customize->add_setting( 'kindling_top_bar_social_links_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#bbbbbb',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_top_bar_social_links_color', array(
				'label'	   				=> esc_html__( 'Social Links Color', 'kindling' ),
				'section'  				=> 'kindling_topbar_social',
				'settings' 				=> 'kindling_top_bar_social_links_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_topbar_social',
			) ) );

			/**
			 * Top Bar Social Link Color Hover
			 */
			$wp_customize->add_setting( 'kindling_top_bar_social_hover_links_color', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_top_bar_social_hover_links_color', array(
				'label'	   				=> esc_html__( 'Social Links Color: Hover', 'kindling' ),
				'section'  				=> 'kindling_topbar_social',
				'settings' 				=> 'kindling_top_bar_social_hover_links_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_topbar_social',
			) ) );

			/**
			 * Top Bar Social Settings
			 */
			$social_options = kindling_social_options();
			foreach ( $social_options as $key => $val ) {
				$wp_customize->add_setting( 'kindling_top_bar_social_profiles[' . $key .']', array(
					'sanitize_callback' 	=> false,
				) );

				$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_top_bar_social_profiles[' . $key .']', array(
					'label'	   				=> esc_html( $val['label'] ),
					'type' 					=> 'text',
					'section'  				=> 'kindling_topbar_social',
					'settings' 				=> 'kindling_top_bar_social_profiles[' . $key .']',
					'priority' 				=> 10,
					'active_callback' 		=> 'kindling_cac_has_topbar_social',
				) ) );
			}

		}

		/**
		 * Get CSS
		 *
		 * @since 1.0.0
		 */
		public static function head_css( $output ) {
		
			// Global vars
			$top_padding 				= get_theme_mod( 'kindling_top_bar_top_padding', '8' );
			$bottom_padding 			= get_theme_mod( 'kindling_top_bar_bottom_padding', '8' );
			$background 				= get_theme_mod( 'kindling_top_bar_bg', '#ffffff' );
			$border_color 				= get_theme_mod( 'kindling_top_bar_border_color', '#f1f1f1' );
			$text_color 				= get_theme_mod( 'kindling_top_bar_text_color', '#929292' );
			$link_color 				= get_theme_mod( 'kindling_top_bar_link_color', '#555555' );
			$link_color_hover 			= get_theme_mod( 'kindling_top_bar_link_color_hover', '#13aff0' );
			$social_links_color 		= get_theme_mod( 'kindling_top_bar_social_links_color', '#bbbbbb' );
			$social_hover_links_color 	= get_theme_mod( 'kindling_top_bar_social_hover_links_color' );

			// Define css var
			$css = '';

			// Top bar top padding
			if ( ! empty( $top_padding ) && '8' != $top_padding ) {
				$css .= '#top-bar{padding-top:'. $top_padding .'px;}';
			}

			// Top bar bottom padding
			if ( ! empty( $bottom_padding ) && '8' != $bottom_padding ) {
				$css .= '#top-bar{padding-bottom:'. $bottom_padding .'px;}';
			}

			// Top bar background color
			if ( ! empty( $background ) && '#ffffff' != $background ) {
				$css .= '#top-bar-wrap,.kindling-top-bar-sticky{background-color:'. $background .';}';
			}

			// Top bar border color
			if ( ! empty( $border_color ) && '#f1f1f1' != $border_color ) {
				$css .= '#top-bar-wrap{border-color:'. $border_color .';}';
			}

			// Top bar text color
			if ( ! empty( $text_color ) && '#929292' != $text_color ) {
				$css .= '#top-bar-wrap,#top-bar-content strong{color:'. $text_color .';}';
			}

			// Top bar link color
			if ( ! empty( $link_color ) && '#555555' != $link_color ) {
				$css .= '#top-bar-content a,#top-bar-social-alt a{color:'. $link_color .';}';
			}

			// Top bar link color hover
			if ( ! empty( $link_color_hover ) && '#13aff0' != $link_color_hover ) {
				$css .= '#top-bar-content a:hover,#top-bar-social-alt a:hover{color:'. $link_color_hover .';}';
			}

			// Top bar social link color
			if ( ! empty( $social_links_color ) && '#bbbbbb' != $social_links_color ) {
				$css .= '#top-bar-social li a{color:'. $social_links_color .';}';
			}

			// Top bar social link color hover
			if ( ! empty( $social_hover_links_color ) ) {
				$css .= '#top-bar-social li a:hover{color:'. $social_hover_links_color .'!important;}';
			}
				
			// Return CSS
			if ( ! empty( $css ) ) {
				$output .= '/* Top Bar CSS */'. $css;
			}

			// Return output css
			return $output;

		}

	}

endif;

return new Kindling_Top_Bar_Customizer();