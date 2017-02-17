<?php
/**
 * Blog single audio format media
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
}

# Get audio html
$audio = kindling_get_post_audio_html();

# Display audio if audio exists and the post isn't protected
if ( $audio && ! post_password_required()  ) : ?>

	<div id="post-media" class="thumbnail clr">
		<div class="blog-post-audio clr"><?php echo $audio; ?></div>
	</div>

<?php
# Else display post thumbnail
else : ?>

	<?php get_template_part( 'partials/single/media/blog-single' ); ?>

<?php endif; ?>