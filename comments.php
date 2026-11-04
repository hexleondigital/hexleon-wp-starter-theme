<?php
/**
 * The template for displaying comments and comment form
 *
 * @package hexleonwp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() ) {
	return;
}

$commenter = wp_get_current_commenter();
$req       = get_option( 'require_name_email' );
$aria_req  = ( $req ? " aria-required='true'" : '' );
$html_req  = ( $req ? " required='required'" : '' );
?>

<div id="comments" class="comments-area mt-16 pt-12 border-t border-slate-200">

	<?php if ( have_comments() ) : ?>
		<div class="comments-header flex items-center justify-between mb-8">
			<h2 class="comments-title text-2xl font-bold text-slate-900 tracking-tight">
				<?php
				$hexleonwp_comment_count = get_comments_number();
				if ( '1' === $hexleonwp_comment_count ) {
					printf(
						/* translators: 1: title. */
						esc_html__( '1 Comment on &ldquo;%1$s&rdquo;', 'hexleonwp' ),
						'<span>' . wp_kses_post( get_the_title() ) . '</span>'
					);
				} else {
					printf(
						/* translators: 1: comment count number, 2: title. */
						esc_html( _nx( '%1$s Comment', '%1$s Comments', $hexleonwp_comment_count, 'comments title', 'hexleonwp' ) ),
						number_format_i18n( $hexleonwp_comment_count )
					);
				}
				?>
			</h2>
			<span class="text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
				<?php printf( esc_html( _n( '%s Total', '%s Total', $hexleonwp_comment_count, 'hexleonwp' ) ), number_format_i18n( $hexleonwp_comment_count ) ); ?>
			</span>
		</div>

		<?php the_comments_navigation(); ?>

		<ol class="comment-list space-y-6 mb-12">
			<?php
			wp_list_comments( array(
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 48,
			) );
			?>
		</ol>

		<?php the_comments_navigation(); ?>

		<?php if ( ! comments_open() ) : ?>
			<div class="p-4 rounded-xl bg-slate-100 text-slate-600 text-sm text-center mb-8">
				<p><?php esc_html_e( 'Comments are closed for this article.', 'hexleonwp' ); ?></p>
			</div>
		<?php endif; ?>

	<?php endif; ?>

	<?php
	// Custom fields for guest users
	$fields = array(
		'author' => '<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">' .
			'<div class="comment-form-author">' .
				'<label for="author" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">' . esc_html__( 'Name', 'hexleonwp' ) . ( $req ? ' <span class="text-red-500">*</span>' : '' ) . '</label>' .
				'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245"' . $aria_req . $html_req . ' class="form-input" placeholder="' . esc_attr__( 'Your Name', 'hexleonwp' ) . '" />' .
			'</div>',
		'email'  => '<div class="comment-form-email">' .
				'<label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">' . esc_html__( 'Email', 'hexleonwp' ) . ( $req ? ' <span class="text-red-500">*</span>' : '' ) . '</label>' .
				'<input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" maxlength="100" aria-describedby="email-notes"' . $aria_req . $html_req . ' class="form-input" placeholder="' . esc_attr__( 'name@example.com', 'hexleonwp' ) . '" />' .
			'</div>',
		'url'    => '<div class="comment-form-url">' .
				'<label for="url" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">' . esc_html__( 'Website', 'hexleonwp' ) . '</label>' .
				'<input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" maxlength="200" class="form-input" placeholder="' . esc_attr__( 'https://yourwebsite.com', 'hexleonwp' ) . '" />' .
			'</div></div>',
		'cookies' => '<div class="comment-form-cookies-consent flex items-start gap-2.5 mb-6">' .
				'<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . ( empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"' ) . ' class="mt-0.5 h-4 w-4 rounded border-slate-300 text-brand-accent focus:ring-brand-accent cursor-pointer" />' .
				'<label for="wp-comment-cookies-consent" class="text-xs text-slate-500 leading-normal cursor-pointer select-none">' . esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'hexleonwp' ) . '</label>' .
			'</div>',
	);

	comment_form( array(
		'class_container'      => 'comment-respond mt-10 bg-white p-6 sm:p-10 rounded-2xl border border-slate-200 shadow-sm',
		'class_form'           => 'comment-form',
		'title_reply_before'   => '<div class="mb-4"><h3 id="reply-title" class="comment-reply-title text-xl sm:text-2xl font-bold text-slate-900 tracking-tight flex items-center justify-between"><span>',
		'title_reply_after'    => '</span></h3></div>',
		'title_reply'          => esc_html__( 'Leave a Reply', 'hexleonwp' ),
		'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'hexleonwp' ),
		'cancel_reply_link'    => esc_html__( 'Cancel Reply', 'hexleonwp' ),
		'cancel_reply_before'  => '<span class="text-xs font-semibold text-red-600 hover:text-red-700 underline ml-3 font-normal">',
		'cancel_reply_after'   => '</span>',
		'comment_notes_before' => '<p class="text-xs text-slate-500 mb-6 leading-relaxed">' . esc_html__( 'Your email address will not be published. Required fields are marked *', 'hexleonwp' ) . '</p>',
		'comment_notes_after'  => '',
		'comment_field'        => '<div class="comment-form-comment mb-5">' .
			'<label for="comment" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">' . esc_html_x( 'Comment', 'noun', 'hexleonwp' ) . ' <span class="text-red-500">*</span></label>' .
			'<textarea id="comment" name="comment" cols="45" rows="5" maxlength="65525" required="required" class="form-input min-h-[130px] resize-y" placeholder="' . esc_attr__( 'Join the discussion and write your comment here...', 'hexleonwp' ) . '"></textarea>' .
		'</div>',
		'fields'               => $fields,
		'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s</button>',
		'class_submit'         => 'btn-primary w-full sm:w-auto cursor-pointer',
		'label_submit'         => esc_html__( 'Post Comment', 'hexleonwp' ),
		'submit_field'         => '<div class="form-submit pt-2">%1$s %2$s</div>',
	) );
	?>

</div>
