<?php
/**
 * Perform all main WooCommerce configurations for this theme
 *
 * @package Kindling WordPress theme
 */

// Define global var for class
global $kindling_woocommerce_config;

// Start and run class
if ( ! class_exists( 'Kindling_WooCommerce_Config' ) ) {

	class Kindling_WooCommerce_Config {

		/**
		 * Main Class Constructor
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			// Include helper functions
			require_once( KINDLING_INC_DIR .'woocommerce/woocommerce-helpers.php' );

			// These filters/actions must run on init
			add_action( 'init', array( $this, 'init' ) );

			// Register Woo sidebar
			add_filter( 'widgets_init', array( $this, 'register_woo_sidebar' ) );

			/*-------------------------------------------------------------------------------*/
			/* -  Front-End only actions/filters
			/*-------------------------------------------------------------------------------*/
			if ( ! is_admin() ) {

				// Display correct sidebar for products
				add_filter( 'kindling_get_sidebar', array( $this, 'display_woo_sidebar' ) );

				// Set correct post layouts
				add_filter( 'kindling_post_layout_class', array( $this, 'layouts' ) );
				
				// Disable WooCommerce main page title
				add_filter( 'woocommerce_show_page_title', '__return_false' );

				// Disable WooCommerce css
				add_filter( 'woocommerce_enqueue_styles', '__return_false' );

				// Show/hide category description
				add_filter( 'kindling_has_term_description_above_loop', array( $this, 'term_description_above_loop' ) );

				// Show/hide next/prev on products
				add_filter( 'kindling_has_next_prev', array( $this, 'next_prev' ) );

				// Define accents
				add_filter( 'kindling_primary_texts', array( $this, 'primary_texts' ) );
				add_filter( 'kindling_primary_borders', array( $this, 'primary_borders' ) );
				add_filter( 'kindling_primary_backgrounds', array( $this, 'primary_backgrounds' ) );
				add_filter( 'kindling_hover_primary_backgrounds', array( $this, 'hover_primary_backgrounds' ) );

				// Border colors
				add_filter( 'kindling_border_color_elements', array( $this, 'border_color_elements' ) );
			
			}

			// Main Woo Actions
			add_action( 'woocommerce_enqueue_styles', array( $this, 'remove_styles' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'remove_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'add_custom_css' ) );
			if ( get_theme_mod( 'kindling_woo_shop_result_count', true )
				|| get_theme_mod( 'kindling_woo_shop_sort', true )
				|| get_theme_mod( 'kindling_woo_grid_list', true ) ) {
				add_action( 'woocommerce_before_shop_loop', array( $this, 'add_shop_loop_div' ) );
			}
			if ( get_theme_mod( 'kindling_woo_grid_list', true ) ) {
				add_action( 'woocommerce_before_shop_loop', array( $this, 'grid_list_buttons' ), 10 );
			}
			if ( get_theme_mod( 'kindling_woo_shop_result_count', true )
				|| get_theme_mod( 'kindling_woo_shop_sort', true )
				|| get_theme_mod( 'kindling_woo_grid_list', true ) ) {
				add_action( 'woocommerce_before_shop_loop', array( $this, 'close_shop_loop_div' ), 40 );
			}
			add_action( 'woocommerce_before_shop_loop_item', array( $this, 'add_shop_loop_item_inner_div' ) );
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'archive_product_add_div_wrap' ), 10 );
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'archive_product_category' ), 15 );
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'archive_product_title' ), 20 );
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'archive_product_price_rating' ), 25 );
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'archive_product_excerpt' ), 30 );
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'archive_product_add_to_cart' ), 35 );
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'archive_product_close_div_wrap' ), 40 );
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'close_shop_loop_item_inner_div' ) );
			add_action( 'woocommerce_before_shop_loop_item', array( $this, 'add_shop_loop_item_out_of_stock_badge' ) );
			add_action( 'woocommerce_before_subcategory_title', array( $this, 'add_container_wrap_category' ), 8 );
			add_action( 'woocommerce_before_subcategory_title', array( $this, 'add_div_before_category_thumbnail' ), 9 );
			add_action( 'woocommerce_before_subcategory_title', array( $this, 'close_div_after_category_thumbnail' ), 11 );
			add_action( 'woocommerce_shop_loop_subcategory_title', array( $this, 'add_div_before_category_title' ), 9 );
			add_action( 'woocommerce_shop_loop_subcategory_title', array( $this, 'add_category_description' ), 11 );
			add_action( 'woocommerce_shop_loop_subcategory_title', array( $this, 'close_div_after_category_title' ), 12 );
			add_action( 'woocommerce_shop_loop_subcategory_title', array( $this, 'close_container_wrap_category' ), 13 );

			add_action( 'woocommerce_after_single_product_summary', array( $this, 'clear_summary_floats' ), 1 );
			add_action( 'woocommerce_before_account_navigation', array( $this, 'kindling_before_account_navigation' ) );
			add_action( 'woocommerce_after_account_navigation', array( $this, 'kindling_after_account_navigation' ) );
			if ( get_option( 'woocommerce_enable_myaccount_registration' ) !== 'yes' ) {
				add_action('woocommerce_before_customer_login_form', array( $this, 'kindling_login_wrap_before' ) );
				add_action('woocommerce_after_customer_login_form', array( $this, 'kindling_login_wrap_after' ) );
			}

			// Main Woo Filters
			add_filter( 'wp_nav_menu_items', array( $this, 'menu_cart_icon' ) , 10, 2 );
			add_filter( 'add_to_cart_fragments', array( $this, 'menu_cart_icon_fragments' ) );
			add_filter( 'woocommerce_general_settings', array( $this, 'remove_general_settings' ) );
			add_filter( 'woocommerce_product_settings', array( $this, 'remove_product_settings' ) );
			add_filter( 'woocommerce_sale_flash', array( $this, 'woocommerce_sale_flash' ), 10, 3 );
			add_filter( 'loop_shop_per_page', array( $this, 'loop_shop_per_page' ), 20 );
			add_filter( 'loop_shop_columns', array( $this, 'loop_shop_columns' ) );
			add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_product_args' ) );
			add_filter( 'woocommerce_pagination_args', array( $this, 'pagination_args' ) );
			add_filter( 'woocommerce_continue_shopping_redirect', array( $this, 'continue_shopping_redirect' ) );
			add_filter( 'post_class', array( $this, 'add_product_entry_classes' ), 40, 3 );
			add_filter( 'product_cat_class', array( $this, 'product_cat_class' ) );

			// Add new typography settings
			add_filter( 'kindling_typography_settings', array( $this, 'typography_settings' ) );
			
		} // End __construct

		/*-------------------------------------------------------------------------------*/
		/* -  Start Class Functions
		/*-------------------------------------------------------------------------------*/

		/**
		 * Runs on Init.
		 * You can't remove certain actions in the constructor because it's too early.
		 *
		 * @since 1.0.0
		 */
		public function init() {

			// Remove category descriptions, these are added already by the theme
			remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
			
			// Alter cross-sells display
			remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
			add_action( 'woocommerce_cart_collaterals', array( $this, 'cross_sell_display' ) );

			// Alter upsells display
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
			add_action( 'woocommerce_after_single_product_summary', array( $this, 'upsell_display' ), 15 );

			// Remove loop product thumbnail function and add our own that pulls from template parts
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'loop_product_thumbnail' ), 10 );

			// Remove single meta
			if ( ! get_theme_mod( 'kindling_woo_product_meta', true ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
			}

			// Remove upsells if set to 0
			if ( '0' == get_theme_mod( 'kindling_woocommerce_upsells_count', '3' ) ) {
				remove_action( 'woocommerce_after_single_product_summary', 'kindling_woocommerce_output_upsells', 15 );
			}

			// Remove related products if count is set to 0
			if ( '0' == get_theme_mod( 'kindling_woocommerce_related_count', '3' ) ) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
			}

			// Remove crossells if set to 0
			if ( '0' == get_theme_mod( 'kindling_woocommerce_cross_sells_count', '2' ) ) {
				remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
			}

			// Remove orderby if disabled
			if ( ! get_theme_mod( 'kindling_woo_shop_sort', true ) ) {
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
			}

			// Add result count if not disabled
			if ( get_theme_mod( 'kindling_woo_shop_result_count', true ) ) {
				add_action( 'woocommerce_before_shop_loop', array( $this, 'result_count' ), 31 );
			}

			// Remove default product result/link/title/rating/price
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
			remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
			remove_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10 );
			remove_action( 'woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10 );
			remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

			if ( defined( 'ELEMENTOR_WOOSTORE__FILE__' ) ) {
				remove_action( 'woocommerce_after_shop_loop_item_title', 'woostore_output_product_excerpt', 35 );
				add_action( 'woocommerce_after_shop_loop_item', 'woostore_output_product_excerpt', 21 );
			}

		}

		/**
		 * Remove general settings from Woo Admin panel.
		 *
		 * @since 1.0.0
		 */
		public static function remove_general_settings( $settings ) {
			$remove = array( 'woocommerce_enable_lightbox' );
			foreach( $settings as $key => $val ) {
				if ( isset( $val['id'] ) && in_array( $val['id'], $remove ) ) {
					unset( $settings[$key] );
				}
			}
			return $settings;
		}

		/**
		 * Remove product settings from Woo Admin panel.
		 *
		 * @since 1.0.0
		 */
		public static function remove_product_settings( $settings ) {
			$remove = array(
				'woocommerce_enable_lightbox'
			);
			foreach( $settings as $key => $val ) {
				if ( isset( $val['id'] ) && in_array( $val['id'], $remove ) ) {
					unset( $settings[$key] );
				}
			}
			return $settings;
		}

		/**
		 * Register new WooCommerce sidebar.
		 *
		 * @since 1.0.0
		 */
		public static function register_woo_sidebar() {

			// Return if custom sidebar disabled
			if ( ! get_theme_mod( 'kindling_woo_custom_sidebar', true ) ) {
				return;
			}

			// Register new woo_sidebar widget area
			register_sidebar( array (
				'name'          => esc_html__( 'WooCommerce Sidebar', 'kindling' ),
				'id'            => 'woo_sidebar',
				'before_widget' => '<div class="sidebar-box %2$s clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<h5 class="widget-title">',
				'after_title'   => '</h5>',
			) );

		}

		/**
		 * Display WooCommerce sidebar.
		 *
		 * @since 1.0.0
		 */
		public static function display_woo_sidebar( $sidebar ) {

			// Alter sidebar display to show woo_sidebar where needed
			if ( get_theme_mod( 'kindling_woo_custom_sidebar', true ) && is_woocommerce() && is_active_sidebar( 'woo_sidebar' ) ) {
				$sidebar = 'woo_sidebar';
			}

			// Return correct sidebar
			return $sidebar;

		}

		/**
		 * Tweaks the post layouts for WooCommerce archives and single product posts.
		 *
		 * @since 1.0.0
		 */
		public static function layouts( $class ) {
			if ( kindling_is_woo_shop() ) {
				$class = get_theme_mod( 'kindling_woo_shop_layout', 'left-sidebar' );
			} elseif ( kindling_is_woo_tax() ) {
				$class = get_theme_mod( 'kindling_woo_shop_layout', 'left-sidebar' );
			} elseif ( kindling_is_woo_single() ) {
				$class = get_theme_mod( 'kindling_woo_product_layout', 'left-sidebar' );
			}
			return $class;
		}

		/**
		 * Remove WooCommerce styles not needed for this theme.
		 *
		 * @since 1.0.0
		 * @link  http://docs.woothemes.com/document/disable-the-default-stylesheet/
		 */
		public static function remove_styles( $enqueue_styles ) {
			if ( is_array( $enqueue_styles ) ) {
				unset( $enqueue_styles['woocommerce-layout'] );
				unset( $enqueue_styles['woocommerce_prettyPhoto_css'] );
			}
			return $enqueue_styles;
		}

		/**
		 * Remove WooCommerce scripts.
		 *
		 * @since 1.0.0
		 */
		public static function remove_scripts() {
			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
			wp_dequeue_script( 'prettyPhoto' );
			wp_dequeue_script( 'prettyPhoto-init' );
		}

		/**
		 * Add Custom WooCommerce CSS.
		 *
		 * @since 1.0.0
		 */
		public static function add_custom_css() {

			// General WooCommerce Custom CSS
			wp_enqueue_style( 'kindling-woocommerce', KINDLING_CSS_DIR_URI .'kindling-woocommerce.min.css' );

		}

		/**
		 * Change onsale text.
		 *
		 * @since 1.0.0
		 */
		public static function woocommerce_sale_flash( $text, $post, $_product ) {
			return '<span class="onsale">'. esc_html__( 'Sale!', 'kindling' ) .'</span>';
		}

		/**
		 * Adds an opening div "kindling-toolbar" around top elements.
		 *
		 * @since 1.1.1
		 */
		public static function add_shop_loop_div() {
			echo '<div class="kindling-toolbar clr">';
		}

		/**
		 * Add grid/list buttons.
		 *
		 * @since 1.1.1
		 */
		public static function grid_list_buttons() {

			// Return if is not in shop page
			if ( ! kindling_is_woo_shop()
				&& ! kindling_is_woo_tax() ) {
				return;
			}

			// Titles
			$grid_view = esc_html__( 'Grid view', 'kindling' );
			$list_view = esc_html__( 'List view', 'kindling' );

			// Active class
			if ( 'list' == get_theme_mod( 'kindling_woo_catalog_view', 'grid' ) ) {
				$list = 'active ';
				$grid = '';
			} else {
				$grid = 'active ';
				$list = '';
			}

			$output = sprintf( '<nav class="kindling-grid-list"><a href="#" id="kindling-grid" title="%1$s" class="%2$sgrid-btn"><span class="icon-grid"></span></a><a href="#" id="kindling-list" title="%3$s" class="%4$slist-btn"><span class="icon-list"></span></a></nav>', $grid_view, $grid, $list_view, $list );

			echo apply_filters( 'kindling_grid_list_buttons_output', $output, $grid_view, $list_view );
		}

		/**
		 * Closes the opening div "kindling-toolbar" around top elements.
		 *
		 * @since 1.1.1
		 */
		public static function close_shop_loop_div() {
			echo '</div>';
		}

		/**
		 * Add result count.
		 *
		 * @since 1.1.1
		 */
		public static function result_count() {
			if ( function_exists( 'wc_get_template' )
				&& ( kindling_is_woo_shop() || kindling_is_woo_tax() ) ) {
				wc_get_template( 'global/result-count.php' );
			}
		}

		/**
		 * Returns correct posts per page for the shop
		 *
		 * @since 1.0.0
		 */
		public static function loop_shop_per_page() {
			if ( get_theme_mod( 'kindling_woo_shop_result_count', true ) ) {
				$posts_per_page = ( isset( $_GET['products-per-page'] ) ) ? $_GET['products-per-page'] : get_theme_mod( 'kindling_woo_shop_posts_per_page', '12' );

			    if ( $posts_per_page == 'all' ) {
			        $posts_per_page = wp_count_posts( 'product' )->publish;
			    }
			} else {
				$posts_per_page = get_theme_mod( 'kindling_woo_shop_posts_per_page' );
				$posts_per_page = $posts_per_page ? $posts_per_page : '12';
			}
			return $posts_per_page;
		}

		/**
		 * Change products per row for the main shop.
		 *
		 * @since 1.0.0
		 */
		public static function loop_shop_columns() {
			$columns = get_theme_mod( 'kindling_woocommerce_shop_columns' );
			$columns = $columns ? $columns : '3';
			return $columns;
		}

		/**
		 * Change products per row for upsells.
		 *
		 * @since 1.0.0
		 */
		public static function upsell_display() {
			// Get count
			$count = get_theme_mod( 'kindling_woocommerce_upsells_count' );
			$count = $count ? $count : '4';
			// Get columns
			$columns = get_theme_mod( 'kindling_woocommerce_upsells_columns' );
			$columns = $columns ? $columns : '3';
			// Alter upsell display
			woocommerce_upsell_display( $count, $columns );
		}

		/**
		 * Change products per row for crossells.
		 *
		 * @since 1.0.0
		 */
		public static function cross_sell_display() {
			// Get count
			$count = get_theme_mod( 'kindling_woocommerce_cross_sells_count' );
			$count = $count ? $count : '2';
			// Get columns
			$columns = get_theme_mod( 'kindling_woocommerce_cross_sells_columns' );
			$columns = $columns ? $columns : '2';
			// Alter cross-sell display
			woocommerce_cross_sell_display( $count, $columns );
		}

		/**
		 * Alter the related product arguments.
		 *
		 * @since 1.0.0
		 */
		public static function related_product_args() {
			// Get global vars
			global $product, $orderby, $related;
			// Get posts per page
			$posts_per_page = get_theme_mod( 'kindling_woocommerce_related_count' );
			$posts_per_page = $posts_per_page ? $posts_per_page : '3';
			// Get columns
			$columns = get_theme_mod( 'kindling_woocommerce_related_columns' );
			$columns = $columns ? $columns : '3';
			// Return array
			return array(
				'posts_per_page' => $posts_per_page,
				'columns'        => $columns,
			);
		}

		/**
		 * Adds an opening div "product-inner" around product entries.
		 *
		 * @since 1.0.0
		 */
		public static function add_shop_loop_item_inner_div() {
			echo '<div class="product-inner clr">';
		}

		/**
		 * Archive product div wrap.
		 *
		 * @since 1.1.4
		 */
		public static function archive_product_add_div_wrap() {
			echo '<div class="woo-entry-inner">';
		}

		/**
		 * Archive product category.
		 *
		 * @since 1.1.4
		 */
		public static function archive_product_category() {
			global $product;

			// Category
			echo $product->get_categories( ', ', '<span class="category">', '</span>' );

		}

		/**
		 * Archive product title.
		 *
		 * @since 1.1.4
		 */
		public static function archive_product_title() {

			// Title
			echo '<a href="'. esc_url( get_the_permalink() ) .'" class="title">'. get_the_title() .'</a>';

		}

		/**
		 * Archive product price/rating.
		 *
		 * @since 1.1.4
		 */
		public static function archive_product_price_rating() {

			// Price/Rating
			echo '<div class="inner">';
				woocommerce_template_loop_price();
				woocommerce_template_loop_rating();
			echo '</div>';

		}

		/**
		 * Archive product excerpt.
		 *
		 * @since 1.1.4
		 */
		public static function archive_product_excerpt() {
			global $post;

			// Description
			if ( ( kindling_is_woo_shop() || kindling_is_woo_tax() )
				&& get_theme_mod( 'kindling_woo_grid_list', true ) ) {
				$length = get_theme_mod( 'kindling_woo_list_excerpt_length', '60' );
				echo '<div class="woo-desc">';
					if ( ! $length ) {
						echo strip_shortcodes( $post->post_excerpt );
					} else {
						echo wp_trim_words( strip_shortcodes( $post->post_excerpt ), $length );
					}
				echo '</div>';
			}

		}

		/**
		 * Archive product add to cart.
		 *
		 * @since 1.1.4
		 */
		public static function archive_product_add_to_cart() {
			
			// Button add to cart
			woocommerce_template_loop_add_to_cart();

		}

		/**
		 * Archive product close div wrap.
		 *
		 * @since 1.1.4
		 */
		public static function archive_product_close_div_wrap() {
			echo '</div>';
		}

		/**
		 * Closes the "product-inner" div around product entries.
		 *
		 * @since 1.0.0
		 */
		public static function close_shop_loop_item_inner_div() {
			echo '</div><!-- .product-inner .clr -->';
		}

		/**
		 * Clear floats after single product summary.
		 *
		 * @since 1.0.0
		 */
		public static function clear_summary_floats() {
			echo '<div class="kindling-clear-after-summary clr"></div>';
		}

		/**
		 * Add wrap and user info to the account navigation.
		 *
		 * @since 1.0.0
		 */
		public static function kindling_before_account_navigation() {

			// Name to display
			$current_user = wp_get_current_user();

			if ( $current_user->display_name ) {
				$name = $current_user->display_name;
			} else {
				$name = esc_html__( 'Welcome!', 'kindling' );
			}
			$name = apply_filters( 'kindling_user_profile_name_text', $name );

			echo '<div class="woocommerce-MyAccount-tabs clr">';
				echo '<div class="kindling-user-profile clr">';
					echo '<div class="image">'. get_avatar( get_the_author_meta( 'user_email' ), 128 ) .'</div>';
					echo '<div class="user-info">';
						echo '<p class="name">'. esc_attr( $name ) .'</p>';
						echo '<a class="logout" href="'. esc_url( wp_logout_url( get_permalink() ) ) .'">'. esc_html__( 'Logout', 'kindling' ) .'</a>';
					echo '</div>';
				echo '</div>';

		}

		/**
		 * Add wrap to the account navigation.
		 *
		 * @since 1.0.0
		 */
		public static function kindling_after_account_navigation() {
			echo '</div>';
		}

		/**
		 * Adds an out of stock tag to the products.
		 *
		 * @since 1.0.0
		 */
		public static function add_shop_loop_item_out_of_stock_badge() {
			if ( function_exists( 'kindling_woo_product_instock' ) && ! kindling_woo_product_instock() ) { ?>
				<div class="outofstock-badge">
					<?php echo apply_filters( 'kindling_woo_outofstock_text', esc_html__( 'Out of Stock', 'kindling' ) ); ?>
				</div><!-- .product-entry-out-of-stock-badge -->
			<?php }
		}

		/**
		 * Adds container wrap for the thumbnail and title of the categories products.
		 *
		 * @since 1.1.1.1
		 */
		public static function add_container_wrap_category() {
			echo '<div class="product-inner clr">';
		}

		/**
		 * Adds a container div before the thumbnail for the categories products.
		 *
		 * @since 1.1.1.1
		 */
		public static function add_div_before_category_thumbnail( $category ) {
			echo '<div class="woo-entry-image clr">';
				echo '<a href="' . get_term_link( $category, 'product_cat' ) . '">';
		}

		/**
		 * Close a container div before the thumbnail for the categories products.
		 *
		 * @since 1.1.1.1
		 */
		public static function close_div_after_category_thumbnail() {
				echo '</a>';
			echo '</div>';
		}

		/**
		 * Adds a container div before the thumbnail for the categories products.
		 *
		 * @since 1.1.1.1
		 */
		public static function add_div_before_category_title( $category ) {
			echo '<div class="woo-entry-inner clr">';
				echo '<a href="' . get_term_link( $category, 'product_cat' ) . '">';
		}

		/**
		 * Add description if list view for the categories products.
		 *
		 * @since 1.1.1.1
		 */
		public static function add_category_description( $category ) {
				// Close category link openend in add_div_before_category_title()
				echo '</a>';

			// Var
			$term 			= get_term( $category->term_id, 'product_cat' );
			$description 	= $term->description;

			// Description
			if ( get_theme_mod( 'kindling_woo_grid_list', true )
				&& $description ) {
				echo '<div class="woo-desc">';
					echo '<div class="description">' . $description . '</div>';
				echo '</div>';
			}
		}

		/**
		 * Close a container div before the thumbnail for the categories products.
		 *
		 * @since 1.1.1.1
		 */
		public static function close_div_after_category_title() {
			echo '</div>';
		}

		/**
		 * Close container wrap for the thumbnail and title of the categories products.
		 *
		 * @since 1.1.1.1
		 */
		public static function close_container_wrap_category() {
			echo '</div>';
		}

		/**
		 * Before my account login.
		 *
		 * @since 1.0.0
		 */
		public static function kindling_login_wrap_before() {
			echo '<div class="kindling-loginform-wrap">';
		}

		/**
		 * After my account login.
		 *
		 * @since 1.0.0
		 */
		public static function kindling_login_wrap_after() {
			echo '</div>';
		}

		/**
		 * Returns our product thumbnail from our template parts based on selected style in theme mods.
		 *
		 * @since 1.0.0
		 */
		public static function loop_product_thumbnail() {
			if ( function_exists( 'wc_get_template' ) ) {
				// Get entry product media style
				$style = get_theme_mod( 'kindling_woo_product_entry_style' );
				$style = $style ? $style : 'image-swap';
				// Get entry product media template part
				wc_get_template( 'loop/thumbnail/'. $style .'.php' );
			}
		}

		/**
		 * Tweaks pagination arguments.
		 *
		 * @since 1.0.0
		 */
		public static function pagination_args( $args ) {
			$args['prev_text'] = '<i class="fa fa-angle-left"></i>';
			$args['next_text'] = '<i class="fa fa-angle-right"></i>';
			return $args;
		}

		/**
		 * Alter continue shoping URL.
		 *
		 * @since 1.0.0
		 */
		public static function continue_shopping_redirect( $return_to ) {
			$shop_id = woocommerce_get_page_id( 'shop' );
			if ( function_exists( 'icl_object_id' ) ) {
				$shop_id = icl_object_id( $shop_id, 'page' );
			}
			if ( $shop_id ) {
				$return_to = get_permalink( $shop_id );
			}
			return $return_to;
		}

		/**
		 * Add classes to WooCommerce product entries.
		 *
		 * @since 1.0.0
		 */
		public static function add_product_entry_classes( $classes, $class = '', $post_id = '' ) {
			global $product, $woocommerce_loop;
			if ( $product && ! empty( $woocommerce_loop['columns'] ) ) {
				if ( $product->get_rating_html() ) {
					$classes[] = 'has-rating';
				}
				$classes[] = 'col';
				$classes[] = kindling_grid_class( $woocommerce_loop['columns'] );
			}
			return $classes;
		}

		/**
		 * Disables the next/previous links if disabled via the customizer.
		 *
		 * @since 1.0.0
		 */
		public static function next_prev( $return ) {
			if ( is_woocommerce() && is_singular( 'product' ) && ! get_theme_mod( 'kindling_woo_next_prev', true ) ) {
				$return = false;
			}
			return $return;
		}

		/**
		 * Adds color accents for WooCommerce styles.
		 *
		 * @since 1.0.0
		 */
		public static function primary_texts( $texts ) {
			return array_merge( array(
				'.woocommerce-checkout .woocommerce-info a',
				'.woocommerce ul.products li.product .category a:hover',
				'.woocommerce ul.products li.product .button:hover',
				'.woocommerce ul.products li.product .product-inner .added_to_cart:hover',
				'.product_meta .posted_in a:hover',
				'.product_meta .tagged_as a:hover',
				'.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover',
				'.woocommerce div.product .woocommerce-tabs ul.tabs li.active a',
				'.woocommerce .kindling-grid-list a.active',
				'.woocommerce .kindling-grid-list a:hover',
			), $texts );
		}

		/**
		 * Adds border accents for WooCommerce styles.
		 *
		 * @since 1.0.0
		 */
		public static function primary_borders( $borders ) {
			return array_merge( array(
				'#current-shop-items-dropdown' => array( 'top' ),
				'.woocommerce div.product .woocommerce-tabs ul.tabs li.active a' => array( 'bottom' ),
				'.wcmenucart-details.count:before',
				'.woocommerce ul.products li.product .button:hover',
				'.woocommerce ul.products li.product .product-inner .added_to_cart:hover',
				'.woocommerce div.product .woocommerce-tabs ul.tabs li.active a',
				'.woocommerce .kindling-grid-list a.active',
				'.woocommerce .kindling-grid-list a:hover',
			), $borders );
		}

		/**
		 * Adds background accents for WooCommerce styles.
		 *
		 * @since 1.0.0
		 */
		public static function primary_backgrounds( $backgrounds ) {
			return array_merge( array(
				'.wcmenucart-details.count',
				'.woocommerce-message a',
				'.woocommerce-error a',
				'.woocommerce-info a',
				'.woocommerce .widget_price_filter .ui-slider .ui-slider-handle',
				'.woocommerce .widget_price_filter .ui-slider .ui-slider-range',
			), $backgrounds );
		}

		/**
		 * Adds background hover accents for WooCommerce styles.
		 *
		 * @since 1.0.0
		 */
		public static function hover_primary_backgrounds( $hover ) {
			return array_merge( array(
				'.woocommerce-error a:hover',
				'.woocommerce-info a:hover',
				'.woocommerce-message a:hover',
			), $hover );
		}

		/**
		 * Adds border color elements for WooCommerce styles.
		 *
		 * @since 1.0.0
		 */
		public static function border_color_elements( $elements ) {
			return array_merge( array(
				'.woocommerce table.shop_table',
				'.woocommerce table.shop_table td',
				'.woocommerce-cart .cart-collaterals .cart_totals tr td',
				'.woocommerce-cart .cart-collaterals .cart_totals tr th',
				'.woocommerce table.shop_table tbody th',
				'.woocommerce table.shop_table tfoot td',
				'.woocommerce table.shop_table tfoot th',
				'.woocommerce .order_details',
				'.woocommerce .shop_table.order_details tfoot th',
				'.woocommerce .shop_table.customer_details th',
				'.woocommerce .cart-collaterals .cross-sells',
				'.woocommerce-page .cart-collaterals .cross-sells',
				'.woocommerce .cart-collaterals .cart_totals',
				'.woocommerce-page .cart-collaterals .cart_totals',
				'.woocommerce .cart-collaterals h2',
				'.woocommerce .cart-collaterals h2',
				'.woocommerce .cart-collaterals h2',
				'.woocommerce-cart .cart-collaterals .cart_totals .order-total th',
				'.woocommerce-cart .cart-collaterals .cart_totals .order-total td',
				'.woocommerce ul.order_details',
				'.woocommerce .shop_table.order_details tfoot th',
				'.woocommerce .shop_table.customer_details th',
				'.woocommerce .woocommerce-checkout #customer_details h3',
				'.woocommerce .woocommerce-checkout h3#order_review_heading',
				'.woocommerce-checkout #payment ul.payment_methods',
				'.woocommerce-checkout form.login',
				'.woocommerce-checkout form.checkout_coupon',
				'.woocommerce-checkout-review-order-table tfoot th',
				'.woocommerce-checkout #payment',
				'.woocommerce ul.order_details',
				'.woocommerce #customer_login > div',
				'.woocommerce .kindling-loginform-wrap',
				'.woocommerce .lost_reset_password',
				'.woocommerce .col-1.address',
				'.woocommerce .col-2.address',
				'.woocommerce-checkout .woocommerce-info',
				'.woocommerce div.product form.cart',
				'.product_meta',
				'.woocommerce div.product .woocommerce-tabs ul.tabs',
				'.woocommerce #reviews #comments ol.commentlist li .comment_container',
				'p.stars span a',
				'.woocommerce ul.product_list_widget li',
				'.woocommerce .widget_shopping_cart .cart_list li',
				'.woocommerce.widget_shopping_cart .cart_list li',
				'.woocommerce ul.product_list_widget li:first-child',
				'.woocommerce .widget_shopping_cart .cart_list li:first-child',
				'.woocommerce.widget_shopping_cart .cart_list li:first-child',
				'.widget_product_categories li a',
				'.woocommerce .kindling-toolbar',
				'.woocommerce .products.list .product',
			), $elements );
		}

		/**
		 * Alter WooCommerce category classes
		 *
		 * @since 1.0.0
		 */
		public static function product_cat_class( $classes ) {
			global $woocommerce_loop;
			$classes[] = 'col';
			$classes[] = kindling_grid_class( $woocommerce_loop['columns'] );
			return $classes;
		}

		/**
		 * Adds cart icon to menu
		 *
		 * @since 1.0.0
		 */
		public static function menu_cart_icon( $items, $args ) {

			// Only used for the main menu
			if ( 'main_menu' != $args->theme_location ) {
				return $items;
			}

			// Get style
			$style 			= kindling_menu_cart_style();
			$header_style 	= kindling_header_style();

			// Return items if no style
			if ( ! $style ) {
				return $items;
			}

			// Toggle class
			$toggle_class = 'toggle-cart-widget';

			// Define classes to add to li element
			$classes = array( 'woo-menu-icon' );
			
			// Add style class
			$classes[] = 'wcmenucart-toggle-'. $style;

			// Prevent clicking on cart and checkout
			if ( 'custom_link' != $style && ( is_cart() || is_checkout() ) ) {
				$classes[] = 'nav-no-click';
			}

			// Add toggle class
			else {
				$classes[] = $toggle_class;
			}

			// Turn classes into string
			$classes = implode( ' ', $classes );
			
			// Add cart link to menu items
			if ( 'full_screen' == $header_style ) {
				$items .= '<li class="woo-cart-link"><a href="'. esc_url( WC()->cart->get_cart_url() ) .'">'. esc_html__( 'Your cart', 'kindling' ) .'</a></li>';
			} else {
				$items .= '<li class="'. $classes .'">'. kindling_wcmenucart_menu_item() .'</li>';
			}
			
			// Return menu items
			return $items;
		}

		/**
		 * Add menu cart item to the Woo fragments so it updates with AJAX
		 *
		 * @since 1.0.0
		 */
		public static function menu_cart_icon_fragments( $fragments ) {
			$fragments['.wcmenucart'] = kindling_wcmenucart_menu_item();
			return $fragments;
		}

		/**
		 * Add typography options for the WooCommerce product title
		 *
		 * @since 1.0.0
		 */
		public static function typography_settings( $settings ) {
			$settings['woo_product_title'] = array(
				'label' 				=> esc_html__( 'WooCommerce Product Title', 'kindling' ),
				'target' 				=> '.woocommerce div.product .product_title',
				'defaults' 				=> array(
					'font-size' 		=> '24',
					'color' 			=> '#333333',
					'line-height' 		=> '1.4',
					'letter-spacing' 	=> '0.6',
				),
			);
			return $settings;
		}

	}

}

$kindling_woocommerce_config = new Kindling_WooCommerce_Config();