<?php if ( post_password_required() ) : ?>
	<p class="nocomments"><?php _e( 'This post is password protected. Enter the password to view comments.', 'react' ); ?></p>
	<?php 
	return; 
endif; ?>
<div id="comments">
<?php if ( have_comments() ) : ?>
	<div class="comment-number clear">
		<h3>
			<?php comments_number( __( 'No Comments', 'react' ), __( 'One Comment', 'react' ), sprintf( __( '%s Comments', 'react' ), get_comments_number() ) ); ?>
		</h3>
		<?php if ( comments_open() ) : ?>
			<a id="leavecomment" href="#respond" title="<?php esc_attr_e( 'Post a comment', 'react' ); ?>"> <?php _e( 'Post a comment', 'react' ); ?></a>
		<?php endif; ?>
	</div><!--end comment-number-->
	<ol class="commentlist">
		<?php wp_list_comments( 'type=comment&callback=react_custom_comment' ); ?>
	</ol>

	<div class="pagination clear">
		<div class="alignleft"><?php next_comments_link( __( '&laquo; Older Comments', 'react' ) ); ?></div>
		<div class="alignright"><?php previous_comments_link( __( 'Newer Comments &raquo;', 'react' ) ); ?></div>
	</div>
	<?php if ( ! empty($comments_by_type['pings']) ) : ?>
		<h3 class="pinghead"><?php _e( 'Trackbacks &amp; Pingbacks', 'react' ); ?></h3>
		<ol class="pinglist">
			<?php wp_list_comments( 'type=pings&callback=react_list_pings' ); ?>
		</ol>

		<div class="pagination clear">
			<div class="alignleft"><?php next_comments_link( __( '&laquo; Older Pingbacks', 'react' ) ); ?></div>
			<div class="alignright"><?php previous_comments_link( __( 'Newer Pingbacks &raquo;', 'react' ) ); ?></div>
		</div>
	<?php endif; ?>
	<?php if ( ! comments_open() ) : ?>
		<p class="note"><?php _e( 'Comments are closed.', 'react' ); ?></p>
	<?php endif; ?>
<?php elseif ( ! comments_open() && ! is_page() && ! has_post_format( 'gallery' ) ) : ?>
	<p class="note"><?php _e( 'Comments are closed.', 'react' ); ?></p>
<?php elseif ( comments_open() ) : ?>
	<!-- If comments are open, but there are no comments. -->
	<div class="comment-number">
		<span><?php _e( 'No comments yet', 'react' ); ?></span>
	</div>
<?php endif; ?>
</div><!--end comments-->

<?php

$req = get_option( 'require_name_email' );
$field = '<p><label for="%1$s" class="comment-field">%2$s</label><input class="text-input" type="text" name="%1$s" id="%1$s" value="%3$s" size="22" tabindex="%4$d" /></p>';
comment_form( array(
	'comment_field' => '<fieldset><label for="comment" class="comment-field">' . _x( 'Comment', 'noun', 'react' ) . '</label><textarea id="comment" name="comment" rows="15" aria-required="true" tabindex="4"></textarea></fieldset>',
	'comment_notes_before' => '',
	'comment_notes_after' => sprintf(
		'<p class="guidelines">%3$s</p>' . "\n" . '<p class="comments-rss"><a href="%1$s">%2$s</a></p>',
		esc_attr( get_post_comments_feed_link() ),
		__( 'Subscribe to this comment feed via RSS', 'react' ),
		__( 'Basic HTML is allowed. Your email address will not be published.', 'react' )
	),
	'fields' => array(
		'author' => sprintf(
			$field,
			'author',
			(
				$req ?
				__( 'Name <span>(required)</span>:', 'react' ) :
				__( 'Name:', 'react' )
			),
			esc_attr( $comment_author ),
			1
		),
		'email' => sprintf(
			$field,
			'email',
			(
				$req ?
				__( 'Email <span>(required)</span>:', 'react' ) :
				__( 'Email:', 'react' )
			),
			esc_attr( $comment_author_email ),
			2
		),
		'url' => sprintf(
			$field,
			'url',
			__( 'Website:', 'react' ),
			esc_attr( $comment_author_url ),
			3
		),
	),
	'label_submit' => __( 'Submit Comment', 'react' ),
	'logged_in_as' => '<p class="com-logged-in">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out &raquo;</a>', 'react' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</p>',
	'title_reply' => __( 'Leave a Reply', 'react' ),
	'title_reply_to' => __( 'Leave a comment to %s', 'react' ),
) );