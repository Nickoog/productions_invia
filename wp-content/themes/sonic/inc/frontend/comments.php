<?php
/**
 * Sonic comment functions
 *
 * @package WordPress
 * @subpackage Sonic
 * @version 2.2.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'sonic_comment' ) ) {
	/**
	 * Basic Comments function
	 *
	 * @since Sonic 1.0.0
	 * @param object $comment
	 * @param array $args
	 * @param int $depth
	 * @return void
	 */
	function sonic_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :

		case 'pingback' :

		case 'trackback' :
			// Display trackbacks differently than normal comments. ?>
			<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
				<p><?php esc_html_e( 'Pingback:', 'sonic' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( 'Edit', 'sonic' ), '<span class="ping-meta"><span class="edit-link">', '</span></span>' ); ?></p>
			<?php
					break;

		default :
				// Proceed with normal comments.
			?>
			<li id="li-comment-<?php comment_ID(); ?>">
				<article id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
					<div class="comment-author vcard">
						<?php echo get_avatar( $comment, 80 ); ?>
					</div><!-- .comment-author -->

					<header class="comment-meta">
						<cite class="fn"><?php comment_author_link(); ?></cite>
							<?php printf(
								'<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								sprintf( _x( '%1$s at %2$s', '1: date, 2: time', 'sonic' ), get_comment_date(), get_comment_time() )
							);
							edit_comment_link( esc_html__( 'Edit', 'sonic' ), '<span class="edit-link">', '<span>' );
						?>
					</header><!-- .comment-meta -->

					<div class="comment-content">
						<?php if ( '0' == $comment->comment_approved ) { ?>
							<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'sonic' ); ?></p>
						<?php } ?>
						<?php comment_text(); ?>
					</div><!-- .comment-content -->

					<div class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'reply_text' => esc_html__( 'Reply', 'sonic' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</div><!-- .reply -->
				</article><!-- #comment-## -->
			<?php
				break;
			endswitch; // End comment_type check.
	}
} // ends check for sonic_comment()