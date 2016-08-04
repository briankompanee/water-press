<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Water_Press
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function water_press_body_classes( $classes ) {

    global $post;

    // Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

    // Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}

    // Adds a class of custom-background-color to sites with a custom background color.
    if ( get_background_color() != 'ffffff' ) {
		$classes[] = 'custom-background-color';
	}

    if( !( is_active_sidebar( 'right-sidebar' )) || is_page_template( 'template-home.php' ) ) {
		$classes[] = 'full-width';
	}

    if( is_page() ){
		$sidebar_layout = get_post_meta( $post->ID, 'water_press_sidebar_layout', true );
        if( $sidebar_layout == 'no-sidebar' )
		$classes[] = 'full-width';
	}

	return $classes;
}
add_filter( 'body_class', 'water_press_body_classes' );

/**
* Hook to move comment text field to the bottom in WP 4.4
*
* @link http://www.wpbeginner.com/wp-tutorials/how-to-move-comment-text-field-to-bottom-in-wordpress-4-4/
*/
function water_press_move_comment_field_to_bottom( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
}
add_filter( 'comment_form_fields', 'water_press_move_comment_field_to_bottom' );

/**
 * Callback function for Comment List *
 *
 * @link https://codex.wordpress.org/Function_Reference/wp_list_comments
 */
function water_press_theme_comment( $comment, $args, $depth ){
    $GLOBALS['comment'] = $comment;
	extract( $args, EXTR_SKIP );

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
	<<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
	<?php printf( __( '<b class="fn">%s</b>', 'water-press' ), get_comment_author_link() ); ?>
	</div>
	<?php if ( $comment->comment_approved == '0' ) : ?>
		<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'water-press' ); ?></em>
		<br />
	<?php endif; ?>

	<div class="comment-metadata commentmetadata">
    <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
		<time>
        <?php
			/* translators: 1: date, 2: time */
			printf( __( '%1$s - %2$s', 'water-press' ), get_comment_date( 'M n, Y' ), get_comment_time() ); ?>
        </time>
    </a>
	</div>

    <div class="comment-content"><?php comment_text(); ?></div>

	<div class="reply">
	<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php
}

/**
 * Function to get Sections
 */
function water_press_get_sections(){
    $sections = array( 'hero', 'about', 'cta1', 'blog', 'experience', 'portfolio', 'cta2', 'contact' );
    $enabled_section = array();
    foreach ( $sections as $section ){
        if ( esc_attr( get_theme_mod( 'water_press_ed_' . $section . '_section' ) ) == 1 ){
            $enabled_section[] = array(
                'id' => $section,
                'menu_text' => esc_attr( get_theme_mod( 'water_press_' . $section . '_section_menu_title','' ) ),
            );
        }
    }
    return $enabled_section;
}
/**
 * Callback for Social Links
*/
function water_press_social_cb(){
    $facebook = get_theme_mod( 'water_press_facebook' );
    $twitter = get_theme_mod( 'water_press_twitter' );
    $pinterest = get_theme_mod( 'water_press_pinterest' );
    $linkedin = get_theme_mod( 'water_press_linkedin' );
    $google_plus = get_theme_mod( 'water_press_google_plus' );

    if( $facebook || $twitter || $pinterest || $linkedin || $google_plus ){ ?>
    <ul class="social-networks">
		<?php
            if( $facebook ) echo '<li><a href="'. esc_url( $facebook ) .'" target="_blank" title="'. esc_html__( 'Facebook', 'water-press' ) .'"><span class="fa fa-facebook"></span></a></li>';
            if( $twitter ) echo '<li><a href="'. esc_url( $twitter ) .'" target="_blank" title="'. esc_html__( 'Twitter', 'water-press' ) .'"><span class="fa fa-twitter"></span></a></li>';
            if( $pinterest ) echo '<li><a href="'. esc_url( $pinterest ) .'" target="_blank" title="'. esc_html__( 'Pinterest', 'water-press' ) .'"><span class="fa fa-pinterest-p"></span></a></li>';
            if( $linkedin ) echo '<li><a href="'. esc_url( $linkedin ) .'" target="_blank" title="'. esc_html__( 'LinkedIn', 'water-press' ) .'"><span class="fa fa-linkedin"></span></a></li>';
            if( $google_plus ) echo '<li><a href="'. esc_url( $google_plus ) .'" target="_blank" title="'. esc_html__( 'Google Plus', 'water-press' ) .'"><span class="fa fa-google-plus"></a></li>';
        ?>
	</ul>
    <?php }
}
add_action( 'water_press_social', 'water_press_social_cb' );

/**
 * Custom CSS
*/
function water_press_custom_css(){
    $custom_css = get_theme_mod( 'water_press_custom_css' );
    if( !empty( $custom_css ) ){
		echo '<style type="text/css">';
		echo wp_strip_all_tags( $custom_css );
		echo '</style>';
	}
}
add_action( 'wp_head', 'water_press_custom_css', 100 );

if ( ! function_exists( 'water_press_excerpt_more' ) && ! is_admin() ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... *
 */
function water_press_excerpt_more() {
	return ' &hellip; ';
}
add_filter( 'excerpt_more', 'water_press_excerpt_more' );
endif;

if ( ! function_exists( 'water_press_excerpt_length' ) ) :
/**
 * Changes the default 55 character in excerpt
*/
function water_press_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'water_press_excerpt_length' );
endif;

/**
 * excerpt length for portfolio section
*/
function water_press_excerpt_length_alt( $length ){
    return 12;
}

/**
 * Footer Credits
*/
function water_press_footer_credit(){
    $text  = '<div class="site-info">';
    $text .= sprintf( esc_html__( 'Copyright &copy;  %s', 'water-press' ), date_i18n( 'Y' ) . ' <a href="' . esc_url( home_url( '/' ) ) .'">' . esc_html( get_bloginfo( 'name' ) ) . '</a> &middot; ' );
    $text .= sprintf( esc_html__( 'Powered by: %s', 'water-press' ), '<a href="'. esc_url( __( 'https://wordpress.org/', 'water-press' ) ) .'" target="_blank">WordPress</a>' );
    $text .= '</div>';
    echo apply_filters( 'water_press_footer_text', $text );
}
add_action( 'water_press_footer', 'water_press_footer_credit' );

/**
 * Return sidebar layouts for pages
*/
function water_press_sidebar_layout(){
    global $post;

    if( get_post_meta( $post->ID, 'water_press_sidebar_layout', true ) ){
        return get_post_meta( $post->ID, 'water_press_sidebar_layout', true );
    }else{
        return 'right-sidebar';
    }
}