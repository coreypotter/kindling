<?php
/**
 * Blog Customizer Options
 *
 * @package Kindling Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kindling_Blog_Customizer' ) ) :

	class Kindling_Blog_Customizer {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'customize_register', array( $this, 'customizer_options' ) );
			add_filter( 'kindling_blog_css',  array( $this, 'blog_css' ) );

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
			$panel = 'kindling_blog';
			$wp_customize->add_panel( $panel , array(
				'title' 			=> esc_html__( 'Blog', 'kindling' ),
				'priority' 			=> 4,
			) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'kindling_blog_entries', array(
				'title' 			=> esc_html__( 'Blog Entries', 'kindling' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Archives & Entries Layout
			 */
			$wp_customize->add_setting( 'kindling_blog_archives_layout', array(
				'default'           	=> 'right-sidebar',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Radio_Image_Control( $wp_customize, 'kindling_blog_archives_layout', array(
				'label'	   				=> esc_html__( 'Archives & Entries Layout', 'kindling' ),
				'section'  				=> 'kindling_blog_entries',
				'settings' 				=> 'kindling_blog_archives_layout',
				'priority' 				=> 10,
				'choices' 				=> array(
					'right-sidebar'  	=> KINDLING_INC_DIR_URI . 'customizer/assets/img/2cr.png',
					'left-sidebar' 		=> KINDLING_INC_DIR_URI . 'customizer/assets/img/2cl.png',
					'full-width'  		=> KINDLING_INC_DIR_URI . 'customizer/assets/img/1c.png',
				),
			) ) );

			/**
			 * Blog Style
			 */
			$wp_customize->add_setting( 'kindling_blog_style', array(
				'default'           	=> 'large-entry',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_blog_style', array(
				'label'	   				=> esc_html__( 'Blog Style', 'kindling' ),
				'type' 					=> 'select',
				'section'  				=> 'kindling_blog_entries',
				'settings' 				=> 'kindling_blog_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'large-entry'  		=> esc_html__( 'Large Image', 'kindling' ),
					'grid-entry' 		=> esc_html__( 'Grid', 'kindling' ),
				),
			) ) );

			/**
			 * Blog Grid Images Size
			 */
			$wp_customize->add_setting( 'kindling_blog_grid_images_size', array(
				'default'           	=> 'medium',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_blog_grid_images_size', array(
				'label'	   				=> esc_html__( 'Images Size', 'kindling' ),
				'type' 					=> 'select',
				'section'  				=> 'kindling_blog_entries',
				'settings' 				=> 'kindling_blog_grid_images_size',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_grid_blog_style',
				'choices' 				=> array(
					'thumbnail' 		=> esc_html__( 'Thumbnail', 'kindling' ),
					'medium' 			=> esc_html__( 'Medium', 'kindling' ),
					'medium_large' 		=> esc_html__( 'Medium Large', 'kindling' ),
					'large' 			=> esc_html__( 'Large', 'kindling' ),
				),
			) ) );

			/**
			 * Blog Grid Columns
			 */
			$wp_customize->add_setting( 'kindling_blog_grid_columns', array(
				'default'           	=> '2',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_blog_grid_columns', array(
				'label'	   				=> esc_html__( 'Grid Columns', 'kindling' ),
				'type' 					=> 'select',
				'section'  				=> 'kindling_blog_entries',
				'settings' 				=> 'kindling_blog_grid_columns',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_grid_blog_style',
				'choices' 				=> array(
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				),
			) ) );

			/**
			 * Blog Grid Style
			 */
			$wp_customize->add_setting( 'kindling_blog_grid_style', array(
				'default'           	=> 'fit-rows',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_blog_grid_style', array(
				'label'	   				=> esc_html__( 'Grid Style', 'kindling' ),
				'type' 					=> 'select',
				'section'  				=> 'kindling_blog_entries',
				'settings' 				=> 'kindling_blog_grid_style',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_grid_blog_style',
				'choices' 				=> array(
					'fit-rows' 			=> esc_html__( 'Fit Rows', 'kindling' ),
					'masonry' 			=> esc_html__( 'Masonry', 'kindling' ),
				),
			) ) );

			/**
			 * Blog Grid Equal Heights
			 */
			$wp_customize->add_setting( 'kindling_blog_grid_equal_heights', array(
				'default'           	=> false,
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_blog_grid_equal_heights', array(
				'label'	   				=> esc_html__( 'Equal Heights', 'kindling' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'kindling_blog_entries',
				'settings' 				=> 'kindling_blog_grid_equal_heights',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_blog_supports_equal_heights',
			) ) );

			/**
			 * Blog Pagination Style
			 */
			$wp_customize->add_setting( 'kindling_blog_pagination_style', array(
				'default'           	=> 'standard',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_blog_pagination_style', array(
				'label'	   				=> esc_html__( 'Blog Pagination Style', 'kindling' ),
				'type' 					=> 'select',
				'section'  				=> 'kindling_blog_entries',
				'settings' 				=> 'kindling_blog_pagination_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'standard' 			=> esc_html__( 'Standard', 'kindling' ),
					'infinite_scroll' 	=> esc_html__( 'Infinite Scroll', 'kindling' ),
					'next_prev' 		=> esc_html__( 'Next/Prev', 'kindling' ),
				),
			) ) );

			/**
			 * Blog Entries Elements Positioning
			 */
			$wp_customize->add_setting( 'kindling_blog_entry_elements_positioning', array(
				'default'           	=> array( 'featured_image', 'title', 'meta', 'content', 'read_more' ),
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Sortable_Control( $wp_customize, 'kindling_blog_entry_elements_positioning', array(
				'label'	   				=> esc_html__( 'Elements Positioning', 'kindling' ),
				'section'  				=> 'kindling_blog_entries',
				'settings' 				=> 'kindling_blog_entry_elements_positioning',
				'priority' 				=> 10,
				'choices' 				=> array(
					'featured_image'    => esc_html__( 'Featured Image', 'kindling' ),
					'title'       		=> esc_html__( 'Title', 'kindling' ),
					'meta' 				=> esc_html__( 'Meta', 'kindling' ),
					'content' 			=> esc_html__( 'Content', 'kindling' ),
					'read_more'   		=> esc_html__( 'Read More', 'kindling' ),
				),
			) ) );

			/**
			 * Blog Entries Meta
			 */
			$wp_customize->add_setting( 'kindling_blog_entry_meta', array(
				'default'           	=> array( 'author', 'date', 'categories', 'comments' ),
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Sortable_Control( $wp_customize, 'kindling_blog_entry_meta', array(
				'label'	   				=> esc_html__( 'Meta', 'kindling' ),
				'section'  				=> 'kindling_blog_entries',
				'settings' 				=> 'kindling_blog_entry_meta',
				'priority' 				=> 10,
				'choices' 				=> array(
					'author'     		=> esc_html__( 'Author', 'kindling' ),
					'date'       		=> esc_html__( 'Date', 'kindling' ),
					'categories' 		=> esc_html__( 'Categories', 'kindling' ),
					'comments'   		=> esc_html__( 'Comments', 'kindling' ),
				),
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'kindling_single_post', array(
				'title' 			=> esc_html__( 'Single Post', 'kindling' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Single Layout
			 */
			$wp_customize->add_setting( 'kindling_blog_single_layout', array(
				'default'           	=> 'right-sidebar',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Radio_Image_Control( $wp_customize, 'kindling_blog_single_layout', array(
				'label'	   				=> esc_html__( 'Layout', 'kindling' ),
				'section'  				=> 'kindling_single_post',
				'settings' 				=> 'kindling_blog_single_layout',
				'priority' 				=> 10,
				'choices' 				=> array(
					'right-sidebar'  	=> KINDLING_INC_DIR_URI . 'customizer/assets/img/2cr.png',
					'left-sidebar' 		=> KINDLING_INC_DIR_URI . 'customizer/assets/img/2cl.png',
					'full-width'  		=> KINDLING_INC_DIR_URI . 'customizer/assets/img/1c.png',
				),
			) ) );

			/**
			 * Page Header Title
			 */
			$wp_customize->add_setting( 'kindling_blog_single_page_header_title', array(
				'default'           	=> 'blog',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_blog_single_page_header_title', array(
				'label'	   				=> esc_html__( 'Page Header Title', 'kindling' ),
				'type' 					=> 'select',
				'section'  				=> 'kindling_single_post',
				'settings' 				=> 'kindling_blog_single_page_header_title',
				'priority' 				=> 10,
				'choices' 				=> array(
					'blog' 				=> esc_html__( 'Blog','kindling' ),
					'post-title' 		=> esc_html__( 'Post Title', 'kindling' ),
				),
			) ) );

			/**
			 * Add Container Featured Image In Page Header
			 */
			$wp_customize->add_setting( 'kindling_blog_single_featured_image_title', array(
				'default'           	=> false,
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_blog_single_featured_image_title', array(
				'label'	   				=> esc_html__( 'Featured Image In Page Header', 'kindling' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'kindling_single_post',
				'settings' 				=> 'kindling_blog_single_featured_image_title',
				'priority' 				=> 10,
			) ) );

			/**
			 * Blog Single Page Header Background Image Height
			 */
			$wp_customize->add_setting( 'kindling_blog_single_title_bg_image_height', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '400',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_blog_single_title_bg_image_height', array(
				'label'	   				=> esc_html__( 'Page Header Height (px)', 'kindling' ),
				'section'  				=> 'kindling_single_post',
				'settings' 				=> 'kindling_blog_single_title_bg_image_height',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 800,
			        'step'  => 1,
			    ),
				'active_callback' 		=> 'kindling_cac_has_blog_single_title_bg_image',
			) ) );

			/**
			 * Blog Single Page Header Background Image Overlay Opacity
			 */
			$wp_customize->add_setting( 'kindling_blog_single_title_bg_image_overlay_opacity', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '0.5',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_blog_single_title_bg_image_overlay_opacity', array(
				'label'	   				=> esc_html__( 'Overlay Opacity', 'kindling' ),
				'section'  				=> 'kindling_single_post',
				'settings' 				=> 'kindling_blog_single_title_bg_image_overlay_opacity',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 1,
			        'step'  => 0.1,
			    ),
				'active_callback' 		=> 'kindling_cac_has_blog_single_title_bg_image',
			) ) );

			/**
			 * Blog Single Page Header Background Image Overlay Color
			 */
			$wp_customize->add_setting( 'kindling_blog_single_title_bg_image_overlay_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#000000',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_blog_single_title_bg_image_overlay_color', array(
				'label'	   				=> esc_html__( 'Overlay Color', 'kindling' ),
				'section'  				=> 'kindling_single_post',
				'settings' 				=> 'kindling_blog_single_title_bg_image_overlay_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_blog_single_title_bg_image',
			) ) );

			/**
			 * Blog Single Elements Positioning
			 */
			$wp_customize->add_setting( 'kindling_blog_single_elements_positioning', array(
				'default' 				=> array( 'featured_image', 'title', 'meta', 'content', 'tags', 'social_share', 'next_prev', 'author_box', 'related_posts', 'single_comments' ),
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Sortable_Control( $wp_customize, 'kindling_blog_single_elements_positioning', array(
				'label'	   				=> esc_html__( 'Elements Positioning', 'kindling' ),
				'section'  				=> 'kindling_single_post',
				'settings' 				=> 'kindling_blog_single_elements_positioning',
				'priority' 				=> 10,
				'choices' 				=> array(
					'featured_image'    => esc_html__( 'Featured Image', 'kindling' ),
					'title'       		=> esc_html__( 'Title', 'kindling' ),
					'meta' 				=> esc_html__( 'Meta', 'kindling' ),
					'content' 			=> esc_html__( 'Content', 'kindling' ),
					'tags' 				=> esc_html__( 'Tags', 'kindling' ),
					'social_share'   	=> esc_html__( 'Social Share', 'kindling' ),
					'next_prev'     	=> esc_html__( 'Next/Prev Links', 'kindling' ),
					'author_box'       	=> esc_html__( 'Author Box', 'kindling' ),
					'related_posts' 	=> esc_html__( 'Related Posts', 'kindling' ),
					'single_comments'   => esc_html__( 'Comments', 'kindling' ),
				),
			) ) );

			/**
			 * Blog Single Meta
			 */
			$wp_customize->add_setting( 'kindling_blog_single_meta', array(
				'default'           	=> array( 'author', 'date', 'categories', 'comments' ),
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Sortable_Control( $wp_customize, 'kindling_blog_single_meta', array(
				'label'	   				=> esc_html__( 'Meta', 'kindling' ),
				'section'  				=> 'kindling_single_post',
				'settings' 				=> 'kindling_blog_single_meta',
				'priority' 				=> 10,
				'choices' 				=> array(
					'author'     		=> esc_html__( 'Author', 'kindling' ),
					'date'       		=> esc_html__( 'Date', 'kindling' ),
					'categories' 		=> esc_html__( 'Categories', 'kindling' ),
					'comments'   		=> esc_html__( 'Comments', 'kindling' ),
				),
			) ) );

			/**
			 * Related Posts Count
			 */
			$wp_customize->add_setting( 'kindling_blog_related_count', array(
				'default' 				=> '3',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_blog_related_count', array(
				'label'	   				=> esc_html__( 'Related Posts Count', 'kindling' ),
				'section'  				=> 'kindling_single_post',
				'settings' 				=> 'kindling_blog_related_count',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 2,
			        'max'   => 12,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Related Posts Columns
			 */
			$wp_customize->add_setting( 'kindling_blog_related_columns', array(
				'default' 				=> '3',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_blog_related_columns', array(
				'label'	   				=> esc_html__( 'Related Posts Columns', 'kindling' ),
				'section'  				=> 'kindling_single_post',
				'settings' 				=> 'kindling_blog_related_columns',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 1,
			        'max'   => 6,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'kindling_general_forms' , array(
				'title' 			=> esc_html__( 'Comments', 'kindling' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Forms Label Color
			 */
			$wp_customize->add_setting( 'kindling_label_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#929292',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_label_color', array(
				'label'	   				=> esc_html__( 'Label Color', 'kindling' ),
				'section'  				=> 'kindling_general_forms',
				'settings' 				=> 'kindling_label_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Forms Padding
			 */
			$wp_customize->add_setting( 'kindling_input_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_input_padding', array(
				'label'	   				=> esc_html__( 'Padding (px)', 'kindling' ),
				'description'	   		=> esc_html__( 'Format: top right bottom left.', 'kindling' ),
				'type' 					=> 'text',
				'section'  				=> 'kindling_general_forms',
				'settings' 				=> 'kindling_input_padding',
				'priority' 				=> 10,
			) ) );

			/**
			 * Forms Font Size
			 */
			$wp_customize->add_setting( 'kindling_input_font_size', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '14',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_input_font_size', array(
				'label'	   				=> esc_html__( 'Font Size (px)', 'kindling' ),
				'section'  				=> 'kindling_general_forms',
				'settings' 				=> 'kindling_input_font_size',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Forms Border Width
			 */
			$wp_customize->add_setting( 'kindling_input_border_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_input_border_width', array(
				'label'	   				=> esc_html__( 'Border Width (px)', 'kindling' ),
				'description'	   		=> esc_html__( 'Format: top right bottom left.', 'kindling' ),
				'type' 					=> 'text',
				'section'  				=> 'kindling_general_forms',
				'settings' 				=> 'kindling_input_border_width',
				'priority' 				=> 10,
			) ) );

			/**
			 * Forms Border Radius
			 */
			$wp_customize->add_setting( 'kindling_input_border_radius', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '3',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_input_border_radius', array(
				'label'	   				=> esc_html__( 'Border Radius (px)', 'kindling' ),
				'section'  				=> 'kindling_general_forms',
				'settings' 				=> 'kindling_input_border_radius',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Forms Border Color
			 */
			$wp_customize->add_setting( 'kindling_input_border_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#dddddd',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_input_border_color', array(
				'label'	   				=> esc_html__( 'Border Color', 'kindling' ),
				'section'  				=> 'kindling_general_forms',
				'settings' 				=> 'kindling_input_border_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Forms Border Color Focus
			 */
			$wp_customize->add_setting( 'kindling_input_border_color_focus', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#bbbbbb',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_input_border_color_focus', array(
				'label'	   				=> esc_html__( 'Border Color: Focus', 'kindling' ),
				'section'  				=> 'kindling_general_forms',
				'settings' 				=> 'kindling_input_border_color_focus',
				'priority' 				=> 10,
			) ) );

			/**
			 * Forms Background Color
			 */
			$wp_customize->add_setting( 'kindling_input_background', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_input_background', array(
				'label'	   				=> esc_html__( 'Background Color', 'kindling' ),
				'section'  				=> 'kindling_general_forms',
				'settings' 				=> 'kindling_input_background',
				'priority' 				=> 10,
			) ) );

			/**
			 * Forms Color
			 */
			$wp_customize->add_setting( 'kindling_input_color', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#333333',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_input_color', array(
				'label'	   				=> esc_html__( 'Color', 'kindling' ),
				'section'  				=> 'kindling_general_forms',
				'settings' 				=> 'kindling_input_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'kindling_general_theme_button' , array(
				'title' 			=> esc_html__( 'Buttons', 'kindling' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Theme Button
			 */
			$wp_customize->add_setting( 'kindling_theme_button_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_theme_button_padding', array(
				'label'	   				=> esc_html__( 'Padding (px)', 'kindling' ),
				'description'	   		=> esc_html__( 'Format: top right bottom left.', 'kindling' ),
				'type' 					=> 'text',
				'section'  				=> 'kindling_general_theme_button',
				'settings' 				=> 'kindling_theme_button_padding',
				'priority' 				=> 10,
			) ) );

			/**
			 * Theme Button Border Radius
			 */
			$wp_customize->add_setting( 'kindling_theme_button_border_radius', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '0',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_theme_button_border_radius', array(
				'label'	   				=> esc_html__( 'Border Radius (px)', 'kindling' ),
				'section'  				=> 'kindling_general_theme_button',
				'settings' 				=> 'kindling_theme_button_border_radius',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Theme Button Background Color
			 */
			$wp_customize->add_setting( 'kindling_theme_button_bg', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#13aff0',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_theme_button_bg', array(
				'label'	   				=> esc_html__( 'Background Color', 'kindling' ),
				'section'  				=> 'kindling_general_theme_button',
				'settings' 				=> 'kindling_theme_button_bg',
				'priority' 				=> 10,
			) ) );

			/**
			 * Theme Button Background Color Hover
			 */
			$wp_customize->add_setting( 'kindling_theme_button_hover_bg', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#0b7cac',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_theme_button_hover_bg', array(
				'label'	   				=> esc_html__( 'Background Color: Hover', 'kindling' ),
				'section'  				=> 'kindling_general_theme_button',
				'settings' 				=> 'kindling_theme_button_hover_bg',
				'priority' 				=> 10,
			) ) );

			/**
			 * Theme Button Color
			 */
			$wp_customize->add_setting( 'kindling_theme_button_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#ffffff',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_theme_button_color', array(
				'label'	   				=> esc_html__( 'Color', 'kindling' ),
				'section'  				=> 'kindling_general_theme_button',
				'settings' 				=> 'kindling_theme_button_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Theme Button Color Hover
			 */
			$wp_customize->add_setting( 'kindling_theme_button_hover_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#ffffff',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_theme_button_hover_color', array(
				'label'	   				=> esc_html__( 'Color: Hover', 'kindling' ),
				'section'  				=> 'kindling_general_theme_button',
				'settings' 				=> 'kindling_theme_button_hover_color',
				'priority' 				=> 10,
			) ) );			
			
		}

		/**
		 * Get CSS
		 *
		 */
		public function blog_css( $output ) {
			$label_color 					= get_theme_mod( 'kindling_label_color', '#929292' );
			$input_padding 					= get_theme_mod( 'kindling_input_padding' );
			$input_font_size 				= get_theme_mod( 'kindling_input_font_size', '14' );
			$input_border_width 			= get_theme_mod( 'kindling_input_border_width' );
			$input_border_radius 			= get_theme_mod( 'kindling_input_border_radius', '3' );
			$input_border_color 			= get_theme_mod( 'kindling_input_border_color', '#dddddd' );
			$input_border_color_focus 		= get_theme_mod( 'kindling_input_border_color_focus', '#bbbbbb' );
			$input_background 				= get_theme_mod( 'kindling_input_background' );
			$input_color 					= get_theme_mod( 'kindling_input_color', '#333333' );
			$theme_button_padding 			= get_theme_mod( 'kindling_theme_button_padding' );
			$theme_button_border_radius 	= get_theme_mod( 'kindling_theme_button_border_radius', '0' );
			$theme_button_bg 				= get_theme_mod( 'kindling_theme_button_bg', '#13aff0' );
			$theme_button_hover_bg 			= get_theme_mod( 'kindling_theme_button_hover_bg', '#0b7cac' );
			$theme_button_color 			= get_theme_mod( 'kindling_theme_button_color', '#ffffff' );
			$theme_button_hover_color 		= get_theme_mod( 'kindling_theme_button_hover_color', '#ffffff' );

			# Define CSS var
			$css = '';


			// Label color
			if ( ! empty( $label_color ) && '#929292' != $label_color ) {
				$css .= 'label{color:'. $label_color .';}';
			}

			// Input padding
			if ( ! empty( $input_padding ) ) {
				$css .= '.site-content input[type="text"],.site-content input[type="password"],.site-content input[type="email"],.site-content input[type="tel"],.site-content input[type="url"],.site-content input[type="search"],.site-content textarea{padding:'. $input_padding .';}';
			}

			// Input font size
			if ( ! empty( $input_font_size ) && '14' != $input_font_size ) {
				$css .= '.site-content input[type="text"],.site-content input[type="password"],.site-content input[type="email"],.site-content input[type="tel"],.site-content input[type="url"],.site-content input[type="search"],.site-content textarea{font-size:'. $input_font_size .'px;}';
			}

			// Input border width
			if ( ! empty( $input_border_width ) ) {
				$css .= '.site-content input[type="text"],.site-content input[type="password"],.site-content input[type="email"],.site-content input[type="tel"],.site-content input[type="url"],.site-content input[type="search"],.site-content textarea{border-width:'. $input_border_width .';}';
			}

			// Input border radius
			if ( ! empty( $input_border_radius ) && '3' != $input_border_radius ) {
				$css .= '.site-content input[type="text"],.site-content input[type="password"],.site-content input[type="email"],.site-content input[type="tel"],.site-content input[type="url"],.site-content input[type="search"],.site-content textarea{border-radius:'. $input_border_radius .'px;}';
			}

			// Input border radius
			if ( ! empty( $input_border_color ) && '3' != $input_border_color ) {
				$css .= '.site-content input[type="text"],.site-content input[type="password"],.site-content input[type="email"],.site-content input[type="tel"],.site-content input[type="url"],.site-content input[type="search"],.site-content textarea,.select2-container .select2-choice{border-color:'. $input_border_color .';}';
			}

			// Input border radius
			if ( ! empty( $input_border_color_focus ) && '3' != $input_border_color_focus ) {
				$css .= '.site-content input[type="text"]:focus,.site-content input[type="password"]:focus,.site-content input[type="email"]:focus,.site-content input[type="tel"]:focus,.site-content input[type="url"]:focus,.site-content input[type="search"]:focus,.site-content textarea:focus,.select2-drop-active,.select2-dropdown-open.select2-drop-above .select2-choice,.select2-dropdown-open.select2-drop-above .select2-choices,.select2-drop.select2-drop-above.select2-drop-active,.select2-container-active .select2-choice,.select2-container-active .select2-choices{border-color:'. $input_border_color_focus .';}';
			}

			// Input border radius
			if ( ! empty( $input_background ) ) {
				$css .= '.site-content input[type="text"],.site-content input[type="password"],.site-content input[type="email"],.site-content input[type="tel"],.site-content input[type="url"],.site-content input[type="search"],.site-content textarea{background-color:'. $input_background .';}';
			}

			// Input border radius
			if ( ! empty( $input_color ) && '#333333' != $input_color ) {
				$css .= '.site-content input[type="text"],.site-content input[type="password"],.site-content input[type="email"],.site-content input[type="tel"],.site-content input[type="url"],.site-content input[type="search"],.site-content textarea{color:'. $input_color .';}';
			}

			// Theme button padding
			if ( ! empty( $theme_button_padding ) ) {
				$css .= '.theme-button,input[type="submit"],button{padding:'. $theme_button_padding .';}';
			}

			// Theme button border radius
			if ( ! empty( $theme_button_border_radius ) && '0' != $theme_button_border_radius ) {
				$css .= '.theme-button,input[type="submit"],button{border-radius:'. $theme_button_border_radius .'px;}';
			}

			// Theme button background color
			if ( ! empty( $theme_button_bg ) && '#13aff0' != $theme_button_bg ) {
				$css .= '.theme-button,input[type="submit"],button{background-color:'. $theme_button_bg .';}';
			}

			// Theme button background color
			if ( ! empty( $theme_button_hover_bg ) && '#0b7cac' != $theme_button_hover_bg ) {
				$css .= '.theme-button:hover,input[type="submit"]:hover,button:hover{background-color:'. $theme_button_hover_bg .';}';
			}

			// Theme button background color
			if ( ! empty( $theme_button_color ) && '#ffffff' != $theme_button_color ) {
				$css .= '.theme-button,input[type="submit"],button{color:'. $theme_button_color .';}';
			}

			// Theme button background color
			if ( ! empty( $theme_button_hover_color ) && '#ffffff' != $theme_button_hover_color ) {
				$css .= '.theme-button:hover,input[type="submit"]:hover,button:hover{color:'. $theme_button_hover_color .';}';
			}
			
			# Build return CSS
			if ( ! empty( $css ) ) {
				$output .= '/* General CSS */'. $css;
			}

			# Return output CSS
			return $output;			
		}
	}

endif;

return new Kindling_Blog_Customizer();