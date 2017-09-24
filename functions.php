<?php
/**
 * Theme functions and definitions.
 *
 * @package Kindling Theme
 */

# Theme info for the welcome page
function kindling_get_theme_info() {
	return array(
		'name'        => 'kindling',
		'dir'         => get_template_directory_uri() .'/inc/',
	);
}

# Migrate the custom CSS of the Theme Panel into the Additional CSS panel of the customizer
function kindling_custom_css_migrate() {
	if ( function_exists( 'wp_update_custom_css_post' ) ) {
		$custom_css = get_theme_mod( 'custom_css' );
		if ( $custom_css ) {
			$core_css = wp_get_custom_css(); # Preserve any CSS already added to the core option.
			$return = wp_update_custom_css_post( $core_css . $custom_css );
			if ( ! is_wp_error( $return ) ) {
				# Remove the old theme_mod, so that the CSS is stored in only one place moving forward.
				remove_theme_mod( 'custom_css' );
			}
		}
	}
}
add_action( 'after_setup_theme', 'kindling_custom_css_migrate' );

# Update Old Theme Mods
function kindling_update_old_theme_mods() {
	$kthmp = get_theme_mod( 'kindling_top_header_menu_position' ) ;
	# Something's set..
	if ( $kthmp ) {
		# Old Value: Set to New Default
		if ( ($kthmp == 'before') || ($thmp == 'after') ) {
			set_theme_mod( 'kindling_top_header_menu_position', 'left' );
		}
	}
}
add_action( 'after_setup_theme', 'kindling_update_old_theme_mods' );


# Core Constants
define( 'KINDLING_THEME_DIR', get_template_directory() );
define( 'KINDLING_THEME_URI', get_template_directory_uri() );

class Kindling_Theme_Class {
	/**
	 * Main Theme Class Constructor
	 *
	 * @since   1.0.0
	 */
	public function __construct() {
		# Define constants
		add_action( 'after_setup_theme', array( 'Kindling_Theme_Class', 'constants' ), 0 );
		# Load all core theme function files
		add_action( 'after_setup_theme', array( 'Kindling_Theme_Class', 'include_functions' ), 1 );
		# Load configuration classes
		add_action( 'after_setup_theme', array( 'Kindling_Theme_Class', 'configs' ), 3 );
		# Load framework classes
		add_action( 'after_setup_theme', array( 'Kindling_Theme_Class', 'classes' ), 4 );
		# Setup theme => add_theme_support, register_nav_menus, load_theme_textdomain, etc
		add_action( 'after_setup_theme', array( 'Kindling_Theme_Class', 'theme_setup' ), 10 );
		# Load custom widgets
		add_action( 'after_setup_theme', array( 'Kindling_Theme_Class', 'custom_widgets' ), 5 );
		# register sidebar widget areas
		add_action( 'widgets_init', array( 'Kindling_Theme_Class', 'register_sidebars' ) );
		# Registers theme_mod strings into Polylang
		if ( class_exists( 'Polylang' ) ) {
			add_action( 'after_setup_theme', array( 'Kindling_Theme_Class', 'polylang_register_string' ) );
		}
		# Registers theme_mod strings into WPML
		if ( class_exists( 'icl_object_id' ) ) {
			add_action( 'after_setup_theme', array( 'Kindling_Theme_Class', 'wpml_register_string' ) );
		}

		/** Admin only actions **/
		if ( is_admin() ) {
			# Load scripts in the WP admin
			add_action( 'admin_enqueue_scripts', array( 'Kindling_Theme_Class', 'admin_scripts' ) );
			# Outputs custom CSS for the admin
			add_action( 'admin_head', array( 'Kindling_Theme_Class', 'admin_inline_css' ) );

		/** Non Admin actions **/
		} else {
			# Load theme CSS
			add_action( 'wp_enqueue_scripts', array( 'Kindling_Theme_Class', 'theme_css' ) );
			# Load theme js
			add_action( 'wp_enqueue_scripts', array( 'Kindling_Theme_Class', 'theme_js' ) );
			# Add a pingback url auto-discovery header for singularly identifiable articles
			add_action( 'wp_head', array( 'Kindling_Theme_Class', 'pingback_header' ), 1 );
			# Add meta viewport tag to header
			add_action( 'wp_head', array( 'Kindling_Theme_Class', 'meta_viewport' ), 1 );
			# Add an X-UA-Compatible header
			add_filter( 'wp_headers', array( 'Kindling_Theme_Class', 'x_ua_compatible_headers' ) );
			# Browser dependent CSS
			add_action( 'wp_head', array( 'Kindling_Theme_Class', 'browser_dependent_css' ) );
			# Loads html5 shiv script
			add_action( 'wp_head', array( 'Kindling_Theme_Class', 'html5_shiv' ) );
			# Outputs custom CSS to the head
			add_action( 'wp_head', array( 'Kindling_Theme_Class', 'custom_css' ), 9999 );
			# Outputs custom JS to the footer
			add_action( 'wp_footer', array( 'Kindling_Theme_Class', 'custom_js' ), 9999 );
			# Alter tagcloud widget to display all tags with 1em font size
			add_filter( 'widget_tag_cloud_args', array( 'Kindling_Theme_Class', 'widget_tag_cloud_args' ) );
			# Alter WP categories widget to display count inside a span
			add_filter( 'wp_list_categories', array( 'Kindling_Theme_Class', 'wp_list_categories_args' ) );
			# Add a responsive wrapper to the WordPress oembed output
			add_filter( 'embed_oembed_html', array( 'Kindling_Theme_Class', 'add_responsive_wrap_to_oembeds' ), 99, 4 );
			# Allow for the use of shortcodes in the WordPress excerpt
			add_filter( 'the_excerpt', 'shortcode_unautop' );
			add_filter( 'the_excerpt', 'do_shortcode' );
			# Adds classes the post class
			add_filter( 'post_class', array( 'Kindling_Theme_Class', 'post_class' ) );
			# Add schema markup to the authors post link
			add_filter( 'the_author_posts_link', array( 'Kindling_Theme_Class', 'the_author_posts_link' ) );
		} # if is_admin()
	}

	/**
	 * Define Constants
	 *
	 * @since   1.0.0
	 */
	public static function constants() {
		$version = self::theme_version();
		# Theme version
		define( 'KINDLING_THEME_VERSION', $version );
		# Javascript and CSS Paths
		define( 'KINDLING_JS_DIR_URI', KINDLING_THEME_URI .'/assets/js/' );
		define( 'KINDLING_CSS_DIR_URI', KINDLING_THEME_URI .'/assets/css/' );
		# Include Paths
		define( 'KINDLING_INC_DIR', KINDLING_THEME_DIR .'/inc/' );
		define( 'KINDLING_INC_DIR_URI', KINDLING_THEME_URI .'/inc/' );
		# Check if plugins are active
		define( 'KINDLING_WOOCOMMERCE_ACTIVE', class_exists( 'WooCommerce' ) );
	}

	/**
	 * Load all core theme function files
	 *
	 * @since 1.0.0
	 */
	public static function include_functions() {
		$dir = KINDLING_INC_DIR;
		require_once( $dir .'helpers.php' );
		require_once( $dir .'customizer/controls/typography/webfonts.php' );
		require_once( $dir .'walker/init.php' );
		require_once( $dir .'walker/menu-walker.php' );
#		require_once( $dir .'admin/admin.php' );
		require_once( $dir .'updater/theme-updater.php' );
	}

	/**
	 * Configs for 3rd party plugins.
	 *
	 * @since 1.0.0
	 */
	public static function configs() {
		$dir = KINDLING_INC_DIR;
		# WooCommerce
		if ( KINDLING_WOOCOMMERCE_ACTIVE ) {
			require_once ( $dir .'woocommerce/woocommerce-config.php' );
		}
	}

	/**
	 * Returns current theme version
	 *
	 * @since   1.0.0
	 */
	public static function theme_version() {
		# Get theme data
		$theme = wp_get_theme();
		# Return theme version
		return $theme->get( 'Version' );
	}

	/**
	 * Load theme classes
	 *
	 * @since   1.0.0
	 */
	public static function classes() {
		# Admin only classes
		if ( is_admin() ) {
			# Plugin Nags
			require_once( KINDLING_INC_DIR .'plugins/class-tgm-plugin-activation.php' );
			require_once( KINDLING_INC_DIR .'plugins/tgm-plugin-activation.php' );
		}

		# Front-end classes
		else {
			# Breadcrumbs class
			require_once( KINDLING_INC_DIR .'breadcrumbs.php' );
		}

		# Customizer class
		require_once( KINDLING_INC_DIR .'customizer/customizer.php' );
	}

	/**
	 * Theme Setup
	 *
	 * @since   1.0.0
	 */
	public static function theme_setup() {
		# Load text domain
		load_theme_textdomain( 'kindling', KINDLING_THEME_DIR .'/languages' );
		# Get globals
		global $content_width;
		# Set content width based on theme's default design
		if ( ! isset( $content_width ) ) {
			$content_width = 1200;
		}
		# Register navigation menus
		register_nav_menus( array(
			'main_menu'       => esc_html__( 'Main', 'kindling' ),
		) );
		# Enable support for Post Formats
		add_theme_support( 'post-formats', array( 'video', 'gallery', 'audio', 'quote', 'link' ) );
		# Enable support for <title> tag
		add_theme_support( 'title-tag' );
		# Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );
		# Enable support for Post Thumbnails on posts and pages
		add_theme_support( 'post-thumbnails' );
		/**
		 * Enable support for site logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 45,
			'width'       => 164,
			'flex-height' => true,
			'flex-width'  => true,
		) );
		/*
		 * Switch default core markup for search form, comment form, comments, galleries, captions and widgets
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'widgets',
		) );
		# Declare WooCommerce support.
		add_theme_support( 'woocommerce' );
		# Add editor style
		add_editor_style( 'editor-style.css' );
		# Declare support for selective refreshing of widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
	}

	/**
	 * Adds the meta tag to the site header
	 *
	 * @since 1.1.0
	 */
	public static function pingback_header() {
		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}

	/**
	 * Adds the meta tag to the site header
	 *
	 * @since 1.0.0
	 */
	public static function meta_viewport() {
		// Meta viewport
		$viewport = '<meta name="viewport" content="width=device-width, initial-scale=1">';
		# Apply filters for child theme tweaking
		echo apply_filters( 'kindling_meta_viewport', $viewport );
	}

	/**
	 * Load scripts in the WP admin
	 *
	 * @since 1.0.0
	 */
	public static function admin_scripts( $hook ) {
		if ( $hook == 'nav-menus.php' ) {
			wp_enqueue_style( 'kindling-nav-menus', KINDLING_INC_DIR_URI .'walker/assets/nav-menus.css' );
		}
	}

	/**
	 * Load front-end scripts
	 *
	 * @since   1.0.0
	 */
	public static function theme_css() {
		# Define dir
		$dir = KINDLING_CSS_DIR_URI;
		$theme_version = KINDLING_THEME_VERSION;
		# Remove font awesome style from plugins
		wp_deregister_style( 'font-awesome' );
		wp_deregister_style( 'fontawesome' );
		# Load font awesome style
		wp_enqueue_style( 'font-awesome', $dir .'devs/font-awesome.min.css', false, '4.7.0' );
		# Register simple line icons style
		wp_enqueue_style( 'simple-line-icons', $dir .'devs/simple-line-icons.min.css', false, '2.2.2' );
		# Main Style.css File
		wp_enqueue_style( 'kindling-style', get_stylesheet_uri(), false, $theme_version );
	}

	/**
	 * Returns all js needed for the front-end
	 *
	 * @since 1.0.0
	 */
	public static function theme_js() {
		# Get js directory uri
		$dir = KINDLING_JS_DIR_URI;
		# Get current theme version
		$theme_version = KINDLING_THEME_VERSION;
		# Get localized array
		$localize_array = Kindling_Theme_Class::localize_array();
		# Comment reply
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
		# Register nicescroll script to use it in some extensions
		wp_register_script( 'nicescroll', $dir .'dynamic/nicescroll.min.js', array( 'jquery' ), $theme_version, true );
		# WooCommerce scripts
		if ( KINDLING_WOOCOMMERCE_ACTIVE ) {
			wp_enqueue_script( 'kindling-woocommerce', $dir .'dynamic/woo-scripts.min.js', array( 'jquery' ), $theme_version, true );
		}
		# Load minified js
		wp_enqueue_script( 'kindling-main', $dir .'main.min.js', array( 'jquery' ), $theme_version, true );
		wp_localize_script( 'kindling-main', 'kindlingLocalize', $localize_array );
	}

	/**
	 * Functions.js localize array
	 *
	 * @since 1.0.0
	 */
	public static function localize_array() {
		# Create array
		$array = array(
			'isRTL'                 => is_rtl(),
			'menuSearchStyle'       => kindling_menu_search_style(),
			'sidrSource'       		=> kindling_sidr_menu_source(),
			'sidrDisplace'       	=> get_theme_mod( 'kindling_mobile_menu_sidr_displace', true ) ?  true : false,
			'sidrSide'       		=> get_theme_mod( 'kindling_mobile_menu_sidr_direction', 'left' ),
			'sidrDropdownTarget'    => 'arrow',
			'customSelects'         => '.woocommerce-ordering .orderby, .cart-collaterals .cart_totals table select, #dropdown_product_cat, .widget_categories select, .widget_archive select, .single-product .variations_form .variations select',
		);
		# WooCart
		if ( KINDLING_WOOCOMMERCE_ACTIVE ) {
			$array['wooCartStyle'] 	= kindling_menu_cart_style();
		}
		# Apply filters and return array
		return apply_filters( 'kindling_localize_array', $array );
	}

	/**
	 * Add headers for IE to override IE's Compatibility View Settings
	 *
	 * @since 1.0.0
	 */
	public static function x_ua_compatible_headers( $headers ) {
		$headers['X-UA-Compatible'] = 'IE=edge';
		return $headers;
	}

	/**
	 * Adds CSS for ie8
	 * Applies the kindling_ie_8_url filter so you can alter your IE8 stylesheet URL
	 *
	 * @since 1.0.0
	 */
	public static function browser_dependent_css() {
		$ie_8 = apply_filters( 'kindling_ie8_stylesheet', KINDLING_CSS_DIR_URI .'ie8.css' );
		echo '<!--[if IE 8]><link rel="stylesheet" type="text/css" href="'. $ie_8 .'" media="screen"><![endif]-->';
		$ie_9 = apply_filters( 'kindling_ie9_stylesheet', KINDLING_CSS_DIR_URI .'ie9.css' );
		echo '<!--[if IE 9]><link rel="stylesheet" type="text/css" href="'. $ie_9 .'" media="screen"><![endif]-->';
	}

	/**
	 * Load HTML5 dependencies for IE8
	 *
	 * @since 1.0.0
	 */
	public static function html5_shiv() {
		echo '<!--[if lt IE 9]><script src="'. KINDLING_JS_DIR_URI .'html5.js"></script><![endif]-->';
	}

	/**
	 * Include all custom widget classes
	 *
	 * @since 1.0.0
	 */
	public static function custom_widgets() {
		if( ! version_compare( PHP_VERSION, '5.2', '>=' ) ) {
			return;
		}
		
		# Define directory for widgets
		$dir = KINDLING_INC_DIR .'widgets/';
		# Define array of custom widgets for the theme
		$widgets = apply_filters( 'kindling_custom_widgets', array(
			'about-me',
			'contact-info',
			'custom-links',
			'custom-menu',
			'facebook',
			'instagram',
			'mailchimp',
			'recent-posts',
			'social',
			'video',
			'custom-header-logo',
			'custom-header-nav',
		) );
		# Loop through widgets and load their files
		if ( $widgets && is_array( $widgets ) ) {
			foreach ( $widgets as $widget ) {
				if ( file_exists( $dir . $widget .'.php' ) ) {
					require_once( $dir . $widget .'.php' );
				}
			}
		}
	}

	/**
	 * Registers sidebars
	 *
	 * @since   1.0.0
	 */
	public static function register_sidebars() {
		# Sidebar
		register_sidebar( array(
			'name'			=> esc_html__( 'Sidebar', 'kindling' ),
			'id'			=> 'sidebar',
			'description'	=> esc_html__( 'Widgets in this area are used in the sidebar region.', 'kindling' ),
			'before_widget'	=> '<div class="sidebar-box %2$s clr">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<h5 class="widget-title">',
			'after_title'	=> '</h5>',
		) );
		# Search Results Sidebar
		if ( get_theme_mod( 'kindling_search_custom_sidebar', true ) ) {
			register_sidebar( array(
				'name'			=> esc_html__( 'Search Results Sidebar', 'kindling' ),
				'id'			=> 'search_sidebar',
				'description'	=> esc_html__( 'Widgets in this area are used in the search result page.', 'kindling' ),
				'before_widget'	=> '<div class="sidebar-box %2$s clr">',
				'after_widget'	=> '</div>',
				'before_title'	=> '<h5 class="widget-title">',
				'after_title'	=> '</h5>',
			) );
		}
		# Footer 1
		register_sidebar( array(
			'name'			=> esc_html__( 'Footer 1', 'kindling' ),
			'id'			=> 'footer-one',
			'description'	=> esc_html__( 'Widgets in this area are used in the first footer region.', 'kindling' ),
			'before_widget'	=> '<div class="footer-widget %2$s clr">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<h6 class="widget-title">',
			'after_title'	=> '</h6>',
		) );
		# Footer 2
		register_sidebar( array(
			'name'			=> esc_html__( 'Footer 2', 'kindling' ),
			'id'			=> 'footer-two',
			'description'	=> esc_html__( 'Widgets in this area are used in the second footer region.', 'kindling' ),
			'before_widget'	=> '<div class="footer-widget %2$s clr">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<h6 class="widget-title">',
			'after_title'	=> '</h6>',
		) );
		# Footer 3
		register_sidebar( array(
			'name'			=> esc_html__( 'Footer 3', 'kindling' ),
			'id'			=> 'footer-three',
			'description'	=> esc_html__( 'Widgets in this area are used in the third footer region.', 'kindling' ),
			'before_widget'	=> '<div class="footer-widget %2$s clr">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<h6 class="widget-title">',
			'after_title'	=> '</h6>',
		) );
		# Footer 4
		register_sidebar( array(
			'name'			=> esc_html__( 'Footer 4', 'kindling' ),
			'id'			=> 'footer-four',
			'description'	=> esc_html__( 'Widgets in this area are used in the fourth footer region.', 'kindling' ),
			'before_widget'	=> '<div class="footer-widget %2$s clr">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<h6 class="widget-title">',
			'after_title'	=> '</h6>',
		) );
	}

	/**
	 * Registers theme_mod strings into Polylang.
	 *
	 * @since 1.1.4
	 */
	public static function polylang_register_string() {
		if ( function_exists( 'pll_register_string' ) && $strings = kindling_register_tm_strings() ) {
			foreach( $strings as $string => $default ) {
				pll_register_string( $string, get_theme_mod( $string, $default ), 'Theme Mod', true );
			}
		}
	}

	/**
	 * Registers theme_mod strings into WPML.
	 *
	 * @since 1.1.4
	 */
	public static function wpml_register_string() {
		if ( function_exists( 'icl_register_string' ) && $strings = kindling_register_tm_strings() ) {
			foreach( $strings as $string => $default ) {
				icl_register_string( 'Theme Mod', $string, get_theme_mod( $string, $default ) );
			}
		}
	}

	/**
	 * All theme functions hook into the kindling_head_css filter for this function.
	 *
	 * @since 1.0.0
	 */
	public static function custom_css( $output = NULL ) {
		# Add filter for adding custom css via other functions
		$output = apply_filters( 'kindling_head_css', $output );
		# Minify and output CSS in the wp_head
		if ( ! empty( $output ) ) {
			echo "<!-- Kindling CSS -->\n<style type=\"text/css\">\n" . wp_strip_all_tags( kindling_minify_css( $output ) ) . "\n</style>";
		}
	}

	/**
	 * All theme functions hook into the kindling_footer_js filter for this function.
	 *
	 * @since 1.1.0
	 */
	public static function custom_js( $output = NULL ) {
		# Add filter for adding custom js via other functions
		$output = apply_filters( 'kindling_footer_js', $output );
		# Minify and output JS in the wp_footer
		if ( ! empty( $output ) ) { ?>
			<script type="text/javascript">
				/* Kindling JS */
				<?php echo kindling_minify_js( $output ); ?>
			</script>
		<?php
		}
	}

	/**
	 * Adds inline CSS for the admin
	 *
	 * @since 1.0.0
	 */
	public static function admin_inline_css() {
		echo '<style>div#setting-error-tgmpa{display:block;}</style>';
	}

	/**
	 * Alters the default WordPress tag cloud widget arguments.
	 * Makes sure all font sizes for the cloud widget are set to 1em.
	 *
	 * @since 1.0.0 
	 */
	public static function widget_tag_cloud_args( $args ) {
		$args['largest']  = '0.923em';
		$args['smallest'] = '0.923em';
		$args['unit']     = 'em';
		return $args;
	}

	/**
	 * Alter wp list categories arguments.
	 * Adds a span around the counter for easier styling.
	 *
	 * @since 1.0.0
	 */
	public static function wp_list_categories_args( $links ) {
		$links = str_replace( '</a> (', '</a> <span class="cat-count-span">(', $links );
		$links = str_replace( ' )', ' )</span>', $links );
		return $links;
	}

	/**
	 * Alters the default oembed output.
	 * Adds special classes for responsive oembeds via CSS.
	 *
	 * @since 1.0.0
	 */
	public static function add_responsive_wrap_to_oembeds( $cache, $url, $attr, $post_ID ) {
		# Supported video embeds
		$hosts = apply_filters( 'kindling_oembed_responsive_hosts', array(
			'vimeo.com',
			'youtube.com',
			'blip.tv',
			'money.cnn.com',
			'dailymotion.com',
			'flickr.com',
			'hulu.com',
			'kickstarter.com',
			'vine.co',
			'soundcloud.com',
			'#http:#((m|www)\.)?youtube\.com/watch.*#i',
	        '#https:#((m|www)\.)?youtube\.com/watch.*#i',
	        '#http:#((m|www)\.)?youtube\.com/playlist.*#i',
	        '#https:#((m|www)\.)?youtube\.com/playlist.*#i',
	        '#http:#youtu\.be/.*#i',
	        '#https:#youtu\.be/.*#i',
	        '#https?:#(.+\.)?vimeo\.com/.*#i',
	        '#https?:#(www\.)?dailymotion\.com/.*#i',
	        '#https?:#dai.ly/*#i',
	        '#https?:#(www\.)?hulu\.com/watch/.*#i',
	        '#https?:#wordpress.tv/.*#i',
	        '#https?:#(www\.)?funnyordie\.com/videos/.*#i',
	        '#https?:#vine.co/v/.*#i',
	        '#https?:#(www\.)?collegehumor\.com/video/.*#i',
	        '#https?:#(www\.|embed\.)?ted\.com/talks/.*#i'
		) );

		# Supports responsive
		$supports_responsive = false;
		# Check if responsive wrap should be added
		foreach( $hosts as $host ) {
			if ( strpos( $url, $host ) !== false ) {
				$supports_responsive = true;
				break; # no need to loop further
			}
		}
		# Output code
		if ( $supports_responsive ) {
			return '<p class="responsive-video-wrap clr">' . $cache . '</p>';
		} else {
			return '<div class="kindling-oembed-wrap clr">' . $cache . '</div>';
		}
	}

	/**
	 * Adds extra classes to the post_class() output
	 *
	 * @since 1.0.0
	 */
	public static function post_class( $classes ) {
		# Get post
		global $post;
		# Add entry class
		$classes[] = 'entry';
		# Add has media class
		if ( has_post_thumbnail()
			|| get_post_meta( $post->ID, 'kindling_post_oembed', true )
			|| get_post_meta( $post->ID, 'kindling_post_self_hosted_media', true )
			|| get_post_meta( $post->ID, 'kindling_post_video_embed', true )
		) {
			$classes[] = 'has-media';
		}

		# Return classes
		return $classes;
	}

	/**
	 * Add schema markup to the authors post link
	 *
	 * @since 1.0.0
	 */
	public static function the_author_posts_link( $link ) {
		# Add schema markup
		$schema = 'itemprop="author" itemscope itemtype="//schema.org/Person"';
		if ( $schema ) {
			$link = str_replace( 'rel="author"', 'rel="author"'. $schema, $link );
		}
		# Return link
		return $link;
	}

}
$Kindling_Theme_Class = new Kindling_Theme_Class;