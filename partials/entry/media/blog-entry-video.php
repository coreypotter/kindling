<?php
/**
 * Blog entry video format media
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

# Get post video
$video = kindling_get_post_video_html(); ?>

<?php
# Display video if one exists and it's not a password protected post
if ( $video && ! post_password_required() ) : ?>

	<div class="blog-entry-media thumbnail clr">

		<div class="blog-entry-video">

			<?php echo $video; ?>

		</div><!-- .blog-entry-video -->

	</div><!-- .blog-entry-media -->

<?php
# Else display post thumbnail
else : ?>

	<?php get_template_part( 'partials/entry/media/blog-entry' ); ?>

<?php endif; ?>