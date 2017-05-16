<?php
/**
 * This file includes helper functions used throughout the theme.
 *
 * @package Kindling Theme
 * @link    http://wpexplorer-themes.com/total/
 */

/*-------------------------------------------------------------------------------*/
/* [ Table of Contents ]
/*-------------------------------------------------------------------------------*

	# General
	# Top Bar
	# Header
	# Page Header
	# Blog
	# Footer
	# WooCommerce
	# Other

/*-------------------------------------------------------------------------------*/
/* [ General ]
/*-------------------------------------------------------------------------------*/

/**
 * Adds classes to the body tag
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_body_classes' ) ) {

	function kindling_body_classes( $classes ) {

		// Save some vars
		$post_layout  = kindling_post_layout();
		$post_id      = kindling_post_id();

		// RTL
		if ( is_RTL() ) {
			$classes[] = 'rtl';
		}
		
		// Main class
		$classes[] = 'kindling-theme';

		// Boxed layout
		if ( 'boxed' == get_theme_mod( 'kindling_main_layout_style', 'wide' ) ) {
			$classes[] = 'boxed-main-layout';

			if ( get_theme_mod( 'kindling_boxed_dropdshadow', true ) ) {
				$classes[] = 'wrap-boxshadow';
			}
		}

		// Top menu header style to control the responsive
		if ( 'top' == kindling_header_style() ) {
			$classes[] = 'top-header-style';
		}

		// Sidebar enabled
		if ( 'left-sidebar' == $post_layout || 'right-sidebar' == $post_layout ) {
			$classes[] = 'has-sidebar';
		}

		// Content layout
		if ( $post_layout ) {
			$classes[] = 'content-'. $post_layout;
		}

		// Single Post cagegories
		if ( is_singular( 'post' ) ) {
			$cats = get_the_category( $post_id );
			foreach ( $cats as $cat ) {
				$classes[] = 'post-in-category-'. $cat->category_nicename;
			}
		}

		// If landing page template
		if ( is_page_template( 'templates/landing.php' ) ) {
			$classes[] = 'landing-page';
		}

		// Topbar
		if ( kindling_display_topbar() ) {
			$classes[] = 'has-topbar';
		}

		// Transparent header style
		if ( 'transparent' == kindling_header_style() ) {
			$classes[] = 'has-transparent-header';
		}

		// If no header border bottom
		if ( true != get_theme_mod( 'kindling_has_header_border_bottom', true ) ) {
			$classes[] = 'no-header-border';
		}

		// Title with Background Image
		if ( 'background-image' == kindling_page_header_style() ) {
			$classes[] = 'page-with-background-title';
		}

		// Disabled header
		if ( ! kindling_has_page_header() ) {
			$classes[] = 'page-header-disabled';
		}

		// Breadcrumbs
		if ( get_theme_mod( 'kindling_breadcrumbs', true ) ) {
			$classes[] = 'has-breadcrumbs';
		}

		// Disabled margins
		if ( 'on' == get_post_meta( get_the_ID(), 'kindling_disable_margins', true ) ) {
			$classes[] = 'no-margins';
		}

		// If WooCommerce grid/list buttons
		if ( KINDLING_WOOCOMMERCE_ACTIVE
			&& get_theme_mod( 'kindling_woo_grid_list', true ) ) {
			$classes[] = 'has-grid-list';
		}
		
		// Return classes
		return $classes;

	}

	add_filter( 'body_class', 'kindling_body_classes' );

}

/**
 * Store current post ID
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_post_id' ) ) {

	function kindling_post_id() {

		// If singular get_the_ID
		if ( is_singular() ) {
			return get_the_ID();
		}

		// Get ID of WooCommerce product archive
		elseif ( KINDLING_WOOCOMMERCE_ACTIVE && is_shop() ) {
			$shop_id = wc_get_page_id( 'shop' );
			if ( isset( $shop_id ) ) {
				return $shop_id;
			}
		}

		// Posts page
		elseif ( is_home() && $page_for_posts = get_option( 'page_for_posts' ) ) {
			return $page_for_posts;
		}

		// Return nothing
		else {
			return NULL;
		}

	}

}

/**
 * Returns correct post layout
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_post_layout' ) ) {

	function kindling_post_layout() {

		// Check URL
		if ( ! empty( $_GET['post_layout'] ) ) {
			return $_GET['post_layout'];
		}

		// Define variables
		$class  = 'right-sidebar';
		$meta   = get_post_meta( kindling_post_id(), 'kindling_post_layout', true );

		// Check meta first to override and return (prevents filters from overriding meta)
		if ( $meta ) {
			return $meta;
		}

		// Singular Page
		if ( is_page() ) {

			// Landing template
			if ( is_page_template( 'templates/landing.php' ) ) {
				$class = 'full-width';
			}

			// Attachment
			elseif ( is_attachment() ) {
				$class = 'full-width';
			}

			// All other pages
			else {
				$class = get_theme_mod( 'kindling_page_single_layout', 'right-sidebar' );
			}

		}

		// Singular Post
		elseif ( is_singular( 'post' ) ) {

			$class = get_theme_mod( 'kindling_blog_single_layout', 'right-sidebar' );

		}

		// Home
		elseif ( is_home() ) {
			$class = get_theme_mod( 'kindling_blog_archives_layout', 'right-sidebar' );
		}

		// Search
		elseif ( is_search() ) {
			$class = get_theme_mod( 'kindling_search_layout', 'right-sidebar' );
		}

		// Standard Categories
		elseif ( is_category() ) {
			$class     = get_theme_mod( 'kindling_blog_archives_layout', 'right-sidebar' );
			$term      = get_query_var( 'cat' );
			$term_data = get_option( "category_$term" );
			if ( $term_data ) {
				if( ! empty( $term_data['kindling_term_layout'] ) ) {
					$class = $term_data['kindling_term_layout'];
				}
			}
		}
		
		// 404 page
		elseif ( is_404() ) {
			$class = 'full-width';
		}

		// All else
		else {
			$class = 'right-sidebar';
		}

		// Class should never be empty
		if ( empty( $class ) ) {
			$class = 'right-sidebar';
		}

		// Apply filters and return
		return apply_filters( 'kindling_post_layout_class', $class );

	}

}

/**
 * Returns the correct sidebar ID
 *
 * @since  1.0.0
 */
if ( ! function_exists( 'kindling_get_sidebar' ) ) {

	function kindling_get_sidebar( $sidebar = 'sidebar' ) {

		// Search
		if ( is_search() ) {
			$sidebar = 'search_sidebar';
		}
		
		// Add filter for tweaking the sidebar display via child theme's
		$sidebar = apply_filters( 'kindling_get_sidebar', $sidebar );

		// Check meta option after filter so it always overrides
		if ( $meta = get_post_meta( get_the_ID(), 'kindling_sidebar', true ) ) {
			$sidebar = $meta;
		}

		// Never show empty sidebar
		if ( ! is_active_sidebar( $sidebar ) ) {
			$sidebar = 'sidebar';
		} 

		// Return the correct sidebar
		return $sidebar;
		
	}

}

/**
 * Returns the correct classname for any specific column grid
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_grid_class' ) ) {

	function kindling_grid_class( $col = '4' ) {
		return esc_attr( apply_filters( 'kindling_grid_class', 'span_1_of_'. $col ) );
	}

}

/**
 * Removes the scheme of the passed URL to fit the current page.
 *
 * @since 1.1.1
 */
if ( ! function_exists( 'kindling_correct_url_scheme' ) ) {

	function kindling_correct_url_scheme( $url ) {

		$url = str_replace( 'http://', '//', str_replace( 'https://', '//', $url ) );

		return $url;
	}

}

/**
 * Gets the attachment ID from the url
 *
 * @since 1.1.1
 */
if ( ! function_exists( 'kindling_get_attachment_id_from_url' ) ) {

	function kindling_get_attachment_id_from_url( $attachment_url = '' ) {

		global $wpdb;
		$attachment_id = false;

		if ( '' == $attachment_url || ! is_string( $attachment_url ) ) {
			return '';
		}

		$upload_dir_paths = wp_upload_dir();
		$upload_dir_paths_baseurl = $upload_dir_paths['baseurl'];

		if ( substr( $attachment_url, 0, 2 ) == '//' ) {
			$upload_dir_paths_baseurl = kindling_correct_url_scheme( $upload_dir_paths_baseurl );
		}

		// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image.
		if ( false !== strpos( $attachment_url, $upload_dir_paths_baseurl ) ) {

			// If this is the URL of an auto-generated thumbnail, get the URL of the original image.
			$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif|tiff|svg)$)/i', '', $attachment_url );

			// Remove the upload path base directory from the attachment URL.
			$attachment_url = str_replace( $upload_dir_paths_baseurl . '/', '', $attachment_url );

			// Run a custom database query to get the attachment ID from the modified attachment URL.
			$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
			$attachment_id = apply_filters( 'wpml_object_id', $attachment_id, 'attachment' );
		}

		return $attachment_id;

	}

}

/**
 * Gets the most important attachment data from the url
 *
 * @since 1.1.1
 */
if ( ! function_exists( 'kindling_get_attachment_data_from_url' ) ) {

	function kindling_get_attachment_data_from_url( $attachment_url = '' ) {

		if ( '' == $attachment_url ) {
			return false;
		}

		$attachment_data['url'] = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
		$attachment_data['id'] = kindling_get_attachment_id_from_url( $attachment_data['url'] );

		if ( ! $attachment_data['id'] ) {
			return false;
		}

		preg_match( '/\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', $attachment_url, $matches );
		if ( count( $matches ) > 0 ) {
			$dimensions 				= explode( 'x', $matches[0] );
			$attachment_data['width'] 	= $dimensions[0];
			$attachment_data['height'] 	= $dimensions[1];
		} else {
			$attachment_src 			= wp_get_attachment_image_src( $attachment_data['id'], 'full' );
			$attachment_data['width'] 	= $attachment_src[1];
			$attachment_data['height'] 	= $attachment_src[2];
		}

		$attachment_data['alt'] 	= get_post_field( '_wp_attachment_image_alt', $attachment_data['id'] );
		$attachment_data['caption'] = get_post_field( 'post_excerpt', $attachment_data['id'] );
		$attachment_data['title'] 	= get_post_field( 'post_title', $attachment_data['id'] );

		return $attachment_data;
	}

}

/*-------------------------------------------------------------------------------*/
/* [ Top Bar ]
/*-------------------------------------------------------------------------------*/

/**
 * Display top bar
 *
 * @since 1.1.2
 */
##if ( ! function_exists( 'kindling_display_topbar' ) ) {
##
##	function kindling_display_topbar() {
##
##		// Return true by default
##		$return = true;
##
##		// Return false if disabled via Customizer
##		if ( true != get_theme_mod( 'kindling_top_bar', true ) ) {
##			$return = false;
##		}
##
##		// Check meta
##		$meta = kindling_post_id() ? get_post_meta( kindling_post_id(), 'kindling_display_top_bar', true ) : '';
##
##		// Check if disabled via meta option
##		if ( 'on' == $meta ) {
##			$return = true;
##		} elseif ( 'off' == $meta ) {
##			$return = false;
##		}
##
##		// Apply filters and return
##		return apply_filters( 'kindling_display_top_bar', $return );
##
##	}
##
##}
##
##/**
## * Add classes to the top bar wrap
## *
## * @since 1.0.0
## */
##if ( ! function_exists( 'kindling_topbar_classes' ) ) {
##
##	function kindling_topbar_classes() {
##
##		// Setup classes array
##		$classes = array();
##
##		// Clearfix class
##		$classes[] = 'clr';
##
##		// Set keys equal to vals
##		$classes = array_combine( $classes, $classes );
##		
##		// Apply filters for child theming
##		$classes = apply_filters( 'kindling_topbar_classes', $classes );
##
##		// Turn classes into space seperated string
##		$classes = implode( ' ', $classes );
##
##		// return classes
##		return $classes;
##
##	}
##
##}
##
##/**
## * Topbar style
## *
## * @since 1.0.0
## */
##if ( ! function_exists( 'kindling_top_bar_style' ) ) {
##
##	function kindling_top_bar_style() {
##		$style = get_theme_mod( 'kindling_top_bar_style' );
##		$style = $style ? $style : 'one';
##		return apply_filters( 'kindling_top_bar_style', $style );
##	}
##
##
##}
##/**
## * Topbar Content classes
## *
## * @since 1.0.0
## */
##if ( ! function_exists( 'kindling_topbar_content_classes' ) ) {
##
##	function kindling_topbar_content_classes() {
##
##		// Define classes
##		$classes = array( 'clr' );
##
##		// Check for content
##		if ( get_theme_mod( 'kindling_top_bar_content' ) ) {
##			$classes[] = 'has-content';
##		}
##
##		// Get topbar style
##		$style = kindling_top_bar_style();
##
##		// Add classes based on top bar style only if social is enabled
##		if ( get_theme_mod( 'kindling_top_bar_social', true ) ) {
##			if ( 'one' == $style ) {
##				$classes[] = 'top-bar-left';
##			} elseif ( 'two' == $style ) {
##				$classes[] = 'top-bar-right';
##			} elseif ( 'three' == $style ) {
##				$classes[] = 'top-bar-centered';
##			}
##		}
##
##		// Apply filters for child theming
##		$classes = apply_filters( 'kindling_top_bar_classes', $classes );
##
##		// Turn classes array into space seperated string
##		$classes = implode( ' ', $classes );
##
##		// Return classes
##		return esc_attr( $classes );
##
##	}
##
##}
##
##/**
## * Returns topbar social alt
## *
## * @since 1.0.0
## */
##if ( ! function_exists( 'kindling_top_bar_social_alt' ) ) {
##
##	function kindling_top_bar_social_alt() {
##
##		// Get page ID from Customizer
##		$content = get_theme_mod( 'kindling_top_bar_social_alt' );
##
##		// Get page content
##		if ( ! empty( $content ) ) {
##
##			$page = get_post( $content );
##
##			if ( $page && ! is_wp_error( $page ) ) {
##				$content = $page->post_content;
##			}
##
##		}
##
##		// Return content
##		return $content;
##
##	}
##
##}

/*-------------------------------------------------------------------------------*/
/* [ Header ]
/*-------------------------------------------------------------------------------*/

/**
 * Display header
 *
 * @since 1.1.2
 */
if ( ! function_exists( 'kindling_display_header' ) ) {

	function kindling_display_header() {

		// Return true by default
		$return = true;

		// Check meta
		$meta = kindling_post_id() ? get_post_meta( kindling_post_id(), 'kindling_display_header', true ) : '';

		// Check if disabled via meta option
		if ( 'on' == $meta ) {
			$return = true;
		} elseif ( 'off' == $meta ) {
			$return = false;
		}

		// Apply filters and return
		return apply_filters( 'kindling_display_header', $return );

	}

}

/**
 * Header style
 *
 * @since 1.1.2
 */
if ( ! function_exists( 'kindling_header_style' ) ) {

	function kindling_header_style() {

		// Get style from customizer setting
		$style = get_theme_mod( 'kindling_header_style', 'minimal' );

		// Sanitize style to make sure it isn't empty
		$style = $style ? $style : 'minimal';

		// Apply filters and return
		return apply_filters( 'kindling_header_style', $style );

	}

}

/**
 * Add classes to the header wrap
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_header_classes' ) ) {

	function kindling_header_classes() {

		// Header style
		$header_style = kindling_header_style();

		// Setup classes array
		$classes = array();

		// Add header style class
		$classes[] = $header_style . '-header';

		// Search overlay
		if ( 'overlay' == kindling_menu_search_style() ) {
			$classes[] = 'search-overlay';
		}

		// Add class if social menu is enabled
		if ( true == get_theme_mod( 'kindling_menu_social', false ) ) {
			$classes[] = 'has-social';
		}

		// Menu position
		if ( 'left-menu' == get_theme_mod( 'kindling_menu_position', 'right-menu' )
			&& ( 'top' != $header_style ) ) {
			$classes[] = 'left-menu';
		}

		// If the search header replace
		if ( 'header_replace' == kindling_menu_search_style() ) {
			$classes[] = 'header-replace';
		}

		// Clearfix class
		$classes[] = 'clr';

		// Set keys equal to vals
		$classes = array_combine( $classes, $classes );
		
		// Apply filters for child theming
		$classes = apply_filters( 'kindling_header_classes', $classes );

		// Turn classes into space seperated string
		$classes = implode( ' ', $classes );

		// return classes
		return $classes;

	}

}

/**
 * Returns header page ID
 *
 * @since 1.1.1
 */
if ( ! function_exists( 'kindling_header_page_id' ) ) {

	function kindling_header_page_id() {

		// Return false if custom header is not selected
		if ( 'custom' != kindling_header_style() ) {
			return false;
		}

		// Get page ID from Customizer
		$page_id = get_theme_mod( 'kindling_header_page_id' );

		// Get page content
		if ( ! empty( $page_id ) ) {

			$page = get_post( $page_id );

			if ( $page && ! is_wp_error( $page ) ) {
				$page_id = $page->post_content;
			}

		}

		// Apply filters and return content
		return apply_filters( 'kindling_header_page_id', $page_id );

	}

}

/**
 * Returns full screen header logo
 *
 * @since 1.0.4
 */
if ( ! function_exists( 'kindling_header_full_screen_logo' ) ) {

	function kindling_header_full_screen_logo() {

		// Return false if disabled
		if ( 'full_screen' != kindling_header_style() ) {
			return false;
		}

		$html = '';

		// Get logo
		$logo_url 		= get_theme_mod( 'kindling_full_screen_header_logo' );

		// Logo data
		$logo_data = array(
			'url'    	=> '',
			'width'  	=> '',
			'height' 	=> '',
			'alt' 		=> '',
		);

		if ( $logo_url ) {

			// Logo url
			$logo_data['url'] 			= $logo_url;

			// Logo data
			$logo_attachment_data 		= kindling_get_attachment_data_from_url( $logo_url );

			// Get logo data
			if ( $logo_attachment_data ) {
				$logo_data['width']  	= $logo_attachment_data['width'];
				$logo_data['height'] 	= $logo_attachment_data['height'];
				$logo_data['alt'] 		= $logo_attachment_data['alt'];
			}

			// Output image
			$html = sprintf( '<a href="%1$s" class="full-screen-logo-link" rel="home" itemprop="url"><img src="%2$s" class="full-screen-logo" width="%3$s" height="%4$s" alt="%5$s" itemprop="url" /></a>',
				esc_url( home_url( '/' ) ),
				esc_url( $logo_data['url'] ),
				esc_attr( $logo_data['width'] ),
				esc_attr( $logo_data['height'] ),
				esc_attr( $logo_data['alt'] )
			);

		}

		// Return logo
		return apply_filters( 'kindling_full_screen_header_logo', $html );

	}

}

/**
 * Echo full_screen header logo
 *
 * @since 1.1.1
 */
if ( ! function_exists( 'the_custom_full_screen_logo' ) ) {

	function the_custom_full_screen_logo() {
		echo kindling_header_full_screen_logo();
	}

}

/**
 * Returns correct menu classes
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_header_menu_classes' ) ) {

	function kindling_header_menu_classes( $return ) {

		// Define classes array
		$classes = array();

		// Return wrapper classes
		if ( 'wrapper' == $return ) {

			// Add special class if the dropdown top border option in the admin is disabled
			if ( true != get_theme_mod( 'kindling_menu_dropdown_top_border', true ) ) {
				$classes[] = 'kindling-dropdown-top-border';
			}

			// Add clearfix
			$classes[] = 'clr';

			// Set keys equal to vals
			$classes = array_combine( $classes, $classes );

			// Apply filters
			$classes = apply_filters( 'kindling_header_menu_wrap_classes', $classes );

		}

		// Inner Classes
		elseif ( 'inner' == $return ) {

			// Core
			$classes[] = 'navigation';
			$classes[] = 'main-navigation';
			$classes[] = 'clr';

			// Add class if current link has background
			if ( '' != get_theme_mod( 'kindling_menu_link_active_background' ) ) {
				$classes[] = 'has-current-style';
			}

			// Set keys equal to vals
			$classes = array_combine( $classes, $classes );

			// Apply filters
			$classes = apply_filters( 'kindling_header_menu_classes', $classes );

		}

		// Return
		if ( is_array( $classes ) ) {
			return implode( ' ', $classes );
		} else {
			return $return;
		}

	}

}

/**
 * Returns custom menu
 *
 * @since 1.1.2
 */
if ( ! function_exists( 'kindling_header_custom_menu' ) ) {

	function kindling_header_custom_menu() {

		$menu = get_post_meta( kindling_post_id(), 'kindling_header_custom_menu', true );
		$menu = 'default' != $menu ? $menu : '';
		return apply_filters( 'kindling_custom_menu', $menu );

	}

}

/**
 * Header logo classes
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_header_logo_classes' ) ) {

	function kindling_header_logo_classes() {

		// Define classes array
		$classes = array( 'clr' );

		// If retina logo
		if ( '' != get_theme_mod( 'kindling_retina_logo' ) ) {
			$classes[] = 'has-retina-logo';
		}

		// Get custom transparent logo
		if ( 'transparent' == kindling_header_style()
			&& kindling_header_transparent_logo() ) {
			$classes[] = 'has-transparent-logo';
		}

		// Get custom full screen logo
		if ( 'full_screen' == kindling_header_style()
			&& kindling_header_full_screen_logo() ) {
			$classes[] = 'has-full-screen-logo';
		}

		// Apply filters for child theming
		$classes = apply_filters( 'kindling_header_logo_classes', $classes );

		// Turn classes into space seperated string
		$classes = implode( ' ', $classes );

		// Return classes
		return $classes;

	}

}

/**
 * Returns menu search style
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_menu_search_style' ) ) {

	function kindling_menu_search_style() {

		// Get search style from Customizer
		$style = get_theme_mod( 'kindling_menu_search_style', 'drop_down' );

		// Apply filters for advanced edits
		$style = apply_filters( 'kindling_menu_search_style', $style );

		// Sanitize output so it's not empty and return
		$style = $style ? $style : 'drop_down';

		// Return style
		return $style;

	}

}

/**
 * Adds the search icon to the menu items
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_add_search_to_menu' ) ) {

	function kindling_add_search_to_menu( $items, $args ) {

		// Only used on main menu
		if ( 'main_menu' != $args->theme_location ) {
			return $items;
		}

		// Get search style
		$search_style = kindling_menu_search_style();
		$header_style = kindling_header_style();

		// Return if disabled
		if ( ! $search_style
			|| 'disabled' == $search_style
			|| 'top' == $header_style ) {
			return $items;
		}
		
		// Get correct search icon class
		if ( 'drop_down' == $search_style ) {
			$class = ' search-dropdown-toggle';
		} elseif ( 'header_replace' == $search_style ) {
			$class = ' search-header-replace-toggle';
		} elseif ( 'overlay' == $search_style ) {
			$class = ' search-overlay-toggle';
		} else {
			$class = '';
		}

		// Add search item to menu
		$items .= '<li class="search-toggle-li">';
			if ( 'full_screen' == $header_style ) {
				$items .= '<form method="get" action="'. esc_url( home_url( '/' ) ) .'" class="header-searchform">';
					$items .= '<input type="search" name="s" value="" autocomplete="off" />';
					$items .= '<label>'. esc_html__( 'Type your search', 'kindling' ) .'<span><i></i><i></i><i></i></span></label>';
				$items .= '</form>';
			} else {
				$items .= '<a href="#" class="site-search-toggle'. $class .'">';
					if ( 'center' == $header_style ) {
						$items .= '<span>'. esc_html__( 'Search', 'kindling' ) .'</span>';
					} else {
						$items .= '<span class="icon-magnifier"></span>';
					}
				$items .= '</a>';
			}
		$items .= '</li>';
		
		// Return nav $items
		return $items;

	}

	add_filter( 'wp_nav_menu_items', 'kindling_add_search_to_menu', 11, 2 );

}

/**
 * Outputs the search for the top header style
 *
 * @since 1.0.2
 */
if ( ! function_exists( 'kindling_top_header_search' ) ) {

	function kindling_top_header_search() {

		// Get header & search style
		$search_style = kindling_menu_search_style();

		// Return if disabled
		if ( 'top' != kindling_header_style()
			|| ! $search_style
			|| 'disabled' == $search_style ) {
			return;
		}
		
		// Get correct search icon class
		if ( 'drop_down' == $search_style ) {
			$class = ' search-dropdown-toggle';
		} elseif ( 'header_replace' == $search_style ) {
			$class = ' search-header-replace-toggle';
		} elseif ( 'overlay' == $search_style ) {
			$class = ' search-overlay-toggle';
		} else {
			$class = '';
		}

		// Add search item to menu
		echo '<div id="search-toggle">';
			echo '<a href="#" class="site-search-toggle'. $class .'">';
				echo '<span class="icon-magnifier"></span>';
			echo '</a>';
		echo '</div>';
		
	}

}

/**
 * Returns header search style
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_menu_cart_style' ) ) {

	function kindling_menu_cart_style() {

		// Return if WooCommerce isn't enabled or icon is disabled
		if ( ! KINDLING_WOOCOMMERCE_ACTIVE || 'disabled' == get_theme_mod( 'kindling_woo_menu_icon_display', 'icon_count' ) ) {
			return;
		}

		// Get Menu Icon Style
		$style = get_theme_mod( 'kindling_woo_menu_icon_style', 'drop_down' );

		// Return click style for these pages
		if ( is_cart() || is_checkout() ) {
			$style = 'custom_link';
		}

		// Apply filters for advanced edits
		$style = apply_filters( 'kindling_menu_cart_style', $style );

		// Sanitize output so it's not empty
		if ( 'drop_down' == $style || ! $style ) {
			$style = 'drop_down';
		}

		// Return style
		return $style;

	}

}

/*-------------------------------------------------------------------------------*/
/* [ Page Header ]
/*-------------------------------------------------------------------------------*/

/**
 * Checks if the page header is enabled
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_has_page_header' ) ) {

	function kindling_has_page_header() {
		
		// Define vars
		$return = true;
		$style  = kindling_page_header_style();

		// Return if page header is disabled via custom field
		if ( kindling_post_id() ) {

			// Return if page header is disabled and there isn't a page header background defined
			if ( 'on' == get_post_meta( kindling_post_id(), 'kindling_disable_title', true ) ) {
				$return	= false;
			}

		}

		// Check if page header style is set to hidden
		if ( 'hidden' == $style || is_page_template( 'templates/landing.php' ) ) {
			$return = false;
		}

		// Apply filters and return
		return apply_filters( 'kindling_display_page_header', $return );

	}

}

/**
 * Returns page header style
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_page_header_style' ) ) {

	function kindling_page_header_style() {

		// Get default page header style defined in Customizer
		$style = get_theme_mod( 'kindling_page_header_style' );

		// Get for header style defined in page settings
		if ( $meta = get_post_meta( kindling_post_id(), 'kindling_post_title_style', true ) ) {
			$style = $meta;
		}

		// If featured image in page header
		if ( true == get_theme_mod( 'kindling_blog_single_featured_image_title', false )
			&& is_singular( 'post' )
			&& has_post_thumbnail() ) {
			$style = 'background-image';
		}

		// Sanitize data
		$style = ( 'default' == $style ) ? '' : $style;
		
		// Apply filters and return
		return apply_filters( 'kindling_page_header_style', $style );

	}

}

/**
 * Return the title
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_title' ) ) {

	function kindling_title() {

		// Default title is null
		$title = NULL;
		
		// Get post ID
		$post_id = kindling_post_id();
		
		// Homepage - display blog description if not a static page
		if ( is_front_page() && ! is_singular( 'page' ) ) {
			
			if ( get_bloginfo( 'description' ) ) {
				$title = get_bloginfo( 'description' );
			} else {
				return esc_html__( 'Recent Posts', 'kindling' );
			}

		// Homepage posts page
		} elseif ( is_home() && ! is_singular( 'page' ) ) {

			$title = get_the_title( get_option( 'page_for_posts', true ) );

		}

		// Search needs to go before archives
		elseif ( is_search() ) {
			global $wp_query;
			$title = '<span id="search-results-count">'. $wp_query->found_posts .'</span> '. esc_html__( 'Search Results Found', 'kindling' );
		}
			
		// Archives
		elseif ( is_archive() ) {

			// Author
			if ( is_author() ) {
				$title = get_the_archive_title();
			}

			// Post Type archive title
			elseif ( is_post_type_archive() ) {
				$title = post_type_archive_title( '', false );
			}

			// Daily archive title
			elseif ( is_day() ) {
				$title = sprintf( esc_html__( 'Daily Archives: %s', 'kindling' ), get_the_date() );
			}

			// Monthly archive title
			elseif ( is_month() ) {
				$title = sprintf( esc_html__( 'Monthly Archives: %s', 'kindling' ), get_the_date( esc_html_x( 'F Y', 'Page title monthly archives date format', 'kindling' ) ) );
			}

			// Yearly archive title
			elseif ( is_year() ) {
				$title = sprintf( esc_html__( 'Yearly Archives: %s', 'kindling' ), get_the_date( esc_html_x( 'Y', 'Page title yearly archives date format', 'kindling' ) ) );
			}

			// Categories/Tags/Other
			else {

				// Get term title
				$title = single_term_title( '', false );

				// Fix for plugins that are archives but use pages
				if ( ! $title ) {
					global $post;
					$title = get_the_title( $post_id );
				}

			}

		} // End is archive check

		// 404 Page
		elseif ( is_404() ) {

			$title = esc_html__( '404: Page Not Found', 'kindling' );

		}
		
		// Anything else with a post_id defined
		elseif ( $post_id ) {

			// Single Pages
			if ( is_singular( 'page' ) || is_singular( 'attachment' ) ) {
				$title = get_the_title( $post_id );
			}

			// Single blog posts
			elseif ( is_singular( 'post' ) ) {

				if ( 'post-title' == get_theme_mod( 'kindling_blog_single_page_header_title', 'blog' ) ) {
					$title = get_the_title();
				} else {
					$title = esc_html__( 'Blog', 'kindling' );
				}

			}

			// Other posts
			else {

				$title = get_the_title( $post_id );
				
			}

			// Custom meta title
			if ( $meta = get_post_meta( $post_id, 'kindling_post_title', true ) ) {
				$title = $meta;
			}

		}

		// Last check if title is empty
		$title = $title ? $title : get_the_title();

		// Apply filters and return title
		return apply_filters( 'kindling_title', $title );
		
	}

}

/**
 * Returns page subheading
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_get_page_subheading' ) ) {

	function kindling_get_page_subheading() {

		// Subheading is NULL by default
		$subheading = NULL;

		// Posts & Pages
		if ( $meta = get_post_meta( kindling_post_id(), 'kindling_post_subheading', true ) ) {
			$subheading = $meta;
		}

		// Search
		elseif ( is_search() ) {
			$subheading = esc_html__( 'You searched for:', 'kindling' ) .' &quot;'. esc_html( get_search_query( false ) ) .'&quot;';
		}

		// Author
		elseif ( is_author() ) {
			$subheading = esc_html__( 'This author has written', 'kindling' ) .' '. get_the_author_posts() .' '. esc_html__( 'articles', 'kindling' );
		}

		// Archives
		elseif ( is_post_type_archive() ) {
			$subheading = get_the_archive_description();
		}

		// All other Taxonomies
		elseif ( is_tax() ) {
			$subheading = term_description();
		}

		// Apply filters and return
		return apply_filters( 'kindling_post_subheading', $subheading );

	}

}

/**
 * Outputs Custom CSS for the page title
 *
 * @since 1.0.4
 */
if ( ! function_exists( 'kindling_page_header_overlay' ) ) {

	function kindling_page_header_overlay() {

		// Define return
		$return = '';

		// Only needed for the background-image style so return otherwise
		if ( 'background-image' != kindling_page_header_style() ) {
			return;
		}

		// Get options
		$overlay 			= get_theme_mod( 'kindling_page_header_bg_image_overlay_opacity', '0.5' );
		$overlay_color 		= get_theme_mod( 'kindling_page_header_bg_image_overlay_color', '#000000' );

		if ( true == get_theme_mod( 'kindling_blog_single_featured_image_title', false )
			&& is_singular( 'post' ) ) {
			$overlay 		= get_theme_mod( 'kindling_blog_single_title_bg_image_overlay_opacity', '0.5' );
			$overlay_color 	= get_theme_mod( 'kindling_blog_single_title_bg_image_overlay_color', '#000000' );
		}

		if ( 'background-image' == get_post_meta( kindling_post_id(), 'kindling_post_title_style', true ) ) {

			if ( $meta_overlay = get_post_meta( kindling_post_id(), 'kindling_post_title_bg_overlay', true ) ) {
				$overlay 		= $meta_overlay;
			}
			if ( $meta_overlay_color = get_post_meta( kindling_post_id(), 'kindling_post_title_bg_overlay_color', true ) ) {
				$overlay_color 	= $meta_overlay_color;
			}

		}

		// Check if overlay
		if ( $overlay ) {

			// Inline style
			$add_style = '';
			if ( '0.5' != $overlay ) {
				$add_style .= 'opacity:'. $overlay .';';
			}
			if ( $overlay_color && '#000000' != $overlay_color ) {
				$add_style .= 'background-color:'. $overlay_color .';';
			}
			if ( $add_style ) {
				$add_style = ' style="' . esc_attr( $add_style ) . '"';
			}

			// Return overlay element
			$return = '<span class="background-image-page-header-overlay" '. $add_style .'></span>';
			
		}

		// Apply filters for child theming
		$return = apply_filters( 'kindling_page_header_overlay', $return );

		// Return
		echo $return;
	}

}

/**
 * Outputs Custom CSS for the page title
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_page_header_css' ) ) {

	function kindling_page_header_css( $output ) {

		// Return output if page header is disabled
		if ( ! kindling_has_page_header() ) {
			return $output;
		}

		// Return if there isn't a page header style defined
		if ( ! kindling_page_header_style() ) {
			return $output;
		}

		// Define var
		$css = '';

		// Check if a header style is defined and make header style dependent tweaks
		if ( kindling_page_header_style() ) {

			// Customize background color
			if ( kindling_page_header_style() == 'solid-color' ) {
				$bg_color = get_theme_mod( 'kindling_page_header_background', '#f5f5f5' );
				if ( $meta_bg_color = get_post_meta( kindling_post_id(), 'kindling_post_title_background_color', true ) ) {
					$bg_color = $meta_bg_color;
				}
				if ( $bg_color && '#f5f5f5' != $bg_color ) {
					$css .='background-color: '. $bg_color .';';
				}
			}

			// Background image Style
			if ( kindling_page_header_style() == 'background-image' ) {

				// Add background image
				$bg_img = get_theme_mod( 'kindling_page_header_bg_image' );

				if ( true == get_theme_mod( 'kindling_blog_single_featured_image_title', false )
					&& is_singular( 'post' )
					&& has_post_thumbnail() ) {
					$bg_img = get_the_post_thumbnail_url();
				}

				if ( $meta_bg_img = get_post_meta( kindling_post_id(), 'kindling_post_title_background', true ) ) {
					$bg_img = $meta_bg_img;
				}

				// Generate image URL if using ID
				if ( is_numeric( $bg_img ) ) {
					$bg_img = wp_get_attachment_image_src( $bg_img, 'full' );
					$bg_img = $bg_img[0];
				}
				
				$bg_img = $bg_img ? $bg_img : null;
				$bg_img = apply_filters( 'kindling_page_header_background_image', $bg_img );

				if ( $bg_img ) {

					// Add css for background image
					$css .= 'background-image: url('. $bg_img .' ) !important;
							background-position: 50% 0;
							-webkit-background-size: cover;
							-moz-background-size: cover;
							-o-background-size: cover;
							background-size: cover;';

					// Custom height
					$title_height 		= get_theme_mod( 'kindling_page_header_bg_image_height', '400' );

					if ( true == get_theme_mod( 'kindling_blog_single_featured_image_title', false )
						&& is_singular( 'post' ) ) {
						$title_height 	= get_theme_mod( 'kindling_blog_single_title_bg_image_height', '400' );
					}

					if ( 'background-image' == get_post_meta( kindling_post_id(), 'kindling_post_title_style', true ) ) {

						if ( $meta_title_height = get_post_meta( kindling_post_id(), 'kindling_post_title_height', true ) ) {
							$title_height 	= $meta_title_height;
						}
						
					}

					$title_height 		= $title_height ? $title_height : '400';
					$title_height 		= apply_filters( 'kindling_post_title_height', $title_height );

					if ( $title_height && '400' != $title_height ) {
						$css .= 'height:'. $title_height .'px;';
					}

				}

			}

		}

		// Apply all css to the page-header class
		if ( ! empty( $css ) ) {
			$css = '.page-header { '. $css .' }';
		}

		// If css var isn't empty add to custom css output
		if ( ! empty( $css ) ) {
			$output .= $css;
		}

		// Return output
		return $output;

	}

	add_filter( 'kindling_head_css', 'kindling_page_header_css' );

}

/*-------------------------------------------------------------------------------*/
/* [ Blog ]
/*-------------------------------------------------------------------------------*/

/**
 * Adds post classes
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_blog_wrap_classes' ) ) {

	function kindling_blog_wrap_classes( $classes = NULL ) {
		
		// Return custom class if set
		if ( $classes ) {
			return $classes;
		}
		
		// Admin defaults
		$style   = kindling_blog_entry_style();
		$classes = array( 'entries', 'clr' );
			
		// Isotope classes
		if ( $style == 'grid-entry' ) {
			$classes[] = 'kindling-row';
			if ( 'masonry' == kindling_blog_grid_style() ) {
				$classes[] = 'blog-masonry-grid';
			} else {
				if ( 'infinite_scroll' == kindling_blog_pagination_style() ) {
					$classes[] = 'blog-masonry-grid';
				} else {
					$classes[] = 'blog-grid';
				}
			}
		}
		
		// Equal heights
		if ( kindling_blog_entry_equal_heights() ) {
			$classes[] = 'blog-equal-heights';
		}
		
		// Infinite scroll classes
		if ( 'infinite_scroll' == kindling_blog_pagination_style() ) {
			$classes[] = 'infinite-scroll-wrap';
		}
		
		// Add filter for child theming
		$classes = apply_filters( 'kindling_blog_wrap_classes', $classes );

		// Turn classes into space seperated string
		if ( is_array( $classes ) ) {
			$classes = implode( ' ', $classes );
		}

		// Echo classes
		echo esc_attr( $classes );
		
	}

}

/**
 * Adds entry classes
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_post_entry_classes' ) ) {

	function kindling_post_entry_classes() {

		// Define classes array
		$classes = array();

		// Entry Style
		$entry_style = kindling_blog_entry_style();

		// Core classes
		$classes[] = 'blog-entry';
		$classes[] = 'clr';

		// Masonry classes
		if ( 'masonry' == kindling_blog_grid_style() ) {
			$classes[] = 'isotope-entry';
		}

		// Add columns for grid style entries
		if ( $entry_style == 'grid-entry' ) {
			$classes[] = 'col';
			$classes[] = kindling_grid_class( kindling_blog_entry_columns() );
		}

		// No Featured Image Class, don't add if oembed or self hosted meta are defined
		if ( ! has_post_thumbnail()
			&& '' == get_post_meta( get_the_ID(), 'kindling_post_self_hosted_shortcode', true )
			&& '' == get_post_meta( get_the_ID(), 'kindling_post_oembed', true ) ) {
			$classes[] = 'no-featured-image';
		}

		// Blog entry style
		$classes[] = $entry_style;

		// Counter
		global $kindling_count;
		if ( $kindling_count ) {
			$classes[] = 'col-'. $kindling_count;
		}

		// Apply filters to entry post class for child theming
		$classes = apply_filters( 'kindling_blog_entry_classes', $classes );

		// Rturn classes array
		return $classes;
		
	}

}

/**
 * Returns correct style for the blog entry based on theme options or category options
 *
 * @since 1.0.4
 */
if ( ! function_exists( 'kindling_blog_entry_style' ) ) {

	function kindling_blog_entry_style() {

		// Get default style from Customizer
		$style = get_theme_mod( 'kindling_blog_style', 'large-entry' );

		// Sanitize
		$style = $style ? $style : 'large-entry';

		// Apply filters for child theming
		$style = apply_filters( 'kindling_blog_entry_style', $style );

		// Return style
		return $style;

	}

}

/**
 * Returns correct images size
 *
 * @since 1.0.4
 */
if ( ! function_exists( 'kindling_blog_entry_images_size' ) ) {

	function kindling_blog_entry_images_size() {

		// Get default size from Customizer
		$size = get_theme_mod( 'kindling_blog_grid_images_size', 'medium' );

		// Sanitize
		$size = $size ? $size : 'medium';

		// Apply filters for child theming
		$size = apply_filters( 'kindling_blog_entry_images_size', $size );

		// Return size
		return $size;

	}

}

/**
 * Returns the grid style
 *
 * @since 1.0.4
 */
if ( ! function_exists( 'kindling_blog_grid_style' ) ) {

	function kindling_blog_grid_style() {

		// Get default style from Customizer
		$style = get_theme_mod( 'kindling_blog_grid_style', 'fit-rows' );

		// Sanitize
		$style = $style ? $style : 'fit-rows';

		// Apply filters for child theming
		$style = apply_filters( 'kindling_blog_grid_style', $style );

		// Return style
		return $style;

	}

}

/**
 * Checks if it's a fit-rows style grid
 *
 * @since 1.0.4
 */
if ( ! function_exists( 'kindling_blog_fit_rows' ) ) {

	function kindling_blog_fit_rows() {

		// Return false by default
		$return = false;

		// Get current blog style
		if ( 'grid-entry' == kindling_blog_entry_style() ) {
			$return = true;
		} else {
			$return = false;
		}

		// Apply filters for child theming
		$return = apply_filters( 'kindling_blog_fit_rows', $return );

		// Return bool
		return $return;

	}

}

/**
 * Checks if the blog entries should have equal heights
 *
 * @since 1.0.4
 */
if ( ! function_exists( 'kindling_blog_entry_equal_heights' ) ) {

	function kindling_blog_entry_equal_heights() {
		if ( ! get_theme_mod( 'kindling_blog_grid_equal_heights', false ) ) {
			return false;
		}
		$entry_style = kindling_blog_entry_style();
		if ( 'grid-entry' == $entry_style
			&& 'masonry' != kindling_blog_grid_style() ) {
			return true;
		}
	}


}

/**
 * Returns correct columns for the blog entries
 *
 * @since 1.0.4
 */
if ( ! function_exists( 'kindling_blog_entry_columns' ) ) {

	function kindling_blog_entry_columns() {

		// Get columns from customizer setting
		$columns = get_theme_mod( 'kindling_blog_grid_columns', '2' );

		// Sanitize
		$columns = $columns ? $columns : '2';

		// Apply filters for child theming
		$columns = apply_filters( 'kindling_blog_entry_columns', $columns );

		// Return columns
		return $columns;

	}

}

/**
 * Check if the post has a gallery
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_post_has_gallery' ) ) {

	function kindling_post_has_gallery( $post_id = '' ) {

		$post_id = $post_id ? $post_id : get_the_ID();

		if ( get_post_meta( $post_id, 'kindling_gallery_id', true ) ) {
			return true;
		}

	}

}

/**
 * Retrieve attachment IDs
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_get_gallery_ids' ) ) {

	function kindling_get_gallery_ids( $post_id = '' ) {

		$post_id = $post_id ? $post_id : get_the_ID();
		$attachment_ids = get_post_meta( $post_id, 'kindling_gallery_id', true );

		if ( $attachment_ids ) {
			return $attachment_ids;
		}

	}

}

/**
 * Retrieve attachment data
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_get_attachment' ) ) {

	function kindling_get_attachment( $id ) {

		$attachment = get_post( $id );

		return array(
			'alt'         => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
			'caption'     => $attachment->post_excerpt,
			'description' => $attachment->post_content,
			'href'        => get_permalink( $attachment->ID ),
			'src'         => $attachment->guid,
			'title'       => $attachment->post_title,
		);

	}

}

/**
 * Return gallery count
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_gallery_count' ) ) {

	function kindling_gallery_count() {

		$ids = kindling_get_gallery_ids();
		return count( $ids );

	}

}

/**
 * Check if lightbox is enabled
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_gallery_is_lightbox_enabled' ) ) {

	function kindling_gallery_is_lightbox_enabled() {

		if ( 'on' == get_post_meta( get_the_ID(), 'kindling_gallery_link_images', true ) ) {
			return true;
		}

	}

}

/**
 * Returns post video
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_get_post_video' ) ) {

	function kindling_get_post_video( $post_id = '' ) {

		// Define video variable
		$video = '';

		// Get correct ID
		$post_id = $post_id ? $post_id : get_the_ID();

		// Embed
		if ( $meta = get_post_meta( $post_id, 'kindling_post_video_embed', true ) ) {
			$video = $meta;
		}

		// Check for self-hosted first
		elseif ( $meta = get_post_meta( $post_id, 'kindling_post_self_hosted_media', true ) ) {
			$video = $meta;
		}

		// Check for post oembed
		elseif ( $meta = get_post_meta( $post_id, 'kindling_post_oembed', true ) ) {
			$video = $meta;
		}

		// Apply filters for child theming
		$video = apply_filters( 'kindling_get_post_video', $video );

		// Return data
		return $video;

	}

}

/**
 * Echo post video HTML
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_post_video_html' ) ) {

	function kindling_post_video_html( $video = '' ) {
		echo kindling_get_post_video_html( $video );
	}

}

/**
 * Returns post video HTML
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_get_post_video_html' ) ) {

	function kindling_get_post_video_html( $video = '' ) {

		// Get video
		$video = $video ? $video : kindling_get_post_video();

		// Return if video is empty
		if ( empty( $video ) ) {
			return;
		}

		// Check post format for standard post type
		if ( 'post' == get_post_type() && 'video' != get_post_format() ) {
			return;
		}

		// Check if it's an embed or iframe

		// Get oembed code and return
		if ( ! is_wp_error( $oembed = wp_oembed_get( $video ) ) && $oembed ) {
			return '<div class="responsive-video-wrap">'. $oembed .'</div>';
		}

		// Display using apply_filters if it's self-hosted
		else {

			$video = apply_filters( 'the_content', $video );

			// Add responsive video wrap for youtube/vimeo embeds
			if ( strpos( $video, 'youtube' ) || strpos( $video, 'vimeo' ) ) {
				return '<div class="responsive-video-wrap">'. $video .'</div>';
			}

			// Else return without responsive wrap
			else {
				return $video;
			}

		}

	}

}

/**
 * Returns post audio
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_get_post_audio' ) ) {

	function kindling_get_post_audio( $id = '' ) {

		// Define video variable
		$audio = '';

		// Get correct ID
		$id = $id ? $id : get_the_ID();

		// Check for self-hosted first
		if ( $self_hosted = get_post_meta( $id, 'kindling_post_self_hosted_media', true ) ) {
			$audio = $self_hosted;
		}

		// Check for kindling_post_audio custom field
		elseif ( $post_video = get_post_meta( $id, 'kindling_post_audio', true ) ) {
			$audio = $post_video;
		}

		// Check for post oembed
		elseif ( $post_oembed = get_post_meta( $id, 'kindling_post_oembed', true ) ) {
			$audio = $post_oembed;
		}

		// Apply filters for child theming
		$audio = apply_filters( 'kindling_get_post_audio', $audio );

		// Return data
		return $audio;

	}

}

/**
 * Returns post audio
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_get_post_audio_html' ) ) {

	function kindling_get_post_audio_html( $audio = '' ) {

		// Get video
		$audio = $audio ? $audio : kindling_get_post_audio();

		// Return if video is empty
		if ( empty( $audio ) ) {
			return;
		}

		// Get oembed code and return
		if ( ! is_wp_error( $oembed = wp_oembed_get( $audio ) ) && $oembed ) {
			return '<div class="responsive-audio-wrap">'. $oembed .'</div>';
		}

		// Display using apply_filters if it's self-hosted
		else {
			return apply_filters( 'the_content', $audio );
		}

	}

}

/**
 * Returns blog entry elements positioning
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'kindling_blog_entry_elements_positioning' ) ) {

	function kindling_blog_entry_elements_positioning() {

		// Default sections
		$sections = array( 'featured_image', 'title', 'meta', 'content', 'read_more' );

		// Get sections from Customizer
		$sections = get_theme_mod( 'kindling_blog_entry_elements_positioning', $sections );

		// Turn into array if string
		if ( $sections && ! is_array( $sections ) ) {
			$sections = explode( ',', $sections );
		}

		// Apply filters for easy modification
		$sections = apply_filters( 'kindling_blog_entry_elements_positioning', $sections );

		// Return sections
		return $sections;

	}

}

/**
 * Returns blog entry meta
 *
 * @since 1.0.5.1
 */
if ( ! function_exists( 'kindling_blog_entry_meta' ) ) {

	function kindling_blog_entry_meta() {

		// Default sections
		$sections = array( 'author', 'date', 'categories', 'comments' );

		// Get sections from Customizer
		$sections = get_theme_mod( 'kindling_blog_entry_meta', $sections );

		// Turn into array if string
		if ( $sections && ! is_array( $sections ) ) {
			$sections = explode( ',', $sections );
		}

		// Apply filters for easy modification
		$sections = apply_filters( 'kindling_blog_entry_meta', $sections );

		// Return sections
		return $sections;

	}

}

/**
 * Returns blog single elements positioning
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'kindling_blog_single_elements_positioning' ) ) {

	function kindling_blog_single_elements_positioning() {

		// Default sections
		$sections = array( 'featured_image', 'title', 'meta', 'content', 'tags', 'social_share', 'next_prev', 'author_box', 'related_posts', 'single_comments' );

		// Get sections from Customizer
		$sections = get_theme_mod( 'kindling_blog_single_elements_positioning', $sections );

		// Turn into array if string
		if ( $sections && ! is_array( $sections ) ) {
			$sections = explode( ',', $sections );
		}

		// Apply filters for easy modification
		$sections = apply_filters( 'kindling_blog_single_elements_positioning', $sections );

		// Return sections
		return $sections;

	}

}

/**
 * Returns blog single meta
 *
 * @since 1.0.5.1
 */
if ( ! function_exists( 'kindling_blog_single_meta' ) ) {

	function kindling_blog_single_meta() {

		// Default sections
		$sections = array( 'author', 'date', 'categories', 'comments' );

		// Get sections from Customizer
		$sections = get_theme_mod( 'kindling_blog_single_meta', $sections );

		// Turn into array if string
		if ( $sections && ! is_array( $sections ) ) {
			$sections = explode( ',', $sections );
		}

		// Apply filters for easy modification
		$sections = apply_filters( 'kindling_blog_single_meta', $sections );

		// Return sections
		return $sections;

	}

}

/**
 * Custom excerpts based on wp_trim_words
 *
 * @since	1.0.0
 * @link	http://codex.wordpress.org/Function_Reference/wp_trim_words
 */
if ( ! function_exists( 'kindling_excerpt' ) ) {

	function kindling_excerpt( $length = 30 ) {

		// Get global post
		global $post;

		// Get post data
		$id			= $post->ID;
		$excerpt	= $post->post_excerpt;

		// Display custom excerpt
		if ( $excerpt ) {
			$output = $excerpt;
		}

		// Check for more tag
		elseif ( strpos( $post->post_content, '<!--more-->' ) ) {
			$kindling_more_tag	= apply_filters( 'kindling_more_tag', null );
			$output				= get_the_content( $kindling_more_tag );
		}

		// Generate auto excerpt
		else {
			$output = wp_trim_words( strip_shortcodes( get_the_content( $id ) ), $length );
		}

		// Echo output
		echo $output;

	}

}

/**
 * Comments and pingbacks
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_comment' ) ) {

	function kindling_comment( $comment, $args, $depth ) {

		$GLOBALS['comment'] = $comment;

		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
			// Display trackbacks differently than normal comments.
		?>

		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">

			<article id="comment-<?php comment_ID(); ?>" class="comment-container">
				<p><?php _e( 'Pingback:', 'kindling' ); ?> <span><span itemprop="name"><?php comment_author_link(); ?></span></span> <?php edit_comment_link( __( '(Edit)', 'kindling' ), '<span class="edit-link">', '</span>' ); ?></p>
			</article>

			<?php
			break;
				default :
				// Proceed with normal comments.
				global $post;
			?>

			<li id="comment-<?php comment_ID(); ?>" class="comment-container">

				<article <?php comment_class( 'comment-body' ); ?>>

					<?php echo get_avatar( $comment, apply_filters( 'kindling_comment_avatar_size', 150 ) ); ?>

		            <div class="comment-content">
		                <div class="comment-author">
		                    <h3 class="comment-link"><?php printf( __( '%s ', 'kindling' ), sprintf( '%s', get_comment_author_link() ) ); ?></h3>

		                    <span class="comment-meta commentmetadata">
		                    	<?php if ( ! is_RTL() ) { ?>
		                        	<span class="comment-date"><?php comment_date('j M Y'); ?></span>
		                        <?php } ?>

		                        <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>

		                        <?php edit_comment_link(__('edit', 'kindling' )); ?>

		                    	<?php if ( is_RTL() ) { ?>
		                        	<span class="comment-date"><?php comment_date('j M Y'); ?></span>
		                        <?php } ?>
		                    </span>
		                </div>

		                <div class="clr"></div>

		                <div class="comment-entry">
		                    <?php if ( '0' == $comment->comment_approved ) : ?>
		                        <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'kindling' ); ?></p>
		                    <?php endif; ?>

		                    <div class="comment-content">
		                        <?php comment_text(); ?>
		                    </div>
		                </div>
		            </div>

				</article><!-- #comment-## -->

			<?php
			break;
		endswitch; // end comment_type check
	}

}

/**
 * Check if a post has terms/categories
 *
 * This function is used for the next and previous posts so if a post is in a category it
 * will display next and previous posts from the same category.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_post_has_terms' ) ) {

	function kindling_post_has_terms( $post_id = '', $post_type = '' ) {

		// Post data
		$post_id    = $post_id ? $post_id : get_the_ID();
		$post_type  = $post_type ? $post_type : get_post_type( $post_id );

		// Standard Posts
		if ( $post_type == 'post' ) {
			$terms = get_the_terms( $post_id, 'category');
			if ( $terms ) {
				return true;
			}
		}

	}

}

/**
 * Returns the "category" taxonomy for a given post type
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_get_post_type_cat_tax' ) ) {

	function kindling_get_post_type_cat_tax( $post_type = '' ) {

		// Get the post type
		$post_type = $post_type ? $post_type : get_post_type();

		// Return taxonomy
		if ( 'post' == $post_type ) {
			$tax = 'category';
		} elseif ( 'product' == $post_type ) {
			$tax = 'product_cat';
		} elseif ( 'tribe_events' == $post_type ) {
			$tax = 'tribe_events_cat';
		} elseif ( 'download' == $post_type ) {
			$tax = 'download_category';
		} else {
			$tax = false;
		}

		// Apply filters & return
		return apply_filters( 'kindling_get_post_type_cat_tax', $tax );

	}

}

/**
 * Numbered Pagination
 *
 * @since	1.0.0
 * @link	https://codex.wordpress.org/Function_Reference/paginate_links
 */
if ( ! function_exists( 'kindling_pagination') ) {

	function kindling_pagination( $query = '', $echo = true ) {
		
		// Arrows with RTL support
		$prev_arrow = is_rtl() ? 'fa fa-angle-right' : 'fa fa-angle-left';
		$next_arrow = is_rtl() ? 'fa fa-angle-left' : 'fa fa-angle-right';
		
		// Get global $query
		if ( ! $query ) {
			global $wp_query;
			$query = $wp_query;
		}

		// Set vars
		$total  = $query->max_num_pages;
		$big    = 999999999;

		// Display pagination if total var is greater then 1 ( current query is paginated )
		if ( $total > 1 )  {

			// Get current page
			if ( $current_page = get_query_var( 'paged' ) ) {
				$current_page = $current_page;
			} elseif ( $current_page = get_query_var( 'page' ) ) {
				$current_page = $current_page;
			} else {
				$current_page = 1;
			}

			// Get permalink structure
			if ( get_option( 'permalink_structure' ) ) {
				if ( is_page() ) {
					$format = 'page/%#%/';
				} else {
					$format = '/%#%/';
				}
			} else {
				$format = '&paged=%#%';
			}

			$args = apply_filters( 'kindling_pagination_args', array(
				'base'      => str_replace( $big, '%#%', html_entity_decode( get_pagenum_link( $big ) ) ),
				'format'    => $format,
				'current'   => max( 1, $current_page ),
				'total'     => $total,
				'mid_size'  => 3,
				'type'      => 'list',
				'prev_text' => '<i class="'. $prev_arrow .'"></i>',
				'next_text' => '<i class="'. $next_arrow .'"></i>',
			) );

			$align = get_theme_mod( 'kindling_pagination_align' );
			$align = $align ? $align : 'right';

			// Output pagination
			if ( $echo ) {
				echo '<div class="kindling-pagination clr kindling-'. $align .'">'. paginate_links( $args ) .'</div>';
			} else {
				return '<div class="kindling-pagination clr kindling-'. $align .'">'. paginate_links( $args ) .'</div>';
			}
		}
	}

}

/**
 * Next and previous pagination
 *
 * @since	1.0.0
 */
if ( ! function_exists( 'kindling_pagejump' ) ) {

	function kindling_pagejump( $pages = '', $range = 4, $echo = true ) {

		// Vars
		$output     = '';
		$showitems  = ($range * 2)+1; 

		// Set correct paged var
		global $paged;
		if ( empty( $paged ) ) {
			$paged = 1;
		}

		// Get pages var
		if ( $pages == '' ) {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if ( ! $pages ) {
				$pages = 1;
			}
		}

		// Display next/previous pagination
		if ( 1 != $pages ) {

			$output .= '<div class="page-jump clr">';
				$output .= '<div class="alignleft newer-posts">';
					$output .= get_previous_posts_link( '&larr; '. esc_html__( 'Newer Posts', 'kindling' ) );
				$output .= '</div>';
				$output .= '<div class="alignright older-posts">';
					$output .= get_next_posts_link( esc_html__( 'Older Posts', 'kindling' ) .' &rarr;' );
				$output .= '</div>';
			$output .= '</div>';

			if ( $echo ) {
				echo $output;
			} else {
				return $output;
			}

		}
		
	}

}

/**
 * Infinite Scroll Pagination
 *
 * @since 1.0.4
 */
if ( ! function_exists( 'kindling_infinite_scroll' ) ) {

	function kindling_infinite_scroll( $type = 'standard' ) {

		// Load infinite scroll script
		wp_enqueue_script(
			'kindling-infinitescroll',
			KINDLING_JS_DIR_URI .'dynamic/infinitescroll.min.js',
			array( 'jquery' ),
			1.0,
			true
		);
		
		// Localize loading text
		$is_params = array( 'msgText' => esc_html__( 'Loading...', 'kindling' ) );
		wp_localize_script( 'kindling-infinitescroll', 'kindlingInfiniteScroll', $is_params );  
		
		// Output pagination HTML
		$output = '';
		$output .= '<div class="infinite-scroll-nav clr">';
			$output .= '<div class="alignleft newer-posts">';
				$output .= get_previous_posts_link('&larr; '. esc_html__( 'Newer Posts', 'kindling' ) );
			$output .= '</div>';
			$output .= '<div class="alignright older-posts">';
				$output .= get_next_posts_link( esc_html__( 'Older Posts', 'kindling' ) .' &rarr;');
			$output .= '</div>';
		$output .= '</div>';

		echo $output;

	}

}

/**
 * Blog Pagination
 * Used to load the correct pagination function for blog archives
 * Execute the correct pagination function based on the theme settings
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_blog_pagination' ) ) {

	function kindling_blog_pagination() {
		
		// Admin Options
		$blog_style       = get_theme_mod( 'kindling_blog_style', 'large-entry' );
		$pagination_style = get_theme_mod( 'kindling_blog_pagination_style', 'standard' );
		
		// Category based settings
		if ( is_category() ) {
			
			// Get taxonomy meta
			$term       = get_query_var( 'cat' );
			$term_data  = get_option( 'category_'. $term );
			$term_style = $term_pagination = '';
			
			if ( isset( $term_data['kindling_term_style'] ) ) {
				$term_style = '' != $term_data['kindling_term_style'] ? $term_data['kindling_term_style'] .'' : $term_style;
			}
			
			if ( isset( $term_data['kindling_term_pagination'] ) ) {
				$term_pagination = '' != $term_data['kindling_term_pagination'] ? $term_data['kindling_term_pagination'] .'' : '';
			}
			
			if ( $term_pagination ) {
				$pagination_style = $term_pagination;
			}
			
		}
		
		// Set default $type for infnite scroll
		if ( 'grid-entry' == $blog_style ) {
			$infinite_type = 'standard-grid';
		} else {
			$infinite_type = 'standard';
		}
		
		// Execute the correct pagination function
		if ( 'infinite_scroll' == $pagination_style ) {
			kindling_infinite_scroll( $infinite_type );
		} else if ( $pagination_style == 'next_prev' ) {
			kindling_pagejump();
		} else {
			kindling_pagination();
		}

	}

}

/**
 * Returns the correct pagination style
 *
 * @since 1.0.4
 */
if ( ! function_exists( 'kindling_blog_pagination_style' ) ) {

	function kindling_blog_pagination_style() {

		// Get default style from Customizer
		$style = get_theme_mod( 'kindling_blog_pagination_style', 'standard' );

		// Apply filters for child theming
		$style = apply_filters( 'kindling_blog_pagination_style', $style );

		// Return style
		return $style;
	}

}

/*-------------------------------------------------------------------------------*/
/* [ Footer ]
/*-------------------------------------------------------------------------------*/

/**
 * Display footer widgets
 *
 * @since 1.1.2
 */
if ( ! function_exists( 'kindling_display_footer_widgets' ) ) {

	function kindling_display_footer_widgets() {

		// Return true by default
		$return = true;

		// Return false if disabled via Customizer
		if ( true != get_theme_mod( 'kindling_footer_widgets', true ) ) {
			$return = false;
		}

		// Check meta
		$meta = kindling_post_id() ? get_post_meta( kindling_post_id(), 'kindling_display_footer_widgets', true ) : '';

		// Check if disabled via meta option
		if ( 'on' == $meta ) {
			$return = true;
		} elseif ( 'off' == $meta ) {
			$return = false;
		}

		// Apply filters and return
		return apply_filters( 'kindling_display_footer_widgets', $return );

	}

}

/**
 * Display footer bottom
 *
 * @since 1.1.2
 */
if ( ! function_exists( 'kindling_display_footer_bottom' ) ) {

	function kindling_display_footer_bottom() {

		// Return true by default
		$return = true;

		// Return false if disabled via Customizer
		if ( true != get_theme_mod( 'kindling_footer_bottom', true ) ) {
			$return = false;
		}

		// Check meta
		$meta = kindling_post_id() ? get_post_meta( kindling_post_id(), 'kindling_display_footer_bottom', true ) : '';

		// Check if disabled via meta option
		if ( 'on' == $meta ) {
			$return = true;
		} elseif ( 'off' == $meta ) {
			$return = false;
		}

		// Apply filters and return
		return apply_filters( 'kindling_display_footer_bottom', $return );

	}

}

/**
 * Add classes to the footer wrap
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_footer_classes' ) ) {

	function kindling_footer_classes() {

		// Setup classes array
		$classes = array();

		// Default class
		$classes[] = 'site-footer';

		// Set keys equal to vals
		$classes = array_combine( $classes, $classes );
		
		// Apply filters for child theming
		$classes = apply_filters( 'kindling_footer_classes', $classes );

		// Turn classes into space seperated string
		$classes = implode( ' ', $classes );

		// return classes
		return $classes;

	}

}

/**
 * Returns footer page ID
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_footer_page_id' ) ) {

	function kindling_footer_page_id() {

		// Return false if disabled via Customizer
		if ( true != get_theme_mod( 'kindling_footer_widgets', true ) ) {
			return null;
		}

		// Get page ID from Customizer
		$page_id = get_theme_mod( 'kindling_footer_widgets_page_id' );

		// Get page content
		if ( ! empty( $page_id ) ) {

			$page = get_post( $page_id );

			if ( $page && ! is_wp_error( $page ) ) {
				$page_id = $page->post_content;
			}

		}

		// Apply filters and return content
		return apply_filters( 'kindling_footer_page_id', $page_id );

	}

}

/*-------------------------------------------------------------------------------*/
/* [ WooCommerce ]
/*-------------------------------------------------------------------------------*/

/**
 * Checks if on the WooCommerce shop page.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_is_woo_shop' ) ) {

	function kindling_is_woo_shop() {
		if ( ! KINDLING_WOOCOMMERCE_ACTIVE ) {
			return false;
		} elseif ( function_exists( 'is_shop' ) && is_shop() ) {
			return true;
		}
	}

}

/**
 * Checks if on a WooCommerce tax.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_is_woo_tax' ) ) {

	function kindling_is_woo_tax() {
		if ( ! KINDLING_WOOCOMMERCE_ACTIVE ) {
			return false;
		} elseif ( ! is_tax() ) {
			return false;
		} elseif ( function_exists( 'is_product_category' ) && function_exists( 'is_product_tag' ) ) {
			if ( is_product_category() || is_product_tag() ) {
				return true;
			}
		}
	}

}

/**
 * Checks if on singular WooCommerce product post.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_is_woo_single' ) ) {

	function kindling_is_woo_single() {
		if ( ! KINDLING_WOOCOMMERCE_ACTIVE ) {
			return false;
		} elseif ( is_woocommerce() && is_singular( 'product' ) ) {
			return true;
		}
	}

}

/*-------------------------------------------------------------------------------*/
/* [ Other ]
/*-------------------------------------------------------------------------------*/

/**
 * Main schema markup
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_main_schema_markup' ) ) {

	function kindling_main_schema_markup() {

		$itemtype = '//schema.org/WebPageElement';
		$itemprop = 'mainContentOfPage';

		if ( is_singular( 'post' ) ) {
			$itemprop = '';
			$itemtype = '//schema.org/Blog';
		}

		$schema = 'itemprop="'. $itemprop .'" itemscope itemtype="'. $itemtype .'"';

		return $schema;

	}

}

/**
 * Translation support
 *
 * @since 1.1.4
 */
if ( ! function_exists( 'kindling_tm_translation' ) ) {

	function kindling_tm_translation( $id, $val = '' ) {

		// Translate theme mod val
		if ( $val ) {

			// WPML translation
			if ( function_exists( 'icl_t' ) && $id ) {
				$val = icl_t( 'Theme Mod', $id, $val );
			}

			// Polylang Translation
			if ( function_exists( 'pll__' ) && $id ) {
				$val = pll__( $val );
			}

			// Return the value
			return $val;

		}

	}

}

/**
 * Register translation strings
 *
 * @since 1.1.4
 */
if ( ! function_exists( 'kindling_register_tm_strings' ) ) {

	function kindling_register_tm_strings() {

		return apply_filters( 'kindling_register_tm_strings', array(
			'kindling_top_bar_content' 			=> '<i class="icon-phone"></i> 1-555-645-324 <i class="icon-user"></i> <a href="#">Sign in</a>',
			'kindling_footer_copyright_text' 		=> 'Copyright - Kindling Theme by Nick Powered by <a href="https://wordpress.org/" title="WordPress" target="_blank">WordPress</a>',
			'kindling_woo_menu_icon_custom_link' 	=> '',
		) );

	}

}

/**
 * Returns array of Social Options
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_social_options' ) ) {

	function kindling_social_options() {
		return apply_filters( 'kindling_social_options', array(
			'twitter' => array(
				'label' => 'Twitter',
				'icon_class' => 'fa fa-twitter',
			),
			'facebook' => array(
				'label' => 'Facebook',
				'icon_class' => 'fa fa-facebook',
			),
			'googleplus' => array(
				'label' => 'Google Plus',
				'icon_class' => 'fa fa-google-plus',
			),
			'pinterest'  => array(
				'label' => 'Pinterest',
				'icon_class' => 'fa fa-pinterest-p',
			),
			'dribbble' => array(
				'label' => 'Dribbble',
				'icon_class' => 'fa fa-dribbble',
			),
			'vk' => array(
				'label' => 'VK',
				'icon_class' => 'fa fa-vk',
			),
			'instagram'  => array(
				'label' => 'Instagram',
				'icon_class' => 'fa fa-instagram',
			),
			'linkedin' => array(
				'label' => 'LinkedIn',
				'icon_class' => 'fa fa-linkedin',
			),
			'tumblr'  => array(
				'label' => 'Tumblr',
				'icon_class' => 'fa fa-tumblr',
			),
			'github'  => array(
				'label' => 'Github',
				'icon_class' => 'fa fa-github-alt',
			),
			'flickr'  => array(
				'label' => 'Flickr',
				'icon_class' => 'fa fa-flickr',
			),
			'skype' => array(
				'label' => 'Skype',
				'icon_class' => 'fa fa-skype',
			),
			'youtube' => array(
				'label' => 'Youtube',
				'icon_class' => 'fa fa-youtube',
			),
			'vimeo' => array(
				'label' => 'Vimeo',
				'icon_class' => 'fa fa-vimeo-square',
			),
			'vine' => array(
				'label' => 'Vine',
				'icon_class' => 'fa fa-vine',
			),
			'xing' => array(
				'label' => 'Xing',
				'icon_class' => 'fa fa-xing',
			),
			'yelp' => array(
				'label' => 'Yelp',
				'icon_class' => 'fa fa-yelp',
			),
			'tripadvisor' => array(
				'label' => 'Tripadvisor',
				'icon_class' => 'fa fa-tripadvisor',
			),
			'rss'  => array(
				'label' => esc_html__( 'RSS', 'kindling' ),
				'icon_class' => 'fa fa-rss',
			),
			'email' => array(
				'label' => esc_html__( 'Email', 'kindling' ),
				'icon_class' => 'fa fa-envelope',
			),
		) );
	}

}

/**
 * Grid Columns
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_grid_columns' ) ) {

	function kindling_grid_columns() {
		return apply_filters( 'kindling_grid_columns', array(
			'1' => '1',
			'2' => '2',
			'3' => '3',
			'4' => '4',
			'5' => '5',
			'6' => '6',
			'7' => '7',
		) );
	}

}

/**
 * Minify CSS
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_minify_css' ) ) {

	function kindling_minify_css( $css = '' ) {

		// Return if no CSS
		if ( ! $css ) return;

		// Normalize whitespace
		$css = preg_replace( '/\s+/', ' ', $css );

		// Remove ; before }
		$css = preg_replace( '/;(?=\s*})/', '', $css );

		// Remove space after , : ; { } */ >
		$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

		// Remove space before , ; { }
		$css = preg_replace( '/ (,|;|\{|})/', '$1', $css );

		// Strips leading 0 on decimal values (converts 0.5px into .5px)
		$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

		// Strips units if value is 0 (converts 0px to 0)
		$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

		// Trim
		$css = trim( $css );

		// Return minified CSS
		return $css;
		
	}

}

/**
 * Minify JS
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'kindling_minify_js' ) ) {

	function kindling_minify_js( $js = '' ) {

		// Return if no JS
		if ( ! $js ) return;

		$replace = array(
			'#\'([^\n\']*?)/\*([^\n\']*)\'#' 	=> "'\1/'+\'\'+'*\2'", 	// remove comments from ' strings
			'#\"([^\n\"]*?)/\*([^\n\"]*)\"#' 	=> '"\1/"+\'\'+"*\2"', 	// remove comments from " strings
			'#/\*.*?\*/#s'            			=> "",      			// strip C style comments
			'#[\r\n]+#'               			=> "\n",    			// remove blank lines and \r's
			'#\n([ \t]*//.*?\n)*#s'   			=> "\n",    			// strip line comments (whole line only)
			'#([^\\])//([^\'"\n]*)\n#s' 		=> "\\1\n", 			// strip line comments
			'#\n\s+#'                 			=> "\n",    			// strip excess whitespace
			'#\s+\n#'                 			=> "\n",    			// strip excess whitespace
			'#(//[^\n]*\n)#s'         			=> "\\1\n", 			// extra line feed after any comments left
			'#/([\'"])\+\'\'\+([\'"])\*#' 		=> "/*" 				// restore comments in strings
		);

		$search = array_keys( $replace );
		$script = preg_replace( $search, $replace, $js );

		$replace = array(
			"&&\n" => "&&",
			"||\n" => "||",
			"(\n"  => "(",
			")\n"  => ")",
			"[\n"  => "[",
			"]\n"  => "]",
			"+\n"  => "+",
			",\n"  => ",",
			"?\n"  => "?",
			":\n"  => ":",
			";\n"  => ";",
			"{\n"  => "{",
			"\n]"  => "]",
			"\n)"  => ")",
			"\n}"  => "}",
			"\n\n" => "\n"
		);

		$search = array_keys( $replace );
		$script = str_replace( $search, $replace, $script );

		// Return minified JS
		return trim( $script );

	}

}

/**
 * Array of Font Awesome Icons for the scroll up button
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_get_awesome_icons' ) ) {

	function kindling_get_awesome_icons( $return = 'up_arrows', $default = 'none' ) {

		// Add none to top of array
		$icons_array = array(
			'none' =>''
		);

		// Define return icons
		$return_icons = array();

		// Returns up arrows only
		if ( 'up_arrows' == $return ) {
			$return_icons = array('chevron-up','caret-up','angle-up','angle-double-up','long-arrow-up','arrow-circle-o-up','arrow-up','level-up','toggle-up');
			$return_icons = array_combine($return_icons, $return_icons);
		}

		return apply_filters( 'kindling_get_awesome_icons', array_merge( $icons_array, $return_icons ) );
		
	}

}

/**
 * Returns shortcode
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_has_shortcode' ) ) {

	function kindling_has_shortcode() {

		// Shortcode is NULL by default
		$shortcode = NULL;

		// Posts & Pages
		if ( $meta = get_post_meta( kindling_post_id(), 'kindling_has_shortcode', true ) ) {
			$shortcode = $meta;
		}

		// Apply filters and return
		return apply_filters( 'kindling_has_shortcode', $shortcode );

	}

}

/**
 * Returns sidr menu source
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kindling_sidr_menu_source' ) ) {
	
	function kindling_sidr_menu_source() {

		// Define array of items
		$items = array();

		// Add close button
		$items['sidrclose'] = '#sidr-close';

		// Add main navigation
		$items['nav'] = '#site-navigation';

		// Add social menu
		if ( true == get_theme_mod( 'kindling_menu_social', false ) ) {
			$items['social'] = '#kindling-social-menu';
		}

		// Add search form
		if ( get_theme_mod( 'kindling_mobile_menu_search', true ) ) {
			$items['search'] = '#mobile-menu-search';
		}

		// Apply filters for child theming
		$items = apply_filters( 'kindling_mobile_menu_source', $items );

		// Turn items into comma seperated list
		$items = implode( ', ', $items );

		// Return
		return $items;

	}

}

/**
 * Query Autoptimize activation - check required if using a page builder
 *
 * @since 1.1.1
 */
if ( ! function_exists( 'is_autoptimize_activated' ) ) {

	function is_autoptimize_activated() {

		return class_exists( 'autoptimizeBase' ) ? true : false;

	}

}