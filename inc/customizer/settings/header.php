<?php
/**
 * Header Customizer Options
 *
 * @package Kindling Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kindling_Header_Customizer' ) ) :

	class Kindling_Header_Customizer {

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
			 * Panel
			 */
			$panel = 'kindling_header_panel';
			$wp_customize->add_panel( $panel , array(
				'title' 			=> esc_html__( 'Header', 'kindling' ),
				'priority' 			=> 2,
			) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'kindling_header_general' , array(
				'title' 			=> esc_html__( 'General', 'kindling' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Header Style
			 */
			$wp_customize->add_setting( 'kindling_header_style', array(
				'default'           	=> 'minimal',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_header_style', array(
				'label'	   				=> esc_html__( 'Style', 'kindling' ),
				'type' 					=> 'select',
				'section'  				=> 'kindling_header_general',
				'settings' 				=> 'kindling_header_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'minimal' 		=> esc_html__( 'Logo Left', 'kindling' ),
					'top'			=> esc_html__( 'Logo Above/Below', 'kindling' ),
					'center'		=> esc_html__( 'Logo Inline Center', 'kindling' ),
				),
			) ) );

			/**
			 * Header Height
			 */
			$wp_customize->add_setting( 'kindling_header_height', array(
#				'transport' 			=> 'postMessage',
				'default'           	=> '74',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_header_height', array(
				'label'	   				=> esc_html__( 'Height (px)', 'kindling' ),
				'section'  				=> 'kindling_header_general',
				'settings' 				=> 'kindling_header_height',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_hasnt_header_styles',
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 300,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Top Header Height
			 */
			$wp_customize->add_setting( 'kindling_top_header_height', array(
#				'transport' 			=> 'postMessage',
				'default'           	=> '40',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_top_header_height', array(
				'label'	   				=> esc_html__( 'Height (px)', 'kindling' ),
				'section'  				=> 'kindling_header_general',
				'settings' 				=> 'kindling_top_header_height',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_top_header_style',
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Header Top Padding
			 */
			$wp_customize->add_setting( 'kindling_header_top_padding', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '0',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_header_top_padding', array(
				'label'	   				=> esc_html__( 'Top Padding (px)', 'kindling' ),
				'section'  				=> 'kindling_header_general',
				'settings' 				=> 'kindling_header_top_padding',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Header Bottom Padding
			 */
			$wp_customize->add_setting( 'kindling_header_bottom_padding', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '0',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_header_bottom_padding', array(
				'label'	   				=> esc_html__( 'Bottom Padding (px)', 'kindling' ),
				'section'  				=> 'kindling_header_general',
				'settings' 				=> 'kindling_header_bottom_padding',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );			

			/**
			 * Logo Styling Heading
			 */
			$wp_customize->add_setting( 'kindling_logo_styling_heading', array(
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Heading_Control( $wp_customize, 'kindling_logo_styling_heading', array(
				'label'    				=> esc_html__( 'Logo Styling', 'kindling' ),
				'section'  				=> 'kindling_header_general',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Header Logo Max Height
			 */
			$wp_customize->add_setting( 'kindling_logo_height', array(
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_logo_height', array(
				'label'	   				=> esc_html__( 'Logo Max Height (px)', 'kindling' ),
				'section'  				=> 'kindling_header_general',
				'settings' 				=> 'kindling_logo_height',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_custom_logo',
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 300,
					'step'  => 1,
			    ),
			) ) );

			/**
			 * Header Logo Top Margin
			 */
			$wp_customize->add_setting( 'kindling_header_logo_top_margin', array(
				'default'           	=> '0',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_header_logo_top_margin', array(
				'label'	   				=> esc_html__( 'Logo Top Margin (px)', 'kindling' ),
				'section'  				=> 'kindling_header_general',
				'settings' 				=> 'kindling_header_logo_top_margin',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_custom_logo',
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Header Logo Bottom Margin
			 */
			$wp_customize->add_setting( 'kindling_header_logo_bottom_margin', array(
				'default'           	=> '0',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_header_logo_bottom_margin', array(
				'label'	   				=> esc_html__( 'Logo Bottom Margin (px)', 'kindling' ),
				'section'  				=> 'kindling_header_general',
				'settings' 				=> 'kindling_header_logo_bottom_margin',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_custom_logo',
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );			
			
			/**
			 * Header Border Bottom
			 */
			$wp_customize->add_setting( 'kindling_has_header_border_bottom', array(
				'transport' 			=> 'postMessage',
				'default'           	=> true,
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_has_header_border_bottom', array(
				'label'	   				=> esc_html__( 'Header Border Bottom', 'kindling' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'kindling_header_general',
				'settings' 				=> 'kindling_has_header_border_bottom',
				'priority' 				=> 10,
			) ) );

			/**
			 * Header Background Color
			 */
			$wp_customize->add_setting( 'kindling_header_background', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#ffffff',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_header_background', array(
				'label'	   				=> esc_html__( 'Background Color', 'kindling' ),
				'section'  				=> 'kindling_header_general',
				'settings' 				=> 'kindling_header_background',
				'priority' 				=> 10,
			) ) );

			/**
			 * Header Border Bottom Color
			 */
			$wp_customize->add_setting( 'kindling_header_border_bottom', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#f1f1f1',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_header_border_bottom', array(
				'label'	   				=> esc_html__( 'Border Bottom Color', 'kindling' ),
				'section'  				=> 'kindling_header_general',
				'settings' 				=> 'kindling_header_border_bottom',
				'priority' 				=> 10,
			) ) );

			/**
			 * Top Menu Header Menu Background Color
			 */
			$wp_customize->add_setting( 'kindling_top_header_menu_background', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#ffffff',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_top_header_menu_background', array(
				'label'	   				=> esc_html__( 'Menu Background Color', 'kindling' ),
				'section'  				=> 'kindling_header_general',
				'settings' 				=> 'kindling_top_header_menu_background',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_top_header_style',
			) ) );

			/**
			 * Top Menu Header Search Button Border Color
			 */
			$wp_customize->add_setting( 'kindling_top_header_search_button_border_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#f1f1f1',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_top_header_search_button_border_color', array(
				'label'	   				=> esc_html__( 'Search Button Border Color', 'kindling' ),
				'section'  				=> 'kindling_header_general',
				'settings' 				=> 'kindling_top_header_search_button_border_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_top_header_style',
			) ) );

			/**
			 * Top Menu Header Search Button Color
			 */
			$wp_customize->add_setting( 'kindling_top_header_search_button_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#333333',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_top_header_search_button_color', array(
				'label'	   				=> esc_html__( 'Search Button Color', 'kindling' ),
				'section'  				=> 'kindling_header_general',
				'settings' 				=> 'kindling_top_header_search_button_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_top_header_style',
			) ) );

			/**
			 * Top Menu Header Search Button Hover Color
			 */
			$wp_customize->add_setting( 'kindling_top_header_search_button_hover_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#13aff0',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_top_header_search_button_hover_color', array(
				'label'	   				=> esc_html__( 'Search Button Color: Hover', 'kindling' ),
				'section'  				=> 'kindling_header_general',
				'settings' 				=> 'kindling_top_header_search_button_hover_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_top_header_style',
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'kindling_header_logo' , array(
				'title' 			=> esc_html__( 'Logo', 'kindling' ),
				'priority' 			=> 9,
				'panel' 			=> $panel,
			) );

			/**
			 * Logo Font Heading
			 */
			$wp_customize->add_setting( 'kindling_logo_font_heading', array(
				'sanitize_callback' 	=> false,
			) );
			$wp_customize->add_control( new Kindling_Customizer_Heading_Control( $wp_customize, 'kindling_logo_font_heading', array(
				'label'    				=> esc_html__( 'Text Logo Font Styling', 'kindling' ),
				'section'  				=> 'kindling_header_logo',
				'priority' 				=> 10,
				'active_callback'	=> 'kindling_cac_hasnt_custom_logo',
			) ) );
			
			/**
			 * Logo Font Family
			 */
			$wp_customize->add_setting( 'kindling_logo_font_family', array(
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( new Kindling_Customizer_Typography_Control( $wp_customize, 'kindling_logo_font_family', array(
				'label' 			=> esc_html__( 'Logo Font Family', 'kindling' ),
				'section' 			=> 'kindling_header_logo',
				'settings' 			=> 'kindling_logo_font_family',
				'priority' 			=> 10,
				'type' 				=> 'select',
				'active_callback'	=> 'kindling_cac_hasnt_custom_logo',
			) ) );

			/**
			 * Logo Font Weight
			 */
			$wp_customize->add_setting( 'kindling_logo_font_weight', array(
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( 'kindling_logo_font_weight', array(
				'label' 			=> esc_html__( 'Logo Font Weight', 'kindling' ),
				'description' 		=> esc_html__( 'Important: Not all fonts support every font-weight.', 'kindling' ),
				'section' 			=> 'kindling_header_logo',
				'settings' 			=> 'kindling_logo_font_weight',
				'priority' 			=> 10,
				'type' 				=> 'select',
				'active_callback'	=> 'kindling_cac_hasnt_custom_logo',
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
			 * Logo Font Style
			 */
			$wp_customize->add_setting( 'kindling_logo_font_style', array(
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( 'kindling_logo_font_style', array(
				'label' 			=> esc_html__( 'Logo Font Style', 'kindling' ),
				'section' 			=> 'kindling_header_logo',
				'settings' 			=> 'kindling_logo_font_style',
				'priority' 			=> 10,
				'type' 				=> 'select',
				'active_callback'	=> 'kindling_cac_hasnt_custom_logo',
				'choices' 			=> array(
					''					=> esc_html__( 'Default', 'kindling' ),
					'normal'			=> esc_html__( 'Normal', 'kindling' ),
					'italic'			=> esc_html__( 'Italic', 'kindling' ),
				),
			) );

			/**
			 * Logo Text Transform
			 */
			$wp_customize->add_setting( 'kindling_logo_text_transform', array(
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( 'kindling_logo_text_transform', array(
				'label' 			=> esc_html__( 'Logo Text Transform', 'kindling' ),
				'section' 			=> 'kindling_header_logo',
				'settings' 			=> 'kindling_logo_text_transform',
				'priority' 			=> 10,
				'type' 				=> 'select',
				'active_callback'	=> 'kindling_cac_hasnt_custom_logo',
				'choices' 			=> array(
					''					=> esc_html__( 'Default', 'kindling' ),
					'capitalize'		=> esc_html__( 'Capitalize', 'kindling' ),
					'lowercase'			=> esc_html__( 'Lowercase', 'kindling' ),
					'uppercase'			=> esc_html__( 'Uppercase', 'kindling' ),
				),
			) );

			/**
			 * Logo Font Size
			 */
			$wp_customize->add_setting( 'kindling_logo_font_size', array(
				'default' 			=> '24',
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_logo_font_size', array(
				'label' 			=> esc_html__( 'Logo Font Size (px)', 'kindling' ),
				'section' 			=> 'kindling_header_logo',
				'settings' 			=> 'kindling_logo_font_size',
				'priority' 			=> 10,
				'active_callback'	=> 'kindling_cac_hasnt_custom_logo',
				'input_attrs' 		=> array(
					'min'				=> 0,
					'max'				=> 100,
					'step'				=> 1,
				),
			) ) );

			/**
			 * Logo Line Height
			 */
			$wp_customize->add_setting( 'kindling_logo_line_height', array(
				'default' 			=> '1.8',
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_logo_line_height', array(
				'label' 			=> esc_html__( 'Logo Line Height', 'kindling' ),
				'section' 			=> 'kindling_header_logo',
				'settings' 			=> 'kindling_logo_line_height',
				'priority' 			=> 10,
				'active_callback'	=> 'kindling_cac_hasnt_custom_logo',
				'input_attrs' 		=> array(
					'min'				=> 0,
					'max'				=> 4,
					'step'				=> 0.1,
				),
			) ) );

			/**
			 * Logo Letter Spacing
			 */
			$wp_customize->add_setting( 'kindling_logo_letter_spacing', array(
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_logo_letter_spacing', array(
				'label' 			=> esc_html__( 'Logo Letter Spacing', 'kindling' ),
				'section' 			=> 'kindling_header_logo',
				'settings' 			=> 'kindling_logo_letter_spacing',
				'priority' 			=> 10,
				'active_callback'	=> 'kindling_cac_hasnt_custom_logo',
				'input_attrs' 		=> array(
					'min'				=> 0,
					'max'				=> 10,
					'step'				=> 0.1,
				),
			) ) );
			
			/**
			 * Header Logo Color
			 */
			$wp_customize->add_setting( 'kindling_logo_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#333333',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_logo_color', array(
				'label'	   				=> esc_html__( 'Color', 'kindling' ),
				'section'  				=> 'kindling_header_logo',
				'settings' 				=> 'kindling_logo_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_hasnt_custom_logo',
			) ) );

			/**
			 * Header Logo Hover Color
			 */
			$wp_customize->add_setting( 'kindling_logo_hover_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#13aff0',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_logo_hover_color', array(
				'label'	   				=> esc_html__( 'Color: Hover', 'kindling' ),
				'section'  				=> 'kindling_header_logo',
				'settings' 				=> 'kindling_logo_hover_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_hasnt_custom_logo',
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'kindling_header_menu' , array(
				'title' 			=> esc_html__( 'Menu', 'kindling' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Menu Top Level Dropdown Icon
			 */
			$wp_customize->add_setting( 'kindling_menu_arrow_down', array(
				'default'           	=> true,
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_menu_arrow_down', array(
				'label'	   				=> esc_html__( 'Top Level Dropdown Icon', 'kindling' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_menu_arrow_down',
				'priority' 				=> 10,
			) ) );

			/**
			 * Menu Second+ Level Dropdown Icon
			 */
			$wp_customize->add_setting( 'kindling_menu_arrow_side', array(
				'default'           	=> true,
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_menu_arrow_side', array(
				'label'	   				=> esc_html__( 'Second+ Level Dropdown Icon', 'kindling' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_menu_arrow_side',
				'priority' 				=> 10,
			) ) );

			/**
			 * Menu Dropdown Top Border
			 */
			$wp_customize->add_setting( 'kindling_menu_dropdown_top_border', array(
				'transport' 			=> 'postMessage',
				'default'           	=> true,
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_menu_dropdown_top_border', array(
				'label'	   				=> esc_html__( 'Dropdown Top Border', 'kindling' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_menu_dropdown_top_border',
				'priority' 				=> 10,
			) ) );

			/**
			 * Top Menu Header Menu Position
			 */
			$wp_customize->add_setting( 'kindling_top_header_menu_position', array(
				'default'           	=> 'left',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Buttonset_Control( $wp_customize, 'kindling_top_header_menu_position', array(
				'label'	   				=> esc_html__( 'Menu Position', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_top_header_menu_position',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_top_header_style',
				'choices' 				=> array(
					'left'				=> esc_html__( 'Left', 'kindling' ),
					'center'			=> esc_html__( 'Center', 'kindling' ),
					'right'				=> esc_html__( 'Right', 'kindling' ),
				),
			) ) );

			/**
			 * Top Menu Header Menu Position (Vertical)
			 */
			$wp_customize->add_setting( 'kindling_top_header_menu_vertical_position', array(
				'default'           	=> 'before',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Buttonset_Control( $wp_customize, 'kindling_top_header_menu_vertical_position', array(
				'label'	   				=> esc_html__( 'Menu Vertical Position', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_top_header_menu_vertical_position',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_top_header_style',
				'choices' 				=> array(
					'before'			=> esc_html__( 'Before Logo', 'kindling' ),
					'after'				=> esc_html__( 'After Logo', 'kindling' ),
				),
			) ) );

			/**
			 * Main Styling Heading
			 */
			$wp_customize->add_setting( 'kindling_menu_main_styling_heading', array(
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Heading_Control( $wp_customize, 'kindling_menu_main_styling_heading', array(
				'label'    				=> esc_html__( 'Main Styling', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'priority' 				=> 10,
			) ) );

			/**
			 * Menu Items Padding
			 */
			$wp_customize->add_setting( 'kindling_menu_items_padding', array(
				'transport' 			=> 'postMessage',
				'default'     			=> '15',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_menu_items_padding', array(
				'label'	   				=> esc_html__( 'Left/Right Padding (px)', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_menu_items_padding',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 50,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Font Family
			 */
			$wp_customize->add_setting( 'kindling_menu_font_family', array(
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( new Kindling_Customizer_Typography_Control( $wp_customize, 'kindling_menu_font_family', array(
				'label' 			=> esc_html__( 'Main Menu Font Family', 'kindling' ),
				'section' 			=> 'kindling_header_menu',
				'settings' 			=> 'kindling_menu_font_family',
				'priority' 			=> 10,
				'type' 				=> 'select',
			) ) );

			/**
			 * Font Weight
			 */
			$wp_customize->add_setting( 'kindling_menu_font_weight', array(
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( 'kindling_menu_font_weight', array(
				'label' 			=> esc_html__( 'Main Menu Font Weight', 'kindling' ),
				'description' 		=> esc_html__( 'Important: Not all fonts support every font-weight.', 'kindling' ),
				'section' 			=> 'kindling_header_menu',
				'settings' 			=> 'kindling_menu_font_weight',
				'priority' 			=> 10,
				'type' 				=> 'select',
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
			$wp_customize->add_setting( 'kindling_menu_font_style', array(
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( 'kindling_menu_font_style', array(
				'label' 			=> esc_html__( 'Main Menu Font Style', 'kindling' ),
				'section' 			=> 'kindling_header_menu',
				'settings' 			=> 'kindling_menu_font_style',
				'priority' 			=> 10,
				'type' 				=> 'select',
				'choices' 			=> array(
					''					=> esc_html__( 'Default', 'kindling' ),
					'normal'			=> esc_html__( 'Normal', 'kindling' ),
					'italic'			=> esc_html__( 'Italic', 'kindling' ),
				),
			) );

			/**
			 * Text Transform
			 */
			$wp_customize->add_setting( 'kindling_menu_text_transform', array(
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( 'kindling_menu_text_transform', array(
				'label' 			=> esc_html__( 'Main Menu Text Transform', 'kindling' ),
				'section' 			=> 'kindling_header_menu',
				'settings' 			=> 'kindling_menu_text_transform',
				'priority' 			=> 10,
				'type' 				=> 'select',
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
			$wp_customize->add_setting( 'kindling_menu_font_size', array(
				'default' 			=> '13',
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_menu_font_size', array(
				'label' 			=> esc_html__( 'Main Menu Font Size (px)', 'kindling' ),
				'section' 			=> 'kindling_header_menu',
				'settings' 			=> 'kindling_menu_font_size',
				'priority' 			=> 10,
				'input_attrs' 		=> array(
					'min'				=> 0,
					'max'				=> 100,
					'step'				=> 1,
				),
			) ) );

			/**
			 * Letter Spacing
			 */
			$wp_customize->add_setting( 'kindling_menu_letter_spacing', array(
				'default' 			=> '0.6',
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_menu_letter_spacing', array(
				'label' 			=> esc_html__( 'Main Menu Letter Spacing', 'kindling' ),
				'section' 			=> 'kindling_header_menu',
				'settings' 			=> 'kindling_menu_letter_spacing',
				'priority' 			=> 10,
				'input_attrs' 		=> array(
					'min'				=> 0,
					'max'				=> 10,
					'step'				=> 0.1,
				),
			) ) );

			/**
			 * Menu Link Color
			 */
			$wp_customize->add_setting( 'kindling_menu_link_color', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#555555',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_menu_link_color', array(
				'label'	   				=> esc_html__( 'Link Color', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_menu_link_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Menu Link Color Hover
			 */
			$wp_customize->add_setting( 'kindling_menu_link_color_hover', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#13aff0',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_menu_link_color_hover', array(
				'label'	   				=> esc_html__( 'Link Color: Hover', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_menu_link_color_hover',
				'priority' 				=> 10,
			) ) );

			/**
			 * Menu Link Active Color
			 */
			$wp_customize->add_setting( 'kindling_menu_link_color_active', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#555555',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_menu_link_color_active', array(
				'label'	   				=> esc_html__( 'Link Color: Current Menu Item', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_menu_link_color_active',
				'priority' 				=> 10,
			) ) );

			/**
			 * Menu Link Background Color
			 */
			$wp_customize->add_setting( 'kindling_menu_link_background', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_menu_link_background', array(
				'label'	   				=> esc_html__( 'Link Background', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_menu_link_background',
				'priority' 				=> 10,
			) ) );

			/**
			 * Menu Link Hover Background Color
			 */
			$wp_customize->add_setting( 'kindling_menu_link_hover_background', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_menu_link_hover_background', array(
				'label'	   				=> esc_html__( 'Link Background: Hover', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_menu_link_hover_background',
				'priority' 				=> 10,
			) ) );

			/**
			 * Menu Link Background Current Menu Item
			 */
			$wp_customize->add_setting( 'kindling_menu_link_active_background', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_menu_link_active_background', array(
				'label'	   				=> esc_html__( 'Link Background: Current Menu Item', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_menu_link_active_background',
				'priority' 				=> 10,
			) ) );

			/**
			 * Dropdowns Styling Heading
			 */
			$wp_customize->add_setting( 'kindling_menu_dropdowns_styling_heading', array(
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Heading_Control( $wp_customize, 'kindling_menu_dropdowns_styling_heading', array(
				'label'    				=> esc_html__( 'Dropdowns Styling', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'priority' 				=> 10,
			) ) );

			/**
			 * Dropdowns Width
			 */
			$wp_customize->add_setting( 'kindling_dropdown_width', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '180',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_dropdown_width', array(
				'label'	   				=> esc_html__( 'Width (px)', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_dropdown_width',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 30,
			        'max'   => 500,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Font Family
			 */
			$wp_customize->add_setting( 'kindling_menu_dropdown_font_family', array(
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( new Kindling_Customizer_Typography_Control( $wp_customize, 'kindling_menu_dropdown_font_family', array(
				'label' 			=> esc_html__( 'Main Menu Dropdowns Font Family', 'kindling' ),
				'section' 			=> 'kindling_header_menu',
				'settings' 			=> 'kindling_menu_dropdown_font_family',
				'priority' 			=> 10,
				'type' 				=> 'select',
			) ) );

			/**
			 * Font Weight
			 */
			$wp_customize->add_setting( 'kindling_menu_dropdown_font_weight', array(
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( 'kindling_menu_dropdown_font_weight', array(
				'label' 			=> esc_html__( 'Main Menu Dropdowns Font Weight', 'kindling' ),
				'description' 		=> esc_html__( 'Important: Not all fonts support every font-weight.', 'kindling' ),
				'section' 			=> 'kindling_header_menu',
				'settings' 			=> 'kindling_menu_dropdown_font_weight',
				'priority' 			=> 10,
				'type' 				=> 'select',
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
			$wp_customize->add_setting( 'kindling_menu_dropdown_font_style', array(
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( 'kindling_menu_dropdown_font_style', array(
				'label' 			=> esc_html__( 'Main Menu Dropdowns Font Style', 'kindling' ),
				'section' 			=> 'kindling_header_menu',
				'settings' 			=> 'kindling_menu_dropdown_font_style',
				'priority' 			=> 10,
				'type' 				=> 'select',
				'choices' 			=> array(
					''					=> esc_html__( 'Default', 'kindling' ),
					'normal'			=> esc_html__( 'Normal', 'kindling' ),
					'italic'			=> esc_html__( 'Italic', 'kindling' ),
				),
			) );

			/**
			 * Text Transform
			 */
			$wp_customize->add_setting( 'kindling_menu_dropdown_text_transform', array(
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( 'kindling_menu_dropdown_text_transform', array(
				'label' 			=> esc_html__( 'Main Menu Dropdowns Text Transform', 'kindling' ),
				'section' 			=> 'kindling_header_menu',
				'settings' 			=> 'kindling_menu_dropdown_text_transform',
				'priority' 			=> 10,
				'type' 				=> 'select',
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
			$wp_customize->add_setting( 'kindling_menu_dropdown_font_size', array(
				'default' 			=> '12',
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_menu_dropdown_font_size', array(
				'label' 			=> esc_html__( 'Main Menu Dropdowns Font Size (px)', 'kindling' ),
				'section' 			=> 'kindling_header_menu',
				'settings' 			=> 'kindling_menu_dropdown_font_size',
				'priority' 			=> 10,
				'input_attrs' 		=> array(
					'min'				=> 0,
					'max'				=> 100,
					'step'				=> 1,
				),
			) ) );

			/**
			 * Line Height
			 */
			$wp_customize->add_setting( 'kindling_menu_dropdown_line_height', array(
				'default' 			=> '1.2',
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_menu_dropdown_line_height', array(
				'label' 			=> esc_html__( 'Main Menu Dropdowns Line Height', 'kindling' ),
				'section' 			=> 'kindling_header_menu',
				'settings' 			=> 'kindling_menu_dropdown_line_height',
				'priority' 			=> 10,
				'input_attrs' 		=> array(
					'min'				=> 0,
					'max'				=> 4,
					'step'				=> 0.1,
				),
			) ) );

			/**
			 * Letter Spacing
			 */
			$wp_customize->add_setting( 'kindling_menu_dropdown_letter_spacing', array(
				'default' 			=> '0.6',
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_menu_dropdown_letter_spacing', array(
				'label' 			=> esc_html__( 'Main Menu Dropdowns Letter Spacing', 'kindling' ),
				'section' 			=> 'kindling_header_menu',
				'settings' 			=> 'kindling_menu_dropdown_letter_spacing',
				'priority' 			=> 10,
				'input_attrs' 		=> array(
					'min'				=> 0,
					'max'				=> 10,
					'step'				=> 0.1,
				),
			) ) );

			/**
			 * Dropdown Background Color
			 */
			$wp_customize->add_setting( 'kindling_dropdown_menu_background', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#ffffff',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_dropdown_menu_background', array(
				'label'	   				=> esc_html__( 'Background Color', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_dropdown_menu_background',
				'priority' 				=> 10,
			) ) );

			/**
			 * Dropdown Top Border Color
			 */
			$wp_customize->add_setting( 'kindling_dropdown_menu_top_border', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#13aff0',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_dropdown_menu_top_border', array(
				'label'	   				=> esc_html__( 'Top Border Color', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_dropdown_menu_top_border',
				'priority' 				=> 10,
			) ) );

			/**
			 * Dropdown Borders Color
			 */
			$wp_customize->add_setting( 'kindling_dropdown_menu_borders', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#f1f1f1',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_dropdown_menu_borders', array(
				'label'	   				=> esc_html__( 'Borders Color', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_dropdown_menu_borders',
				'priority' 				=> 10,
			) ) );

			/**
			 * Dropdown Link Color
			 */
			$wp_customize->add_setting( 'kindling_dropdown_menu_link_color', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#333333',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_dropdown_menu_link_color', array(
				'label'	   				=> esc_html__( 'Link Color', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_dropdown_menu_link_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Dropdown Link Hover Color
			 */
			$wp_customize->add_setting( 'kindling_dropdown_menu_link_color_hover', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#555555',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_dropdown_menu_link_color_hover', array(
				'label'	   				=> esc_html__( 'Link Color: Hover', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_dropdown_menu_link_color_hover',
				'priority' 				=> 10,
			) ) );

			/**
			 * Dropdown Link Hover Background Color
			 */
			$wp_customize->add_setting( 'kindling_dropdown_menu_link_hover_bg', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#f8f8f8',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_dropdown_menu_link_hover_bg', array(
				'label'	   				=> esc_html__( 'Link Background: Hover', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_dropdown_menu_link_hover_bg',
				'priority' 				=> 10,
			) ) );

			/**
			 * Dropdown Link Active Color
			 */
			$wp_customize->add_setting( 'kindling_dropdown_menu_link_color_active', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_dropdown_menu_link_color_active', array(
				'label'	   				=> esc_html__( 'Link Color: Current Menu Item', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_dropdown_menu_link_color_active',
				'priority' 				=> 10,
			) ) );

			/**
			 * Dropdown Link Active Background Color
			 */
			$wp_customize->add_setting( 'kindling_dropdown_menu_link_bg_active', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_dropdown_menu_link_bg_active', array(
				'label'	   				=> esc_html__( 'Link Background: Current Menu Item', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_dropdown_menu_link_bg_active',
				'priority' 				=> 10,
			) ) );



			/**
			 * Search Heading
			 */
			$wp_customize->add_setting( 'kindling_menu_search_heading', array(
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Heading_Control( $wp_customize, 'kindling_menu_search_heading', array(
				'label'    				=> esc_html__( 'Search Icon', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'priority' 				=> 10,
			) ) );

			/**
			 * Search Icon Style
			 */
			$wp_customize->add_setting( 'kindling_menu_search_style', array(
				'default'           	=> 'drop_down',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_menu_search_style', array(
				'label'	   				=> esc_html__( 'Search Icon Style', 'kindling' ),
				'type' 					=> 'select',
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_menu_search_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'disabled' 			=> esc_html__( 'Disabled','kindling' ),
					'drop_down' 		=> esc_html__( 'Drop Down','kindling' ),
					'header_replace' 	=> esc_html__( 'Header Replace','kindling' ),
					'overlay' 			=> esc_html__( 'Overlay','kindling' ),
				),
			) ) );

			/**
			 * Search Dropdown Input Background Color
			 */
			$wp_customize->add_setting( 'kindling_search_dropdown_input_background', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_search_dropdown_input_background', array(
				'label'	   				=> esc_html__( 'Input Background Color', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_search_dropdown_input_background',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_menu_search_dropdown',
			) ) );

			/**
			 * Search Dropdown Input Color
			 */
			$wp_customize->add_setting( 'kindling_search_dropdown_input_color', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#333333',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_search_dropdown_input_color', array(
				'label'	   				=> esc_html__( 'Input Color', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_search_dropdown_input_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_menu_search_dropdown',
			) ) );

			/**
			 * Search Dropdown Input Border Color
			 */
			$wp_customize->add_setting( 'kindling_search_dropdown_input_border', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#dddddd',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_search_dropdown_input_border', array(
				'label'	   				=> esc_html__( 'Input Border Color', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_search_dropdown_input_border',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_menu_search_dropdown',
			) ) );

			/**
			 * Search Dropdown Input Focus Border Color
			 */
			$wp_customize->add_setting( 'kindling_search_dropdown_input_border_focus', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#bbbbbb',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_search_dropdown_input_border_focus', array(
				'label'	   				=> esc_html__( 'Input Border Color: Focus', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_search_dropdown_input_border_focus',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_menu_search_dropdown',
			) ) );

			/**
			 * Search Overlay Background Color
			 */
			$wp_customize->add_setting( 'kindling_search_overlay_bg', array(
				'transport' 			=> 'postMessage',
				'default' 				=> 'rgba(0,0,0,0.9)',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_search_overlay_bg', array(
				'label'	   				=> esc_html__( 'Overlay Background Color', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_search_overlay_bg',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_menu_search_overlay',
			) ) );

			/**
			 * Search Overlay Input Color
			 */
			$wp_customize->add_setting( 'kindling_search_overlay_input_color', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#ffffff',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_search_overlay_input_color', array(
				'label'	   				=> esc_html__( 'Input Color', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_search_overlay_input_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_menu_search_overlay',
			) ) );

			/**
			 * Search Overlay Input Dashed Text Color
			 */
			$wp_customize->add_setting( 'kindling_search_overlay_input_dashed_bg', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#ffffff',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_search_overlay_input_dashed_bg', array(
				'label'	   				=> esc_html__( 'Input Dashed Text Color', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_search_overlay_input_dashed_bg',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_menu_search_overlay',
			) ) );

			/**
			 * Search Overlay Input Border Color
			 */
			$wp_customize->add_setting( 'kindling_search_overlay_input_border_color', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#444444',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_search_overlay_input_border_color', array(
				'label'	   				=> esc_html__( 'Input Border Color', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_search_overlay_input_border_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_menu_search_overlay',
			) ) );

			/**
			 * Search Overlay Input Hover Border Color
			 */
			$wp_customize->add_setting( 'kindling_search_overlay_input_hover_border_color', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#777777',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_search_overlay_input_hover_border_color', array(
				'label'	   				=> esc_html__( 'Input Border Color: Hover', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_search_overlay_input_hover_border_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_menu_search_overlay',
			) ) );

			/**
			 * Search Overlay Input Focus Border Color
			 */
			$wp_customize->add_setting( 'kindling_search_overlay_input_focus_border_color', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#ffffff',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_search_overlay_input_focus_border_color', array(
				'label'	   				=> esc_html__( 'Input Border Color: Focus', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_search_overlay_input_focus_border_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_menu_search_overlay',
			) ) );

			/**
			 * Search Overlay Close Button Color
			 */
			$wp_customize->add_setting( 'kindling_search_overlay_close_button_color', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#ffffff',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_search_overlay_close_button_color', array(
				'label'	   				=> esc_html__( 'Close Button Color', 'kindling' ),
				'section'  				=> 'kindling_header_menu',
				'settings' 				=> 'kindling_search_overlay_close_button_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_menu_search_overlay',
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'kindling_header_mobile_menu' , array(
				'title' 			=> esc_html__( 'Mobile Menu', 'kindling' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Mobile Menu Icon Class
			 */
			$wp_customize->add_setting( 'kindling_mobile_menu_icon', array(
				'default'           	=> 'bars',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_mobile_menu_icon', array(
				'label'	   				=> esc_html__( 'Toggle Icon FontAwesome Class', 'kindling' ),
				'description'			=> esc_html__( '(default: bars)', 'kindling' ),
				'section'  				=> 'kindling_header_mobile_menu',
				'settings' 				=> 'kindling_mobile_menu_icon',
				'priority' 				=> 10,
			) ) );

			/**
			 * Mobile Menu Toggle Text
			 */
			$wp_customize->add_setting( 'kindling_mobile_menu_text', array(
				'default'           	=> 'MENU',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_mobile_menu_text', array(
				'label'	   				=> esc_html__( 'Toggle Text', 'kindling' ),
				'description'			=> esc_html__( '(default: MENU)', 'kindling' ),
				'section'  				=> 'kindling_header_mobile_menu',
				'settings' 				=> 'kindling_mobile_menu_text',
				'priority' 				=> 10,
			) ) );

			/**
			 * Mobile Menu Direction
			 */
			$wp_customize->add_setting( 'kindling_mobile_menu_sidr_direction', array(
				'default'           	=> 'left',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Buttonset_Control( $wp_customize, 'kindling_mobile_menu_sidr_direction', array(
				'label'	   				=> esc_html__( 'Direction', 'kindling' ),
				'section'  				=> 'kindling_header_mobile_menu',
				'settings' 				=> 'kindling_mobile_menu_sidr_direction',
				'priority' 				=> 10,
				'choices' 				=> array(
					'left' 	=> esc_html__( 'Left', 'kindling' ),
					'right' => esc_html__( 'Right', 'kindling' ),
				),
			) ) );

			/**
			 * Mobile Menu Displace
			 */
			$wp_customize->add_setting( 'kindling_mobile_menu_sidr_displace', array(
				'default'           	=> true,
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_mobile_menu_sidr_displace', array(
				'label'	   				=> esc_html__( 'Displace', 'kindling' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'kindling_header_mobile_menu',
				'settings' 				=> 'kindling_mobile_menu_sidr_displace',
				'priority' 				=> 10,
			) ) );

			/**
			 * Mobile Menu Search
			 */
			$wp_customize->add_setting( 'kindling_mobile_menu_search', array(
				'default'           	=> true,
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_mobile_menu_search', array(
				'label'	   				=> esc_html__( 'Mobile Menu Search', 'kindling' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'kindling_header_mobile_menu',
				'settings' 				=> 'kindling_mobile_menu_search',
				'priority' 				=> 10,
			) ) );

			/**
			 * Mobile Header Height
			 */
			$wp_customize->add_setting( 'kindling_mobile_header_height', array(
				'default'           	=> '74',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_mobile_header_height', array(
				'label'	   				=> esc_html__( 'Height (px)', 'kindling' ),
				'section'  				=> 'kindling_header_mobile_menu',
				'settings' 				=> 'kindling_mobile_header_height',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_hasnt_header_styles',
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 300,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Top Mobile Header Height
			 */
			$wp_customize->add_setting( 'kindling_mobile_top_header_height', array(
				'default'           	=> '40',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_mobile_top_header_height', array(
				'label'	   				=> esc_html__( 'Height (px)', 'kindling' ),
				'section'  				=> 'kindling_header_mobile_menu',
				'settings' 				=> 'kindling_mobile_top_header_height',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_top_header_style',
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Mobile Header Top Margin
			 */
			$wp_customize->add_setting( 'kindling_mobile_header_top_margin', array(
				'default'           	=> '0',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_mobile_header_top_margin', array(
				'label'	   				=> esc_html__( 'Top Margin (px)', 'kindling' ),
				'section'  				=> 'kindling_header_mobile_menu',
				'settings' 				=> 'kindling_mobile_header_top_margin',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Mobile Header Bottom Margin
			 */
			$wp_customize->add_setting( 'kindling_mobile_header_bottom_margin', array(
				'default'           	=> '0',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_mobile_header_bottom_margin', array(
				'label'	   				=> esc_html__( 'Bottom Margin (px)', 'kindling' ),
				'section'  				=> 'kindling_header_mobile_menu',
				'settings' 				=> 'kindling_mobile_header_bottom_margin',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );			

			/**
			 * Mobile Logo Styling Heading
			 */
			$wp_customize->add_setting( 'kindling_mobile_logo_styling_heading', array(
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Heading_Control( $wp_customize, 'kindling_mobile_logo_styling_heading', array(
				'label'    				=> esc_html__( 'Mobile Logo Styling', 'kindling' ),
				'section'  				=> 'kindling_header_mobile_menu',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Mobile Header Logo Max Height
			 */
			$wp_customize->add_setting( 'kindling_mobile_logo_height', array(
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_mobile_logo_height', array(
				'label'	   				=> esc_html__( 'Logo Max Height (px)', 'kindling' ),
				'section'  				=> 'kindling_header_mobile_menu',
				'settings' 				=> 'kindling_mobile_logo_height',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_custom_logo',
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 300,
					'step'  => 1,
			    ),
			) ) );

			/**
			 * Mobile Header Logo Top Margin
			 */
			$wp_customize->add_setting( 'kindling_mobile_header_logo_top_margin', array(
				'default'           	=> '0',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_mobile_header_logo_top_margin', array(
				'label'	   				=> esc_html__( 'Logo Top Margin (px)', 'kindling' ),
				'section'  				=> 'kindling_header_mobile_menu',
				'settings' 				=> 'kindling_mobile_header_logo_top_margin',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_custom_logo',
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Mobile Header Logo Bottom Margin
			 */
			$wp_customize->add_setting( 'kindling_mobile_header_logo_bottom_margin', array(
				'default'           	=> '0',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_mobile_header_logo_bottom_margin', array(
				'label'	   				=> esc_html__( 'Logo Bottom Margin (px)', 'kindling' ),
				'section'  				=> 'kindling_header_mobile_menu',
				'settings' 				=> 'kindling_mobile_header_logo_bottom_margin',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_custom_logo',
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );
			
			/**
			 * Mobile Menu Styling
			 */
			$wp_customize->add_setting( 'kindling_mobile_menu_styling_heading', array(
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Heading_Control( $wp_customize, 'kindling_mobile_menu_styling_heading', array(
				'label'    				=> esc_html__( 'Styling: Mobile Sidebar Menu', 'kindling' ),
				'section'  				=> 'kindling_header_mobile_menu',
				'priority' 				=> 10,
			) ) );

			/**
			 * Font Family
			 */
			$wp_customize->add_setting( 'kindling_mobile_menu_dropdown_font_family', array(
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( new Kindling_Customizer_Typography_Control( $wp_customize, 'kindling_mobile_menu_dropdown_font_family', array(
				'label' 			=> esc_html__( 'Mobile Menu Dropdowns Font Family', 'kindling' ),
				'section' 			=> 'kindling_header_mobile_menu',
				'settings' 			=> 'kindling_mobile_menu_dropdown_font_family',
				'priority' 			=> 10,
				'type' 				=> 'select',
			) ) );

			/**
			 * Font Weight
			 */
			$wp_customize->add_setting( 'kindling_mobile_menu_dropdown_font_weight', array(
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( 'kindling_mobile_menu_dropdown_font_weight', array(
				'label' 			=> esc_html__( 'Mobile Menu Dropdowns Font Weight', 'kindling' ),
				'description' 		=> esc_html__( 'Important: Not all fonts support every font-weight.', 'kindling' ),
				'section' 			=> 'kindling_header_mobile_menu',
				'settings' 			=> 'kindling_mobile_menu_dropdown_font_weight',
				'priority' 			=> 10,
				'type' 				=> 'select',
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
			$wp_customize->add_setting( 'kindling_mobile_menu_dropdown_font_style', array(
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( 'kindling_mobile_menu_dropdown_font_style', array(
				'label' 			=> esc_html__( 'Mobile Menu Dropdowns Font Style', 'kindling' ),
				'section' 			=> 'kindling_header_mobile_menu',
				'settings' 			=> 'kindling_mobile_menu_dropdown_font_style',
				'priority' 			=> 10,
				'type' 				=> 'select',
				'choices' 			=> array(
					''					=> esc_html__( 'Default', 'kindling' ),
					'normal'			=> esc_html__( 'Normal', 'kindling' ),
					'italic'			=> esc_html__( 'Italic', 'kindling' ),
				),
			) );

			/**
			 * Text Transform
			 */
			$wp_customize->add_setting( 'kindling_mobile_menu_dropdown_text_transform', array(
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( 'kindling_mobile_menu_dropdown_text_transform', array(
				'label' 			=> esc_html__( 'Mobile Menu Dropdowns Text Transform', 'kindling' ),
				'section' 			=> 'kindling_header_mobile_menu',
				'settings' 			=> 'kindling_mobile_menu_dropdown_text_transform',
				'priority' 			=> 10,
				'type' 				=> 'select',
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
			$wp_customize->add_setting( 'kindling_mobile_menu_dropdown_font_size', array(
				'default' 			=> '15',
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_mobile_menu_dropdown_font_size', array(
				'label' 			=> esc_html__( 'Mobile Menu Dropdowns Font Size (px)', 'kindling' ),
				'section' 			=> 'kindling_header_mobile_menu',
				'settings' 			=> 'kindling_mobile_menu_dropdown_font_size',
				'priority' 			=> 10,
				'input_attrs' 		=> array(
					'min'				=> 0,
					'max'				=> 100,
					'step'				=> 1,
				),
			) ) );

			/**
			 * Line Height
			 */
			$wp_customize->add_setting( 'kindling_mobile_menu_dropdown_line_height', array(
				'default' 			=> '1.8',
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_mobile_menu_dropdown_line_height', array(
				'label' 			=> esc_html__( 'Mobile Menu Dropdowns Line Height', 'kindling' ),
				'section' 			=> 'kindling_header_mobile_menu',
				'settings' 			=> 'kindling_mobile_menu_dropdown_line_height',
				'priority' 			=> 10,
				'input_attrs' 		=> array(
					'min'				=> 0,
					'max'				=> 4,
					'step'				=> 0.1,
				),
			) ) );

			/**
			 * Letter Spacing
			 */
			$wp_customize->add_setting( 'kindling_mobile_menu_dropdown_letter_spacing', array(
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_mobile_menu_dropdown_letter_spacing', array(
				'label' 			=> esc_html__( 'Mobile Menu Dropdowns Letter Spacing', 'kindling' ),
				'section' 			=> 'kindling_header_mobile_menu',
				'settings' 			=> 'kindling_mobile_menu_dropdown_letter_spacing',
				'priority' 			=> 10,
				'input_attrs' 		=> array(
					'min'				=> 0,
					'max'				=> 10,
					'step'				=> 0.1,
				),
			) ) );

			/**
			 * Mobile Menu Close Button Background
			 */
			$wp_customize->add_setting( 'kindling_mobile_menu_sidr_close_button_background', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#f8f8f8',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_mobile_menu_sidr_close_button_background', array(
				'label'	   				=> esc_html__( 'Close Button Background', 'kindling' ),
				'section'  				=> 'kindling_header_mobile_menu',
				'settings' 				=> 'kindling_mobile_menu_sidr_close_button_background',
				'priority' 				=> 10,
			) ) );

			/**
			 * Mobile Menu Background
			 */
			$wp_customize->add_setting( 'kindling_mobile_menu_sidr_background', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#ffffff',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_mobile_menu_sidr_background', array(
				'label'	   				=> esc_html__( 'Background Color', 'kindling' ),
				'section'  				=> 'kindling_header_mobile_menu',
				'settings' 				=> 'kindling_mobile_menu_sidr_background',
				'priority' 				=> 10,
			) ) );

			/**
			 * Mobile Menu Background
			 */
			$wp_customize->add_setting( 'kindling_mobile_menu_sidr_borders', array(
				'transport' 			=> 'postMessage',
				'default' 				=> 'rgba(0,0,0,0.035)',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_mobile_menu_sidr_borders', array(
				'label'	   				=> esc_html__( 'Borders Color', 'kindling' ),
				'section'  				=> 'kindling_header_mobile_menu',
				'settings' 				=> 'kindling_mobile_menu_sidr_borders',
				'priority' 				=> 10,
			) ) );

			/**
			 * Mobile Menu Links Color
			 */
			$wp_customize->add_setting( 'kindling_mobile_menu_links', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#555555',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_mobile_menu_links', array(
				'label'	   				=> esc_html__( 'Links Color', 'kindling' ),
				'section'  				=> 'kindling_header_mobile_menu',
				'settings' 				=> 'kindling_mobile_menu_links',
				'priority' 				=> 10,
			) ) );

			/**
			 * Mobile Menu Links Hover Color
			 */
			$wp_customize->add_setting( 'kindling_mobile_menu_links_hover', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#13aff0',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_mobile_menu_links_hover', array(
				'label'	   				=> esc_html__( 'Links Color: Hover', 'kindling' ),
				'section'  				=> 'kindling_header_mobile_menu',
				'settings' 				=> 'kindling_mobile_menu_links_hover',
				'priority' 				=> 10,
			) ) );

			/**
			 * Mobile Menu Background Color
			 */
			$wp_customize->add_setting( 'kindling_mobile_menu_sidr_dropdowns_background', array(
				'transport' 			=> 'postMessage',
				'default' 				=> 'rgba(0,0,0,0.02)',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_mobile_menu_sidr_dropdowns_background', array(
				'label'	   				=> esc_html__( 'Dropdowns Menus: Background', 'kindling' ),
				'section'  				=> 'kindling_header_mobile_menu',
				'settings' 				=> 'kindling_mobile_menu_sidr_dropdowns_background',
				'priority' 				=> 10,
			) ) );

			/**
			 * Mobile Menu Searchbar Background
			 */
			$wp_customize->add_setting( 'kindling_mobile_menu_sidr_search_bg', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_mobile_menu_sidr_search_bg', array(
				'label'	   				=> esc_html__( 'Searchbar Background', 'kindling' ),
				'section'  				=> 'kindling_header_mobile_menu',
				'settings' 				=> 'kindling_mobile_menu_sidr_search_bg',
				'priority' 				=> 10,
			) ) );

			/**
			 * Mobile Menu Searchbar Color
			 */
			$wp_customize->add_setting( 'kindling_mobile_menu_sidr_search_color', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#333333',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_mobile_menu_sidr_search_color', array(
				'label'	   				=> esc_html__( 'Searchbar Color', 'kindling' ),
				'section'  				=> 'kindling_header_mobile_menu',
				'settings' 				=> 'kindling_mobile_menu_sidr_search_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Mobile Menu Searchbar Border Color
			 */
			$wp_customize->add_setting( 'kindling_mobile_menu_sidr_search_border_color', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#dddddd',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_mobile_menu_sidr_search_border_color', array(
				'label'	   				=> esc_html__( 'Searchbar Border Color', 'kindling' ),
				'section'  				=> 'kindling_header_mobile_menu',
				'settings' 				=> 'kindling_mobile_menu_sidr_search_border_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Mobile Menu Searchbar Focus Border Color
			 */
			$wp_customize->add_setting( 'kindling_mobile_menu_sidr_search_border_color_focus', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#bbbbbb',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_mobile_menu_sidr_search_border_color_focus', array(
				'label'	   				=> esc_html__( 'Searchbar Border Color: Focus', 'kindling' ),
				'section'  				=> 'kindling_header_mobile_menu',
				'settings' 				=> 'kindling_mobile_menu_sidr_search_border_color_focus',
				'priority' 				=> 10,
			) ) );

			/**
			 * Mobile Menu Searchbar Button Color
			 */
			$wp_customize->add_setting( 'kindling_mobile_menu_sidr_search_button_color', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#555555',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_mobile_menu_sidr_search_button_color', array(
				'label'	   				=> esc_html__( 'Searchbar Button Color', 'kindling' ),
				'section'  				=> 'kindling_header_mobile_menu',
				'settings' 				=> 'kindling_mobile_menu_sidr_search_button_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Mobile Menu Searchbar Hover Button Color
			 */
			$wp_customize->add_setting( 'kindling_mobile_menu_sidr_search_button_hover_color', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#222222',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_mobile_menu_sidr_search_button_hover_color', array(
				'label'	   				=> esc_html__( 'Searchbar Button Color: Hover', 'kindling' ),
				'section'  				=> 'kindling_header_mobile_menu',
				'settings' 				=> 'kindling_mobile_menu_sidr_search_button_hover_color',
				'priority' 				=> 10,
			) ) );

		}

		/**
		 * Get CSS
		 *
		 * @since 1.0.0
		 */
		public static function head_css( $output ) {

			// Get header style
			$header_style 									= get_theme_mod( 'kindling_header_style', 'minimal' );
		
			// Global vars
			$header_height 									= get_theme_mod( 'kindling_header_height', '74' );
			$top_height 									= get_theme_mod( 'kindling_top_header_height', '40' );
			$header_background 								= get_theme_mod( 'kindling_header_background', '#ffffff' );
			$header_border_bottom 							= get_theme_mod( 'kindling_header_border_bottom', '#f1f1f1' );
			$header_top_padding								= get_theme_mod( 'kindling_header_top_padding', '0' );
			$header_bottom_padding							= get_theme_mod( 'kindling_header_bottom_padding', '0' );
			$top_header_menu_background 					= get_theme_mod( 'kindling_top_header_menu_background', '#ffffff' );
			$top_header_search_button_border_color 			= get_theme_mod( 'kindling_top_header_search_button_border_color', '#f1f1f1' );
			$top_header_search_button_color 				= get_theme_mod( 'kindling_top_header_search_button_color', '#333333' );
			$top_header_search_button_hover_color 			= get_theme_mod( 'kindling_top_header_search_button_hover_color', '#13aff0' );
			$logo_height									= get_theme_mod( 'kindling_logo_height' );
			$logo_color 									= get_theme_mod( 'kindling_logo_color', '#333333' );
			$logo_hover_color 								= get_theme_mod( 'kindling_logo_hover_color', '#13aff0' );
			$logo_top_margin								= get_theme_mod( 'kindling_header_logo_top_margin', '0' );
			$logo_bottom_margin								= get_theme_mod( 'kindling_header_logo_bottom_margin', '0' );
			$search_dropdown_input_bg 						= get_theme_mod( 'kindling_search_dropdown_input_background' );
			$search_dropdown_input_color 					= get_theme_mod( 'kindling_search_dropdown_input_color', '#333333' );
			$search_dropdown_input_border 					= get_theme_mod( 'kindling_search_dropdown_input_border', '#dddddd' );
			$search_dropdown_input_border_focus 			= get_theme_mod( 'kindling_search_dropdown_input_border_focus', '#bbbbbb' );
			$search_overlay_bg 								= get_theme_mod( 'kindling_search_overlay_bg', 'rgba(0,0,0,0.9)' );
			$search_overlay_input_color 					= get_theme_mod( 'kindling_search_overlay_input_color', '#ffffff' );
			$search_overlay_input_dashed_bg 				= get_theme_mod( 'kindling_search_overlay_input_dashed_bg', '#ffffff' );
			$search_overlay_input_border 					= get_theme_mod( 'kindling_search_overlay_input_border_color', '#444444' );
			$search_overlay_input_border_hover 				= get_theme_mod( 'kindling_search_overlay_input_hover_border_color', '#777777' );
			$search_overlay_input_border_focus 				= get_theme_mod( 'kindling_search_overlay_input_focus_border_color', '#ffffff' );
			$search_overlay_close_button_color 				= get_theme_mod( 'kindling_search_overlay_close_button_color', '#ffffff' );
			$menu_items_padding 							= get_theme_mod( 'kindling_menu_items_padding', '15' );
			$menu_link_color 								= get_theme_mod( 'kindling_menu_link_color', '#555555' );
			$menu_link_color_hover 							= get_theme_mod( 'kindling_menu_link_color_hover', '#13aff0' );
			$menu_link_color_active 						= get_theme_mod( 'kindling_menu_link_color_active', '#555555' );
			$menu_link_background 							= get_theme_mod( 'kindling_menu_link_background' );
			$menu_link_hover_background 					= get_theme_mod( 'kindling_menu_link_hover_background' );
			$menu_link_active_background 					= get_theme_mod( 'kindling_menu_link_active_background' );
			$dropdown_width 								= get_theme_mod( 'kindling_dropdown_width', '180' );
			$dropdown_menu_background 						= get_theme_mod( 'kindling_dropdown_menu_background', '#ffffff' );
			$dropdown_menu_top_border 						= get_theme_mod( 'kindling_dropdown_menu_top_border', '#13aff0' );
			$dropdown_menu_borders 							= get_theme_mod( 'kindling_dropdown_menu_borders', '#f1f1f1' );
			$dropdown_menu_link_color 						= get_theme_mod( 'kindling_dropdown_menu_link_color', '#333333' );
			$dropdown_menu_link_color_hover 				= get_theme_mod( 'kindling_dropdown_menu_link_color_hover', '#555555' );
			$dropdown_menu_link_hover_bg 					= get_theme_mod( 'kindling_dropdown_menu_link_hover_bg', '#f8f8f8' );
			$dropdown_menu_link_color_active 				= get_theme_mod( 'kindling_dropdown_menu_link_color_active' );
			$dropdown_menu_link_bg_active 					= get_theme_mod( 'kindling_dropdown_menu_link_bg_active' );
			$mobile_menu_sidr_close_button_bg 				= get_theme_mod( 'kindling_mobile_menu_sidr_close_button_background', '#f8f8f8' );
			$mobile_menu_sidr_background 					= get_theme_mod( 'kindling_mobile_menu_sidr_background', '#ffffff' );
			$mobile_menu_sidr_borders 						= get_theme_mod( 'kindling_mobile_menu_sidr_borders', 'rgba(0,0,0,0.035)' );
			$mobile_menu_links 								= get_theme_mod( 'kindling_mobile_menu_links', '#555555' );
			$mobile_menu_links_hover 						= get_theme_mod( 'kindling_mobile_menu_links_hover', '#13aff0' );
			$mobile_menu_sidr_dropdowns_bg 					= get_theme_mod( 'kindling_mobile_menu_sidr_dropdowns_background', 'rgba(0,0,0,0.02)' );
			$mobile_menu_sidr_search_bg 					= get_theme_mod( 'kindling_mobile_menu_sidr_search_bg' );
			$mobile_menu_sidr_search_color 					= get_theme_mod( 'kindling_mobile_menu_sidr_search_color', '#333333' );
			$mobile_menu_sidr_search_border_color 			= get_theme_mod( 'kindling_mobile_menu_sidr_search_border_color', '#dddddd' );
			$mobile_menu_sidr_search_border_color_focus 	= get_theme_mod( 'kindling_mobile_menu_sidr_search_border_color_focus', '#bbbbbb' );
			$mobile_menu_sidr_search_button_color 			= get_theme_mod( 'kindling_mobile_menu_sidr_search_button_color', '#555555' );
			$mobile_menu_sidr_search_button_hover_color 	= get_theme_mod( 'kindling_mobile_menu_sidr_search_button_hover_color', '#222222' );
			$top_menu_pos									= get_theme_mod( 'kindling_top_header_menu_position', 'left' );
			$mobile_header_height 							= get_theme_mod( 'kindling_mobile_header_height', '74' );
			$mobile_top_height 								= get_theme_mod( 'kindling_mobile_top_header_height', '40' );
			$mobile_header_top_margin						= get_theme_mod( 'kindling_mobile_header_top_margin', '0' );
			$mobile_header_bottom_margin					= get_theme_mod( 'kindling_mobile_header_bottom_margin', '0' );
			$mobile_logo_height								= get_theme_mod( 'kindling_mobile_logo_height' );
			$mobile_logo_top_margin							= get_theme_mod( 'kindling_mobile_header_logo_top_margin', '0' );
			$mobile_logo_bottom_margin						= get_theme_mod( 'kindling_mobile_header_logo_bottom_margin', '0' );
			### TYPOGRAPHY: LOGO ##
			$logo_font_family								= get_theme_mod( 'kindling_logo_font_family' );
			$logo_font_weight								= get_theme_mod( 'kindling_logo_font_weight' );
			$logo_font_style								= get_theme_mod( 'kindling_logo_font_style' );
			$logo_text_transform							= get_theme_mod( 'kindling_logo_text_transform' );
			$logo_font_size									= get_theme_mod( 'kindling_logo_font_size', '24' );
			$logo_line_height								= get_theme_mod( 'kindling_logo_line_height', '1.8' );
			$logo_letter_spacing							= get_theme_mod( 'kindling_logo_letter_spacing' );
			### TYPOGRAPHY: MAIN MENU ##
			$menu_font_family								= get_theme_mod( 'kindling_menu_font_family' );
			$menu_font_weight								= get_theme_mod( 'kindling_menu_font_weight' );
			$menu_font_style								= get_theme_mod( 'kindling_menu_font_style' );
			$menu_text_transform							= get_theme_mod( 'kindling_menu_text_transform' );
			$menu_font_size									= get_theme_mod( 'kindling_menu_font_size', '13' );
			$menu_letter_spacing							= get_theme_mod( 'kindling_menu_letter_spacing', '0.6' );
			### TYPOGRAPHY: MAIN MENU DROPDOWNS ##
			$menu_dropdown_font_family						= get_theme_mod( 'kindling_menu_dropdown_font_family' );
			$menu_dropdown_font_weight						= get_theme_mod( 'kindling_menu_dropdown_font_weight' );
			$menu_dropdown_font_style						= get_theme_mod( 'kindling_menu_dropdown_font_style' );
			$menu_dropdown_text_transform					= get_theme_mod( 'kindling_menu_dropdown_text_transform' );
			$menu_dropdown_font_size						= get_theme_mod( 'kindling_menu_dropdown_font_size', '12' );
			$menu_dropdown_line_height						= get_theme_mod( 'kindling_menu_dropdown_line_height', '1.2' );
			$menu_dropdown_letter_spacing					= get_theme_mod( 'kindling_menu_dropdown_letter_spacing', '0.6' );
			### TYPOGRAPHY: MOBILE MENU DROPDOWNS ##
			$mobile_menu_dropdown_font_family				= get_theme_mod( 'kindling_mobile_menu_dropdown_font_family' );
			$mobile_menu_dropdown_font_weight				= get_theme_mod( 'kindling_mobile_menu_dropdown_font_weight' );
			$mobile_menu_dropdown_font_style				= get_theme_mod( 'kindling_mobile_menu_dropdown_font_style' );
			$mobile_menu_dropdown_text_transform			= get_theme_mod( 'kindling_mobile_menu_dropdown_text_transform' );
			$mobile_menu_dropdown_font_size					= get_theme_mod( 'kindling_mobile_menu_dropdown_font_size', '15' );
			$mobile_menu_dropdown_line_height				= get_theme_mod( 'kindling_mobile_menu_dropdown_line_height', '1.8' );
			$mobile_menu_dropdown_letter_spacing			= get_theme_mod( 'kindling_mobile_menu_dropdown_letter_spacing' );
			
			// Define css var
			$css = '';

			## START: Media Query - Desktop (959px-)
			$css .= '@media only screen and (min-width:959px){';

			// Add header height
			if ( ( ! empty( $header_height ) && 'top' != $header_style ) ) {
				$css .= '#site-logo #site-logo-inner{height:'. $header_height .'px;}';
				$css .= '#site-navigation-wrap .dropdown-menu > li > a,#kindling-mobile-menu-icon a{line-height:'. $header_height .'px;}';
			}

			// Add header height for top header style
			if ( ! empty( $top_height ) && 'top' == $header_style  ) {
				$css .= '#site-header.top-header #search-toggle{height:'. $top_height .'px;}';
				$css .= '#site-header.top-header #site-navigation-wrap .dropdown-menu > li > a,#site-header.top-header #kindling-mobile-menu-icon a{line-height:'. $top_height .'px;}';
			}

			// Header top padding
			if ( ! empty( $header_top_padding ) && '0' != $header_top_padding ) {
				$css .= '#site-header-inner{padding-top:'. $header_top_padding .'px;}';
			}

			// Header bottom padding
			if ( ! empty( $header_bottom_padding ) && '0' != $header_bottom_padding ) {
				$css .= '#site-header-inner{padding-bottom:'. $header_bottom_padding .'px;}';
			}

			# Header logo max height
			if ( !empty( $logo_height ) ) {
				# Top Menu should always use logo height
				if ( $header_style == 'top' ) {
					$css .= '#site-logo #site-logo-inner a img{max-height:'. $logo_height .'px;}';
				} else {
					# Determine if we should use logo or header height
					if ( $logo_height < $header_height ) {
						# If logo height is specified and less than header_height, set it:
						$css .= '#site-logo #site-logo-inner a img,#site-header.center-header #site-navigation .middle-site-logo a img{max-height:'. $logo_height .'px;}';
					} else {
						# If logo height is empty, or larger than menu, set it to menu:
						$css .= '#site-logo #site-logo-inner a img,#site-header.center-header #site-navigation .middle-site-logo a img{max-height:'. $header_height .'px;}';
					}
				}
			}

			// Header logo top margin
			if ( ! empty( $logo_top_margin ) && '0' != $logo_top_margin ) {
				if ( 'center' != $header_style ) {
					$css .= '#site-logo #site-logo-inner a img{margin-top:'. $logo_top_margin .'px;}';
				} else {
					$css .= '#site-header.center-header #site-navigation .middle-site-logo a img{margin-top:'. $logo_top_margin .'px;}';
				}
			}

			// Header logo bottom margin
			if ( ! empty( $logo_bottom_margin ) && '0' != $logo_bottom_margin ) {
				if ( 'center' != $header_style ) {
					$css .= '#site-logo #site-logo-inner a img{margin-bottom:'. $logo_bottom_margin .'px;}';
				} else {
					$css .= '#site-header.center-header #site-navigation .middle-site-logo a img{margin-bottom:'. $logo_bottom_margin .'px;}';
				}
			}
			
			$css .= '}';
			## END: Media Query - Desktop (959px-)
			
			// Header background color
			if ( ! empty( $header_background ) && '#ffffff' != $header_background ) {
				$css .= '#site-header,#searchform-header-replace{background-color:'. $header_background .';}';
			}

			// Header border color
			if ( ! empty( $header_border_bottom ) && '#f1f1f1' != $header_border_bottom ) {
				$css .= '#site-header{border-color:'. $header_border_bottom .';}';
			}

			// Top menu header menu background color
			if ( ! empty( $top_header_menu_background ) && '#ffffff' != $top_header_menu_background ) {
				$css .= '#site-header.top-header .header-top,#site-header.top-header #searchform-header-replace{background-color:'. $top_header_menu_background .';}';
			}

			// Top menu header menu background color
			if ( ! empty( $top_header_search_button_border_color ) && '#f1f1f1' != $top_header_search_button_border_color ) {
				$css .= '#site-header.top-header #search-toggle{border-color:'. $top_header_search_button_border_color .';}';
			}

			// Top menu header menu background color
			if ( ! empty( $top_header_search_button_color ) && '#333333' != $top_header_search_button_color ) {
				$css .= '#site-header.top-header #search-toggle a{color:'. $top_header_search_button_color .';}';
			}

			// Top menu header menu background color
			if ( ! empty( $top_header_search_button_hover_color ) && '#13aff0' != $top_header_search_button_hover_color ) {
				$css .= '#site-header.top-header #search-toggle a:hover{color:'. $top_header_search_button_hover_color .';}';
			}

			// Header logo color
			if ( ! empty( $logo_color ) && '#333333' != $logo_color ) {
				$css .= '#site-logo a.site-logo-text{color:'. $logo_color .';}';
			}

			// Header logo hover color
			if ( ! empty( $logo_hover_color ) && '#13aff0' != $logo_hover_color ) {
				$css .= '#site-logo a.site-logo-text:hover{color:'. $logo_hover_color .';}';
			}

			// Search dropdown input background
			if ( ! empty( $search_dropdown_input_bg ) ) {
				$css .= '#searchform-dropdown input{background-color:'. $search_dropdown_input_bg .';}';
			}

			// Search dropdown input color
			if ( ! empty( $search_dropdown_input_color ) && '#333333' != $search_dropdown_input_color ) {
				$css .= '#searchform-dropdown input{color:'. $search_dropdown_input_color .';}';
			}

			// Search dropdown input border color
			if ( ! empty( $search_dropdown_input_border ) && '#dddddd' != $search_dropdown_input_border ) {
				$css .= '#searchform-dropdown input{border-color:'. $search_dropdown_input_border .';}';
			}

			// Search dropdown input border color focus
			if ( ! empty( $search_dropdown_input_border_focus ) && '#bbbbbb' != $search_dropdown_input_border_focus ) {
				$css .= '#searchform-dropdown input:focus{border-color:'. $search_dropdown_input_border_focus .';}';
			}

			// Search overlay background color
			if ( ! empty( $search_overlay_bg ) && 'rgba(0,0,0,0.9)' != $search_overlay_bg ) {
				$css .= '#searchform-overlay{background-color:'. $search_overlay_bg .';}';
			}

			// Search overlay input color
			if ( ! empty( $search_overlay_input_color ) && '#ffffff' != $search_overlay_input_color ) {
				$css .= '#searchform-overlay form input, #searchform-overlay form label{color:'. $search_overlay_input_color .';}';
			}

			// Search overlay input dashed background
			if ( ! empty( $search_overlay_input_dashed_bg ) && '#ffffff' != $search_overlay_input_dashed_bg ) {
				$css .= '#searchform-overlay form label i{color:'. $search_overlay_input_dashed_bg .';}';
			}

			// Search overlay input border color
			if ( ! empty( $search_overlay_input_border ) && '#444444' != $search_overlay_input_border ) {
				$css .= '#searchform-overlay form input{border-color:'. $search_overlay_input_border .';}';
			}

			// Search overlay input border color hover
			if ( ! empty( $search_overlay_input_border_hover ) && '#777777' != $search_overlay_input_border_hover ) {
				$css .= '#searchform-overlay form input:hover{border-color:'. $search_overlay_input_border_hover .';}';
			}

			// Search overlay input border color focus
			if ( ! empty( $search_overlay_input_border_focus ) && '#ffffff' != $search_overlay_input_border_focus ) {
				$css .= '#searchform-overlay form input:focus{border-color:'. $search_overlay_input_border_focus .';}';
			}

			// Search overlay close button color
			if ( ! empty( $search_overlay_close_button_color ) && '#ffffff' != $search_overlay_close_button_color ) {
				$css .= '.search-overlay .search-toggle-li .search-overlay-toggle.exit > span:before{color:'. $search_overlay_close_button_color .';}';
			}

			// Menu items padding
			if ( ! empty( $menu_items_padding ) && '15' != $menu_items_padding ) {
				$css .= '#site-navigation-wrap .dropdown-menu > li > a{padding: 0 '. $menu_items_padding .'px;}';
			}

			// Menu link color
			if ( ! empty( $menu_link_color ) && '#555555' != $menu_link_color ) {
				$css .= '#site-navigation-wrap .dropdown-menu > li > a,#kindling-mobile-menu-icon a,#searchform-header-replace-close{color:'. $menu_link_color .';}';
			}

			// Menu link color hover
			if ( ! empty( $menu_link_color_hover ) && '#13aff0' != $menu_link_color_hover ) {
				$css .= '#site-navigation-wrap .dropdown-menu > li > a:hover,#kindling-mobile-menu-icon a:hover,#searchform-header-replace-close:hover{color:'. $menu_link_color_hover .';}';
			}

			// Menu link active color
			if ( ! empty( $menu_link_color_active ) && '#555555' != $menu_link_color_active ) {
				$css .= '#site-navigation-wrap .dropdown-menu > .current-menu-item > a > span,#site-navigation-wrap .dropdown-menu > .current-menu-parent > a > span,#site-navigation-wrap .dropdown-menu > .current-menu-item > a:hover > span,#site-navigation-wrap .dropdown-menu > .current-menu-parent > a:hover > span{color:'. $menu_link_color_active .';}';
			}

			// Menu link background color
			if ( ! empty( $menu_link_background ) ) {
				$css .= '#site-navigation-wrap .dropdown-menu > li > a{background-color:'. $menu_link_background .';}';
			}

			// Menu link hover background color
			if ( ! empty( $menu_link_hover_background ) ) {
				$css .= '#site-navigation-wrap .dropdown-menu > li > a:hover,#site-navigation-wrap .dropdown-menu > li.sfHover > a{background-color:'. $menu_link_hover_background .';}';
			}

			// Menu link active background color
			if ( ! empty( $menu_link_active_background ) ) {
				$css .= '#site-navigation-wrap .dropdown-menu > .current-menu-item > a > span,#site-navigation-wrap .dropdown-menu > .current-menu-parent > a > span,#site-navigation-wrap .dropdown-menu > .current-menu-item > a:hover > span,#site-navigation-wrap .dropdown-menu > .current-menu-parent > a:hover > span{background-color:'. $menu_link_active_background .';}';
			}

			// Dropdown menu width
			if ( ! empty( $dropdown_width ) && '180' != $dropdown_width ) {
				$css .= '.dropdown-menu .sub-menu{min-width:'. $dropdown_width .'px;}';
			}

			// Dropdown menu background color
			if ( ! empty( $dropdown_menu_background ) && '#ffffff' != $dropdown_menu_background ) {
				$css .= '.dropdown-menu .sub-menu,#searchform-dropdown,#current-shop-items-dropdown{background-color:'. $dropdown_menu_background .';}';
			}

			// Dropdown menu top border color
			if ( ! empty( $dropdown_menu_top_border ) && '#13aff0' != $dropdown_menu_top_border ) {
				$css .= '.dropdown-menu .sub-menu,#searchform-dropdown,#current-shop-items-dropdown{border-color:'. $dropdown_menu_top_border .';}';
			}

			// Dropdown menu borders color
			if ( ! empty( $dropdown_menu_borders ) && '#f1f1f1' != $dropdown_menu_borders ) {
				$css .= '.dropdown-menu ul li.menu-item,#site-navigation .megamenu > li,#site-navigation .megamenu li ul.sub-menu{border-color:'. $dropdown_menu_borders .';}';
			}

			// Dropdown menu link color
			if ( ! empty( $dropdown_menu_link_color ) && '#333333' != $dropdown_menu_link_color ) {
				$css .= '.dropdown-menu ul li a.menu-link{color:'. $dropdown_menu_link_color .';}';
			}

			// Dropdown menu link hover color
			if ( ! empty( $dropdown_menu_link_color_hover ) && '#555555' != $dropdown_menu_link_color_hover ) {
				$css .= '.dropdown-menu ul li a.menu-link:hover{color:'. $dropdown_menu_link_color_hover .';}';
			}

			// Dropdown menu link hover background color
			if ( ! empty( $dropdown_menu_link_hover_bg ) && '#f8f8f8' != $dropdown_menu_link_hover_bg ) {
				$css .= '.dropdown-menu ul li a.menu-link:hover{background-color:'. $dropdown_menu_link_hover_bg .';}';
			}

			// Dropdown menu link active color
			if ( ! empty( $dropdown_menu_link_color_active ) ) {
				$css .= '.dropdown-menu ul > .current-menu-item > a > span {color:'. $dropdown_menu_link_color_active .';}';
			}

			// Dropdown menu link active background color
			if ( ! empty( $dropdown_menu_link_bg_active ) ) {
				$css .= '.dropdown-menu ul > .current-menu-item > a.menu-link{background-color:'. $dropdown_menu_link_bg_active .';}';
			}

			// Dropdown menu link active background color
			if ( ! empty( $dropdown_category_title_bg ) && '#f8f8f8' != $dropdown_category_title_bg ) {
				$css .= '#site-navigation li.mega-cat .mega-cat-title{background-color:'. $dropdown_category_title_bg .';}';
			}

			// Dropdown menu link active background color
			if ( ! empty( $dropdown_category_title_color ) && '#222222' != $dropdown_category_title_color ) {
				$css .= '#site-navigation li.mega-cat .mega-cat-title{color:'. $dropdown_category_title_color .';}';
			}

			// Dropdown menu link active background color
			if ( ! empty( $dropdown_category_links_color ) && '#555555' != $dropdown_category_links_color ) {
				$css .= '#site-navigation li.mega-cat ul li .mega-post-title a{color:'. $dropdown_category_links_color .';}';
			}

			// Dropdown menu link active background color
			if ( ! empty( $dropdown_category_links_hover_color ) && '#333333' != $dropdown_category_links_hover_color ) {
				$css .= '#site-navigation li.mega-cat ul li .mega-post-title a:hover{color:'. $dropdown_category_links_hover_color .';}';
			}

			// Dropdown menu link active background color
			if ( ! empty( $dropdown_category_date_color ) && '#bbbbbb' != $dropdown_category_date_color ) {
				$css .= '#site-navigation li.mega-cat ul li .mega-post-date{color:'. $dropdown_category_date_color .';}';
			}
			
			// Mobile menu sidr close button background
			if ( ! empty( $mobile_menu_sidr_close_button_bg ) && '#f8f8f8' != $mobile_menu_sidr_close_button_bg ) {
				$css .= 'a.sidr-class-toggle-sidr-close{background-color:'. $mobile_menu_sidr_close_button_bg .';}';
			}

			// Mobile menu background
			if ( ! empty( $mobile_menu_sidr_background ) && '#ffffff' != $mobile_menu_sidr_background ) {
				$css .= '#sidr{background-color:'. $mobile_menu_sidr_background .';}';
			}

			// Mobile menu borders color
			if ( ! empty( $mobile_menu_sidr_borders ) && 'rgba(0,0,0,0.035)' != $mobile_menu_sidr_borders ) {
				$css .= '#sidr li, #sidr ul{border-color:'. $mobile_menu_sidr_borders .';}';
			}

			// Mobile menu links color
			if ( ! empty( $mobile_menu_links ) && '#555555' != $mobile_menu_links ) {
				$css .= 'body .sidr a, body .sidr-class-dropdown-toggle{color:'. $mobile_menu_links .';}';
			}

			// Mobile menu links hover color
			if ( ! empty( $mobile_menu_links_hover ) && '#13aff0' != $mobile_menu_links_hover ) {
				$css .= 'body .sidr a:hover, body .sidr-class-dropdown-toggle:hover, body .sidr-class-dropdown-toggle .fa, body .sidr-class-menu-item-has-children.active > a, body .sidr-class-menu-item-has-children.active > a > .sidr-class-dropdown-toggle{color:'. $mobile_menu_links_hover .';}';
			}

			// Mobile menu dropdowns background color
			if ( ! empty( $mobile_menu_sidr_dropdowns_bg ) && 'rgba(0,0,0,0.02)' != $mobile_menu_sidr_dropdowns_bg ) {
				$css .= '.sidr-class-main-menu ul{background-color:'. $mobile_menu_sidr_dropdowns_bg .';}';
			}

			// Mobile menu search background color
			if ( ! empty( $mobile_menu_sidr_search_bg ) ) {
				$css .= 'body .sidr-class-mobile-searchform input{background-color:'. $mobile_menu_sidr_search_bg .';}';
			}

			// Mobile menu search background color
			if ( ! empty( $mobile_menu_sidr_search_color ) && '#333333' != $mobile_menu_sidr_search_color ) {
				$css .= 'body .sidr-class-mobile-searchform input,body .sidr-class-mobile-searchform input:focus{color:'. $mobile_menu_sidr_search_color .';}';
			}

			// Mobile menu search border color
			if ( ! empty( $mobile_menu_sidr_search_border_color ) && '#dddddd' != $mobile_menu_sidr_search_border_color ) {
				$css .= 'body .sidr-class-mobile-searchform input{border-color:'. $mobile_menu_sidr_search_border_color .';}';
			}

			// Mobile menu search focus border color
			if ( ! empty( $mobile_menu_sidr_search_border_color_focus ) && '#bbbbbb' != $mobile_menu_sidr_search_border_color_focus ) {
				$css .= 'body .sidr-class-mobile-searchform input:focus{border-color:'. $mobile_menu_sidr_search_border_color_focus .';}';
			}

			// Mobile menu search border color
			if ( ! empty( $mobile_menu_sidr_search_button_color ) && '#555555' != $mobile_menu_sidr_search_button_color ) {
				$css .= '.sidr-class-mobile-searchform button{color:'. $mobile_menu_sidr_search_button_color .';}';
			}

			// Mobile menu search border color
			if ( ! empty( $mobile_menu_sidr_search_button_hover_color ) && '#222222' != $mobile_menu_sidr_search_button_hover_color ) {
				$css .= '.sidr-class-mobile-searchform button:hover{color:'. $mobile_menu_sidr_search_button_hover_color .';}';
			}

			## START: Logo Typography
			$css .= '#site-logo a.site-logo-text{';
			if ( ! empty ( $logo_font_family ) ) {
				$css .= 'font-family:'. $logo_font_family .';';
			}
			if ( ! empty ( $logo_font_weight ) ) {
				$css .= 'font-weight:'. $logo_font_weight .';';
			}
			if ( ! empty ( $logo_font_style ) ) {
				$css .= 'font-style:'. $logo_font_style .';';
			}
			if ( ! empty ( $logo_text_transform ) ) {
				$css .= 'text-transform:'. $logo_text_transform .';';
			}
			if ( ! empty ( $logo_font_size ) && ( $logo_font_size != '24' ) ) {
				$css .= 'font-size:'. $logo_font_size .'px;';
			}
			if ( ! empty ( $logo_line_height ) && ( $logo_line_height != '1.8' ) ) {
				$css .= 'line-height:'. $logo_line_height .';';
			}
			if ( ! empty ( $logo_letter_spacing ) ) {
				$css .= 'letter-spacing:'. $logo_letter_spacing .'px;';
			}
			$css .= '}';
			## END: Logo Typography
			
			## START: Main Menu Typography
			$css .= '#site-navigation-wrap .dropdown-menu>li>a,#site-header.top-header #site-navigation-wrap .dropdown-menu>li>a,#site-header.center-header #site-navigation-wrap .dropdown-menu>li>a,#kindling-mobile-menu-icon a{';
			if ( ! empty ( $menu_font_family ) ) {
				$css .= 'font-family:'. $menu_font_family .';';
			}
			if ( ! empty ( $menu_font_weight ) ) {
				$css .= 'font-weight:'. $menu_font_weight .';';
			}
			if ( ! empty ( $menu_font_style ) ) {
				$css .= 'font-style:'. $menu_font_style .';';
			}
			if ( ! empty ( $menu_text_transform ) ) {
				$css .= 'text-transform:'. $menu_text_transform .';';
			}
			if ( ! empty ( $menu_font_size ) && ( $menu_font_size != '13' ) ) {
				$css .= 'font-size:'. $menu_font_size .'px;';
			}
			if ( ! empty ( $menu_letter_spacing ) && ( $menu_letter_spacing != '0.6' ) ) {
				$css .= 'letter-spacing:'. $menu_letter_spacing .'px;';
			}
			$css .= '}';
			## END: Main Menu Typography
			
			## START: Main Menu Dropdowns Typography
			$css .= '.dropdown-menu ul li a.menu-link{';
			if ( ! empty ( $menu_dropdown_font_family ) ) {
				$css .= 'font-family:'. $menu_dropdown_font_family .';';
			}
			if ( ! empty ( $menu_dropdown_font_weight ) ) {
				$css .= 'font-weight:'. $menu_dropdown_font_weight .';';
			}
			if ( ! empty ( $menu_dropdown_font_style ) ) {
				$css .= 'font-style:'. $menu_dropdown_font_style .';';
			}
			if ( ! empty ( $menu_dropdown_text_transform ) ) {
				$css .= 'text-transform:'. $menu_dropdown_text_transform .';';
			}
			if ( ! empty ( $menu_dropdown_font_size ) && ( $menu_dropdown_font_size != '12' ) ) {
				$css .= 'font-size:'. $menu_dropdown_font_size .'px;';
			}
			if ( ! empty ( $menu_dropdown_line_height ) && ( $menu_dropdown_line_height != '1.2' ) ) {
				$css .= 'line-height:'. $menu_dropdown_line_height .';';
			}
			if ( ! empty ( $menu_dropdown_letter_spacing ) && ( $menu_dropdown_letter_spacing != '0.6' ) ) {
				$css .= 'letter-spacing:'. $menu_dropdown_letter_spacing .'px;';
			}
			$css .= '}';
			## END: Main Menu Dropdowns Typography
			
			## START: Mobile Menu Dropdowns Typography
			$css .= '.sidr-class-dropdown-menu li a, a.sidr-class-toggle-sidr-close{';
			if ( ! empty ( $mobile_menu_dropdown_font_family ) ) {
				$css .= 'font-family:'. $mobile_menu_dropdown_font_family .';';
			}
			if ( ! empty ( $mobile_menu_dropdown_font_weight ) ) {
				$css .= 'font-weight:'. $mobile_menu_dropdown_font_weight .';';
			}
			if ( ! empty ( $mobile_menu_dropdown_font_style ) ) {
				$css .= 'font-style:'. $mobile_menu_dropdown_font_style .';';
			}
			if ( ! empty ( $mobile_menu_dropdown_text_transform ) ) {
				$css .= 'text-transform:'. $mobile_menu_dropdown_text_transform .';';
			}
			if ( ! empty ( $mobile_menu_dropdown_font_size ) && ( $mobile_menu_dropdown_font_size != '15' ) ) {
				$css .= 'font-size:'. $mobile_menu_dropdown_font_size .'px;';
			}
			if ( ! empty ( $mobile_menu_dropdown_line_height ) && ( $mobile_menu_dropdown_line_height != '1.8' ) ) {
				$css .= 'line-height:'. $mobile_menu_dropdown_line_height .';';
			}
			if ( ! empty ( $mobile_menu_dropdown_letter_spacing ) ) {
				$css .= 'letter-spacing:'. $mobile_menu_dropdown_letter_spacing .'px;';
			}
			$css .= '}';
			## END: Mobile Menu Dropdowns Typography

			## START: Media Query - Tablet or Smaller (-959px)
			$css .= '@media only screen and (max-width:959px){';

			# $mobile_header_height
			// Add header height
			if ( ! empty( $mobile_header_height ) && ( $header_style != 'top' ) ) {
				$css .= '#kindling-mobile-menu-icon{height:'. $mobile_header_height .'px;}';
				$css .= '#site-navigation-wrap .dropdown-menu > li > a,#kindling-mobile-menu-icon a{line-height:'. $mobile_header_height .'px;}';
			}

			# $mobile_top_height
			// Add header height for top header style
			if ( ! empty( $mobile_top_height ) && 'top' == $header_style  ) {
				$css .= '#site-header.top-header #search-toggle{height:'. $mobile_top_height .'px;}';
				$css .= '#site-header.top-header #site-navigation-wrap .dropdown-menu > li > a,#site-header.top-header #kindling-mobile-menu-icon a{line-height:'. $mobile_top_height .'px;}';
			}

			# $mobile_header_top_margin
			// Header top margin
			if ( ! empty( $mobile_header_top_margin ) && $mobile_header_top_margin != 0 ) {
				$css .= '#kindling-mobile-menu-icon{margin-top:'. $mobile_header_top_margin .'px;}';
			}

			# $mobile_header_bottom_margin
			// Header bottom margin
			if ( ! empty( $mobile_header_bottom_margin ) && '0' != $mobile_header_bottom_margin ) {
				$css .= '#kindling-mobile-menu-icon{margin-bottom:'. $mobile_header_bottom_margin .'px;}';
			}

			# $mobile_logo_height
			# Header logo max height
			if ( !empty( $mobile_logo_height ) ) {
				$css .= '#site-header.center-header #site-navigation .middle-site-logo a img{max-height:'. $mobile_logo_height .'px;}';
				$css .= '#site-logo #site-logo-inner a img{max-height:'. $mobile_logo_height .'px;}';
			}

			# $mobile_logo_top_margin
			// Header logo top margin
			if ( ! empty( $mobile_logo_top_margin ) && '0' != $mobile_logo_top_margin ) {
				$css .= '#site-header.center-header #site-navigation .middle-site-logo a img{margin-top:'. $mobile_logo_top_margin .'px;}';
				$css .= '#site-logo #site-logo-inner a img{margin-top:'. $mobile_logo_top_margin .'px;}';
			}

			# $mobile_logo_bottom_margin
			// Header logo bottom margin
			if ( ! empty( $mobile_logo_bottom_margin ) && '0' != $mobile_logo_bottom_margin ) {
				$css .= '#site-header.center-header #site-navigation .middle-site-logo a img{margin-bottom:'. $mobile_logo_bottom_margin .'px;}';
				$css .= '#site-logo #site-logo-inner a img{margin-bottom:'. $mobile_logo_bottom_margin .'px;}';
			}

			$css .= '}'; 
			## END: Media Query - Tablet or Smaller (-959px)
			

			// Return CSS
			if ( ! empty( $css ) ) {
				$output .= '/* Header CSS */'. $css;
			}

			# Load Google fonts via wp_enqueue_style
			if ( ! empty( $logo_font_family ) )                 { kindling_enqueue_google_font( $logo_font_family ); }
			if ( ! empty( $menu_font_family ) )                 { kindling_enqueue_google_font( $menu_font_family ); }
			if ( ! empty( $menu_dropdown_font_family ) )        { kindling_enqueue_google_font( $menu_dropdown_font_family ); }
			if ( ! empty( $mobile_menu_dropdown_font_family ) ) { kindling_enqueue_google_font( $mobile_menu_dropdown_font_family ); }
			
			
			// Return output css
			return $output;
		}
	}

endif;

return new Kindling_Header_Customizer();