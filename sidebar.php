<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Kindling Theme
 */

if ( in_array( kindling_post_layout(), array( 'full-screen', 'full-width' ) ) ) { return; } 
?>

<?php do_action( 'kindling_before_sidebar' ); ?>
<aside id="sidebar" class="sidebar-container widget-area sidebar-primary" itemscope itemtype="//schema.org/WPSideBar">

	<?php do_action( 'kindling_before_sidebar_inner' ); ?>
	<div id="sidebar-inner" class="clr">
		<?php
		if ( $sidebar = kindling_get_sidebar() ) {
			dynamic_sidebar( $sidebar );
		} ?>
	</div><!-- #sidebar-inner -->
	<?php do_action( 'kindling_after_sidebar_inner' ); ?>

</aside><!-- #sidebar -->
<?php do_action( 'kindling_after_sidebar' ); ?>