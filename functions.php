<?php
/**
 * SkelePress theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package SkelePress_theme
 */
class Walker_Quickstart_Menu extends Walker {

    // Tell Walker where to inherit it's parent and id values
    var $db_fields = array(
        'parent' => 'menu_item_parent', 
        'id'     => 'db_id' 
    );

    /**
     * At the start of each element, output a <li> and <a> tag structure.
     * 
     * Note: Menu objects include url and title properties, so we will use those.
     */
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $output .= sprintf( "\n<li><a class='navbar-item navbar-link' href='%s'%s>%s</a> </li>\n",
            $item->url,
            ( $item->object_id === get_the_ID() ) ? ' class="current"' : '',
            $item->title
        );
    }

}
if ( ! function_exists( 'skelepress_theme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function skelepress_theme_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on SkelePress theme, use a find and replace
		 * to change 'skelepress-theme' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'skelepress-theme', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'skelepress-theme' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'skelepress_theme_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'skelepress_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function skelepress_theme_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'skelepress_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'skelepress_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function skelepress_theme_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'skelepress-theme' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'skelepress-theme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'skelepress_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function skelepress_theme_scripts() {
	wp_enqueue_style( 'normalize', get_template_directory_uri().'/Skeleton/css/normalize.css'  );
	wp_enqueue_style( 'skelepress-theme-style', get_stylesheet_uri() );
	wp_enqueue_style( 'skeleton', get_template_directory_uri().'/Skeleton/css/skeleton.css' );
	// wp_enqueue_style( 'skeleton', get_template_directory_uri().'/custom.css' );
	wp_enqueue_style( 'Raleway', get_template_directory_uri().'/fonts/Raleway-Regular.ttf' );

	wp_enqueue_script( 'skelepress-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'skelepress-theme-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	wp_deregister_script('jquery');
	wp_enqueue_script( 'jquery', get_template_directory_uri() . '/js/jquery-3.3.1.min.js', array(), null, true );
	
	wp_enqueue_script( 'site', get_template_directory_uri() . '/js/site.js', array('jquery'), '20180909', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'skelepress_theme_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

add_filter('the_content', 'the_end');
function the_end( $text ){
	return wp_trim_words( $text, 200, ' '.__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'skelepress-theme' ));
}

function alter_comment_form_fields($fields){
	$fields   = array(
		'author' => '<p class="comment-form-fields-c u-pull-left">' .
					 '<input id="author" name="author" type="text" placeholder="'.__( 'Name', 'skelepress-theme' ) .'*" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245"' . $html_req . ' />',
		'email'  => ''.
					 '<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' placeholder="'.__( 'Email', 'skelepress-theme' ).'*" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" maxlength="100" aria-describedby="email-notes"' . $html_req . ' /></p>'
						);
  return $fields;
}

add_filter('comment_form_default_fields','alter_comment_form_fields');


function alter_field_comment($a){
	$a   = '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" placeholder="'._x( 'Comment', 'noun', 'skelepress-theme') .'*" required="required"></textarea></p>';
  return $a;
}


add_filter( 'comment_form_field_comment', 'alter_field_comment' );

function alter_comment_submit($s, $args){
  $button = '<input name="%1$s" type="submit" id="%2$s" class="%3$s button button-primary u-pull-right" value="%4$s" />';

  return sprintf(
	  $button,
	  esc_attr( $args['name_submit'] ),
	  esc_attr( $args['id_submit'] ),
	  esc_attr( $args['class_submit'] ),
	  esc_attr( $args['label_submit'] )
   );
}


add_filter( 'comment_form_submit_button', 'alter_comment_submit', 10, 2 );