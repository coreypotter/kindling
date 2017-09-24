<?php
/**
 * The template for displaying a "No posts found" message.
 *
 * @package Kindling Theme
 */
?>

<div class="page-content">
	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) { ?>
		<p><?php printf( esc_html__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'kindling' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
	<?php } elseif ( is_search() ) { ?>
		<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'kindling' ); ?></p>
	<?php } elseif ( is_category() ) { ?>
		<p><?php esc_html_e( 'There aren\'t any posts currently published in this category.', 'kindling' ); ?></p>
	<?php } elseif ( is_tax() ) { ?>
		<p><?php esc_html_e( 'There aren\'t any posts currently published under this taxonomy.', 'kindling' ); ?></p>
	<?php } elseif ( is_tag() ) { ?>
		<p><?php esc_html_e( 'There aren\'t any posts currently published under this tag.', 'kindling' ); ?></p>
	<?php } else { ?>
		<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'kindling' ); ?></p>
	<?php } ?>
</div><!-- .page-content -->