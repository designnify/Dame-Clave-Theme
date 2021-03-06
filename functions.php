<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Dame Clave' );
define( 'CHILD_THEME_URL', 'http://designnify.com/' );
define( 'CHILD_THEME_VERSION', '1.0' );

//* Enqueue Styles and Scripts
add_action( 'wp_enqueue_scripts', 'genesis_sample_scripts' );
function genesis_sample_scripts() {

	//* Add Google Fonts
	wp_register_style( 'google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:400,700|Oswald:300,400,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'google-fonts' );

	//* Remove default CSS
	wp_dequeue_style( 'genesis-sample-theme' );
	
	//* Script for responsive menu
	wp_enqueue_script( 'my-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enable shortcodes in widgets
add_filter('widget_text', 'do_shortcode');

//* Add support for 2-column footer widgets
add_theme_support( 'genesis-footer-widgets', 2 );

//* Activate the use of Dashicons
 add_action( 'wp_enqueue_scripts', 'load_dashicons_front_end' );
function load_dashicons_front_end() {
wp_enqueue_style( 'dashicons' );
}

//* Add new thumbnail image sizes for post excerpts
add_image_size( 'post-image-large', 320, 320, TRUE );

//* Removing emoji code form head
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

//* Modify the WordPress read more link for automatic excerpts
add_filter('excerpt_more', 'get_read_more_link');
add_filter( 'the_content_more_link', 'get_read_more_link' );
function get_read_more_link() {
   return '...&nbsp;<a href="' . get_permalink() . '" class="read-more">[Lue&nbsp;lisää]</a>';
}

//* Modify the length of post excerpts
add_filter( 'excerpt_length', 'sp_excerpt_length' );
function sp_excerpt_length( $length ) {
	return 50;
}

// Modify the WordPress read more link for hand-crafted excerpts
add_filter('get_the_excerpt', 'wpm_manual_excerpt_read_more_link');
function wpm_manual_excerpt_read_more_link($excerpt) {
    $excerpt_more = '';
    if (has_excerpt() && ! is_attachment() && get_post_type() == 'post') {
        $excerpt_more = '&nbsp;<a href="' . get_permalink() . '" class="read-more">[Lue&nbsp;lisää]' . '</span></a>';
    }
    return $excerpt . $excerpt_more;
}

/* Display Featured Image on top of the post */
add_action( 'genesis_before_entry', 'featured_post_image', 8 );
function featured_post_image() {
  if ( ! is_singular( 'post' ) )  return;
	the_post_thumbnail('post-image');
}

//* Remove the entry meta in the entry header
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

//* Remove the entry meta in the entry footer
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

//* Customize the credits
add_filter( 'genesis_footer_creds_text', 'sp_footer_creds_text' );
function sp_footer_creds_text() {
	echo '<div class="creds"><p>';
	echo 'Copyright &copy; ';
	echo date('Y');
	echo ' &middot; Dame Clave';
	echo '</p></div>';
}

//* Register widget areas for home page
genesis_register_sidebar( array(
	'id'				=> 'front-page-top',
	'name'			=> __( 'Front Page Top', 'dame-clave' ),
	'description'	=> __( 'This is home page top widget', 'dame-clave' ),
	'before_title' 		=> '<h1 class="widget-title">',
    'after_title' 		=> '</h1>',
) );
genesis_register_sidebar( array(
	'id'				=> 'column-one',
	'name'			=> __( '1st-column', 'dame-clave' ),
	'description'	=> __( 'This is home page first column widget', 'dame-clave' ),
	'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>',
    'before_title'=>'<h2 class="widget-title">','after_title'=>'</h2>'
) );
genesis_register_sidebar( array(
	'id'				=> 'column-two',
	'name'			=> __( '2nd-column', 'dame-clave' ),
	'description'	=> __( 'This is home page second column widget', 'dame-clave' ),
	'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>',
    'before_title'=>'<h2 class="widget-title">','after_title'=>'</h2>'
) );
genesis_register_sidebar( array(
	'id'				=> 'column-three',
	'name'			=> __( '3rd-column', 'dame-clave' ),
	'description'	=> __( 'This is home page third column widget', 'dame-clave' ),
	'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>',
    'before_title'=>'<h2 class="widget-title">','after_title'=>'</h2>'
) );

//* Hooks the widgets below header in widget area after header

add_action( 'genesis_after_header', 'dame_clave_front_page_top_genesis' );
function dame_clave_front_page_top_genesis() {
if ( ! is_home() )
 return;
	genesis_widget_area('front-page-top', array(
		'before'	=> '<section class="front-page-top"><div class="wrap">',
		'after'		=> '</div></section>',
		));
}
add_action( 'genesis_after_header', 'dame_clave_front_page_middle_genesis' );
function dame_clave_front_page_middle_genesis() {
	if ( ! is_home() )
		return;
	if ( ! is_home( 'column-one' ) || ( 'column-two' ) || ( 'column-three' ) ) {
		echo '<section class="front-page-middle"><div class="wrap">';
		
		   genesis_widget_area( 'column-one', array(
		       'before' => '<div class="one-third first front-page-middle-columns column-one">',
		       'after'		=> '</div>',
		   ) );
	
		   genesis_widget_area( 'column-two', array(
		       'before' => '<div class="one-third front-page-middle-columns column-two">',
		       'after'		=> '</div>',
		   ) );
		   
		   genesis_widget_area( 'column-three', array(
		       'before' => '<div class="one-third front-page-middle-columns column-three">',
		       'after'		=> '</div>',
		   ) );
		echo '</div></section>';
	}
}
