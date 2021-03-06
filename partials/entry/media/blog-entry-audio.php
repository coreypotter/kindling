<?php
/**
 * Blog entry audio format media
 *
 * @package Kindling Theme
 */

# Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

# Return if Kindling Extra is not active
if ( ! class_exists( 'Kindling_Extra' ) ) {
	return;
} ?>

<?php $audio = kindling_get_post_audio_html(); ?>

<?php if ( $audio ) : ?>
	
	<div class="thumbnail"><?php echo $audio; ?></div>

<?php
# Else display post thumbnail
else : ?>

	<?php get_template_part( 'partials/entry/media/blog-entry' ); ?>

<?php endif; ?>