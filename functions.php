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

//* Add support for custom background
// add_theme_support( 'custom-background' );

//* Enable shortcodes in widgets
add_filter('widget_text', 'do_shortcode');

//* Add support for 2-column footer widgets
add_theme_support( 'genesis-footer-widgets', 2 );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'header_image'    => '',
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'height'          => 160,
	'width'           => 175,
) );

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

//* Customize the credits
add_filter( 'genesis_footer_creds_text', 'sp_footer_creds_text' );
function sp_footer_creds_text() {
	echo '<div class="creds"><p>';
	echo 'Copyright &copy; ';
	echo date('Y');
	echo ' &middot; Dame Clave';
	echo '</p></div>';
}

//* Clean Markup Text Widget 
add_action('widgets_init', create_function('', 'register_widget("clean_markup_widget");'));
class Clean_Markup_Widget extends WP_Widget {
	function __construct() {
		parent::WP_Widget('clean_markup_widget', 'Clean markup widget', array('description'=>'Simple widget for well-formatted markup &amp; text'));
	}
	function widget($args, $instance) {
		extract($args);
		$markup = $instance['markup'];
		//echo $before_widget;
		if ($markup) echo $markup;
		//echo $after_widget;
	}
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['markup'] = $new_instance['markup'];
		return $instance;
	}
	function form($instance) {
		if ($instance) $markup = esc_attr($instance['markup']);
		else $markup = __('&lt;p&gt;Clean, well-formatted markup.&lt;/p&gt;', 'markup_widget'); ?>
		<p>
			<label for="<?php echo $this->get_field_id('markup'); ?>"><?php _e('Markup/text'); ?></label><br />
			<textarea class="widefat" id="<?php echo $this->get_field_id('markup'); ?>" name="<?php echo $this->get_field_name('markup'); ?>" type="text" rows="16" cols="20" value="<?php echo $markup; ?>"><?php echo $markup; ?></textarea>
		</p>
<?php }
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
/*
add_action( 'genesis_after_header', 'dame_clave_front_page_top_genesis' );
function dame_clave_front_page_top_genesis() {
	if ( ! is_home() )
		return;
	if ( ! is_home( 'front-page-top-left' ) || ( 'front-page-top-right' ) ) {
		echo '<section class="front-page-top"><div class="wrap">';
		
		   genesis_widget_area( 'front-page-top-left', array(
		       'before' => '<div class="one-half first front-page-top-left">',
		       'after'		=> '</div>',
		   ) );
	
		   genesis_widget_area( 'front-page-top-right', array(
		       'before' => '<div class="one-half front-page-top-right">',
		       'after'		=> '</div>',
		   ) );
		echo '</div></section>';
	}
}
*/
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
