<?php
/**
 * Gallery Style WooCommerce
 *
 * @package Kindling Theme
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Return dummy image if no featured image is defined
if ( ! has_post_thumbnail() ) {
	kindling_woo_placeholder_img();
	return;
}

// Get global product data
global $product;

// Get first image
$thumbnail_id  = get_post_thumbnail_id();

// Get gallery images
$attachment_ids = $product->get_gallery_attachment_ids();

// Get attachments count
$attachments_count = count( $attachment_ids );

// If there are attachments display slider
if ( $attachment_ids ) : ?>

	<div class="product-entry-slider woo-entry-image clr">

		<?php
		// Define counter variable
		$count=0;

		if ( has_post_thumbnail() ) : ?>

			<div class="kindling-slider-slide">
				<a href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link">
					<?php
					echo wp_get_attachment_image( $thumbnail_id, 'shop_catalog', '', array(
				        'alt'           => get_the_title(),
				        'itemprop'      => 'image',
				    ) ); ?>
			    </a>
			</div>

		<?php
		endif;

		if ( $attachments_count > 0 ) :

			// Loop through images
			foreach ( $attachment_ids as $attachment_id ) :

				// Add to counter
				$count++;

				// Only display the first 5 images
				if ( $count < 5 ) : ?>

					<div class="kindling-slider-slide">
						<a href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link">
							<?php
							echo wp_get_attachment_image( $attachment_id, 'shop_catalog', '', array(
						        'alt'           => get_the_title(),
						        'itemprop'      => 'image',
						    ) ); ?>
					    </a>
					</div>

				<?php
				endif;

			endforeach;

		endif; ?>

	</div>

<?php
// There aren't any images so lets display the featured image
else :

	wc_get_template(  'loop/thumbnail/featured-image.php' );

endif; ?>