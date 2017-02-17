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

			add_action( 'customize_register', 	array( $this, 'customizer_options' ) );

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
				'priority' 			=> 210,
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

		}

	}

endif;

return new Kindling_Blog_Customizer();