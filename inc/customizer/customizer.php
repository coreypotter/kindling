<?php
/**
 * Kindling Customizer Class
 *
 * @package Kindling Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kindling_Customizer' ) ) :
	/**
	 * The Kindling Customizer class
	 */
	class Kindling_Customizer {
		/* Actions */
	
		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {

			add_action( 'customize_register',					array( $this, 'custom_controls' ) );
			add_action( 'customize_register',					array( $this, 'controls_helpers' ) );
			add_action( 'customize_register',					array( $this, 'customize_register' ), 11 );
			add_action( 'after_setup_theme',					array( $this, 'register_options' ) );
			add_action( 'customize_preview_init', 				array( $this, 'customize_preview_init' ) );
			add_action( 'customize_controls_enqueue_scripts', 	array( $this, 'custom_customize_enqueue' ), 7 );
			
			/* Export & Import */
			add_action( 'plugins_loaded', 'CEI_Core::load_plugin_textdomain' );
			add_action( 'customize_controls_print_scripts', 'CEI_Core::controls_print_scripts' );
			add_action( 'customize_controls_enqueue_scripts', 'CEI_Core::controls_enqueue_scripts' );
			add_action( 'customize_register', 'CEI_Core::init', 999999 );
			add_action( 'customize_register', 'CEI_Core::register' );
		}

		/**
		 * Adds custom controls
		 *
		 * @since 1.0.0
		 */
		public function custom_controls( $wp_customize ) {

			// Path
			$dir = KINDLING_INC_DIR . 'customizer/controls/';

			// Add the controls
			require_once( $dir . 'buttonset/class-control-buttonset.php' );
			require_once( $dir . 'color/class-control-color.php' );
			require_once( $dir . 'dropdown-pages/class-control-dropdown-pages.php' );
			require_once( $dir . 'heading/class-control-heading.php' );
			require_once( $dir . 'icon-select/class-control-icon-select.php' );
			require_once( $dir . 'multicheck/class-control-multicheck.php' );
			require_once( $dir . 'radio-image/class-control-radio-image.php' );
			require_once( $dir . 'range/class-control-range.php' );
			require_once( $dir . 'sortable/class-control-sortable.php' );
			require_once( $dir . 'typography/class-control-typography.php' );
			require_once( $dir . 'exportimport/class-cei-core.php' );

			// Register the controls
			$wp_customize->register_control_type( 'Kindling_Customizer_Buttonset_Control' );
			$wp_customize->register_control_type( 'Kindling_Customizer_Color_Control' );
			$wp_customize->register_control_type( 'Kindling_Customizer_Dropdown_Pages' );
			$wp_customize->register_control_type( 'Kindling_Customizer_Heading_Control' );
			$wp_customize->register_control_type( 'Kindling_Customizer_Icon_Select_Control' );
			$wp_customize->register_control_type( 'Kindling_Customize_Multicheck_Control' );
			$wp_customize->register_control_type( 'Kindling_Customizer_Range_Control' );
			$wp_customize->register_control_type( 'Kindling_Customizer_Radio_Image_Control' );
			$wp_customize->register_control_type( 'Kindling_Customizer_Sortable_Control' );
			$wp_customize->register_control_type( 'Kindling_Customizer_Typography_Control' );

		}

		/**
		 * Adds customizer helpers
		 *
		 * @since 1.0.0
		 */
		public function controls_helpers() {
			require_once( KINDLING_INC_DIR .'customizer/customizer-helpers.php' );
		}

		/**
		 * Core modules
		 *
		 * @since 1.0.0
		 */
		public static function customize_register( $wp_customize ) {

			// Tweak default controls
			$wp_customize->get_setting( 'blogname' )->transport 		= 'postMessage';
			$wp_customize->get_setting( 'blogdescription' )->transport 	= 'postMessage';

			// Remove core sections
			$wp_customize->remove_section( 'colors' );
			$wp_customize->remove_section( 'themes' );
			$wp_customize->remove_section( 'background_image' );

			// Remove core controls
			$wp_customize->remove_control( 'header_textcolor' );
			$wp_customize->remove_control( 'background_color' );
			$wp_customize->remove_control( 'background_image' );

			// Remove default settings
			$wp_customize->remove_setting( 'background_color' );
			$wp_customize->remove_setting( 'background_image' );

			// Move custom logo setting
			$wp_customize->get_control( 'custom_logo' )->section = 'kindling_header_logo';

			// Move custom css setting
			$wp_customize->get_control( 'custom_css' )->section = 'kindling_custom_code_panel';

		}

		/**
		 * Adds customizer options
		 *
		 * @since 1.0.0
		 */
		public function register_options() {
			
			// Var
			$dir = KINDLING_INC_DIR .'customizer/settings/';

			// Options
			if ( get_theme_mod( 'oe_general_panel_enable', true ) ) {
				require_once( $dir .'general.php' );
			}

			if ( get_theme_mod( 'oe_typography_panel_enable', true ) ) {
				require_once( $dir .'typography.php' );
			}

#			if ( get_theme_mod( 'oe_topbar_panel_enable', true ) ) {
#				require_once( $dir .'topbar.php' );
#			}

			if ( get_theme_mod( 'oe_header_panel_enable', true ) ) {
				require_once( $dir .'header.php' );
			}

			if ( get_theme_mod( 'oe_blog_panel_enable', true ) ) {
				require_once( $dir .'blog.php' );
			}

			if ( get_theme_mod( 'oe_sidebar_panel_enable', true ) ) {
				require_once( $dir .'sidebar.php' );
			}

#			if ( get_theme_mod( 'oe_footer_widgets_panel_enable', true ) ) {
#				require_once( $dir .'footer-widgets.php' );
#			}

			if ( get_theme_mod( 'oe_footer_bottom_panel_enable', true ) ) {
				require_once( $dir .'footer-bottom.php' );
			}

			if ( KINDLING_WOOCOMMERCE_ACTIVE
				&& get_theme_mod( 'oe_woocommerce_panel_enable', true ) ) {
				require_once( $dir .'woocommerce.php' );
			}

			if ( get_theme_mod( 'oe_custom_code_panel_enable', true ) ) {
				require_once( $dir .'custom-code.php' );
			}
		}

		/**
		 * Loads js file for customizer preview
		 *
		 * @since 1.0.0
		 */
		public function customize_preview_init() {
			wp_enqueue_script( 'kindling-customize-preview', KINDLING_THEME_URI . '/inc/customizer/assets/js/customize-preview.js', array( 'customize-preview' ), KINDLING_THEME_VERSION, true );
		}

		/**
		 * Load scripts for customizer
		 *
		 * @since 1.0.0
		 */
		public function custom_customize_enqueue() {
			wp_enqueue_style( 'font-awesome', KINDLING_CSS_DIR_URI .'devs/font-awesome.min.css' );
			wp_enqueue_style( 'kindling-general-css', KINDLING_INC_DIR_URI . 'customizer/controls/general.css' );
		}

	}

endif;

return new Kindling_Customizer();
