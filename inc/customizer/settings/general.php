<?php
/**
 * General Customizer Options
 *
 * @package Kindling Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kindling_General_Customizer' ) ) :

	class Kindling_General_Customizer {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'customize_register', array( $this, 'customizer_options' ) );
			add_filter( 'kindling_head_css',  array( $this, 'site_background_css' ) );
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
			$panel = 'kindling_general_panel';
			$wp_customize->add_panel( $panel , array(
				'title' 			=> esc_html__( 'General Options', 'kindling' ),
				'priority' 			=> 1,
			) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'kindling_general_styling' , array(
				'title' 			=> esc_html__( 'Colors', 'kindling' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Primary Color
			 */
			$wp_customize->add_setting( 'kindling_primary_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#13aff0',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_primary_color', array(
				'label'	   				=> esc_html__( 'Primary Color', 'kindling' ),
				'section'  				=> 'kindling_general_styling',
				'settings' 				=> 'kindling_primary_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Hover Primary Color
			 */
			$wp_customize->add_setting( 'kindling_hover_primary_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#0b7cac',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_hover_primary_color', array(
				'label'	   				=> esc_html__( 'Hover Primary Color', 'kindling' ),
				'section'  				=> 'kindling_general_styling',
				'settings' 				=> 'kindling_hover_primary_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Main Border Color
			 */
			$wp_customize->add_setting( 'kindling_main_border_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#e9e9e9',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_main_border_color', array(
				'label'	   				=> esc_html__( 'Main Border Color', 'kindling' ),
				'section'  				=> 'kindling_general_styling',
				'settings' 				=> 'kindling_main_border_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Heading Site Background
			 */
			$wp_customize->add_setting( 'kindling_site_background_heading', array(
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Heading_Control( $wp_customize, 'kindling_site_background_heading', array(
				'label'    				=> esc_html__( 'Site Background', 'kindling' ),
				'section'  				=> 'kindling_general_styling',
				'priority' 				=> 10,
			) ) );

			/**
			 * Site Background
			 */
			$wp_customize->add_setting( 'kindling_background_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#ffffff',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_background_color', array(
				'label'	   				=> esc_html__( 'Background Color', 'kindling' ),
				'section'  				=> 'kindling_general_styling',
				'settings' 				=> 'kindling_background_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_hasnt_boxed_layout',
			) ) );

			/**
			 * Site Background Image
			 */
			$wp_customize->add_setting( 'kindling_background_image', array(
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'kindling_background_image', array(
				'label'	   				=> esc_html__( 'Background Image', 'kindling' ),
				'section'  				=> 'kindling_general_styling',
				'settings' 				=> 'kindling_background_image',
				'priority' 				=> 10,
			) ) );

			/**
			 * Site Background Image Position
			 */
			$wp_customize->add_setting( 'kindling_background_image_position', array(
				'transport' 			=> 'postMessage',
				'default' 				=> 'initial',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_background_image_position', array(
				'label'	   				=> esc_html__( 'Position', 'kindling' ),
				'type' 					=> 'select',
				'section'  				=> 'kindling_general_styling',
				'settings' 				=> 'kindling_background_image_position',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_background_image',
				'choices' 				=> array(
					'initial' 			=> esc_html__( 'Default', 'kindling' ),
					'top left' 			=> esc_html__( 'Top Left', 'kindling' ),
					'top center' 		=> esc_html__( 'Top Center', 'kindling' ),
					'top right'  		=> esc_html__( 'Top Right', 'kindling' ),
					'center left' 		=> esc_html__( 'Center Left', 'kindling' ),
					'center center' 	=> esc_html__( 'Center Center', 'kindling' ),
					'center right' 		=> esc_html__( 'Center Right', 'kindling' ),
					'bottom left' 		=> esc_html__( 'Bottom Left', 'kindling' ),
					'bottom center' 	=> esc_html__( 'Bottom Center', 'kindling' ),
					'bottom right' 		=> esc_html__( 'Bottom Right', 'kindling' ),
				),
			) ) );

			/**
			 * Site Background Image Attachment
			 */
			$wp_customize->add_setting( 'kindling_background_image_attachment', array(
				'transport' 			=> 'postMessage',
				'default' 				=> 'initial',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_background_image_attachment', array(
				'label'	   				=> esc_html__( 'Attachment', 'kindling' ),
				'type' 					=> 'select',
				'section'  				=> 'kindling_general_styling',
				'settings' 				=> 'kindling_background_image_attachment',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_background_image',
				'choices' 				=> array(
					'initial' 	=> esc_html__( 'Default', 'kindling' ),
					'scroll' 	=> esc_html__( 'Scroll', 'kindling' ),
					'fixed' 	=> esc_html__( 'Fixed', 'kindling' ),
				),
			) ) );

			/**
			 * Site Background Image Repeat
			 */
			$wp_customize->add_setting( 'kindling_background_image_repeat', array(
				'transport' 			=> 'postMessage',
				'default' 				=> 'initial',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_background_image_repeat', array(
				'label'	   				=> esc_html__( 'Repeat', 'kindling' ),
				'type' 					=> 'select',
				'section'  				=> 'kindling_general_styling',
				'settings' 				=> 'kindling_background_image_repeat',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_background_image',
				'choices' 				=> array(
					'initial' 	=> esc_html__( 'Default', 'kindling' ),
					'no-repeat' => esc_html__( 'No-repeat', 'kindling' ),
					'repeat' 	=> esc_html__( 'Repeat', 'kindling' ),
					'repeat-x' 	=> esc_html__( 'Repeat-x', 'kindling' ),
					'repeat-y' 	=> esc_html__( 'Repeat-y', 'kindling' ),
				),
			) ) );

			/**
			 * Site Background Image Size
			 */
			$wp_customize->add_setting( 'kindling_background_image_size', array(
				'transport' 			=> 'postMessage',
				'default' 				=> 'initial',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_background_image_size', array(
				'label'	   				=> esc_html__( 'Size', 'kindling' ),
				'type' 					=> 'select',
				'section'  				=> 'kindling_general_styling',
				'settings' 				=> 'kindling_background_image_size',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_background_image',
				'choices' 				=> array(
					'initial' 	=> esc_html__( 'Default', 'kindling' ),
					'auto' 		=> esc_html__( 'Auto', 'kindling' ),
					'cover' 	=> esc_html__( 'Cover', 'kindling' ),
					'contain' 	=> esc_html__( 'Contain', 'kindling' ),
				),
			) ) );

			/**
			 * Heading Links Color
			 */
			$wp_customize->add_setting( 'kindling_links_color_heading', array(
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Heading_Control( $wp_customize, 'kindling_links_color_heading', array(
				'label'    				=> esc_html__( 'Links Color', 'kindling' ),
				'section'  				=> 'kindling_general_styling',
				'priority' 				=> 10,
			) ) );

			/**
			 * Links Color
			 */
			$wp_customize->add_setting( 'kindling_links_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#333333',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_links_color', array(
				'label'	   				=> esc_html__( 'Color', 'kindling' ),
				'section'  				=> 'kindling_general_styling',
				'settings' 				=> 'kindling_links_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Links Color Hover
			 */
			$wp_customize->add_setting( 'kindling_links_color_hover', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#13aff0',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_links_color_hover', array(
				'label'	   				=> esc_html__( 'Color: Hover', 'kindling' ),
				'section'  				=> 'kindling_general_styling',
				'settings' 				=> 'kindling_links_color_hover',
				'priority' 				=> 10,
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'kindling_general_settings' , array(
				'title' 			=> esc_html__( 'Layout', 'kindling' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Main Layout Style
			 */
			$wp_customize->add_setting( 'kindling_main_layout_style', array(
				'default'           	=> 'wide',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Buttonset_Control( $wp_customize, 'kindling_main_layout_style', array(
				'label'	   				=> esc_html__( 'Layout Style', 'kindling' ),
				'section'  				=> 'kindling_general_settings',
				'settings' 				=> 'kindling_main_layout_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'wide'  			=> esc_html__( 'Wide', 'kindling' ),
					'boxed' 			=> esc_html__( 'Boxed', 'kindling' ),
				),
			) ) );

			/**
			 * Boxed Layout Drop-Shadow
			 */
			$wp_customize->add_setting( 'kindling_boxed_dropdshadow', array(
				'transport' 			=> 'postMessage',
				'default'           	=> true,
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_boxed_dropdshadow', array(
				'label'	   				=> esc_html__( 'Boxed Layout Drop-Shadow', 'kindling' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'kindling_general_settings',
				'settings' 				=> 'kindling_boxed_dropdshadow',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_boxed_layout',
			) ) );

			/**
			 * Boxed Width
			 */
			$wp_customize->add_setting( 'kindling_boxed_width', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '1280',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_boxed_width', array(
				'label'	   				=> esc_html__( 'Boxed Width (px)', 'kindling' ),
				'section'  				=> 'kindling_general_settings',
				'settings' 				=> 'kindling_boxed_width',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_boxed_layout',
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 4000,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Boxed Outside Background
			 */
			$wp_customize->add_setting( 'kindling_boxed_outside_bg', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#e9e9e9',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_boxed_outside_bg', array(
				'label'	   				=> esc_html__( 'Outside Background', 'kindling' ),
				'section'  				=> 'kindling_general_settings',
				'settings' 				=> 'kindling_boxed_outside_bg',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_boxed_layout',
			) ) );

			/**
			 * Boxed Inner Background
			 */
			$wp_customize->add_setting( 'kindling_boxed_inner_bg', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#ffffff',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_boxed_inner_bg', array(
				'label'	   				=> esc_html__( 'Inner Background', 'kindling' ),
				'section'  				=> 'kindling_general_settings',
				'settings' 				=> 'kindling_boxed_inner_bg',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_boxed_layout',
			) ) );

			/**
			 * Main Container Width
			 */
			$wp_customize->add_setting( 'kindling_main_container_width', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '1200',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_main_container_width', array(
				'label'	   				=> esc_html__( 'Main Container Width (px)', 'kindling' ),
				'section'  				=> 'kindling_general_settings',
				'settings' 				=> 'kindling_main_container_width',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_hasnt_boxed_layout',
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 4096,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Content Width
			 */
			$wp_customize->add_setting( 'kindling_left_container_width', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '72',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_left_container_width', array(
				'label'	   				=> esc_html__( 'Content Width (%)', 'kindling' ),
				'section'  				=> 'kindling_general_settings',
				'settings' 				=> 'kindling_left_container_width',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Sidebar Width
			 */
			$wp_customize->add_setting( 'kindling_sidebar_width', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '28',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_sidebar_width', array(
				'label'	   				=> esc_html__( 'Sidebar Width (%)', 'kindling' ),
				'section'  				=> 'kindling_general_settings',
				'settings' 				=> 'kindling_sidebar_width',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Heading Pages
			 */
			$wp_customize->add_setting( 'kindling_pages_heading', array(
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Heading_Control( $wp_customize, 'kindling_pages_heading', array(
				'label'    	=> esc_html__( 'Pages', 'kindling' ),
				'section'  	=> 'kindling_general_settings',
				'priority' 	=> 10,
			) ) );

			/**
			 * Pages
			 */
			$wp_customize->add_setting( 'kindling_page_single_layout', array(
				'default'           	=> 'right-sidebar',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Radio_Image_Control( $wp_customize, 'kindling_page_single_layout', array(
				'label'	   				=> esc_html__( 'Layout', 'kindling' ),
				'section'  				=> 'kindling_general_settings',
				'settings' 				=> 'kindling_page_single_layout',
				'priority' 				=> 10,
				'choices' 				=> array(
					'right-sidebar'  	=> KINDLING_INC_DIR_URI . 'customizer/assets/img/2cr.png',
					'left-sidebar' 		=> KINDLING_INC_DIR_URI . 'customizer/assets/img/2cl.png',
					'full-width'  		=> KINDLING_INC_DIR_URI . 'customizer/assets/img/1c.png',
				),
			) ) );

			/**
			 * Content Top Padding
			 */
			$wp_customize->add_setting( 'kindling_page_content_top_padding', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '50',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_page_content_top_padding', array(
				'label'	   				=> esc_html__( 'Content Top Padding (px)', 'kindling' ),
				'section'  				=> 'kindling_general_settings',
				'settings' 				=> 'kindling_page_content_top_padding',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 300,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Content Bottom Padding
			 */
			$wp_customize->add_setting( 'kindling_page_content_bottom_padding', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '50',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_page_content_bottom_padding', array(
				'label'	   				=> esc_html__( 'Content Bottom Padding (px)', 'kindling' ),
				'section'  				=> 'kindling_general_settings',
				'settings' 				=> 'kindling_page_content_bottom_padding',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 300,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Heading Search Result Page
			 */
			$wp_customize->add_setting( 'kindling_search_result_heading', array(
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Heading_Control( $wp_customize, 'kindling_search_result_heading', array(
				'label'    	=> esc_html__( 'Search Result Page', 'kindling' ),
				'section'  	=> 'kindling_general_settings',
				'priority' 	=> 10,
			) ) );

			/**
			 * Search Page
			 */
			$wp_customize->add_setting( 'kindling_search_custom_sidebar', array(
				'default'           	=> true,
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_search_custom_sidebar', array(
				'label'	   				=> esc_html__( 'Custom Sidebar', 'kindling' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'kindling_general_settings',
				'settings' 				=> 'kindling_search_custom_sidebar',
				'priority' 				=> 10,
			) ) );

			/**
			 * Search Page Layout
			 */
			$wp_customize->add_setting( 'kindling_search_layout', array(
				'default'           	=> 'right-sidebar',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Radio_Image_Control( $wp_customize, 'kindling_search_layout', array(
				'label'	   				=> esc_html__( 'Layout', 'kindling' ),
				'section'  				=> 'kindling_general_settings',
				'settings' 				=> 'kindling_search_layout',
				'priority' 				=> 10,
				'choices' 				=> array(
					'right-sidebar'  	=> KINDLING_INC_DIR_URI . 'customizer/assets/img/2cr.png',
					'left-sidebar' 		=> KINDLING_INC_DIR_URI . 'customizer/assets/img/2cl.png',
					'full-width'  		=> KINDLING_INC_DIR_URI . 'customizer/assets/img/1c.png',
				),
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'kindling_general_page_header' , array(
				'title' 			=> esc_html__( 'Page Title', 'kindling' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Page Title Style
			 */
			$wp_customize->add_setting( 'kindling_page_header_style', array(
				'default'           	=> '',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_page_header_style', array(
				'label'	   				=> esc_html__( 'Style', 'kindling' ),
				'type' 					=> 'select',
				'section'  				=> 'kindling_general_page_header',
				'settings' 				=> 'kindling_page_header_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'' 					=> esc_html__( 'Default','kindling' ),
					'centered' 			=> esc_html__( 'Centered', 'kindling' ),
					'centered-minimal' 	=> esc_html__( 'Centered Minimal', 'kindling' ),
#					'background-image' 	=> esc_html__( 'Background Image', 'kindling' ),
					'hidden' 			=> esc_html__( 'Hidden', 'kindling' ),
				),
			) ) );

			/**
			 * Page Title Background Image
			 */
			$wp_customize->add_setting( 'kindling_page_header_bg_image', array(
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'kindling_page_header_bg_image', array(
				'label'	   				=> esc_html__( 'Image', 'kindling' ),
				'section'  				=> 'kindling_general_page_header',
				'settings' 				=> 'kindling_page_header_bg_image',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_hasnt_bg_image_page_header',
			) ) );

			/**
			 * Page Title Background Image Height
			 */
			$wp_customize->add_setting( 'kindling_page_header_bg_image_height', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '400',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_page_header_bg_image_height', array(
				'label'	   				=> esc_html__( 'Height (px)', 'kindling' ),
				'section'  				=> 'kindling_general_page_header',
				'settings' 				=> 'kindling_page_header_bg_image_height',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 800,
			        'step'  => 1,
			    ),
				'active_callback' 		=> 'kindling_cac_hasnt_bg_image_page_header',
			) ) );

			/**
			 * Page Title Background Image Overlay Opacity
			 */
			$wp_customize->add_setting( 'kindling_page_header_bg_image_overlay_opacity', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '0.5',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_page_header_bg_image_overlay_opacity', array(
				'label'	   				=> esc_html__( 'Overlay Opacity', 'kindling' ),
				'section'  				=> 'kindling_general_page_header',
				'settings' 				=> 'kindling_page_header_bg_image_overlay_opacity',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 1,
			        'step'  => 0.1,
			    ),
				'active_callback' 		=> 'kindling_cac_hasnt_bg_image_page_header',
			) ) );

			/**
			 * Page Title Background Image Overlay Color
			 */
			$wp_customize->add_setting( 'kindling_page_header_bg_image_overlay_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#000000',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_page_header_bg_image_overlay_color', array(
				'label'	   				=> esc_html__( 'Overlay Color', 'kindling' ),
				'section'  				=> 'kindling_general_page_header',
				'settings' 				=> 'kindling_page_header_bg_image_overlay_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_hasnt_bg_image_page_header',
			) ) );

			/**
			 * Page Title Top Padding
			 */
			$wp_customize->add_setting( 'kindling_page_header_top_padding', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '34',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_page_header_top_padding', array(
				'label'	   				=> esc_html__( 'Top Padding (px)', 'kindling' ),
				'section'  				=> 'kindling_general_page_header',
				'settings' 				=> 'kindling_page_header_top_padding',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 200,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Page Title Bottom Padding
			 */
			$wp_customize->add_setting( 'kindling_page_header_bottom_padding', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '34',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_page_header_bottom_padding', array(
				'label'	   				=> esc_html__( 'Bottom Padding (px)', 'kindling' ),
				'section'  				=> 'kindling_general_page_header',
				'settings' 				=> 'kindling_page_header_bottom_padding',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 200,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Page Title Background Color
			 */
			$wp_customize->add_setting( 'kindling_page_header_background', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#f5f5f5',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_page_header_background', array(
				'label'	   				=> esc_html__( 'Background Color', 'kindling' ),
				'section'  				=> 'kindling_general_page_header',
				'settings' 				=> 'kindling_page_header_background',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_bg_image_page_header',
			) ) );

			/**
			 * Page Title Color
			 */
			$wp_customize->add_setting( 'kindling_page_header_title_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#333333',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_page_header_title_color', array(
				'label'	   				=> esc_html__( 'Text Color', 'kindling' ),
				'section'  				=> 'kindling_general_page_header',
				'settings' 				=> 'kindling_page_header_title_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_bg_image_page_header',
			) ) );

			/**
			 * Breadcrumbs Heading
			 */
			$wp_customize->add_setting( 'kindling_breadcrumbs_heading', array(
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Heading_Control( $wp_customize, 'kindling_breadcrumbs_heading', array(
				'label'    				=> esc_html__( 'Breadcrumbs', 'kindling' ),
				'section'  				=> 'kindling_general_page_header',
				'priority' 				=> 10,
			) ) );

			/**
			 * Breadcrumbs
			 */
			$wp_customize->add_setting( 'kindling_breadcrumbs', array(
				'default'           	=> true,
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_breadcrumbs', array(
				'label'	   				=> esc_html__( 'Breadcrumbs', 'kindling' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'kindling_general_page_header',
				'settings' 				=> 'kindling_breadcrumbs',
				'priority' 				=> 10,
			) ) );

			/**
			 * Breadcrumbs Position
			 */
			$wp_customize->add_setting( 'kindling_breadcrumbs_position', array(
				'default'           	=> '',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_breadcrumbs_position', array(
				'label'	   				=> esc_html__( 'Position', 'kindling' ),
				'type' 					=> 'select',
				'section'  				=> 'kindling_general_page_header',
				'settings' 				=> 'kindling_breadcrumbs_position',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_breadcrumbs',
				'choices' 				=> array(
					'' 					=> esc_html__( 'Absolute Right','kindling' ),
					'under-title' 		=> esc_html__( 'Under Title', 'kindling' ),
				),
			) ) );

			/**
			 * Breadcrumbs Text Color
			 */
			$wp_customize->add_setting( 'kindling_breadcrumbs_text_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#c6c6c6',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_breadcrumbs_text_color', array(
				'label'	   				=> esc_html__( 'Text Color', 'kindling' ),
				'section'  				=> 'kindling_general_page_header',
				'settings' 				=> 'kindling_breadcrumbs_text_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_breadcrumbs',
			) ) );

			/**
			 * Breadcrumbs Separator Color
			 */
			$wp_customize->add_setting( 'kindling_breadcrumbs_seperator_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#c6c6c6',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_breadcrumbs_seperator_color', array(
				'label'	   				=> esc_html__( 'Separator Color', 'kindling' ),
				'section'  				=> 'kindling_general_page_header',
				'settings' 				=> 'kindling_breadcrumbs_seperator_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_breadcrumbs',
			) ) );

			/**
			 * Breadcrumbs Separator Color
			 */
			$wp_customize->add_setting( 'kindling_breadcrumbs_seperator_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#c6c6c6',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_breadcrumbs_seperator_color', array(
				'label'	   				=> esc_html__( 'Separator Color', 'kindling' ),
				'section'  				=> 'kindling_general_page_header',
				'settings' 				=> 'kindling_breadcrumbs_seperator_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_breadcrumbs',
			) ) );

			/**
			 * Breadcrumbs Link Color
			 */
			$wp_customize->add_setting( 'kindling_breadcrumbs_link_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#333333',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_breadcrumbs_link_color', array(
				'label'	   				=> esc_html__( 'Link Color', 'kindling' ),
				'section'  				=> 'kindling_general_page_header',
				'settings' 				=> 'kindling_breadcrumbs_link_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_breadcrumbs',
			) ) );

			/**
			 * Breadcrumbs Link Color
			 */
			$wp_customize->add_setting( 'kindling_breadcrumbs_link_color_hover', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#13aff0',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_breadcrumbs_link_color_hover', array(
				'label'	   				=> esc_html__( 'Link Color: Hover', 'kindling' ),
				'section'  				=> 'kindling_general_page_header',
				'settings' 				=> 'kindling_breadcrumbs_link_color_hover',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_breadcrumbs',
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'kindling_general_scroll_top' , array(
				'title' 			=> esc_html__( 'Scroll To Top', 'kindling' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Scroll To Top
			 */
			$wp_customize->add_setting( 'kindling_scroll_top', array(
				'default'           	=> true,
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_scroll_top', array(
				'label'	   				=> esc_html__( 'Scroll Up Button', 'kindling' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'kindling_general_scroll_top',
				'settings' 				=> 'kindling_scroll_top',
				'priority' 				=> 10,
			) ) );

			/**
			 * Scroll Top Arrow
			 */
			$wp_customize->add_setting( 'kindling_scroll_top_arrow', array(
				'transport' 			=> 'postMessage',
				'default'           	=> 'angle-up',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Icon_Select_Control( $wp_customize, 'kindling_scroll_top_arrow', array(
				'label'	   				=> esc_html__( 'Arrow Icon', 'kindling' ),
				'section'  				=> 'kindling_general_scroll_top',
				'settings' 				=> 'kindling_scroll_top_arrow',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_scrolltop',
			    'choices' 				=> kindling_get_awesome_icons( 'up_arrows' ),
			) ) );

			/**
			 * Scroll Top Size
			 */
			$wp_customize->add_setting( 'kindling_scroll_top_size', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '40',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_scroll_top_size', array(
				'label'	   				=> esc_html__( 'Button Size (px)', 'kindling' ),
				'section'  				=> 'kindling_general_scroll_top',
				'settings' 				=> 'kindling_scroll_top_size',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_scrolltop',
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 60,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Scroll Top Icon Size
			 */
			$wp_customize->add_setting( 'kindling_scroll_top_icon_size', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '18',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_scroll_top_icon_size', array(
				'label'	   				=> esc_html__( 'Icon Size (px)', 'kindling' ),
				'section'  				=> 'kindling_general_scroll_top',
				'settings' 				=> 'kindling_scroll_top_icon_size',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_scrolltop',
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 60,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Scroll Top Border Radius
			 */
			$wp_customize->add_setting( 'kindling_scroll_top_border_radius', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '2',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_scroll_top_border_radius', array(
				'label'	   				=> esc_html__( 'Border Radius (px)', 'kindling' ),
				'section'  				=> 'kindling_general_scroll_top',
				'settings' 				=> 'kindling_scroll_top_border_radius',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_scrolltop',
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Scroll Top Background Color
			 */
			$wp_customize->add_setting( 'kindling_scroll_top_bg', array(
				'transport' 			=> 'postMessage',
				'default'           	=> 'rgba(0,0,0,0.4)',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_scroll_top_bg', array(
				'label'	   				=> esc_html__( 'Background Color', 'kindling' ),
				'section'  				=> 'kindling_general_scroll_top',
				'settings' 				=> 'kindling_scroll_top_bg',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_scrolltop',
			) ) );

			/**
			 * Scroll Top Background Hover Color
			 */
			$wp_customize->add_setting( 'kindling_scroll_top_bg_hover', array(
				'transport' 			=> 'postMessage',
				'default'           	=> 'rgba(0,0,0,0.8)',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_scroll_top_bg_hover', array(
				'label'	   				=> esc_html__( 'Background Color: Hover', 'kindling' ),
				'section'  				=> 'kindling_general_scroll_top',
				'settings' 				=> 'kindling_scroll_top_bg_hover',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_scrolltop',
			) ) );

			/**
			 * Scroll Top Color
			 */
			$wp_customize->add_setting( 'kindling_scroll_top_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#ffffff',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_scroll_top_color', array(
				'label'	   				=> esc_html__( 'Color', 'kindling' ),
				'section'  				=> 'kindling_general_scroll_top',
				'settings' 				=> 'kindling_scroll_top_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_scrolltop',
			) ) );

			/**
			 * Scroll Top Hover Color
			 */
			$wp_customize->add_setting( 'kindling_scroll_top_color_hover', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#ffffff',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_scroll_top_color_hover', array(
				'label'	   				=> esc_html__( 'Color: Hover', 'kindling' ),
				'section'  				=> 'kindling_general_scroll_top',
				'settings' 				=> 'kindling_scroll_top_color_hover',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_scrolltop',
			) ) );

			/**
			 * Section
			 */
#			$wp_customize->add_section( 'kindling_general_pagination' , array(
#				'title' 			=> esc_html__( 'Pagination', 'kindling' ),
#				'priority' 			=> 10,
#				'panel' 			=> $panel,
#			) );

			/**
			 * Pagination Align
			 */
			$wp_customize->add_setting( 'kindling_pagination_align', array(
				'transport' 			=> 'postMessage',
				'default'           	=> 'right',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_pagination_align', array(
				'label'	   				=> esc_html__( 'Align', 'kindling' ),
				'type' 					=> 'select',
				'section'  				=> 'kindling_general_pagination',
				'settings' 				=> 'kindling_pagination_align',
				'priority' 				=> 10,
				'choices' 				=> array(
					'right' 	=> esc_html__( 'Right', 'kindling' ),
					'center' 	=> esc_html__( 'Center', 'kindling' ),
					'left' 		=> esc_html__( 'Left', 'kindling' ),
				),
			) ) );

			/**
			 * Pagination Font Size
			 */
			$wp_customize->add_setting( 'kindling_pagination_font_size', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '18',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_pagination_font_size', array(
				'label'	   				=> esc_html__( 'Font Size (px)', 'kindling' ),
				'section'  				=> 'kindling_general_pagination',
				'settings' 				=> 'kindling_pagination_font_size',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Pagination Border Width
			 */
			$wp_customize->add_setting( 'kindling_pagination_border_width', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '1',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_pagination_border_width', array(
				'label'	   				=> esc_html__( 'Border Width (px)', 'kindling' ),
				'section'  				=> 'kindling_general_pagination',
				'settings' 				=> 'kindling_pagination_border_width',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 20,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Pagination Background Color
			 */
			$wp_customize->add_setting( 'kindling_pagination_bg', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_pagination_bg', array(
				'label'	   				=> esc_html__( 'Background Color', 'kindling' ),
				'section'  				=> 'kindling_general_pagination',
				'settings' 				=> 'kindling_pagination_bg',
				'priority' 				=> 10,
			) ) );

			/**
			 * Pagination Background Color Hover
			 */
			$wp_customize->add_setting( 'kindling_pagination_hover_bg', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#f8f8f8',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_pagination_hover_bg', array(
				'label'	   				=> esc_html__( 'Background Color: Hover', 'kindling' ),
				'section'  				=> 'kindling_general_pagination',
				'settings' 				=> 'kindling_pagination_hover_bg',
				'priority' 				=> 10,
			) ) );

			/**
			 * Pagination Color
			 */
			$wp_customize->add_setting( 'kindling_pagination_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#555555',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_pagination_color', array(
				'label'	   				=> esc_html__( 'Color', 'kindling' ),
				'section'  				=> 'kindling_general_pagination',
				'settings' 				=> 'kindling_pagination_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Pagination Color Hover
			 */
			$wp_customize->add_setting( 'kindling_pagination_hover_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#333333',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_pagination_hover_color', array(
				'label'	   				=> esc_html__( 'Color: Hover', 'kindling' ),
				'section'  				=> 'kindling_general_pagination',
				'settings' 				=> 'kindling_pagination_hover_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Pagination Border Color
			 */
			$wp_customize->add_setting( 'kindling_pagination_border_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#e9e9e9',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_pagination_border_color', array(
				'label'	   				=> esc_html__( 'Border Color', 'kindling' ),
				'section'  				=> 'kindling_general_pagination',
				'settings' 				=> 'kindling_pagination_border_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Pagination Border Color Hover
			 */
			$wp_customize->add_setting( 'kindling_pagination_border_hover_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#e9e9e9',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_pagination_border_hover_color', array(
				'label'	   				=> esc_html__( 'Border Color: Hover', 'kindling' ),
				'section'  				=> 'kindling_general_pagination',
				'settings' 				=> 'kindling_pagination_border_hover_color',
				'priority' 				=> 10,
			) ) );

		}

		/**
		 * Generates arrays of elements to target
		 *
		 * @since 1.0.0
		 */
		private static function primary_color_arrays( $return ) {

			// Texts
			$texts = apply_filters( 'kindling_primary_texts', array(
				'a:hover',
				'a.light:hover',
				'.theme-heading .text::before',
				'#site-navigation-wrap .dropdown-menu > li > a:hover',
				'#kindling-mobile-menu-icon a:hover',
				'.blog-entry.post .blog-entry-header h2 a:hover',
				'.blog-entry.post .blog-entry-readmore a:hover',
				'ul.meta li a:hover',
				'.dropcap',
				'.single-post .post-pagination-wrap ul li .title',
				'.related-post-title a:hover',
				'.woocommerce-MyAccount-navigation ul li a:before',
				'#wp-calendar caption',
				'.contact-info-widget i',
				'.custom-links-widget .kindling-custom-links li a:hover',
				'.custom-links-widget .kindling-custom-links li a:hover:before',
				'.posts-thumbnails-widget li a:hover',
				'.social-widget li.kindling-email a:hover',
				'.comment-author .comment-meta .comment-reply-link',
				'#respond #cancel-comment-reply-link:hover',
				'#footer-bottom a:hover',
				'#footer-bottom #footer-bottom-menu a:hover',
				'.sidr a:hover',
				'.sidr-class-dropdown-toggle:hover',
				'.sidr-class-menu-item-has-children.active > a',
				'.sidr-class-menu-item-has-children.active > a > .sidr-class-dropdown-toggle',
				'#kindling-post-list.one .kindling-post-category:hover',
				'#kindling-post-list.one .kindling-post-category:hover a',
				'#kindling-post-list.two .slick-arrow:hover',
				'#kindling-post-list.two article:hover .kindling-post-category',
				'#kindling-post-list.two article:hover .kindling-post-category a',
			) );

			// Backgrounds
			$backgrounds = apply_filters( 'kindling_primary_backgrounds', array(
				'input[type="button"]',
				'input[type="reset"]',
				'input[type="submit"]',
				'.button',
				'#site-navigation-wrap .dropdown-menu > li.btn > a > span',
				'.thumbnail:hover i',
				'.post-quote-content',
				'#kindling-post-list.one .readmore:hover',
				'#kindling-post-list.one .kindling-post-category',
				'#kindling-post-list.two .kindling-post-category',
				'#kindling-post-list.two article:hover .slide-overlay-wrap',
				'.kindling-modal .kindling-close-modal',
			) );

			// Borders
			$borders = apply_filters( 'kindling_primary_borders', array(
				'.widget-title',
				'blockquote',
				'#searchform-dropdown',
				'.dropdown-menu .sub-menu',
				'.blog-entry.large-entry .blog-entry-readmore a:hover',
				'.kindling-newsletter-form-wrap input[type="email"]:focus',
				'.social-widget li.kindling-email a:hover',
				'#respond #cancel-comment-reply-link:hover',
				'#kindling-post-list.one .readmore:hover',
			) );

			// Return array
			if ( 'texts' == $return ) {
				return $texts;
			} elseif ( 'backgrounds' == $return ) {
				return $backgrounds;
			} elseif ( 'borders' == $return ) {
				return $borders;
			}

		}

		/**
		 * Generates array of elements to target
		 *
		 * @since 1.0.0
		 */
		private static function hover_primary_color_array( $return ) {

			// Hover backgrounds
			$hover = apply_filters( 'kindling_hover_primary_backgrounds', array(
				'input[type="button"]:hover',
				'input[type="reset"]:hover',
				'input[type="submit"]:hover',
				'input[type="button"]:focus',
				'input[type="reset"]:focus',
				'input[type="submit"]:focus',
				'.button:hover',
				'#site-navigation-wrap .dropdown-menu > li.btn > a:hover > span',
				'.post-quote-author',
				'.kindling-modal .kindling-close-modal:hover',
			) );

			// Return array
			if ( 'hover' == $return ) {
				return $hover;
			}

		}

		/**
		 * Returns array of elements and border style to apply
		 *
		 * @since 1.0.0
		 */
		private static function main_border_array() {

			return apply_filters( 'kindling_border_color_elements', array(

				// General
				'table th',
				'table td',
				'hr',
				'.content-area',
				'body.content-left-sidebar #content-wrap .content-area,
				.content-left-sidebar .content-area',

				// Header
				'#site-header',

				// Search top header
				'#site-header.top-header #search-toggle',

				// Dropdown
				'.dropdown-menu ul li',

				// Page header
				'.centered-minimal-page-header',

				// Blog
				'.blog-entry.post',

				'.blog-entry.grid-entry .blog-entry-inner',

				'.single-post h1.entry-title',

				'.single-post .entry-share',
				'.single-post .entry-share ul li a',

				'.single-post .post-pagination-wrap',
				'.single-post .post-pagination-wrap ul li.post-prev',

				'#author-bio',
				'#author-bio .author-bio-avatar',
				'#author-bio .author-bio-social li a',

				'#related-posts',

				'#comments',
				'.comment-body',
				'#respond #cancel-comment-reply-link',

				'#blog-entries .type-page',
				
				// Pagination
				'.page-numbers a,
				.page-numbers span,
				.page-links span',

				// Widgets
				'#wp-calendar caption,
				#wp-calendar th,
				#wp-calendar tbody',

				'.contact-info-widget i',

				'.posts-thumbnails-widget li',

				'.tagcloud a'

			) );

		}

		/**
		 * Get Site Background CSS
		 *
		 * @since 1.0.0
		 */
		public function site_background_css( $output ) {

			// Global vars
			$background_color 				= get_theme_mod( 'kindling_background_color', '#ffffff' );
			$background_image 				= get_theme_mod( 'kindling_background_image' );
			$background_image_position 		= get_theme_mod( 'kindling_background_image_position' );
			$background_image_attachment 	= get_theme_mod( 'kindling_background_image_attachment' );
			$background_image_repeat 		= get_theme_mod( 'kindling_background_image_repeat' );
			$background_image_size 			= get_theme_mod( 'kindling_background_image_size' );

			// Define css var
			$css = '';

			// Get site background color
			if ( ! empty( $background_color ) && '#ffffff' != $background_color ) {
				$css .= 'background-color:'. $background_color .';';
			}

			// Get site background image
			if ( ! empty( $background_image ) ) {
				$css .= 'background-image:url('. $background_image .');';
			}

			// Get site background position
			if ( ! empty( $background_image_position ) && 'initial' != $background_image_position ) {
				$css .= 'background-position:'. $background_image_position .';';
			}

			// Get site background attachment
			if ( ! empty( $background_image_attachment ) && 'initial' != $background_image_attachment ) {
				$css .= 'background-attachment:'. $background_image_attachment .';';
			}

			// Get site background repeat
			if ( ! empty( $background_image_repeat ) && 'initial' != $background_image_repeat ) {
				$css .= 'background-repeat:'. $background_image_repeat .';';
			}

			// Get site background size
			if ( ! empty( $background_image_size ) && 'initial' != $background_image_size ) {
				$css .= 'background-size:'. $background_image_size .';';
			}

			// Return CSS
			if ( ! empty( $css ) ) {
				$output .= '/* Site Background CSS */body{'. $css .'}';
			}

			// Return output css
			return $output;

		}

		/**
		 * Get CSS
		 *
		 * @since 1.0.0
		 */
		public function head_css( $output ) {

			// Global vars
			$primary_color 					= get_theme_mod( 'kindling_primary_color', '#13aff0' );
			$hover_primary_color 			= get_theme_mod( 'kindling_hover_primary_color', '#0b7cac' );
			$main_border_color 				= get_theme_mod( 'kindling_main_border_color', '#e9e9e9' );
			$links_color 					= get_theme_mod( 'kindling_links_color', '#333333' );
			$links_color_hover 				= get_theme_mod( 'kindling_links_color_hover', '#13aff0' );
			$boxed_width 					= get_theme_mod( 'kindling_boxed_width', '1280' );
			$boxed_outside_bg 				= get_theme_mod( 'kindling_boxed_outside_bg', '#e9e9e9' );
			$boxed_inner_bg 				= get_theme_mod( 'kindling_boxed_inner_bg', '#ffffff' );
			$main_container_width 			= get_theme_mod( 'kindling_main_container_width', '1200' );
			$left_container_width 			= get_theme_mod( 'kindling_left_container_width', '72' );
			$sidebar_width 					= get_theme_mod( 'kindling_sidebar_width', '28' );
			$content_top_padding 			= get_theme_mod( 'kindling_page_content_top_padding', '50' );
			$content_bottom_padding 		= get_theme_mod( 'kindling_page_content_bottom_padding', '50' );
			$page_header_top_padding 		= get_theme_mod( 'kindling_page_header_top_padding', '34' );
			$page_header_bottom_padding 	= get_theme_mod( 'kindling_page_header_bottom_padding', '34' );
			$page_header_bg 				= get_theme_mod( 'kindling_page_header_background', '#f5f5f5' );
			$page_header_title_color 		= get_theme_mod( 'kindling_page_header_title_color', '#333333' );
			$breadcrumbs_text_color 		= get_theme_mod( 'kindling_breadcrumbs_text_color', '#c6c6c6' );
			$breadcrumbs_seperator_color 	= get_theme_mod( 'kindling_breadcrumbs_seperator_color', '#c6c6c6' );
			$breadcrumbs_link_color 		= get_theme_mod( 'kindling_breadcrumbs_link_color', '#333333' );
			$breadcrumbs_link_color_hover 	= get_theme_mod( 'kindling_breadcrumbs_link_color_hover', '#13aff0' );
			$scroll_top_size 				= get_theme_mod( 'kindling_scroll_top_size', '40' );
			$scroll_top_icon_size 			= get_theme_mod( 'kindling_scroll_top_icon_size', '18' );
			$scroll_top_border_radius 		= get_theme_mod( 'kindling_scroll_top_border_radius', '2' );
			$scroll_top_bg 					= get_theme_mod( 'kindling_scroll_top_bg', 'rgba(0,0,0,0.4)' );
			$scroll_top_bg_hover 			= get_theme_mod( 'kindling_scroll_top_bg_hover', 'rgba(0,0,0,0.8)' );
			$scroll_top_color 				= get_theme_mod( 'kindling_scroll_top_color', '#ffffff' );
			$scroll_top_color_hover 		= get_theme_mod( 'kindling_scroll_top_color_hover', '#ffffff' );
			$pagination_font_size 			= get_theme_mod( 'kindling_pagination_font_size', '18' );
			$pagination_border_width 		= get_theme_mod( 'kindling_pagination_border_width', '1' );
			$pagination_bg 					= get_theme_mod( 'kindling_pagination_bg' );
			$pagination_hover_bg 			= get_theme_mod( 'kindling_pagination_hover_bg', '#f8f8f8' );
			$pagination_color 				= get_theme_mod( 'kindling_pagination_color', '#555555' );
			$pagination_hover_color 		= get_theme_mod( 'kindling_pagination_hover_color', '#333333' );
			$pagination_border_color 		= get_theme_mod( 'kindling_pagination_border_color', '#e9e9e9' );
			$pagination_border_hover_color 	= get_theme_mod( 'kindling_pagination_border_hover_color', '#e9e9e9' );

			// Define css var
			$css = '';

			// Get primary color arrays
			$texts       	= $this->primary_color_arrays( 'texts' );
			$backgrounds 	= $this->primary_color_arrays( 'backgrounds' );
			$borders     	= $this->primary_color_arrays( 'borders' );

			// Get hover primary color arrays
			$hover_primary 	= $this->hover_primary_color_array( 'hover' );

			// Get hover primary color arrays
			$main_border 	= $this->main_border_array();

			// Texts
			if ( ! empty( $texts ) && '#13aff0' != $primary_color ) {
				$css .= implode( ',', $texts ) .'{color:'. $primary_color .';}';
			}

			// Backgrounds
			if ( ! empty( $backgrounds ) && '#13aff0' != $primary_color ) {
				$css .= implode( ',', $backgrounds ) .'{background-color:'. $primary_color .';}';
			}

			// Borders
			if ( ! empty( $borders ) && '#13aff0' != $primary_color ) {
				foreach ( $borders as $key => $val ) {
					if ( is_array( $val ) ) {
						$css .= $key .'{';
						foreach ( $val as $key => $val ) {
							$css .= 'border-'. $val .'-color:'. $primary_color .';';
						}
						$css .= '}'; 
					} else {
						$css .= $val .'{border-color:'. $primary_color .';}';
					}
				}
			}

			// Hover primary color
			if ( ! empty( $hover_primary ) && '#0b7cac' != $hover_primary_color ) {
				$css .= implode( ',', $hover_primary ) .'{background-color:'. $hover_primary_color .';}';
			}

			// Main border color
			if ( ! empty( $main_border ) && '#e9e9e9' != $main_border_color ) {
				$css .= implode( ',', $main_border ) .'{border-color:'. $main_border_color .';}';
			}

			// Links color
			if ( ! empty( $links_color ) && '#333333' != $links_color ) {
				$css .= 'a{color:'. $links_color .';}';
			}

			// Links color hover
			if ( ! empty( $links_color_hover ) && '#13aff0' != $links_color_hover ) {
				$css .= 'a{color:'. $links_color_hover .';}';
			}

			// Boxed width
			if ( ! empty( $boxed_width ) && '1280' != $boxed_width ) {
				$css .= '.boxed-main-layout #wrap{width:'. $boxed_width .'px;}';
			}

			// Boxed outside background
			if ( ! empty( $boxed_outside_bg ) && '#e9e9e9' != $boxed_outside_bg ) {
				$css .= '.boxed-main-layout{background-color:'. $boxed_outside_bg .';}';
			}

			// Boxed inner background
			if ( ! empty( $boxed_inner_bg ) && '#ffffff' != $boxed_inner_bg ) {
				$css .= '.boxed-main-layout #wrap{background-color:'. $boxed_inner_bg .';}';
			}

			// Content top padding
			if ( ! empty( $main_container_width ) && '1200' != $main_container_width ) {
				$css .= '.container{width:'. $main_container_width .'px;}';
			}

			// Content top padding
			if ( ! empty( $left_container_width ) && '72' != $left_container_width ) {
				$css .= '@media only screen and (min-width: 960px){ .content-area{width:'. $left_container_width .'%;} }';
			}

			// Content top padding
			if ( ! empty( $sidebar_width ) && '28' != $sidebar_width ) {
				$css .= '@media only screen and (min-width: 960px){ .widget-area{width:'. $sidebar_width .'%;} }';
			}

			// Content top padding
			if ( ! empty( $content_top_padding ) && '50' != $content_top_padding ) {
				$css .= '#main #content-wrap{padding-top:'. $content_top_padding .'px;}';
			}

			// Content bottom padding
			if ( ! empty( $content_bottom_padding ) && '50' != $content_bottom_padding ) {
				$css .= '#main #content-wrap{padding-bottom:'. $content_bottom_padding .'px;}';
			}

			// Page header top padding
			if ( ! empty( $page_header_top_padding ) && '34' != $page_header_top_padding ) {
				$css .= '.page-header, .has-transparent-header .page-header{padding-top:'. $page_header_top_padding .'px;}';
			}

			// Page header bottom padding
			if ( ! empty( $page_header_bottom_padding ) && '34' != $page_header_bottom_padding ) {
				$css .= '.page-header, .has-transparent-header .page-header{padding-bottom:'. $page_header_bottom_padding .'px;}';
			}

			// Page header background
			if ( ! empty( $page_header_bg ) && '#f5f5f5' != $page_header_bg ) {
				$css .= '.page-header{background-color:'. $page_header_bg .';}';
			}

			// Page header color
			if ( ! empty( $page_header_title_color ) && '#333333' != $page_header_title_color ) {
				$css .= '.page-header .page-header-title{color:'. $page_header_title_color .';}';
			}

			// Breadcrumbs text color
			if ( ! empty( $breadcrumbs_text_color ) && '#c6c6c6' != $breadcrumbs_text_color ) {
				$css .= '.site-breadcrumbs{color:'. $breadcrumbs_text_color .';}';
			}

			// Breadcrumbs seperator color
			if ( ! empty( $breadcrumbs_seperator_color ) && '#c6c6c6' != $breadcrumbs_seperator_color ) {
				$css .= '.site-breadcrumbs .sep{color:'. $breadcrumbs_seperator_color .';}';
			}

			// Breadcrumbs link color
			if ( ! empty( $breadcrumbs_link_color ) && '#333333' != $breadcrumbs_link_color ) {
				$css .= '.site-breadcrumbs a{color:'. $breadcrumbs_link_color .';}';
			}

			// Breadcrumbs link hover color
			if ( ! empty( $breadcrumbs_link_color_hover ) && '#13aff0' != $breadcrumbs_link_color_hover ) {
				$css .= '.site-breadcrumbs a:hover{color:'. $breadcrumbs_link_color_hover .';}';
			}

			// Scroll top button size
			if ( ! empty( $scroll_top_size ) && '40' != $scroll_top_size ) {
				$css .= '#scroll-top{width:'. $scroll_top_size .'px;height:'. $scroll_top_size .'px;line-height:'. $scroll_top_size .'px;}';
			}

			// Scroll top button icon size
			if ( ! empty( $scroll_top_icon_size ) && '18' != $scroll_top_icon_size ) {
				$css .= '#scroll-top{font-size:'. $scroll_top_icon_size .'px;}';
			}

			// Scroll top button border radius
			if ( ! empty( $scroll_top_border_radius ) && '2' != $scroll_top_border_radius ) {
				$css .= '#scroll-top{border-radius:'. $scroll_top_border_radius .'px;}';
			}

			// Scroll top button background color
			if ( ! empty( $scroll_top_bg ) && 'rgba(0,0,0,0.4)' != $scroll_top_bg ) {
				$css .= '#scroll-top{background-color:'. $scroll_top_bg .';}';
			}

			// Scroll top button background hover color
			if ( ! empty( $scroll_top_bg_hover ) && 'rgba(0,0,0,0.8)' != $scroll_top_bg_hover ) {
				$css .= '#scroll-top:hover{background-color:'. $scroll_top_bg_hover .';}';
			}

			// Scroll top button background color
			if ( ! empty( $scroll_top_color ) && '#ffffff' != $scroll_top_color ) {
				$css .= '#scroll-top{color:'. $scroll_top_color .';}';
			}

			// Scroll top button background hover color
			if ( ! empty( $scroll_top_color_hover ) && '#ffffff' != $scroll_top_color_hover ) {
				$css .= '#scroll-top:hover{color:'. $scroll_top_color_hover .';}';
			}

			// Pagination font size
			if ( ! empty( $pagination_font_size ) && '18' != $pagination_font_size ) {
				$css .= '.page-numbers a, .page-numbers span, .page-links span{font-size:'. $pagination_font_size .'px;}';
			}

			// Pagination border width
			if ( ! empty( $pagination_border_width ) && '1' != $pagination_border_width ) {
				$css .= '.page-numbers a, .page-numbers span, .page-links span{border-width:'. $pagination_border_width .'px;}';
			}

			// Pagination background color
			if ( ! empty( $pagination_bg ) ) {
				$css .= '.page-numbers a, .page-numbers span, .page-links span{background-color:'. $pagination_bg .';}';
			}

			// Pagination background color hover
			if ( ! empty( $pagination_hover_bg ) && '#f8f8f8' != $pagination_hover_bg ) {
				$css .= '.page-numbers a:hover, .page-links a:hover span, .page-numbers.current, .page-numbers.current:hover{background-color:'. $pagination_hover_bg .';}';
			}

			// Pagination color
			if ( ! empty( $pagination_color ) && '#555555' != $pagination_color ) {
				$css .= '.page-numbers a, .page-numbers span, .page-links span{color:'. $pagination_color .';}';
			}

			// Pagination color hover
			if ( ! empty( $pagination_hover_color ) && '#333333' != $pagination_hover_color ) {
				$css .= '.page-numbers a:hover, .page-links a:hover span, .page-numbers.current, .page-numbers.current:hover{color:'. $pagination_hover_color .';}';
			}

			// Pagination border color
			if ( ! empty( $pagination_border_color ) && '#e9e9e9' != $pagination_border_color ) {
				$css .= '.page-numbers a, .page-numbers span, .page-links span{border-color:'. $pagination_border_color .';}';
			}

			// Pagination border color hover
			if ( ! empty( $pagination_border_hover_color ) && '#e9e9e9' != $pagination_border_hover_color ) {
				$css .= '.page-numbers a:hover, .page-links a:hover span, .page-numbers.current, .page-numbers.current:hover{border-color:'. $pagination_border_hover_color .';}';
			}

			// Return CSS
			if ( ! empty( $css ) ) {
				$output .= '/* General CSS */'. $css;
			}

			// Return output css
			return $output;

		}

	}

endif;

return new Kindling_General_Customizer();