 <?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments and the comment
 * form. The actual display of comments is handled by a callback to
 * kindling_comment() which is located at functions/comments-callback.php
 *
 * @package Kindling Theme
 */

# Return if password is required
if ( post_password_required() ) { return; }

# Add classes to the comments main wrapper
$classes = 'comments-area clr';

if ( get_comments_number() != 0 ) {	$classes .= ' has-comments'; }
if ( !comments_open() && get_comments_number() < 1 ) { $classes .= ' empty-closed-comments'; return; }
if ( 'full-screen' == kindling_post_layout() ) { $classes .= ' container'; } 
?>

<section id="comments" class="<?php echo esc_attr( $classes ); ?>">
	<?php if ( have_comments() ) : ?>
		<h2 class="theme-heading comments-title">
			<span class="text"><?php printf( _nx( 'This Post Has One Comment', 'This Post Has %1$s Comments', get_comments_number(), 'comments title', 'kindling' ), number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' ); ?></span>
		</h2>
		<ol class="comment-list">
			<?php # List comments
			wp_list_comments( array(
				'callback' 	=> 'kindling_comment',
				'style'     => 'ol',
				'format'    => 'html5',
			) ); ?>
		</ol><!-- .comment-list -->

		<?php # Display comment navigation - WP 4.4.0
		if ( function_exists( 'the_comments_navigation' ) ) :
			the_comments_navigation( array(
				'prev_text' => '<span class="fa fa-angle-left"></span>',
				'next_text' => '<span class="fa fa-angle-right"></span>',
			) );

		elseif ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<div class="comment-navigation clr">
				<?php paginate_comments_links( array(
					'prev_text' => '<span class="fa fa-angle-left"></span>',
					'next_text' => '<span class="fa fa-angle-right"></span>',
				) ); ?>
			</div>
		<?php endif; ?>

		<?php
		# Display comments closed message
		if ( ! comments_open() && get_comments_number() ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.' , 'kindling' ); ?></p>
		<?php endif; ?>

	<?php endif; # have_comments() ?>

	<?php
	function kindling_modify_comment_form_fields( $fields ){
		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );

		$fields['author'] 	= '<div class="comment-form-author"><input type="text" name="author" id="author" value="'. esc_attr( $commenter['comment_author'] ) .'" placeholder="'. esc_html__( 'Name (required)', 'kindling' ).'" size="22" tabindex="1"'. ( $req ? ' aria-required="true"' : '' ) .' class="input-name" /></div>';
		$fields['email'] 	= '<div class="comment-form-email"><input type="text" name="email" id="email" value="'. esc_attr( $commenter['comment_author_email'] ) .'" placeholder="'. esc_html__( 'Email (required)', 'kindling' ).'" size="22" tabindex="2"'. ( $req ? ' aria-required="true"' : '' ) .' class="input-email" /></div>';
		$fields['url'] 		= '<div class="comment-form-url"><input type="text" name="url" id="url" value="'. esc_attr( $commenter['comment_author_url'] ) .'" placeholder="'. esc_html__( 'Website', 'kindling' ).'" size="22" tabindex="3" class="input-website" /></div>';

		return $fields;
	}
	add_filter( 'comment_form_default_fields', 'kindling_modify_comment_form_fields' );

	comment_form(
		array(
			'must_log_in'			=> '<p class="must-log-in">'.  sprintf( esc_html__( 'You must be %slogged in%s to post a comment.', 'kindling' ), '<a href="'. wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) .'">', '</a>' ) .'</p>',
			'logged_in_as'			=> '<p class="logged-in-as">'. esc_html__( 'Logged in as', 'kindling' ) .' <a href="'. admin_url( 'profile.php' ) .'">'. $user_identity .'</a>. <a href="' . wp_logout_url( get_permalink() ) .'" title="'. esc_html__( 'Log out of this account', 'kindling' ) .'">'. esc_html__( 'Log out &raquo;', 'kindling' ) .'</a></p>',
			'comment_notes_before'	=> false,
			'comment_notes_after'	=> false,
			'comment_field'			=> '<div class="comment-textarea"><textarea name="comment" id="comment" cols="39" rows="4" tabindex="4" class="textarea-comment" placeholder="'. esc_html__( 'Your Comment Here...', 'kindling' ) .'"></textarea></div>',
			'id_submit'				=> 'comment-submit',
			'label_submit'			=> esc_html__( 'Post Comment', 'kindling' ),
		)
	); ?>
</section><!-- #comments -->