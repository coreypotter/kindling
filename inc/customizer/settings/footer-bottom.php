<?php
/**
 * Footer Bottom Customizer Options
 *
 * @package Kindling Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kindling_Footer_Bottom_Customizer' ) ) :

	class Kindling_Footer_Bottom_Customizer {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'customize_register', array( $this, 'customizer_options' ) );
			add_filter( 'kindling_head_css',  array( $this, 'head_css' ) );
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
			$section = 'kindling_footer_bottom_section';
			$wp_customize->add_section( $section , array(
				'title' 			=> esc_html__( 'Footer', 'kindling' ),
				'priority' 			=> 3,
			) );

			/**
			 * Enable Footer Page Embed (Widgets Area)
			 */
			$wp_customize->add_setting( 'kindling_footer_widgets', array(
				'default'           	=> false,
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_footer_widgets', array(
				'label'	   				=> esc_html__( 'Enable Footer Page Embed', 'kindling' ),
				'type' 					=> 'checkbox',
				'section'  				=> $section,
				'settings' 				=> 'kindling_footer_widgets',
				'priority' 				=> 10,
			) ) );

			/**
			 * Footer Widgets Page ID
			 */
			$wp_customize->add_setting( 'kindling_footer_widgets_page_id', array(
				'default' 				=> '',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Dropdown_Pages( $wp_customize, 'kindling_footer_widgets_page_id', array(
				'label'	   				=> esc_html__( 'Page ID', 'kindling' ),
				'description'	   		=> esc_html__( 'Choose a page to embed above the footer credits.', 'kindling' ),
				'type' 					=> 'select',
				'section'  				=> $section,
				'settings' 				=> 'kindling_footer_widgets_page_id',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_footer_widgets',
			) ) );			
			
			/**
			 * Enable Footer Bottom
			 */
			$wp_customize->add_setting( 'kindling_footer_bottom', array(
				'default'           	=> true,
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_footer_bottom', array(
				'label'	   				=> esc_html__( 'Enable Footer Credits', 'kindling' ),
				'type' 					=> 'checkbox',
				'section'  				=> $section,
				'settings' 				=> 'kindling_footer_bottom',
				'priority' 				=> 10,
			) ) );

			/**
			 * Footer Bottom Copyright
			 */
			$wp_customize->add_setting( 'kindling_footer_copyright_text', array(
				'transport'           	=> 'postMessage',
				'default'           	=> 'Copyright - Kindling Theme by <a href="https://github.com/coreypotter/" target="_blank">Corey Potter</a> | Powered by <a href="https://wordpress.org/" title="WordPress" target="_blank">WordPress</a>',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_footer_copyright_text', array(
				'label'	   				=> esc_html__( 'Copyright', 'kindling' ),
				'type' 					=> 'textarea',
				'section'  				=> $section,
				'settings' 				=> 'kindling_footer_copyright_text',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_footer_bottom',
			) ) );

			/**
			 * Footer Bottom Padding
			 */
			$wp_customize->add_setting( 'kindling_bottom_footer_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_bottom_footer_padding', array(
				'label'	   				=> esc_html__( 'Padding', 'kindling' ),
				'description' 			=> esc_html__( 'Format: top right bottom left.', 'kindling' ),
				'type' 					=> 'text',
				'section'  				=> $section,
				'settings' 				=> 'kindling_bottom_footer_padding',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_footer_bottom',
			) ) );

			/**
			 * Font Family
			 */
			$wp_customize->add_setting( 'kindling_copyright_font_family', array(
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( new Kindling_Customizer_Typography_Control( $wp_customize, 'kindling_copyright_font_family', array(
				'label' 			=> esc_html__( 'Copyright Font Family', 'kindling' ),
				'section' 			=> $section,
				'settings' 			=> 'kindling_copyright_font_family',
				'priority' 			=> 10,
				'type' 				=> 'select',
				'active_callback'	=> 'kindling_cac_has_footer_bottom',
			) ) );

			/**
			 * Font Weight
			 */
			$wp_customize->add_setting( 'kindling_copyright_font_weight', array(
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( 'kindling_copyright_font_weight', array(
				'label' 			=> esc_html__( 'Copyright Font Weight', 'kindling' ),
				'description' 		=> esc_html__( 'Important: Not all fonts support every font-weight.', 'kindling' ),
				'section' 			=> $section,
				'settings' 			=> 'kindling_copyright_font_weight',
				'priority' 			=> 10,
				'type' 				=> 'select',
				'active_callback'	=> 'kindling_cac_has_footer_bottom',
				'choices' 			=> array(
					'' 					=> esc_html__( 'Default', 'kindling' ),
					'100'				=> esc_html__( 'Thin: 100', 'kindling' ),
					'200'				=> esc_html__( 'Extra Light: 200', 'kindling' ),
					'300'				=> esc_html__( 'Light: 300', 'kindling' ),
					'400'				=> esc_html__( 'Normal: 400', 'kindling' ),
					'500'				=> esc_html__( 'Medium: 500', 'kindling' ),
					'600'				=> esc_html__( 'Semibold: 600', 'kindling' ),
					'700'				=> esc_html__( 'Bold: 700', 'kindling' ),
					'800'				=> esc_html__( 'Extra Bold: 800', 'kindling' ),
					'900'				=> esc_html__( 'Black: 900', 'kindling' ),
				),
			) );

			/**
			 * Font Style
			 */
			$wp_customize->add_setting( 'kindling_copyright_font_style', array(
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( 'kindling_copyright_font_style', array(
				'label' 			=> esc_html__( 'Copyright Font Style', 'kindling' ),
				'section' 			=> $section,
				'settings' 			=> 'kindling_copyright_font_style',
				'priority' 			=> 10,
				'type' 				=> 'select',
				'active_callback'	=> 'kindling_cac_has_footer_bottom',
				'choices' 			=> array(
					''					=> esc_html__( 'Default', 'kindling' ),
					'normal'			=> esc_html__( 'Normal', 'kindling' ),
					'italic'			=> esc_html__( 'Italic', 'kindling' ),
				),
			) );

			/**
			 * Text Transform
			 */
			$wp_customize->add_setting( 'kindling_copyright_text_transform', array(
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( 'kindling_copyright_text_transform', array(
				'label' 			=> esc_html__( 'Copyright Text Transform', 'kindling' ),
				'section' 			=> $section,
				'settings' 			=> 'kindling_copyright_text_transform',
				'priority' 			=> 10,
				'type' 				=> 'select',
				'active_callback'	=> 'kindling_cac_has_footer_bottom',
				'choices' 			=> array(
					''					=> esc_html__( 'Default', 'kindling' ),
					'capitalize'		=> esc_html__( 'Capitalize', 'kindling' ),
					'lowercase'			=> esc_html__( 'Lowercase', 'kindling' ),
					'uppercase'			=> esc_html__( 'Uppercase', 'kindling' ),
				),
			) );

			/**
			 * Font Size
			 */
			$wp_customize->add_setting( 'kindling_copyright_font_size', array(
				'default' 			=> '12',
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_copyright_font_size', array(
				'label' 			=> esc_html__( 'Copyright Font Size (px)', 'kindling' ),
				'section' 			=> $section,
				'settings' 			=> 'kindling_copyright_font_size',
				'priority' 			=> 10,
				'active_callback'	=> 'kindling_cac_has_footer_bottom',
				'input_attrs' 		=> array(
					'min'				=> 0,
					'max'				=> 100,
					'step'				=> 1,
				),
			) ) );

			/**
			 * Line Height
			 */
			$wp_customize->add_setting( 'kindling_copyright_line_height', array(
				'default' 			=> '1',
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_copyright_line_height', array(
				'label' 			=> esc_html__( 'Copyright Line Height', 'kindling' ),
				'section' 			=> $section,
				'settings' 			=> 'kindling_copyright_line_height',
				'priority' 			=> 10,
				'active_callback'	=> 'kindling_cac_has_footer_bottom',
				'input_attrs' 		=> array(
					'min'				=> 0,
					'max'				=> 4,
					'step'				=> 0.1,
				),
			) ) );

			/**
			 * Letter Spacing
			 */
			$wp_customize->add_setting( 'kindling_copyright_letter_spacing', array(
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_copyright_letter_spacing', array(
				'label' 			=> esc_html__( 'Copyright Letter Spacing (px)', 'kindling' ),
				'section' 			=> $section,
				'settings' 			=> 'kindling_copyright_letter_spacing',
				'priority' 			=> 10,
				'active_callback'	=> 'kindling_cac_has_footer_bottom',
				'input_attrs' 		=> array(
					'min'				=> 0,
					'max'				=> 10,
					'step'				=> 0.1,
				),
			) ) );			
			
			/**
			 * Footer Bottom Background Color
			 */
			$wp_customize->add_setting( 'kindling_bottom_footer_background', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#1b1b1b',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_bottom_footer_background', array(
				'label'	   				=> esc_html__( 'Background Color', 'kindling' ),
				'section'  				=> $section,
				'settings' 				=> 'kindling_bottom_footer_background',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_footer_bottom',
			) ) );

			/**
			 * Footer Bottom Color
			 */
			$wp_customize->add_setting( 'kindling_bottom_footer_color', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#929292',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_bottom_footer_color', array(
				'label'	   				=> esc_html__( 'Text Color', 'kindling' ),
				'section'  				=> $section,
				'settings' 				=> 'kindling_bottom_footer_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_footer_bottom',
			) ) );

			/**
			 * Footer Bottom Links Color
			 */
			$wp_customize->add_setting( 'kindling_bottom_footer_link_color', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#ffffff',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_bottom_footer_link_color', array(
				'label'	   				=> esc_html__( 'Links Color', 'kindling' ),
				'section'  				=> $section,
				'settings' 				=> 'kindling_bottom_footer_link_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_footer_bottom',
			) ) );

			/**
			 * Footer Bottom Links Hover Color
			 */
			$wp_customize->add_setting( 'kindling_bottom_footer_link_color_hover', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#13aff0',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_bottom_footer_link_color_hover', array(
				'label'	   				=> esc_html__( 'Links Color: Hover', 'kindling' ),
				'section'  				=> $section,
				'settings' 				=> 'kindling_bottom_footer_link_color_hover',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_footer_bottom',
			) ) );

		}

		/**
		 * Get CSS
		 *
		 * @since 1.0.0
		 */
		public static function head_css( $output ) {
		
			// Global vars
			$bottom_padding 			= get_theme_mod( 'kindling_bottom_footer_padding' );
			$bottom_background 			= get_theme_mod( 'kindling_bottom_footer_background', '#1b1b1b' );
			$bottom_color 				= get_theme_mod( 'kindling_bottom_footer_color', '#929292' );
			$bottom_link_color 			= get_theme_mod( 'kindling_bottom_footer_link_color', '#ffffff' );
			$bottom_link_color_hover 	= get_theme_mod( 'kindling_bottom_footer_link_color_hover', '#13aff0' );
			$copyright_font_family		= get_theme_mod( 'kindling_copyright_font_family' );
			$copyright_font_weight		= get_theme_mod( 'kindling_copyright_font_weight' );
			$copyright_font_style		= get_theme_mod( 'kindling_copyright_font_style' );
			$copyright_text_transform	= get_theme_mod( 'kindling_copyright_text_transform' );
			$copyright_font_size		= get_theme_mod( 'kindling_copyright_font_size', '12' );
			$copyright_line_height		= get_theme_mod( 'kindling_copyright_line_height', '1' );
			$copyright_letter_spacing	= get_theme_mod( 'kindling_copyright_letter_spacing' );

			// Define css var
			$css = '';

			// Footer bottom padding
			if ( ! empty( $bottom_padding ) ) {
				$css .= '#footer-bottom{padding:'. $bottom_padding .';}';
			}

			// Footer bottom background
			if ( ! empty( $bottom_background ) && '#1b1b1b' != $bottom_background ) {
				$css .= '#footer-bottom{background-color:'. $bottom_background .';}';
			}

			// Footer bottom color
			if ( ! empty( $bottom_color ) && '#929292' != $bottom_color ) {
				$css .= '#footer-bottom,#footer-bottom p{color:'. $bottom_color .';}';
			}

			// Footer bottom links color
			if ( ! empty( $bottom_link_color ) && '#ffffff' != $bottom_link_color ) {
				$css .= '#footer-bottom a,#footer-bottom #footer-bottom-menu a{color:'. $bottom_link_color .';}';
			}

			// Footer bottom links hover color
			if ( ! empty( $bottom_link_color_hover ) && '#13aff0' != $bottom_link_color_hover ) {
				$css .= '#footer-bottom a:hover,#footer-bottom #footer-bottom-menu a:hover{color:'. $bottom_link_color_hover .';}';
			}
				
			## START: Copyright Typography
			$css .= '#footer-bottom #copyright{';
			if ( ! empty ( $copyright_font_family ) ) {
				$css .= 'font-family:'. $copyright_font_family .';';
			}
			if ( ! empty ( $copyright_font_weight ) ) {
				$css .= 'font-weight:'. $copyright_font_weight .';';
			}
			if ( ! empty ( $copyright_font_style ) ) {
				$css .= 'font-style:'. $copyright_font_style .';';
			}
			if ( ! empty ( $copyright_text_transform ) ) {
				$css .= 'text-transform:'. $copyright_text_transform .';';
			}
			if ( ! empty ( $copyright_font_size ) && ( $copyright_font_size != '12' ) ) {
				$css .= 'font-size:'. $copyright_font_size .'px;';
			}
			if ( ! empty ( $copyright_line_height ) && ( $copyright_line_height != '1' ) ) {
				$css .= 'line-height:'. $copyright_line_height .';';
			}
			if ( ! empty ( $copyright_letter_spacing ) ) {
				$css .= 'letter-spacing:'. $copyright_letter_spacing .'px;';
			}
			$css .= '}';
			## END: Copyright Typography

			// Return CSS
			if ( ! empty( $css ) ) {
				$output .= '/* Footer Bottom CSS */'. $css;
			}

			// Return output css
			return $output;

		}

	}

endif;

return new Kindling_Footer_Bottom_Customizer();