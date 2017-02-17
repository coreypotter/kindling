<?php
/**
 * Blog single video format media
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
$video = kindling_get_post_video_html();

# Display video if one exists and it's not a password protected post
if ( $video && ! post_password_required() ) : ?>

	<div id="post-media" class="thumbnail clr">

		<div class="blog-post-video">

			<?php echo $video; ?>

		</div><!-- .blog-post-video -->

	</div><!-- #post-media -->

<?php
# Else display post thumbnail
else : ?>

	<?php get_template_part( 'partials/single/media/blog-single' ); ?>

<?php endif; ?>