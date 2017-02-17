<?php
/**
 * Top Menu Header Style
 *
 * @package Kindling Theme
 */

# Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

# Menu position
$position 	= get_theme_mod( 'kindling_top_header_menu_position', 'before' );

# Search style
$search 	= kindling_menu_search_style(); ?>

<?php
if ( 'after' == $position ) { ?>
	<div class="header-bottom clr">
		<div class="container">
			<?php get_template_part( 'partials/header/logo' ); ?>
		</div>
	</div>
<?php
} ?>

<div class="header-top clr">

	<?php do_action( 'kindling_before_header_inner' ); ?>

	<div id="site-header-inner" class="container clr">

		<?php
		# Search header replace
		if ( 'header_replace' == $search ) {
			get_template_part( 'partials/header/search-replace' );
		} ?>

		<div class="left clr">

			<div class="inner">
				
				<?php get_template_part( 'partials/header/nav' ); ?>

				<?php get_template_part( 'partials/header/mobile-icon' ); ?>

			</div>
			
		</div>

		<div class="right clr">

			<div class="inner">
				
				<?php if ( true == get_theme_mod( 'kindling_menu_social', false ) ) {
					get_template_part( 'partials/header/social' );
				}

				kindling_top_header_search();

				# Search style
				if ( 'drop_down' == $search ) {
					get_template_part( 'partials/header/search-dropdown' );
				} else if ( 'overlay' == $search ) {
					get_template_part( 'partials/header/search-overlay' );
				} ?>

			</div>

		</div>

	</div><!-- #site-header-inner -->

	<?php do_action( 'kindling_after_header_inner' ); ?>

</div><!-- .header-top -->

<?php
if ( 'before' == $position ) { ?>
	<div class="header-bottom clr">
		<div class="container">
			<?php get_template_part( 'partials/header/logo' ); ?>
		</div>
	</div>
<?php
} ?>