<?php
/**
 * Active callback functions for the customizer
 *
 * @package Kindling Theme
 */

/*-------------------------------------------------------------------------------*/
/* [ Table of contents ]
/*-------------------------------------------------------------------------------*

	# Core
	# Background
	# Header
	# Logo
	# Menu
	# Page Header
	# Blog
	# WooCommerce

/*-------------------------------------------------------------------------------*/
/* [ Core ]
/*-------------------------------------------------------------------------------*/
function kindling_cac_has_boxed_layout() {
	if ( 'boxed' == get_theme_mod( 'kindling_main_layout_style', 'wide' ) ) {
		return true;
	} else {
		return false;
	}
}

function kindling_cac_hasnt_boxed_layout() {
	if ( 'wide' == get_theme_mod( 'kindling_main_layout_style', 'wide' ) ) {
		return true;
	} else {
		return false;
	}
}

function kindling_cac_has_page_header() {
	if ( 'hidden' != get_theme_mod( 'kindling_page_header_style' ) ) {
		return true;
	} else {
		return false;
	}
}

function kindling_cac_has_breadcrumbs() {
	if ( function_exists( 'yoast_breadcrumb' ) ) {
		return true;
	} else {
		return get_theme_mod( 'kindling_breadcrumbs', true );
	}
}


function kindling_cac_enabled_not_yoast() {
	if ( function_exists( 'yoast_breadcrumb' ) ) {
		return false;
	} else {
		return kindling_cac_has_breadcrumbs();
	}
}

function kindling_cac_has_scrolltop() {
	return get_theme_mod( 'kindling_scroll_top', true );
}

function kindling_cac_has_footer_widgets() {
	return get_theme_mod( 'kindling_footer_widgets', true );
}

function kindling_cac_has_footer_bottom() {
	return get_theme_mod( 'kindling_footer_bottom', true );
}

/*-------------------------------------------------------------------------------*/
/* [ Background ]
/*-------------------------------------------------------------------------------*/

function kindling_cac_has_background_image() {
	if ( '' != get_theme_mod( 'kindling_background_image' ) ) {
		return true;
	} else {
		return false;
	}
}

/*-------------------------------------------------------------------------------*/
/* [ Header ]
/*-------------------------------------------------------------------------------*/

# TODO: Refactor this. It's bad, REAL bad.
function kindling_cac_hasnt_header_styles() {
	if ( 'top' == get_theme_mod( 'kindling_header_style', 'minimal' ) ) {
		return false;
	} else {
		return true;
	}
}

function kindling_cac_has_minimal_header_style() {
	if ( 'minimal' == get_theme_mod( 'kindling_header_style', 'minimal' ) ) {
		return true;
	} else {
		return false;
	}
}

function kindling_cac_has_top_header_style() {
	if ( 'top' == get_theme_mod( 'kindling_header_style', 'minimal' ) ) {
		return true;
	} else {
		return false;
	}
}

function kindling_cac_has_full_screen_header_style() {
	if ( 'full_screen' == get_theme_mod( 'kindling_header_style', 'minimal' ) ) {
		return true;
	} else {
		return false;
	}
}

function kindling_cac_has_center_header_style() {
	if ( 'center' == get_theme_mod( 'kindling_header_style', 'minimal' ) ) {
		return true;
	} else {
		return false;
	}
}

function kindling_cac_has_menu_social() {
	if ( true == get_theme_mod( 'kindling_menu_social', false ) ) {
		return true;
	} else {
		return false;
	}
}

function kindling_cac_has_minimal_header_style_and_menu_social() {
	$has_style = ( 'minimal' == get_theme_mod( 'kindling_header_style', 'minimal' ) );
	$has_social = ( true == get_theme_mod( 'kindling_menu_social', false ) );
	return ( $has_style && $has_social );

}

function kindling_cac_has_top_header_style_and_menu_social() {
	$has_style = ( 'top' == get_theme_mod( 'kindling_header_style', 'minimal' ) );
	$has_social = ( true == get_theme_mod( 'kindling_menu_social', false ) );
	return ( $has_style && $has_social );

}

function kindling_cac_has_center_header_style_and_menu_social() {
	$has_style = ( 'center' == get_theme_mod( 'kindling_header_style', 'minimal' ) );
	$has_social = ( true == get_theme_mod( 'kindling_menu_social', false ) );
	return ( $has_style && $has_social );
}

/*-------------------------------------------------------------------------------*/
/* [ Logo ]
/*-------------------------------------------------------------------------------*/
function kindling_cac_has_custom_logo() {
	if ( has_custom_logo() ) {
		return true;
	} else {
		return false;
	}
}

function kindling_cac_hasnt_custom_logo() {
	if ( has_custom_logo() ) {
		return false;
	} else {
		return true;
	}
}

/*-------------------------------------------------------------------------------*/
/* [ Menu ]
/*-------------------------------------------------------------------------------*/
function kindling_cac_has_menu_search_dropdown() {
	if ( 'drop_down' == get_theme_mod( 'kindling_menu_search_style', 'drop_down' ) ) {
		return true;
	} else {
		return false;
	}
}

function kindling_cac_has_menu_search_overlay() {
	if ( 'overlay' == get_theme_mod( 'kindling_menu_search_style', 'drop_down' ) ) {
		return true;
	} else {
		return false;
	}
}

function kindling_cac_has_menu_dropdown_top_border() {
	return get_theme_mod( 'kindling_menu_dropdown_top_border', false );
}

/*-------------------------------------------------------------------------------*/
/* [ Page Header ]
/*-------------------------------------------------------------------------------*/
function kindling_cac_hasnt_bg_image_page_header() {
	if ( 'background-image' == get_theme_mod( 'kindling_page_header_style' ) ) {
		return true;
	} else {
		return false;
	}
}

function kindling_cac_has_bg_image_page_header() {
	if ( 'background-image' == get_theme_mod( 'kindling_page_header_style' ) ) {
		return false;
	} else {
		return true;
	}
}

/*-------------------------------------------------------------------------------*/
/* [ Blog ]
/*-------------------------------------------------------------------------------*/
function kindling_cac_grid_blog_style() {
	if ( 'grid-entry' == get_theme_mod( 'kindling_blog_style', 'large-entry' ) ) {
		return true;
	} else {
		return false;
	}
}

function kindling_cac_blog_supports_equal_heights() {
	if ( kindling_cac_grid_blog_style()
		&& 'masonry' != get_theme_mod( 'kindling_blog_grid_style', 'fit-rows' ) ) {
		return true;
	} else {
		return false;
	}
}

function kindling_cac_has_blog_single_title_bg_image() {
	if ( true == get_theme_mod( 'kindling_blog_single_featured_image_title', false ) ) {
		return true;
	} else {
		return false;
	}
}

/*-------------------------------------------------------------------------------*/
/* [ WooCommerce ]
/*-------------------------------------------------------------------------------*/
function kindling_cac_has_menu_cart() {
	if ( 'disabled' != get_theme_mod( 'kindling_woo_menu_icon_display', 'icon_count' ) ) {
		return true;
	} else {
		return false;
	}
}

function kindling_cac_has_grid_list_buttons() {
	if ( true == get_theme_mod( 'kindling_woo_grid_list', true ) ) {
		return true;
	} else {
		return false;
	}
}