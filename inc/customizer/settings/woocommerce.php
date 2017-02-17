<?php
/**
 * WooCommerce Customizer Options
 *
 * @package Kindling Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kindling_WooCommerce_Customizer' ) ) :

	class Kindling_WooCommerce_Customizer {

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
			$panel = 'kindling_woocommerce_panel';
			$wp_customize->add_panel( $panel , array(
				'title' 			=> esc_html__( 'WooCommerce', 'kindling' ),
				'priority' 			=> 210,
			) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'kindling_woocommerce_general' , array(
				'title' 			=> esc_html__( 'General', 'kindling' ),
				'description' 		=> esc_html__( 'For some options, you must save and refresh your live site to preview changes.', 'kindling' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Custom WooCommerce Sidebar
			 */
			$wp_customize->add_setting( 'kindling_woo_custom_sidebar', array(
				'default'           	=> true,
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_woo_custom_sidebar', array(
				'label'	   				=> esc_html__( 'Custom WooCommerce Sidebar', 'kindling' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'kindling_woocommerce_general',
				'settings' 				=> 'kindling_woo_custom_sidebar',
				'priority' 				=> 10,
			) ) );

			/**
			 * Menu Cart: Display
			 */
			$wp_customize->add_setting( 'kindling_woo_menu_icon_display', array(
				'transport'           	=> 'postMessage',
				'default'           	=> 'icon_count',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_woo_menu_icon_display', array(
				'label'	   				=> esc_html__( 'Menu Cart: Display', 'kindling' ),
				'type' 					=> 'select',
				'section'  				=> 'kindling_woocommerce_general',
				'settings' 				=> 'kindling_woo_menu_icon_display',
				'priority' 				=> 10,
				'choices' 				=> array(
					'disabled' 		=> esc_html__( 'Disabled', 'kindling' ),
					'icon' 			=> esc_html__( 'Icon', 'kindling' ),
					'icon_total' 	=> esc_html__( 'Icon And Cart Total', 'kindling' ),
					'icon_count' 	=> esc_html__( 'Icon And Cart Count', 'kindling' ),
				),
			) ) );

			/**
			 * Menu Cart: Style
			 */
			$wp_customize->add_setting( 'kindling_woo_menu_icon_style', array(
				'transport'           	=> 'postMessage',
				'default'           	=> 'drop_down',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_woo_menu_icon_style', array(
				'label'	   				=> esc_html__( 'Menu Cart: Style', 'kindling' ),
				'type' 					=> 'select',
				'section'  				=> 'kindling_woocommerce_general',
				'settings' 				=> 'kindling_woo_menu_icon_style',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_menu_cart',
				'choices' 				=> array(
					'drop_down' 		=> esc_html__( 'Drop-Down', 'kindling' ),
					'cart' 				=> esc_html__( 'Go To Cart', 'kindling' ),
					'custom_link' 		=> esc_html__( 'Custom Link', 'kindling' ),
				),
			) ) );

			/**
			 * Menu Cart: Custom Link
			 */
			$wp_customize->add_setting( 'kindling_woo_menu_icon_custom_link', array(
				'transport'           	=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_woo_menu_icon_custom_link', array(
				'label'	   				=> esc_html__( 'Menu Cart: Custom Link', 'kindling' ),
				'type' 					=> 'text',
				'section'  				=> 'kindling_woocommerce_general',
				'settings' 				=> 'kindling_woo_menu_icon_custom_link',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_menu_cart',
			) ) );

			/**
			 * Heading Styling Cart Dropdowns
			 */
			$wp_customize->add_setting( 'kindling_woo_cart_dropdowns_styling_heading', array(
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Heading_Control( $wp_customize, 'kindling_woo_cart_dropdowns_styling_heading', array(
				'label'    	=> esc_html__( 'Styling: Cart Dropdowns', 'kindling' ),
				'section'  	=> 'kindling_woocommerce_general',
				'priority' 	=> 10,
			) ) );

			/**
			 * Dropdown Borders Color
			 */
			$wp_customize->add_setting( 'kindling_woo_cart_dropdown_borders', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#e9e9e9',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_woo_cart_dropdown_borders', array(
				'label'	   				=> esc_html__( 'Dropdown Borders Color', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_general',
				'settings' 				=> 'kindling_woo_cart_dropdown_borders',
				'priority' 				=> 10,
			) ) );

			/**
			 * Link Color
			 */
			$wp_customize->add_setting( 'kindling_woo_cart_dropdown_link_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#333333',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_woo_cart_dropdown_link_color', array(
				'label'	   				=> esc_html__( 'Link Color', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_general',
				'settings' 				=> 'kindling_woo_cart_dropdown_link_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Link Hover Color
			 */
			$wp_customize->add_setting( 'kindling_woo_cart_dropdown_link_color_hover', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#13aff0',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_woo_cart_dropdown_link_color_hover', array(
				'label'	   				=> esc_html__( 'Link Color: Hover', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_general',
				'settings' 				=> 'kindling_woo_cart_dropdown_link_color_hover',
				'priority' 				=> 10,
			) ) );

			/**
			 * Remove Link Color
			 */
			$wp_customize->add_setting( 'kindling_woo_cart_dropdown_remove_link_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#777777',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_woo_cart_dropdown_remove_link_color', array(
				'label'	   				=> esc_html__( 'Remove Link Color', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_general',
				'settings' 				=> 'kindling_woo_cart_dropdown_remove_link_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Remove Link Hover Color
			 */
			$wp_customize->add_setting( 'kindling_woo_cart_dropdown_remove_link_color_hover', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#333333',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_woo_cart_dropdown_remove_link_color_hover', array(
				'label'	   				=> esc_html__( 'Remove Link Color: Hover', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_general',
				'settings' 				=> 'kindling_woo_cart_dropdown_remove_link_color_hover',
				'priority' 				=> 10,
			) ) );

			/**
			 * Quantity Color
			 */
			$wp_customize->add_setting( 'kindling_woo_cart_dropdown_quantity_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#bcbcbc',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_woo_cart_dropdown_quantity_color', array(
				'label'	   				=> esc_html__( 'Quantity Color', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_general',
				'settings' 				=> 'kindling_woo_cart_dropdown_quantity_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Price Color
			 */
			$wp_customize->add_setting( 'kindling_woo_cart_dropdown_price_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#57bf6d',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_woo_cart_dropdown_price_color', array(
				'label'	   				=> esc_html__( 'Price Color', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_general',
				'settings' 				=> 'kindling_woo_cart_dropdown_price_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Subtotal Color
			 */
			$wp_customize->add_setting( 'kindling_woo_cart_dropdown_subtotal_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#444444',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_woo_cart_dropdown_subtotal_color', array(
				'label'	   				=> esc_html__( 'Subtotal Color', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_general',
				'settings' 				=> 'kindling_woo_cart_dropdown_subtotal_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Checkout Button: Background Color
			 */
			$wp_customize->add_setting( 'kindling_woo_cart_dropdown_checkout_button_bg', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#dddddd',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_woo_cart_dropdown_checkout_button_bg', array(
				'label'	   				=> esc_html__( 'Checkout Button Background', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_general',
				'settings' 				=> 'kindling_woo_cart_dropdown_checkout_button_bg',
				'priority' 				=> 10,
			) ) );

			/**
			 * Checkout Button Hover: Background Color
			 */
			$wp_customize->add_setting( 'kindling_woo_cart_dropdown_checkout_button_hover_bg', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#cccccc',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_woo_cart_dropdown_checkout_button_hover_bg', array(
				'label'	   				=> esc_html__( 'Checkout Button Background: Hover', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_general',
				'settings' 				=> 'kindling_woo_cart_dropdown_checkout_button_hover_bg',
				'priority' 				=> 10,
			) ) );

			/**
			 * Checkout Button: Color
			 */
			$wp_customize->add_setting( 'kindling_woo_cart_dropdown_checkout_button_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#333333',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_woo_cart_dropdown_checkout_button_color', array(
				'label'	   				=> esc_html__( 'Checkout Button Color', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_general',
				'settings' 				=> 'kindling_woo_cart_dropdown_checkout_button_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Checkout Button Hover: Color
			 */
			$wp_customize->add_setting( 'kindling_woo_cart_dropdown_checkout_button_hover_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#333333',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_woo_cart_dropdown_checkout_button_hover_color', array(
				'label'	   				=> esc_html__( 'Checkout Button Color: Hover', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_general',
				'settings' 				=> 'kindling_woo_cart_dropdown_checkout_button_hover_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'kindling_woocommerce_archives' , array(
				'title' 			=> esc_html__( 'Archives', 'kindling' ),
				'description' 		=> esc_html__( 'For some options, you must save and refresh your live site to preview changes.', 'kindling' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Layout
			 */
			$wp_customize->add_setting( 'kindling_woo_shop_layout', array(
				'default'           	=> 'left-sidebar',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Radio_Image_Control( $wp_customize, 'kindling_woo_shop_layout', array(
				'label'	   				=> esc_html__( 'Layout', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_archives',
				'settings' 				=> 'kindling_woo_shop_layout',
				'priority' 				=> 10,
				'choices' 				=> array(
					'right-sidebar'  	=> KINDLING_INC_DIR_URI . 'customizer/assets/img/2cr.png',
					'left-sidebar' 		=> KINDLING_INC_DIR_URI . 'customizer/assets/img/2cl.png',
					'full-width'  		=> KINDLING_INC_DIR_URI . 'customizer/assets/img/1c.png',
				),
			) ) );

			/**
			 * Shop Posts Per Page
			 */
			$wp_customize->add_setting( 'kindling_woo_shop_posts_per_page', array(
				'default'           	=> '12',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_woo_shop_posts_per_page', array(
				'label'	   				=> esc_html__( 'Shop Posts Per Page', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_archives',
				'settings' 				=> 'kindling_woo_shop_posts_per_page',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 1,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Shop Columns
			 */
			$wp_customize->add_setting( 'kindling_woocommerce_shop_columns', array(
				'default'           	=> '3',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_woocommerce_shop_columns', array(
				'label'	   				=> esc_html__( 'Shop Columns', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_archives',
				'settings' 				=> 'kindling_woocommerce_shop_columns',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 1,
			        'max'   => 7,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Grid/List Buttons
			 */
			$wp_customize->add_setting( 'kindling_woo_grid_list', array(
				'default'           	=> true,
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_woo_grid_list', array(
				'label'	   				=> esc_html__( 'Grid/List Buttons', 'kindling' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'kindling_woocommerce_archives',
				'settings' 				=> 'kindling_woo_grid_list',
				'priority' 				=> 10,
			) ) );

			/**
			 * Catalog View
			 */
			$wp_customize->add_setting( 'kindling_woo_catalog_view', array(
				'default'           	=> 'grid',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_woo_catalog_view', array(
				'label'	   				=> esc_html__( 'Default Catalog View', 'kindling' ),
				'type' 					=> 'select',
				'section'  				=> 'kindling_woocommerce_archives',
				'settings' 				=> 'kindling_woo_catalog_view',
				'priority' 				=> 10,
				'choices' 				=> array(
					'grid'  	=> esc_html__( 'Grid View', 'kindling' ),
					'list' 		=> esc_html__( 'List View', 'kindling' ),
				),
				'active_callback' 		=> 'kindling_cac_has_grid_list_buttons',
			) ) );

			/**
			 * List View Excerpt Length
			 */
			$wp_customize->add_setting( 'kindling_woo_list_excerpt_length', array(
				'default'           	=> '60',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_woo_list_excerpt_length', array(
				'label'	   				=> esc_html__( 'Excerpt Length', 'kindling' ),
				'description'	   		=> esc_html__( 'Length of the short description of the list view, leave empty for full content', 'kindling' ),
				'type' 					=> 'text',
				'section'  				=> 'kindling_woocommerce_archives',
				'settings' 				=> 'kindling_woo_list_excerpt_length',
				'priority' 				=> 10,
				'active_callback' 		=> 'kindling_cac_has_grid_list_buttons',
			) ) );

			/**
			 * Shop Sort
			 */
			$wp_customize->add_setting( 'kindling_woo_shop_sort', array(
				'default'           	=> true,
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_woo_shop_sort', array(
				'label'	   				=> esc_html__( 'Shop Sort', 'kindling' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'kindling_woocommerce_archives',
				'settings' 				=> 'kindling_woo_shop_sort',
				'priority' 				=> 10,
			) ) );

			/**
			 * Shop Result Count
			 */
			$wp_customize->add_setting( 'kindling_woo_shop_result_count', array(
				'default'           	=> true,
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_woo_shop_result_count', array(
				'label'	   				=> esc_html__( 'Shop Result Count', 'kindling' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'kindling_woocommerce_archives',
				'settings' 				=> 'kindling_woo_shop_result_count',
				'priority' 				=> 10,
			) ) );

			/**
			 * Product Entry Media
			 */
			$wp_customize->add_setting( 'kindling_woo_product_entry_style', array(
				'default'           	=> 'image-swap',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_woo_product_entry_style', array(
				'label'	   				=> esc_html__( 'Product Entry Media', 'kindling' ),
				'type' 					=> 'select',
				'section'  				=> 'kindling_woocommerce_archives',
				'settings' 				=> 'kindling_woo_product_entry_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'featured-image'  	=> esc_html__( 'Featured Image', 'kindling' ),
					'image-swap' 		=> esc_html__( 'Image Swap', 'kindling' ),
					'gallery-slider'  	=> esc_html__( 'Gallery Slider', 'kindling' ),
				),
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'kindling_woocommerce_single' , array(
				'title' 			=> esc_html__( 'Single', 'kindling' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Layout
			 */
			$wp_customize->add_setting( 'kindling_woo_product_layout', array(
				'default'           	=> 'left-sidebar',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Radio_Image_Control( $wp_customize, 'kindling_woo_product_layout', array(
				'label'	   				=> esc_html__( 'Layout', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_single',
				'settings' 				=> 'kindling_woo_product_layout',
				'priority' 				=> 10,
				'choices' 				=> array(
					'right-sidebar'  	=> KINDLING_INC_DIR_URI . 'customizer/assets/img/2cr.png',
					'left-sidebar' 		=> KINDLING_INC_DIR_URI . 'customizer/assets/img/2cl.png',
					'full-width'  		=> KINDLING_INC_DIR_URI . 'customizer/assets/img/1c.png',
				),
			) ) );

			/**
			 * Up-Sells Count
			 */
			$wp_customize->add_setting( 'kindling_woocommerce_upsells_count', array(
				'default'           	=> '3',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_woocommerce_upsells_count', array(
				'label'	   				=> esc_html__( 'Up-Sells Count', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_single',
				'settings' 				=> 'kindling_woocommerce_upsells_count',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 1,
			        'max'   => 10,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Up-Sells Columns
			 */
			$wp_customize->add_setting( 'kindling_woocommerce_upsells_columns', array(
				'default'           	=> '3',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_woocommerce_upsells_columns', array(
				'label'	   				=> esc_html__( 'Up-Sells Columns', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_single',
				'settings' 				=> 'kindling_woocommerce_upsells_columns',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 1,
			        'max'   => 7,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Related Items Count
			 */
			$wp_customize->add_setting( 'kindling_woocommerce_related_count', array(
				'default'           	=> '3',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_woocommerce_related_count', array(
				'label'	   				=> esc_html__( 'Related Items Count', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_single',
				'settings' 				=> 'kindling_woocommerce_related_count',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 1,
			        'max'   => 10,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Related Products Columns
			 */
			$wp_customize->add_setting( 'kindling_woocommerce_related_columns', array(
				'default'           	=> '3',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_woocommerce_related_columns', array(
				'label'	   				=> esc_html__( 'Related Products Columns', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_single',
				'settings' 				=> 'kindling_woocommerce_related_columns',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 1,
			        'max'   => 7,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Product Meta
			 */
			$wp_customize->add_setting( 'kindling_woo_product_meta', array(
				'default'           	=> true,
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindling_woo_product_meta', array(
				'label'	   				=> esc_html__( 'Product Meta', 'kindling' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'kindling_woocommerce_single',
				'settings' 				=> 'kindling_woo_product_meta',
				'priority' 				=> 10,
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'kindling_woocommerce_cart' , array(
				'title' 			=> esc_html__( 'Cart', 'kindling' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Cross-Sells Count
			 */
			$wp_customize->add_setting( 'kindling_woocommerce_cross_sells_count', array(
				'default'           	=> '2',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_woocommerce_cross_sells_count', array(
				'label'	   				=> esc_html__( 'Cross-Sells Count', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_cart',
				'settings' 				=> 'kindling_woocommerce_cross_sells_count',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 1,
			        'max'   => 10,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Cross-Sells Columns
			 */
			$wp_customize->add_setting( 'kindling_woocommerce_cross_sells_columns', array(
				'default'           	=> '2',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Range_Control( $wp_customize, 'kindling_woocommerce_cross_sells_columns', array(
				'label'	   				=> esc_html__( 'Cross-Sells Columns', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_cart',
				'settings' 				=> 'kindling_woocommerce_cross_sells_columns',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 1,
			        'max'   => 7,
			        'step'  => 1,
			    ),
			) ) );			/**
			 * Section
			 */
			$wp_customize->add_section( 'kindling_woocommerce_styling' , array(
				'title' 				=> esc_html__( 'Advanced Styling', 'kindling' ),
				'priority' 				=> 10,
				'panel' 				=> $panel,
			) );

			/**
		     * On Sale Background
		     */
	        $wp_customize->add_setting( 'kindling_onsale_bg', array(
				'default'				=> '#3fc387',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_onsale_bg', array(
				'label'					=> esc_html__( 'On Sale Background', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_onsale_bg',
				'priority'				=> 10,
			) ) );

			/**
		     * On Sale Color
		     */
	        $wp_customize->add_setting( 'kindling_onsale_color', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_onsale_color', array(
				'label'					=> esc_html__( 'On Sale Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_onsale_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Out of Stock Background
		     */
	        $wp_customize->add_setting( 'kindling_outofstock_bg', array(
				'default'				=> '#000000',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_outofstock_bg', array(
				'label'					=> esc_html__( 'Out of Stock Background', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_outofstock_bg',
				'priority'				=> 10,
			) ) );

			/**
		     * Out of Stock Color
		     */
	        $wp_customize->add_setting( 'kindling_outofstock_color', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_outofstock_color', array(
				'label'					=> esc_html__( 'Out of Stock Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_outofstock_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Stars Color Before
		     */
	        $wp_customize->add_setting( 'kindling_stars_color_before', array(
				'default'				=> '#dfdbdf',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_stars_color_before', array(
				'label'					=> esc_html__( 'Stars Color Before', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_stars_color_before',
				'priority'				=> 10,
			) ) );

			/**
		     * Stars Color
		     */
	        $wp_customize->add_setting( 'kindling_stars_color', array(
				'default'				=> '#f9ca63',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_stars_color', array(
				'label'					=> esc_html__( 'Stars Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_stars_color',
				'priority'				=> 10,
			) ) );

			/**
			 * Heading Product Entry Toolbar
			 */
			$wp_customize->add_setting( 'kindling_product_entry_toolbar_heading', array(
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Heading_Control( $wp_customize, 'kindling_product_entry_toolbar_heading', array(
				'label'    				=> esc_html__( 'Product Entry: Toolbar', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_styling',
				'priority' 				=> 10,
			) ) );

			/**
		     * Tootlbar Border Color
		     */
	        $wp_customize->add_setting( 'kindling_toolbar_border_color', array(
				'default'				=> '#eaeaea',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_toolbar_border_color', array(
				'label'					=> esc_html__( 'Border Top/Bottom Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_toolbar_border_color',
				'priority'				=> 10
			) ) );

			/**
		     * Grid/List Color
		     */
	        $wp_customize->add_setting( 'kindling_toolbar_grid_list_color', array(
				'default'				=> '#999999',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_toolbar_grid_list_color', array(
				'label'					=> esc_html__( 'Grid/List Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_toolbar_grid_list_color',
				'priority'				=> 10
			) ) );

			/**
		     * Grid/List Border Color
		     */
	        $wp_customize->add_setting( 'kindling_toolbar_grid_list_border_color', array(
				'default'				=> '#eaeaea',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_toolbar_grid_list_border_color', array(
				'label'					=> esc_html__( 'Grid/List Border Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_toolbar_grid_list_border_color',
				'priority'				=> 10
			) ) );

			/**
		     * Grid/List Hover Color
		     */
	        $wp_customize->add_setting( 'kindling_toolbar_grid_list_hover_color', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_toolbar_grid_list_hover_color', array(
				'label'					=> esc_html__( 'Grid/List Hover Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_toolbar_grid_list_hover_color',
				'priority'				=> 10
			) ) );

			/**
		     * Grid/List Active Color
		     */
	        $wp_customize->add_setting( 'kindling_toolbar_grid_list_active_color', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_toolbar_grid_list_active_color', array(
				'label'					=> esc_html__( 'Grid/List Active Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_toolbar_grid_list_active_color',
				'priority'				=> 10
			) ) );

			/**
		     * Select Color
		     */
	        $wp_customize->add_setting( 'kindling_toolbar_select_color', array(
				'default'				=> '#999999',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_toolbar_select_color', array(
				'label'					=> esc_html__( 'Select Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_toolbar_select_color',
				'priority'				=> 10
			) ) );

			/**
		     * Select Border Color
		     */
	        $wp_customize->add_setting( 'kindling_toolbar_select_border_color', array(
				'default'				=> '#dddddd',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_toolbar_select_border_color', array(
				'label'					=> esc_html__( 'Select Border Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_toolbar_select_border_color',
				'priority'				=> 10
			) ) );

			/**
		     * Number of Products Color
		     */
	        $wp_customize->add_setting( 'kindling_toolbar_number_of_products_color', array(
				'default'				=> '#555555',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_toolbar_number_of_products_color', array(
				'label'					=> esc_html__( 'Number of Products Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_toolbar_number_of_products_color',
				'priority'				=> 10
			) ) );

			/**
		     * Number of Products Inactive Color
		     */
	        $wp_customize->add_setting( 'kindling_toolbar_number_of_products_inactive_color', array(
				'default'				=> '#999999',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_toolbar_number_of_products_inactive_color', array(
				'label'					=> esc_html__( 'Number of Products Inactive Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_toolbar_number_of_products_inactive_color',
				'priority'				=> 10
			) ) );

			/**
		     * Number of Products Border Color
		     */
	        $wp_customize->add_setting( 'kindling_toolbar_number_of_products_border_color', array(
				'default'				=> '#999999',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_toolbar_number_of_products_border_color', array(
				'label'					=> esc_html__( 'Number of Products Border Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_toolbar_number_of_products_border_color',
				'priority'				=> 10
			) ) );

			/**
			 * Heading Product Entry
			 */
			$wp_customize->add_setting( 'kindling_product_entry_heading', array(
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Heading_Control( $wp_customize, 'kindling_product_entry_heading', array(
				'label'    				=> esc_html__( 'Product Entry', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_styling',
				'priority' 				=> 10,
			) ) );

			/**
		     * Category Color
		     */
	        $wp_customize->add_setting( 'kindling_category_color', array(
				'default'				=> '#999999',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_category_color', array(
				'label'					=> esc_html__( 'Category Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_category_color',
				'priority'				=> 10
			) ) );

			/**
		     * Category Color Hover
		     */
	        $wp_customize->add_setting( 'kindling_category_color_hover', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_category_color_hover', array(
				'label'					=> esc_html__( 'Category Color: Hover', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_category_color_hover',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Title Color
		     */
	        $wp_customize->add_setting( 'kindling_product_title_color', array(
				'default'				=> '#333333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_product_title_color', array(
				'label'					=> esc_html__( 'Title Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_product_title_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Title Color Hover
		     */
	        $wp_customize->add_setting( 'kindling_product_title_color_hover', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_product_title_color_hover', array(
				'label'					=> esc_html__( 'Title Color: Hover', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_product_title_color_hover',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Price Color
		     */
	        $wp_customize->add_setting( 'kindling_product_entry_price_color', array(
				'default'				=> '#57bf6d',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_product_entry_price_color', array(
				'label'					=> esc_html__( 'Price Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_product_entry_price_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Del Price Color
		     */
	        $wp_customize->add_setting( 'kindling_product_entry_del_price_color', array(
				'default'				=> '#666666',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_product_entry_del_price_color', array(
				'label'					=> esc_html__( 'Del Price Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_product_entry_del_price_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Add To Cart Color
		     */
	        $wp_customize->add_setting( 'kindling_product_entry_addtocart_color', array(
				'default'				=> '#848494',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_product_entry_addtocart_color', array(
				'label'					=> esc_html__( 'Add To Cart Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_product_entry_addtocart_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Add To Cart Color Hover
		     */
	        $wp_customize->add_setting( 'kindling_product_entry_addtocart_color_hover', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_product_entry_addtocart_color_hover', array(
				'label'					=> esc_html__( 'Add To Cart Color: Hover', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_product_entry_addtocart_color_hover',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Add To Cart Border Color
		     */
	        $wp_customize->add_setting( 'kindling_product_entry_addtocart_border_color', array(
				'default'				=> '#e4e4e4',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_product_entry_addtocart_border_color', array(
				'label'					=> esc_html__( 'Add To Cart Border Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_product_entry_addtocart_border_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Add To Cart Border Color Hover
		     */
	        $wp_customize->add_setting( 'kindling_product_entry_addtocart_border_color_hover', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_product_entry_addtocart_border_color_hover', array(
				'label'					=> esc_html__( 'Add To Cart Border Color: Hover', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_product_entry_addtocart_border_color_hover',
				'priority'				=> 10,
			) ) );

			/**
			 * Heading Single Product
			 */
			$wp_customize->add_setting( 'kindling_single_product_heading', array(
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Heading_Control( $wp_customize, 'kindling_single_product_heading', array(
				'label'    				=> esc_html__( 'Single Product', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_styling',
				'priority' 				=> 10,
			) ) );

			/**
		     * Single Product Title Color
		     */
	        $wp_customize->add_setting( 'kindling_single_product_title_color', array(
				'default'				=> '#333333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_single_product_title_color', array(
				'label'					=> esc_html__( 'Title Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_single_product_title_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Price Color
		     */
	        $wp_customize->add_setting( 'kindling_single_product_price_color', array(
				'default'				=> '#57bf6d',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_single_product_price_color', array(
				'label'					=> esc_html__( 'Price Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_single_product_price_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Del Price Color
		     */
	        $wp_customize->add_setting( 'kindling_single_product_del_price_color', array(
				'default'				=> '#555555',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_single_product_del_price_color', array(
				'label'					=> esc_html__( 'Del Price Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_single_product_del_price_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Description Color
		     */
	        $wp_customize->add_setting( 'kindling_single_product_description_color', array(
				'default'				=> '#aaaaaa',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_single_product_description_color', array(
				'label'					=> esc_html__( 'Description Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_single_product_description_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Quantity Border Color
		     */
	        $wp_customize->add_setting( 'kindling_quantity_border_color', array(
				'default'				=> '#e4e4e4',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_quantity_border_color', array(
				'label'					=> esc_html__( 'Quantity Border Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_quantity_border_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Quantity Border Color Focus
		     */
	        $wp_customize->add_setting( 'kindling_quantity_border_color_focus', array(
				'default'				=> '#bbbbbb',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_quantity_border_color_focus', array(
				'label'					=> esc_html__( 'Quantity Border Color Focus', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_quantity_border_color_focus',
				'priority'				=> 10,
			) ) );

			/**
		     * Quantity Color
		     */
	        $wp_customize->add_setting( 'kindling_quantity_color', array(
				'default'				=> '#777777',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_quantity_color', array(
				'label'					=> esc_html__( 'Quantity Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_quantity_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Quantity Plus/Minus Color
		     */
	        $wp_customize->add_setting( 'kindling_quantity_plus_minus_color', array(
				'default'				=> '#cccccc',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_quantity_plus_minus_color', array(
				'label'					=> esc_html__( 'Quantity Plus/Minus Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_quantity_plus_minus_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Quantity Plus/Minus Color Hover
		     */
	        $wp_customize->add_setting( 'kindling_quantity_plus_minus_color_hover', array(
				'default'				=> '#cccccc',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_quantity_plus_minus_color_hover', array(
				'label'					=> esc_html__( 'Quantity Plus/Minus Color: Hover', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_quantity_plus_minus_color_hover',
				'priority'				=> 10,
			) ) );

			/**
		     * Quantity Plus/Minus Border Color Hover
		     */
	        $wp_customize->add_setting( 'kindling_quantity_plus_minus_border_color_hover', array(
				'default'				=> '#e0e0e0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_quantity_plus_minus_border_color_hover', array(
				'label'					=> esc_html__( 'Quantity Plus/Minus Border Color: Hover', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_quantity_plus_minus_border_color_hover',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Meta Title Color
		     */
	        $wp_customize->add_setting( 'kindling_single_product_meta_title_color', array(
				'default'				=> '#333333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_single_product_meta_title_color', array(
				'label'					=> esc_html__( 'Meta Title Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_single_product_meta_title_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Meta Link Color
		     */
	        $wp_customize->add_setting( 'kindling_single_product_meta_link_color', array(
				'default'				=> '#aaaaaa',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_single_product_meta_link_color', array(
				'label'					=> esc_html__( 'Meta Link Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_single_product_meta_link_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Meta Link Color Hover
		     */
	        $wp_customize->add_setting( 'kindling_single_product_meta_link_color_hover', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_single_product_meta_link_color_hover', array(
				'label'					=> esc_html__( 'Meta Link Color: Hover', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_single_product_meta_link_color_hover',
				'priority'				=> 10,
			) ) );

			/**
			 * Heading Single Product Thumbnails
			 */
			$wp_customize->add_setting( 'kindling_single_product_thumbnails_heading', array(
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Heading_Control( $wp_customize, 'kindling_single_product_thumbnails_heading', array(
				'label'    				=> esc_html__( 'Single Product: Thumbnails', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_styling',
				'priority' 				=> 10,
			) ) );

			/**
		     * Single Product Thumbnails Next/Prev Hover Background
		     */
	        $wp_customize->add_setting( 'kindling_single_product_thumbnails_next_prev_hover_bg', array(
				'default'				=> '#f3f3f3',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_single_product_thumbnails_next_prev_hover_bg', array(
				'label'					=> esc_html__( 'Next/Prev Background: Hover', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_single_product_thumbnails_next_prev_hover_bg',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Thumbnails Next/Prev Color
		     */
	        $wp_customize->add_setting( 'kindling_single_product_thumbnails_next_prev_color', array(
				'default'				=> '#929292',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_single_product_thumbnails_next_prev_color', array(
				'label'					=> esc_html__( 'Next/Prev Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_single_product_thumbnails_next_prev_color',
				'priority'				=> 10,
			) ) );

			/**
			 * Heading Product Tabs
			 */
			$wp_customize->add_setting( 'kindling_single_product_tabs_heading', array(
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Heading_Control( $wp_customize, 'kindling_single_product_tabs_heading', array(
				'label'    				=> esc_html__( 'Single Product: Tabs', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_styling',
				'priority' 				=> 10,
			) ) );

			/**
		     * Single Product Tabs Borders Color
		     */
	        $wp_customize->add_setting( 'kindling_single_product_tabs_borders_color', array(
				'default'				=> '#e9e9e9',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_single_product_tabs_borders_color', array(
				'label'					=> esc_html__( 'Borders Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_single_product_tabs_borders_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Tabs Text Color
		     */
	        $wp_customize->add_setting( 'kindling_single_product_tabs_text_color', array(
				'default'				=> '#999999',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_single_product_tabs_text_color', array(
				'label'					=> esc_html__( 'Text Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_single_product_tabs_text_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Tabs Text Color Hover
		     */
	        $wp_customize->add_setting( 'kindling_single_product_tabs_text_color_hover', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_single_product_tabs_text_color_hover', array(
				'label'					=> esc_html__( 'Text Color: Hover', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_single_product_tabs_text_color_hover',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Tabs Active Text Color
		     */
	        $wp_customize->add_setting( 'kindling_single_product_tabs_active_text_color', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_single_product_tabs_active_text_color', array(
				'label'					=> esc_html__( 'Active Text Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_single_product_tabs_active_text_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Tabs Active Text Borders Color
		     */
	        $wp_customize->add_setting( 'kindling_single_product_tabs_active_text_borders_color', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_single_product_tabs_active_text_borders_color', array(
				'label'					=> esc_html__( 'Active Text Borders Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_single_product_tabs_active_text_borders_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Tabs Product Description Color
		     */
	        $wp_customize->add_setting( 'kindling_single_product_tabs_product_description_title_color', array(
				'default'				=> '#333333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_single_product_tabs_product_description_title_color', array(
				'label'					=> esc_html__( 'Product Description: Title Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_single_product_tabs_product_description_title_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Tabs Product Description Color
		     */
	        $wp_customize->add_setting( 'kindling_single_product_tabs_product_description_color', array(
				'default'				=> '#929292',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_single_product_tabs_product_description_color', array(
				'label'					=> esc_html__( 'Product Description: Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_single_product_tabs_product_description_color',
				'priority'				=> 10,
			) ) );

			/**
			 * Heading Account
			 */
			$wp_customize->add_setting( 'kindling_account_heading', array(
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Heading_Control( $wp_customize, 'kindling_account_heading', array(
				'label'    				=> esc_html__( 'Account', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_styling',
				'priority' 				=> 10,
			) ) );

			/**
		     * Navigation Borders Color
		     */
	        $wp_customize->add_setting( 'kindling_account_navigation_borders_color', array(
				'default'				=> '#e9e9e9',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_account_navigation_borders_color', array(
				'label'					=> esc_html__( 'Navigation: Borders Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_account_navigation_borders_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Navigation Icons Color
		     */
	        $wp_customize->add_setting( 'kindling_account_navigation_icons_color', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_account_navigation_icons_color', array(
				'label'					=> esc_html__( 'Navigation: Icons Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_account_navigation_icons_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Navigation Links Color
		     */
	        $wp_customize->add_setting( 'kindling_account_navigation_links_color', array(
				'default'				=> '#333333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_account_navigation_links_color', array(
				'label'					=> esc_html__( 'Navigation: Links Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_account_navigation_links_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Navigation Links Color Hover
		     */
	        $wp_customize->add_setting( 'kindling_account_navigation_links_color_hover', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_account_navigation_links_color_hover', array(
				'label'					=> esc_html__( 'Navigation: Links Color: Hover', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_account_navigation_links_color_hover',
				'priority'				=> 10,
			) ) );

			/**
		     * Addresses Box Background
		     */
	        $wp_customize->add_setting( 'kindling_account_addresses_bg', array(
				'default'				=> '#f6f6f6',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_account_addresses_bg', array(
				'label'					=> esc_html__( 'Addresses: Box Background', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_account_addresses_bg',
				'priority'				=> 10,
			) ) );

			/**
		     * Addresses Box Title Color
		     */
	        $wp_customize->add_setting( 'kindling_account_addresses_title_color', array(
				'default'				=> '#333333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_account_addresses_title_color', array(
				'label'					=> esc_html__( 'Addresses: Box Title Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_account_addresses_title_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Addresses Box Title Border Bottom Color
		     */
	        $wp_customize->add_setting( 'kindling_account_addresses_title_border_color', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_account_addresses_title_border_color', array(
				'label'					=> esc_html__( 'Addresses: Box Title Border Bottom Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_account_addresses_title_border_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Addresses Box Content Color
		     */
	        $wp_customize->add_setting( 'kindling_account_addresses_content_color', array(
				'default'				=> '#898989',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_account_addresses_content_color', array(
				'label'					=> esc_html__( 'Addresses: Box Content Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_account_addresses_content_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Addresses Box Button Background Color
		     */
	        $wp_customize->add_setting( 'kindling_account_addresses_button_bg', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_account_addresses_button_bg', array(
				'label'					=> esc_html__( 'Addresses: Box Button Background', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_account_addresses_button_bg',
				'priority'				=> 10,
			) ) );

			/**
		     * Addresses Box Button Background Color Hover
		     */
	        $wp_customize->add_setting( 'kindling_account_addresses_button_bg_hover', array(
				'default'				=> '#f8f8f8',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_account_addresses_button_bg_hover', array(
				'label'					=> esc_html__( 'Addresses: Box Button Background: Hover', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_account_addresses_button_bg_hover',
				'priority'				=> 10,
			) ) );

			/**
		     * Addresses Box Button Color
		     */
	        $wp_customize->add_setting( 'kindling_account_addresses_button_color', array(
				'default'				=> '#898989',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_account_addresses_button_color', array(
				'label'					=> esc_html__( 'Addresses: Box Button color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_account_addresses_button_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Addresses Box Button Color Hover
		     */
	        $wp_customize->add_setting( 'kindling_account_addresses_button_color_hover', array(
				'default'				=> '#555555',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_account_addresses_button_color_hover', array(
				'label'					=> esc_html__( 'Addresses: Box Button color: Hover', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_account_addresses_button_color_hover',
				'priority'				=> 10,
			) ) );

			/**
			 * Heading Cart
			 */
			$wp_customize->add_setting( 'kindling_cart_heading', array(
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Heading_Control( $wp_customize, 'kindling_cart_heading', array(
				'label'    				=> esc_html__( 'Cart', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_styling',
				'priority' 				=> 10,
			) ) );

			/**
		     * Borders Color
		     */
	        $wp_customize->add_setting( 'kindling_cart_borders_color', array(
				'default'				=> '#e9e9e9',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_cart_borders_color', array(
				'label'					=> esc_html__( 'Borders Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_cart_borders_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Head Background
		     */
	        $wp_customize->add_setting( 'kindling_cart_head_bg', array(
				'default'				=> '#f7f7f7',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_cart_head_bg', array(
				'label'					=> esc_html__( 'Head Background', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_cart_head_bg',
				'priority'				=> 10,
			) ) );

			/**
		     * Head Titles Color
		     */
	        $wp_customize->add_setting( 'kindling_cart_head_titles_color', array(
				'default'				=> '#444444',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_cart_head_titles_color', array(
				'label'					=> esc_html__( 'Head Titles Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_cart_head_titles_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Cart Totals Table Titles Color
		     */
	        $wp_customize->add_setting( 'kindling_cart_totals_table_titles_color', array(
				'default'				=> '#444444',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_cart_totals_table_titles_color', array(
				'label'					=> esc_html__( 'Cart Totals Table: Titles Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_cart_totals_table_titles_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Remove Button Color
		     */
	        $wp_customize->add_setting( 'kindling_cart_remove_button_color', array(
				'default'				=> '#bbbbbb',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_cart_remove_button_color', array(
				'label'					=> esc_html__( 'Remove Button Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_cart_remove_button_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Remove Button Color Hover
		     */
	        $wp_customize->add_setting( 'kindling_cart_remove_button_color_hover', array(
				'default'				=> '#333333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_cart_remove_button_color_hover', array(
				'label'					=> esc_html__( 'Remove Button Color: Hover', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_cart_remove_button_color_hover',
				'priority'				=> 10,
			) ) );

			/**
			 * Heading Checkout
			 */
			$wp_customize->add_setting( 'kindling_checkout_heading', array(
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Heading_Control( $wp_customize, 'kindling_checkout_heading', array(
				'label'    				=> esc_html__( 'Checkout', 'kindling' ),
				'section'  				=> 'kindling_woocommerce_styling',
				'priority' 				=> 10,
			) ) );

			/**
		     * Notices Borders Color
		     */
	        $wp_customize->add_setting( 'kindling_checkout_notices_borders_color', array(
				'default'				=> '#e9e9e9',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_checkout_notices_borders_color', array(
				'label'					=> esc_html__( 'Notices: Borders Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_checkout_notices_borders_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Notices Icon Color
		     */
	        $wp_customize->add_setting( 'kindling_checkout_notices_icon_color', array(
				'default'				=> '#dddddd',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_checkout_notices_icon_color', array(
				'label'					=> esc_html__( 'Notices: Icon Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_checkout_notices_icon_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Notices Color
		     */
	        $wp_customize->add_setting( 'kindling_checkout_notices_color', array(
				'default'				=> '#777777',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_checkout_notices_color', array(
				'label'					=> esc_html__( 'Notices: Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_checkout_notices_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Notices Link Color
		     */
	        $wp_customize->add_setting( 'kindling_checkout_notices_link_color', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_checkout_notices_link_color', array(
				'label'					=> esc_html__( 'Notices: Link Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_checkout_notices_link_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Notices Link Color Hover
		     */
	        $wp_customize->add_setting( 'kindling_checkout_notices_link_color_hover', array(
				'default'				=> '#333333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_checkout_notices_link_color_hover', array(
				'label'					=> esc_html__( 'Notices: Link Color: Hover', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_checkout_notices_link_color_hover',
				'priority'				=> 10,
			) ) );

			/**
		     * Notices Form Border Color
		     */
	        $wp_customize->add_setting( 'kindling_checkout_notices_form_border_color', array(
				'default'				=> '#e9e9e9',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_checkout_notices_form_border_color', array(
				'label'					=> esc_html__( 'Notices Form: Border Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_checkout_notices_form_border_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Titles Color
		     */
	        $wp_customize->add_setting( 'kindling_checkout_titles_color', array(
				'default'				=> '#333333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_checkout_titles_color', array(
				'label'					=> esc_html__( 'Titles Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_checkout_titles_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Titles Border Bottom Color
		     */
	        $wp_customize->add_setting( 'kindling_checkout_titles_border_bottom_color', array(
				'default'				=> '#e9e9e9',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_checkout_titles_border_bottom_color', array(
				'label'					=> esc_html__( 'Titles Border Bottom Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_checkout_titles_border_bottom_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Table Main Background
		     */
	        $wp_customize->add_setting( 'kindling_checkout_table_main_bg', array(
				'default'				=> '#f7f7f7',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_checkout_table_main_bg', array(
				'label'					=> esc_html__( 'Table Main Background', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_checkout_table_main_bg',
				'priority'				=> 10,
			) ) );

			/**
		     * Table Titles Color
		     */
	        $wp_customize->add_setting( 'kindling_checkout_table_titles_color', array(
				'default'				=> '#444444',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_checkout_table_titles_color', array(
				'label'					=> esc_html__( 'Table Titles Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_checkout_table_titles_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Table Borders Color
		     */
	        $wp_customize->add_setting( 'kindling_checkout_table_borders_color', array(
				'default'				=> '#e9e9e9',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_checkout_table_borders_color', array(
				'label'					=> esc_html__( 'Table Borders Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_checkout_table_borders_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Payment Methods Background
		     */
	        $wp_customize->add_setting( 'kindling_checkout_payment_methods_bg', array(
				'default'				=> '#f8f8f8',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_checkout_payment_methods_bg', array(
				'label'					=> esc_html__( 'Payment Methods Background', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_checkout_payment_methods_bg',
				'priority'				=> 10,
			) ) );

			/**
		     * Payment Methods Borders Color
		     */
	        $wp_customize->add_setting( 'kindling_checkout_payment_methods_borders_color', array(
				'default'				=> '#e9e9e9',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_checkout_payment_methods_borders_color', array(
				'label'					=> esc_html__( 'Payment Methods Borders Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_checkout_payment_methods_borders_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Payment Box Background
		     */
	        $wp_customize->add_setting( 'kindling_checkout_payment_box_bg', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_checkout_payment_box_bg', array(
				'label'					=> esc_html__( 'Payment Box Background', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_checkout_payment_box_bg',
				'priority'				=> 10,
			) ) );

			/**
		     * Payment Box Color
		     */
	        $wp_customize->add_setting( 'kindling_checkout_payment_box_color', array(
				'default'				=> '#515151',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> false,
			) );

			$wp_customize->add_control( new Kindling_Customizer_Color_Control( $wp_customize, 'kindling_checkout_payment_box_color', array(
				'label'					=> esc_html__( 'Payment Box Color', 'kindling' ),
				'section'				=> 'kindling_woocommerce_styling',
				'settings'				=> 'kindling_checkout_payment_box_color',
				'priority'				=> 10,
			) ) );

		}

		/**
		 * Get CSS
		 *
		 * @since 1.0.0
		 */
		public static function head_css( $output ) {
		
			// Global vars
			$cart_dropdown_borders 						= get_theme_mod( 'kindling_woo_cart_dropdown_borders', '#e9e9e9' );
			$cart_dropdown_link_color 					= get_theme_mod( 'kindling_woo_cart_dropdown_link_color', '#333333' );
			$cart_dropdown_link_color_hover 			= get_theme_mod( 'kindling_woo_cart_dropdown_link_color_hover', '#13aff0' );
			$cart_dropdown_remove_link_color			= get_theme_mod( 'kindling_woo_cart_dropdown_remove_link_color', '#777777' );
			$cart_dropdown_remove_link_color_hover		= get_theme_mod( 'kindling_woo_cart_dropdown_remove_link_color_hover', '#333333' );
			$cart_dropdown_quantity_color				= get_theme_mod( 'kindling_woo_cart_dropdown_quantity_color', '#bcbcbc' );
			$cart_dropdown_price_color					= get_theme_mod( 'kindling_woo_cart_dropdown_price_color', '#57bf6d' );
			$cart_dropdown_subtotal_color				= get_theme_mod( 'kindling_woo_cart_dropdown_subtotal_color', '#444444' );
			$cart_dropdown_checkout_button_bg			= get_theme_mod( 'kindling_woo_cart_dropdown_checkout_button_bg', '#dddddd' );
			$cart_dropdown_checkout_button_hover_bg		= get_theme_mod( 'kindling_woo_cart_dropdown_checkout_button_hover_bg', '#cccccc' );
			$cart_dropdown_checkout_button_color		= get_theme_mod( 'kindling_woo_cart_dropdown_checkout_button_color', '#333333' );
			$cart_dropdown_checkout_button_hover_color	= get_theme_mod( 'kindling_woo_cart_dropdown_checkout_button_hover_color', '#333333' );
		
			// Styling vars
			$onsale_bg 											= get_theme_mod( 'kindling_onsale_bg', '#3FC387' );
			$onsale_color 										= get_theme_mod( 'kindling_onsale_color', '#ffffff' );
			$outofstock_bg 										= get_theme_mod( 'kindling_outofstock_bg', '#000000' );
			$outofstock_color 									= get_theme_mod( 'kindling_outofstock_color', '#ffffff' );
			$stars_color_before 								= get_theme_mod( 'kindling_stars_color_before', '#dfdbdf' );
			$stars_color 										= get_theme_mod( 'kindling_stars_color', '#f9ca63' );
			$quantity_border_color 								= get_theme_mod( 'kindling_quantity_border_color', '#e4e4e4' );
			$quantity_border_color_focus 						= get_theme_mod( 'kindling_quantity_border_color_focus', '#bbbbbb' );
			$quantity_color 									= get_theme_mod( 'kindling_quantity_color', '#777777' );
			$quantity_plus_minus_color 							= get_theme_mod( 'kindling_quantity_plus_minus_color', '#cccccc' );
			$quantity_plus_minus_color_hover 					= get_theme_mod( 'kindling_quantity_plus_minus_color_hover', '#cccccc' );
			$quantity_plus_minus_border_color_hover 			= get_theme_mod( 'kindling_quantity_plus_minus_border_color_hover', '#e0e0e0' );
			$toolbar_border_color 								= get_theme_mod( 'kindling_toolbar_border_color', '#eaeaea' );
			$toolbar_grid_list_color 							= get_theme_mod( 'kindling_toolbar_grid_list_color', '#999999' );
			$toolbar_grid_list_border_color 					= get_theme_mod( 'kindling_toolbar_grid_list_border_color', '#eaeaea' );
			$toolbar_grid_list_hover_color 						= get_theme_mod( 'kindling_toolbar_grid_list_hover_color', '#13aff0' );
			$toolbar_grid_list_active_color 					= get_theme_mod( 'kindling_toolbar_grid_list_active_color', '#13aff0' );
			$toolbar_select_color 								= get_theme_mod( 'kindling_toolbar_select_color', '#999999' );
			$toolbar_select_border_color 						= get_theme_mod( 'kindling_toolbar_select_border_color', '#dddddd' );
			$toolbar_number_of_products_color 					= get_theme_mod( 'kindling_toolbar_number_of_products_color', '#555555' );
			$toolbar_number_of_products_inactive_color 			= get_theme_mod( 'kindling_toolbar_number_of_products_inactive_color', '#999999' );
			$toolbar_number_of_products_border_color 			= get_theme_mod( 'kindling_toolbar_number_of_products_border_color', '#999999' );
			$category_color 									= get_theme_mod( 'kindling_category_color', '#999999' );
			$category_color_hover 								= get_theme_mod( 'kindling_category_color_hover', '#13aff0' );
			$product_title_color 								= get_theme_mod( 'kindling_product_title_color', '#333333' );
			$product_title_color_hover 							= get_theme_mod( 'kindling_product_title_color_hover', '#13aff0' );
			$product_entry_price_color 							= get_theme_mod( 'kindling_product_entry_price_color', '#57bf6d' );
			$product_entry_del_price_color 						= get_theme_mod( 'kindling_product_entry_del_price_color', '#666666' );
			$product_entry_addtocart_color 						= get_theme_mod( 'kindling_product_entry_addtocart_color', '#848494' );
			$product_entry_addtocart_color_hover 				= get_theme_mod( 'kindling_product_entry_addtocart_color_hover', '#13aff0' );
			$product_entry_addtocart_border_color 				= get_theme_mod( 'kindling_product_entry_addtocart_border_color', '#e4e4e4' );
			$product_entry_addtocart_border_color_hover 		= get_theme_mod( 'kindling_product_entry_addtocart_border_color_hover', '#13aff0' );
			$single_product_title_color 						= get_theme_mod( 'kindling_single_product_title_color', '#333333' );
			$single_product_price_color 						= get_theme_mod( 'kindling_single_product_price_color', '#57bf6d' );
			$single_product_del_price_color 					= get_theme_mod( 'kindling_single_product_del_price_color', '#555555' );
			$single_product_description_color 					= get_theme_mod( 'kindling_single_product_description_color', '#aaaaaa' );
			$single_product_meta_title_color 					= get_theme_mod( 'kindling_single_product_meta_title_color', '#333333' );
			$single_product_meta_link_color 					= get_theme_mod( 'kindling_single_product_meta_link_color', '#aaaaaa' );
			$single_product_meta_link_color_hover 				= get_theme_mod( 'kindling_single_product_meta_link_color_hover', '#13aff0' );
			$single_product_thumbnails_next_prev_hover_bg 		= get_theme_mod( 'kindling_single_product_thumbnails_next_prev_hover_bg', '#f3f3f3' );
			$single_product_thumbnails_next_prev_color 			= get_theme_mod( 'kindling_single_product_thumbnails_next_prev_color', '#929292' );
			$single_product_tabs_borders_color 					= get_theme_mod( 'kindling_single_product_tabs_borders_color', '#e9e9e9' );
			$single_product_tabs_text_color 					= get_theme_mod( 'kindling_single_product_tabs_text_color', '#999999' );
			$single_product_tabs_text_color_hover 				= get_theme_mod( 'kindling_single_product_tabs_text_color_hover', '#13aff0' );
			$single_product_tabs_active_text_color 				= get_theme_mod( 'kindling_single_product_tabs_active_text_color', '#13aff0' );
			$single_product_tabs_active_text_borders_color 		= get_theme_mod( 'kindling_single_product_tabs_active_text_borders_color', '#13aff0' );
			$single_product_tabs_product_description_title_color = get_theme_mod( 'kindling_single_product_tabs_product_description_title_color', '#333333' );
			$single_product_tabs_product_description_color 		= get_theme_mod( 'kindling_single_product_tabs_product_description_color', '#929292' );
			$account_nav_borders_color 							= get_theme_mod( 'kindling_account_navigation_borders_color', '#e9e9e9' );
			$account_nav_icons_color 							= get_theme_mod( 'kindling_account_navigation_icons_color', '#13aff0' );
			$account_nav_links_color 							= get_theme_mod( 'kindling_account_navigation_links_color', '#333333' );
			$account_nav_links_color_hover 						= get_theme_mod( 'kindling_account_navigation_links_color_hover', '#13aff0' );
			$account_addresses_bg 								= get_theme_mod( 'kindling_account_addresses_bg', '#f6f6f6' );
			$account_addresses_title_color 						= get_theme_mod( 'kindling_account_addresses_title_color', '#333333' );
			$account_addresses_title_border_color 				= get_theme_mod( 'kindling_account_addresses_title_border_color', '#ffffff' );
			$account_addresses_content_color 					= get_theme_mod( 'kindling_account_addresses_content_color', '#898989' );
			$account_addresses_button_bg 						= get_theme_mod( 'kindling_account_addresses_button_bg', '#ffffff' );
			$account_addresses_button_bg_hover 					= get_theme_mod( 'kindling_account_addresses_button_bg_hover', '#f8f8f8' );
			$account_addresses_button_color 					= get_theme_mod( 'kindling_account_addresses_button_color', '#898989' );
			$account_addresses_button_color_hover 				= get_theme_mod( 'kindling_account_addresses_button_color_hover', '#555555' );
			$cart_borders_color 								= get_theme_mod( 'kindling_cart_borders_color', '#e9e9e9' );
			$cart_head_bg 										= get_theme_mod( 'kindling_cart_head_bg', '#f7f7f7' );
			$cart_head_titles_color 							= get_theme_mod( 'kindling_cart_head_titles_color', '#444444' );
			$cart_totals_table_titles_color 					= get_theme_mod( 'kindling_cart_totals_table_titles_color', '#444444' );
			$cart_remove_button_color 							= get_theme_mod( 'kindling_cart_remove_button_color', '#bbbbbb' );
			$cart_remove_button_color_hover 					= get_theme_mod( 'kindling_cart_remove_button_color_hover', '#333333' );
			$checkout_notices_borders_color 					= get_theme_mod( 'kindling_checkout_notices_borders_color', '#e9e9e9' );
			$checkout_notices_icon_color 						= get_theme_mod( 'kindling_checkout_notices_icon_color', '#dddddd' );
			$checkout_notices_color 							= get_theme_mod( 'kindling_checkout_notices_color', '#777777' );
			$checkout_notices_link_color 						= get_theme_mod( 'kindling_checkout_notices_link_color', '#13aff0' );
			$checkout_notices_link_color_hover 					= get_theme_mod( 'kindling_checkout_notices_link_color_hover', '#333333' );
			$checkout_notices_form_border_color 				= get_theme_mod( 'kindling_checkout_notices_form_border_color', '#e9e9e9' );
			$checkout_titles_color 								= get_theme_mod( 'kindling_checkout_titles_color', '#333333' );
			$checkout_titles_border_bottom_color 				= get_theme_mod( 'kindling_checkout_titles_border_bottom_color', '#e9e9e9' );
			$checkout_table_main_bg 							= get_theme_mod( 'kindling_checkout_table_main_bg', '#f7f7f7' );
			$checkout_table_titles_color 						= get_theme_mod( 'kindling_checkout_table_titles_color', '#444444' );
			$checkout_table_borders_color 						= get_theme_mod( 'kindling_checkout_table_borders_color', '#e9e9e9' );
			$checkout_payment_methods_bg 						= get_theme_mod( 'kindling_checkout_payment_methods_bg', '#f8f8f8' );
			$checkout_payment_methods_borders_color 			= get_theme_mod( 'kindling_checkout_payment_methods_borders_color', '#e9e9e9' );
			$checkout_payment_box_bg 							= get_theme_mod( 'kindling_checkout_payment_box_bg', '#ffffff' );
			$checkout_payment_box_color 						= get_theme_mod( 'kindling_checkout_payment_box_color', '#515151' );

			// Define css var
			$css = '';

			// Cart dropdown borders
			if ( ! empty( $cart_dropdown_borders ) && '#e9e9e9' != $cart_dropdown_borders ) {
				$css .= '#site-navigation .woocommerce.widget_shopping_cart .cart_list li{border-color:'. $cart_dropdown_borders .';}';
			}

			// Cart dropdown link color
			if ( ! empty( $cart_dropdown_link_color ) && '#333333' != $cart_dropdown_link_color ) {
				$css .= '#site-navigation .woocommerce ul.product_list_widget li a{color:'. $cart_dropdown_link_color .';}';
			}

			// Cart dropdown link hover color
			if ( ! empty( $cart_dropdown_link_color_hover ) && '#13aff0' != $cart_dropdown_link_color_hover ) {
				$css .= '#site-navigation .woocommerce ul.product_list_widget li a:hover{color:'. $cart_dropdown_link_color_hover .';}';
			}

			// Cart dropdown remove link color
			if ( ! empty( $cart_dropdown_remove_link_color ) && '#777777' != $cart_dropdown_remove_link_color ) {
				$css .= 'body #site-navigation .woocommerce ul.product_list_widget li a.remove{color:'. $cart_dropdown_remove_link_color .';}';
			}

			// Cart dropdown remove link hover color
			if ( ! empty( $cart_dropdown_remove_link_color_hover ) && '#333333' != $cart_dropdown_remove_link_color_hover ) {
				$css .= 'body #site-navigation .woocommerce ul.product_list_widget li a.remove:hover{color:'. $cart_dropdown_remove_link_color_hover .';}';
			}

			// Cart dropdown quantity color
			if ( ! empty( $cart_dropdown_quantity_color ) && '#bcbcbc' != $cart_dropdown_quantity_color ) {
				$css .= '#site-navigation .woocommerce ul.product_list_widget li .quantity{color:'. $cart_dropdown_quantity_color .';}';
			}

			// Cart dropdown price color
			if ( ! empty( $cart_dropdown_price_color ) && '#57bf6d' != $cart_dropdown_price_color ) {
				$css .= '#site-navigation #current-shop-items-dropdown .amount{color:'. $cart_dropdown_price_color .';}';
			}

			// Cart dropdown subtotal color
			if ( ! empty( $cart_dropdown_subtotal_color ) && '#444444' != $cart_dropdown_subtotal_color ) {
				$css .= '#site-navigation .woocommerce .total strong{color:'. $cart_dropdown_subtotal_color .';}';
			}

			// Cart dropdown checkout button background color
			if ( ! empty( $cart_dropdown_checkout_button_bg ) && '#dddddd' != $cart_dropdown_checkout_button_bg ) {
				$css .= '#site-navigation .woocommerce .widget_shopping_cart_content .buttons .checkout{background-color:'. $cart_dropdown_checkout_button_bg .';}';
			}

			// Cart dropdown checkout button hover background color
			if ( ! empty( $cart_dropdown_checkout_button_hover_bg ) && '#cccccc' != $cart_dropdown_checkout_button_hover_bg ) {
				$css .= '#site-navigation .woocommerce .widget_shopping_cart_content .buttons .checkout:hover{background-color:'. $cart_dropdown_checkout_button_hover_bg .';}';
			}

			// Cart dropdown checkout button color
			if ( ! empty( $cart_dropdown_checkout_button_color ) && '#333333' != $cart_dropdown_checkout_button_color ) {
				$css .= '#site-navigation .woocommerce .widget_shopping_cart_content .buttons .checkout{color:'. $cart_dropdown_checkout_button_color .';}';
			}

			// Cart dropdown checkout button hover color
			if ( ! empty( $cart_dropdown_checkout_button_hover_color ) && '#333333' != $cart_dropdown_checkout_button_hover_color ) {
				$css .= '#site-navigation .woocommerce .widget_shopping_cart_content .buttons .checkout:hover{color:'. $cart_dropdown_checkout_button_hover_color .';}';
			}

			// Add onsale bg
			if ( ! empty( $onsale_bg ) && '#3FC387' != $onsale_bg ) {
				$css .= '.woocommerce span.onsale{background-color:'. $onsale_bg .';}';
			}

			// Add onsale color
			if ( ! empty( $onsale_color ) && '#ffffff' != $onsale_color ) {
				$css .= '.woocommerce span.onsale{color:'. $onsale_color .';}';
			}

			// Add out of stock bg
			if ( ! empty( $outofstock_bg ) && '#000000' != $outofstock_bg ) {
				$css .= '.woocommerce ul.products li.product.outofstock .outofstock-badge{background-color:'. $outofstock_bg .';}';
			}

			// Add out of stock color
			if ( ! empty( $outofstock_color ) && '#ffffff' != $outofstock_color ) {
				$css .= '.woocommerce ul.products li.product.outofstock .outofstock-badge{color:'. $outofstock_color .';}';
			}

			// Add stars color before
			if ( ! empty( $stars_color_before ) && '#dfdbdf' != $stars_color_before ) {
				$css .= '.woocommerce .star-rating:before{color:'. $stars_color_before .';}';
			}

			// Add stars color
			if ( ! empty( $stars_color ) && '#f9ca63' != $stars_color ) {
				$css .= '.woocommerce .star-rating span{color:'. $stars_color .';}';
			}

			// Add quantity border color
			if ( ! empty( $quantity_border_color ) && '#e4e4e4' != $quantity_border_color ) {
				$css .= '.quantity .qty,.quantity .qty-changer a{border-color:'. $quantity_border_color .';}';
			}

			// Add quantity border color focus
			if ( ! empty( $quantity_border_color_focus ) && '#bbbbbb' != $quantity_border_color_focus ) {
				$css .= 'body .quantity .qty:focus{border-color:'. $quantity_border_color_focus .';}';
			}

			// Add quantity color
			if ( ! empty( $quantity_color ) && '#777777' != $quantity_color ) {
				$css .= '.quantity .qty{color:'. $quantity_color .';}';
			}

			// Add quantity plus/minus color
			if ( ! empty( $quantity_plus_minus_color ) && '#cccccc' != $quantity_plus_minus_color ) {
				$css .= '.quantity .qty-changer a{color:'. $quantity_plus_minus_color .';}';
			}

			// Add quantity plus/minus color hover
			if ( ! empty( $quantity_plus_minus_color_hover ) && '#cccccc' != $quantity_plus_minus_color_hover ) {
				$css .= '.quantity .qty-changer a:hover{color:'. $quantity_plus_minus_color_hover .';}';
			}

			// Add quantity plus/minus border color hover
			if ( ! empty( $quantity_plus_minus_border_color_hover ) && '#e0e0e0' != $quantity_plus_minus_border_color_hover ) {
				$css .= '.quantity .qty-changer a:hover{border-color:'. $quantity_plus_minus_border_color_hover .';}';
			}

			// Add toolbar border color
			if ( ! empty( $toolbar_border_color ) && '#eaeaea' != $toolbar_border_color ) {
				$css .= '.woocommerce .kindling-toolbar{border-color:'. $toolbar_border_color .';}';
			}

			// Add toolbar grid/list color
			if ( ! empty( $toolbar_grid_list_color ) && '#999999' != $toolbar_grid_list_color ) {
				$css .= '.woocommerce .kindling-grid-list a{color:'. $toolbar_grid_list_color .';}';
			}

			// Add toolbar grid/list border color
			if ( ! empty( $toolbar_grid_list_border_color ) && '#eaeaea' != $toolbar_grid_list_border_color ) {
				$css .= '.woocommerce .kindling-grid-list a{border-color:'. $toolbar_grid_list_border_color .';}';
			}

			// Add toolbar grid/list hover color
			if ( ! empty( $toolbar_grid_list_hover_color ) && '#13aff0' != $toolbar_grid_list_hover_color ) {
				$css .= '.woocommerce .kindling-grid-list a:hover{color:'. $toolbar_grid_list_hover_color .';border-color:'. $toolbar_grid_list_hover_color .';}';
			}

			// Add toolbar grid/list active color
			if ( ! empty( $toolbar_grid_list_active_color ) && '#13aff0' != $toolbar_grid_list_active_color ) {
				$css .= '.woocommerce .kindling-grid-list a.active{color:'. $toolbar_grid_list_active_color .';border-color:'. $toolbar_grid_list_active_color .';}';
			}

			// Add toolbar select color
			if ( ! empty( $toolbar_select_color ) && '#999999' != $toolbar_select_color ) {
				$css .= '.woocommerce .woocommerce-ordering .theme-select,.woocommerce .woocommerce-ordering .theme-select:after{color:'. $toolbar_select_color .';}';
			}

			// Add toolbar select border color
			if ( ! empty( $toolbar_select_border_color ) && '#dddddd' != $toolbar_select_border_color ) {
				$css .= '.woocommerce .woocommerce-ordering .theme-select,.woocommerce .woocommerce-ordering .theme-select:after{border-color:'. $toolbar_select_border_color .';}';
			}

			// Add toolbar number of products color
			if ( ! empty( $toolbar_number_of_products_color ) && '#555555' != $toolbar_number_of_products_color ) {
				$css .= '.woocommerce .result-count li.view-title,.woocommerce .result-count li a.active, .woocommerce .result-count li a:hover{color:'. $toolbar_number_of_products_color .';}';
			}

			// Add toolbar number of products inactive color
			if ( ! empty( $toolbar_number_of_products_inactive_color ) && '#999999' != $toolbar_number_of_products_inactive_color ) {
				$css .= '.woocommerce .result-count li a{color:'. $toolbar_number_of_products_inactive_color .';}';
			}

			// Add toolbar number of products border color
			if ( ! empty( $toolbar_number_of_products_border_color ) && '#999999' != $toolbar_number_of_products_border_color ) {
				$css .= '.woocommerce .result-count li:after{color:'. $toolbar_number_of_products_border_color .';}';
			}

			// Add category color
			if ( ! empty( $category_color ) && '#999999' != $category_color ) {
				$css .= '.woocommerce ul.products li.product .category a{color:'. $category_color .';}';
			}

			// Add category color hover
			if ( ! empty( $category_color_hover ) && '#13aff0' != $category_color_hover ) {
				$css .= '.woocommerce ul.products li.product .category a:hover{color:'. $category_color_hover .';}';
			}

			// Add product entry title color
			if ( ! empty( $product_title_color ) && '#333333' != $product_title_color ) {
				$css .= '.woocommerce ul.products li.product a.title{color:'. $product_title_color .';}';
			}

			// Add product entry title color hover
			if ( ! empty( $product_title_color_hover ) && '#13aff0' != $product_title_color_hover ) {
				$css .= '.woocommerce ul.products li.product a.title:hover{color:'. $product_title_color_hover .';}';
			}

			// Add product entry price color
			if ( ! empty( $product_entry_price_color ) && '#57bf6d' != $product_entry_price_color ) {
				$css .= '.woocommerce ul.products li.product .price .amount{color:'. $product_entry_price_color .';}';
			}

			// Add product entry del price color
			if ( ! empty( $product_entry_del_price_color ) && '#666666' != $product_entry_del_price_color ) {
				$css .= '.woocommerce ul.products li.product .price del .amount{color:'. $product_entry_del_price_color .';}';
			}

			// Add product entry add to cart color
			if ( ! empty( $product_entry_addtocart_color ) && '#848494' != $product_entry_addtocart_color ) {
				$css .= '.woocommerce ul.products li.product .button,.woocommerce ul.products li.product .product-inner .added_to_cart{color:'. $product_entry_addtocart_color .';}';
			}

			// Add product entry add to cart color hover
			if ( ! empty( $product_entry_addtocart_color_hover ) && '#13aff0' != $product_entry_addtocart_color_hover ) {
				$css .= '.woocommerce ul.products li.product .button:hover,.woocommerce ul.products li.product .product-inner .added_to_cart:hover{color:'. $product_entry_addtocart_color_hover .';}';
			}

			// Add product entry add to cart border color
			if ( ! empty( $product_entry_addtocart_border_color ) && '#e4e4e4' != $product_entry_addtocart_border_color ) {
				$css .= '.woocommerce ul.products li.product .button,.woocommerce ul.products li.product .product-inner .added_to_cart{border-color:'. $product_entry_addtocart_border_color .';}';
			}

			// Add product entry add to cart color hover
			if ( ! empty( $product_entry_addtocart_border_color_hover ) && '#13aff0' != $product_entry_addtocart_border_color_hover ) {
				$css .= '.woocommerce ul.products li.product .button:hover,.woocommerce ul.products li.product .product-inner .added_to_cart:hover{border-color:'. $product_entry_addtocart_border_color_hover .';}';
			}

			// Add single product title color
			if ( ! empty( $single_product_title_color ) && '#333333' != $single_product_title_color ) {
				$css .= '.woocommerce div.product .product_title{color:'. $single_product_title_color .';}';
			}

			// Add single product price color
			if ( ! empty( $single_product_price_color ) && '#57bf6d' != $single_product_price_color ) {
				$css .= '.price,.amount{color:'. $single_product_price_color .';}';
			}

			// Add single product del price color
			if ( ! empty( $single_product_del_price_color ) && '#555555' != $single_product_del_price_color ) {
				$css .= '.price del,del .amount{color:'. $single_product_del_price_color .';}';
			}

			// Add single product description color
			if ( ! empty( $single_product_description_color ) && '#aaaaaa' != $single_product_description_color ) {
				$css .= '.woocommerce div.product div[itemprop="description"]{color:'. $single_product_description_color .';}';
			}

			// Add single product meta title color
			if ( ! empty( $single_product_meta_title_color ) && '#333333' != $single_product_meta_title_color ) {
				$css .= '.product_meta .posted_in,.product_meta .tagged_as{color:'. $single_product_meta_title_color .';}';
			}

			// Add single product meta link color
			if ( ! empty( $single_product_meta_link_color ) && '#aaaaaa' != $single_product_meta_link_color ) {
				$css .= '.product_meta .posted_in a,.product_meta .tagged_as a{color:'. $single_product_meta_link_color .';}';
			}

			// Add single product meta link color hover
			if ( ! empty( $single_product_meta_link_color_hover ) && '#13aff0' != $single_product_meta_link_color_hover ) {
				$css .= '.product_meta .posted_in a:hover,.product_meta .tagged_as a:hover{color:'. $single_product_meta_link_color_hover .';}';
			}

			// Add single product thumbnails next/prev hover bg
			if ( ! empty( $single_product_thumbnails_next_prev_hover_bg ) && '#f3f3f3' != $single_product_thumbnails_next_prev_hover_bg ) {
				$css .= '.woocommerce div.product .product-thumbnails .slick-arrow:hover{background-color:'. $single_product_thumbnails_next_prev_hover_bg .';}';
			}

			// Add single product thumbnails next/prev color
			if ( ! empty( $single_product_thumbnails_next_prev_color ) && '#929292' != $single_product_thumbnails_next_prev_color ) {
				$css .= '.woocommerce div.product .product-thumbnails .slick-arrow{color:'. $single_product_thumbnails_next_prev_color .';}';
			}

			// Add single product tabs borders color
			if ( ! empty( $single_product_tabs_borders_color ) && '#e9e9e9' != $single_product_tabs_borders_color ) {
				$css .= '.woocommerce div.product .woocommerce-tabs ul.tabs{border-color:'. $single_product_tabs_borders_color .';}';
			}

			// Add single product tabs text color
			if ( ! empty( $single_product_tabs_text_color ) && '#999999' != $single_product_tabs_text_color ) {
				$css .= '.woocommerce div.product .woocommerce-tabs ul.tabs li a{color:'. $single_product_tabs_text_color .';}';
			}

			// Add single product tabs text color hover
			if ( ! empty( $single_product_tabs_text_color_hover ) && '#13aff0' != $single_product_tabs_text_color_hover ) {
				$css .= '.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover{color:'. $single_product_tabs_text_color_hover .';}';
			}

			// Add single product tabs active text color
			if ( ! empty( $single_product_tabs_active_text_color ) && '#13aff0' != $single_product_tabs_active_text_color ) {
				$css .= '.woocommerce div.product .woocommerce-tabs ul.tabs li.active a{color:'. $single_product_tabs_active_text_color .';}';
			}

			// Add single product tabs active text borders color
			if ( ! empty( $single_product_tabs_active_text_borders_color ) && '#13aff0' != $single_product_tabs_active_text_borders_color ) {
				$css .= '.woocommerce div.product .woocommerce-tabs ul.tabs li.active a{border-color:'. $single_product_tabs_active_text_borders_color .';}';
			}

			// Add single product tabs product description title color
			if ( ! empty( $single_product_tabs_product_description_title_color ) && '#333333' != $single_product_tabs_product_description_title_color ) {
				$css .= '.woocommerce div.product .woocommerce-tabs .panel h2{color:'. $single_product_tabs_product_description_title_color .';}';
			}

			// Add single product tabs product description color
			if ( ! empty( $single_product_tabs_product_description_color ) && '#929292' != $single_product_tabs_product_description_color ) {
				$css .= '.woocommerce div.product .woocommerce-tabs .panel p{color:'. $single_product_tabs_product_description_color .';}';
			}

			// Add account navigation borders color
			if ( ! empty( $account_nav_borders_color ) && '#e9e9e9' != $account_nav_borders_color ) {
				$css .= '.woocommerce-MyAccount-navigation ul,.woocommerce-MyAccount-navigation ul li{border-color:'. $account_nav_borders_color .';}';
			}

			// Add account navigation icons color
			if ( ! empty( $account_nav_icons_color ) && '#13aff0' != $account_nav_icons_color ) {
				$css .= '.woocommerce-MyAccount-navigation ul li a:before{color:'. $account_nav_icons_color .';}';
			}

			// Add account navigation links color
			if ( ! empty( $account_nav_links_color ) && '#333333' != $account_nav_links_color ) {
				$css .= '.woocommerce-MyAccount-navigation ul li a{color:'. $account_nav_links_color .';}';
			}

			// Add account navigation links color hover
			if ( ! empty( $account_nav_links_color_hover ) && '#13aff0' != $account_nav_links_color_hover ) {
				$css .= '.woocommerce-MyAccount-navigation ul li a:hover{color:'. $account_nav_links_color_hover .';}';
			}

			// Add account addresses background color
			if ( ! empty( $account_addresses_bg ) && '#f6f6f6' != $account_addresses_bg ) {
				$css .= '.woocommerce-MyAccount-content .addresses .woocommerce-Address .title, .woocommerce-MyAccount-content .addresses .woocommerce-Address address{background-color:'. $account_addresses_bg .';}';
			}

			// Add account addresses title color
			if ( ! empty( $account_addresses_title_color ) && '#333333' != $account_addresses_title_color ) {
				$css .= '.woocommerce-MyAccount-content .addresses .woocommerce-Address .title h3{color:'. $account_addresses_title_color .';}';
			}

			// Add account addresses title border color
			if ( ! empty( $account_addresses_title_border_color ) && '#ffffff' != $account_addresses_title_border_color ) {
				$css .= '.woocommerce-MyAccount-content .addresses .woocommerce-Address .title{border-color:'. $account_addresses_title_border_color .';}';
			}

			// Add account addresses content color
			if ( ! empty( $account_addresses_content_color ) && '#898989' != $account_addresses_content_color ) {
				$css .= '.woocommerce-MyAccount-content .addresses .woocommerce-Address address{color:'. $account_addresses_content_color .';}';
			}

			// Add account addresses button background color
			if ( ! empty( $account_addresses_button_bg ) && '#ffffff' != $account_addresses_button_bg ) {
				$css .= '.woocommerce-MyAccount-content .addresses .woocommerce-Address .title a{background-color:'. $account_addresses_button_bg .';}';
			}

			// Add account addresses button background color hover
			if ( ! empty( $account_addresses_button_bg_hover ) && '#f8f8f8' != $account_addresses_button_bg_hover ) {
				$css .= '.woocommerce-MyAccount-content .addresses .woocommerce-Address .title a:hover{background-color:'. $account_addresses_button_bg_hover .';}';
			}

			// Add account addresses button color
			if ( ! empty( $account_addresses_button_color ) && '#898989' != $account_addresses_button_color ) {
				$css .= '.woocommerce-MyAccount-content .addresses .woocommerce-Address .title a{color:'. $account_addresses_button_color .';}';
			}

			// Add account addresses button color hover
			if ( ! empty( $account_addresses_button_color_hover ) && '#555555' != $account_addresses_button_color_hover ) {
				$css .= '.woocommerce-MyAccount-content .addresses .woocommerce-Address .title a:hover{color:'. $account_addresses_button_color_hover .';}';
			}

			// Add cart borders color
			if ( ! empty( $cart_borders_color ) && '#e9e9e9' != $cart_borders_color ) {
				$css .= '.woocommerce-cart table.shop_table,.woocommerce-cart table.shop_table th,.woocommerce-cart table.shop_table td,.woocommerce-cart .cart-collaterals .cross-sells,.woocommerce-page .cart-collaterals .cross-sells,.woocommerce-cart .cart-collaterals h2,.woocommerce-cart .cart-collaterals .cart_totals,.woocommerce-page .cart-collaterals .cart_totals,.woocommerce-cart .cart-collaterals .cart_totals table th,.woocommerce-cart .cart-collaterals .cart_totals .order-total th,.woocommerce-cart table.shop_table td,.woocommerce-cart .cart-collaterals .cart_totals tr td,.woocommerce-cart .cart-collaterals .cart_totals .order-total td{border-color:'. $cart_borders_color .';}';
			}

			// Add cart head background
			if ( ! empty( $cart_head_bg ) && '#f7f7f7' != $cart_head_bg ) {
				$css .= '.woocommerce-cart table.shop_table thead,.woocommerce-cart .cart-collaterals h2{background-color:'. $cart_head_bg .';}';
			}

			// Add cart head titles color
			if ( ! empty( $cart_head_titles_color ) && '#444444' != $cart_head_titles_color ) {
				$css .= '.woocommerce-cart table.shop_table thead th,.woocommerce-cart .cart-collaterals h2{color:'. $cart_head_titles_color .';}';
			}

			// Add cart totals table titles color
			if ( ! empty( $cart_totals_table_titles_color ) && '#444444' != $cart_totals_table_titles_color ) {
				$css .= '.woocommerce-cart .cart-collaterals .cart_totals table th{color:'. $cart_totals_table_titles_color .';}';
			}

			// Add cart remove button color
			if ( ! empty( $cart_remove_button_color ) && '#bbbbbb' != $cart_remove_button_color ) {
				$css .= '.woocommerce table.shop_table a.remove{color:'. $cart_remove_button_color .';}';
			}

			// Add cart remove button color hover
			if ( ! empty( $cart_remove_button_color_hover ) && '#333333' != $cart_remove_button_color_hover ) {
				$css .= '.woocommerce table.shop_table a.remove:hover{color:'. $cart_remove_button_color_hover .';}';
			}

			// Add checkout notices borders color
			if ( ! empty( $checkout_notices_borders_color ) && '#e9e9e9' != $checkout_notices_borders_color ) {
				$css .= '.woocommerce-checkout .woocommerce-info{border-color:'. $checkout_notices_borders_color .';}';
			}

			// Add checkout notices icon color
			if ( ! empty( $checkout_notices_icon_color ) && '#dddddd' != $checkout_notices_icon_color ) {
				$css .= '.woocommerce-checkout .woocommerce-info:before{color:'. $checkout_notices_icon_color .';}';
			}

			// Add checkout notices color
			if ( ! empty( $checkout_notices_color ) && '#777777' != $checkout_notices_color ) {
				$css .= '.woocommerce-checkout .woocommerce-info{color:'. $checkout_notices_color .';}';
			}

			// Add checkout notices link color
			if ( ! empty( $checkout_notices_link_color ) && '#13aff0' != $checkout_notices_link_color ) {
				$css .= '.woocommerce-checkout .woocommerce-info a{color:'. $checkout_notices_link_color .';}';
			}

			// Add checkout notices link color hover
			if ( ! empty( $checkout_notices_link_color_hover ) && '#333333' != $checkout_notices_link_color_hover ) {
				$css .= '.woocommerce-checkout .woocommerce-info a:hover{color:'. $checkout_notices_link_color_hover .';}';
			}

			// Add checkout notices form border color
			if ( ! empty( $checkout_notices_form_border_color ) && '#e9e9e9' != $checkout_notices_form_border_color ) {
				$css .= '.woocommerce-checkout form.login,.woocommerce-checkout form.checkout_coupon{border-color:'. $checkout_notices_form_border_color .';}';
			}

			// Add checkout titles color
			if ( ! empty( $checkout_titles_color ) && '#333333' != $checkout_titles_color ) {
				$css .= '.woocommerce .woocommerce-checkout #customer_details h3,.woocommerce .woocommerce-checkout h3#order_review_heading{color:'. $checkout_titles_color .';}';
			}

			// Add checkout notices titles border bottom color
			if ( ! empty( $checkout_titles_border_bottom_color ) && '#e9e9e9' != $checkout_titles_border_bottom_color ) {
				$css .= '.woocommerce .woocommerce-checkout #customer_details h3,.woocommerce .woocommerce-checkout h3#order_review_heading{border-color:'. $checkout_titles_border_bottom_color .';}';
			}

			// Add checkout table main background
			if ( ! empty( $checkout_table_main_bg ) && '#f7f7f7' != $checkout_table_main_bg ) {
				$css .= '.woocommerce table.shop_table thead,.woocommerce-checkout-review-order-table tfoot th{background-color:'. $checkout_table_main_bg .';}';
			}

			// Add checkout table titles color
			if ( ! empty( $checkout_table_titles_color ) && '#444444' != $checkout_table_titles_color ) {
				$css .= '.woocommerce-checkout table.shop_table thead th,.woocommerce-checkout table.shop_table tfoot th{color:'. $checkout_table_titles_color .';}';
			}

			// Add checkout table borders color
			if ( ! empty( $checkout_table_borders_color ) && '#e9e9e9' != $checkout_table_borders_color ) {
				$css .= '.woocommerce-checkout table.shop_table,.woocommerce-checkout table.shop_table th,.woocommerce-checkout table.shop_table td,.woocommerce-checkout table.shop_table tfoot th,.woocommerce-checkout table.shop_table tfoot td{border-color:'. $checkout_table_borders_color .';}';
			}

			// Add checkout payment methods background
			if ( ! empty( $checkout_payment_methods_bg ) && '#f8f8f8' != $checkout_payment_methods_bg ) {
				$css .= '.woocommerce-checkout #payment{background-color:'. $checkout_payment_methods_bg .';}';
			}

			// Add checkout payment methods borders color
			if ( ! empty( $checkout_payment_methods_borders_color ) && '#e9e9e9' != $checkout_payment_methods_borders_color ) {
				$css .= '.woocommerce-checkout #payment,.woocommerce-checkout #payment ul.payment_methods{border-color:'. $checkout_payment_methods_borders_color .';}';
			}

			// Add checkout payment box background
			if ( ! empty( $checkout_payment_box_bg ) && '#ffffff' != $checkout_payment_box_bg ) {
				$css .= '.woocommerce-checkout #payment div.payment_box{background-color:'. $checkout_payment_box_bg .';}';
			}

			// Add checkout payment box color
			if ( ! empty( $checkout_payment_box_color ) && '#515151' != $checkout_payment_box_color ) {
				$css .= '.woocommerce-checkout #payment div.payment_box{color:'. $checkout_payment_box_color .';}';
			}
				
			// Return CSS
			if ( ! empty( $css ) ) {
				$output .= '/* WooCommerce CSS */'. $css;
			}

			// Return output css
			return $output;

		}

	}

endif;

return new Kindling_WooCommerce_Customizer();