<?php
/**
 * Blog single tags
 *
 * @package Kindling Theme
 */

# Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

# Display tags ?>
<div class="post-tags clr">
	<?php the_tags(); ?>
</div>