<?php
/**
 * leslie theme functions and definitions
 * @since v. 0.1
 */
    // bring in scripts for theme specific options
require( get_template_directory() . '/include/theme-options.php' ); // Functions for theme options page
require_once( get_template_directory() . '/include/leslie-plugin-options.php' ); // Functions for theme plugin installer

    // pre page load setup functions
function leslie_setup() {
    /**
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // custom editor style support
    add_editor_style( 'editor-style.css' );
    
    // This theme uses Featured Images (also known as post thumbnails)
    add_theme_support('post-thumbnails'); 
    set_post_thumbnail_size( 150, 150 );

    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    add_theme_support( "title-tag" ); 

    // language support - add your translation
    load_theme_textdomain('leslie', get_template_directory_uri() . '/languages');

    // This theme uses wp_nav_menu in one location.
    register_nav_menus(array(
        'primary' => __('Primary Navigation', 'leslie'),
        ));  

    //customer header image banner support 
    add_theme_support( 'custom-header' );
    $defaults = array(
    'default-image'  => get_template_directory_uri() . '/include/images/header-426x100.jpg', 
    'random-default' => false,
    'width'          => 426,
    'height'         => 100,
    'flex-height'    => true,
    'flex-width'     => true,
    'uploads'        => true,
    'header-text'    => false,
    );
    add_theme_support( 'custom-header', $defaults );

    // Add theme support for Custom Background
    add_theme_support( 'custom-background', array(
        'default-image' => get_template_directory_uri() . '/include/images/default-background.png', 
        'default-color' => 'fafafa',
    )); 
}
    add_action('after_setup_theme', 'leslie_setup');
//set content width for unspecified media
function leslie_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'leslie_content_width', 640 );
}
    add_action( 'after_setup_theme', 'leslie_content_width', 0 );

// add backwards compatibility for title_tag
if ( ! function_exists( '_wp_render_title_tag' ) ) {
    function theme_slug_render_title() {
        ?>
        <title><?php wp_title( '|', true, 'right' ); ?></title>
        <?php
    }
    add_action( 'wp_head', 'theme_slug_render_title' );
} // ends title_tag compat.

function leslie_add_theme_scripts() {    
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() 
                                      .'/include/css/slicknav.min.css' );
    // Loads default main stylesheet and support script.
    wp_enqueue_style( 'leslie-style', get_stylesheet_uri() );

    // script to help responsive video embeds
    wp_enqueue_script( 'leslie-theme', get_template_directory_uri() 
                        .'/include/js/theme.js', 
                        array( 'jquery' ), '', true );
    wp_enqueue_script( 'slicknav-menu', get_template_directory_uri() 
                        .'/include/js/jquery.slicknav.min.js', 
                        array( 'jquery' ), '', true );
    wp_enqueue_script( 'leslie-slicknav', get_template_directory_uri() 
                        .'/include/js/leslie-slicknav.js', 
                        array( 'jquery' ), '', true );
}
    add_action( 'wp_enqueue_scripts', 'leslie_add_theme_scripts' );
/**
 * only enable js if the visitor is browsing either a page or a post    
 * or if comments are open for the entry, or threaded comments are enabled
 */
function leslie_theme_queue_js(){
    if ( (!is_admin()) && is_singular() && comments_open() && get_option('thread_comments') )
        wp_enqueue_script( 'comment-reply' );
}
    add_action('wp_print_scripts', 'leslie_theme_queue_js');

// add ie conditional html5 shim to header
function leslie_add_ie_html5_shim () {
     echo "<!--[if lt IE 9]>\n";
     echo '<script src="', get_template_directory_uri() .'/include/js/html5.js"></script>'."\n";
     echo '<meta http-equiv="X-UA-Compatible" content="IE=9"/>'."\n";
     echo "<![endif]-->\n";
}
    add_action('wp_head', 'leslie_add_ie_html5_shim');

    // font imported by enqueue method
    function leslie_add_google_fonts() {
    wp_enqueue_style( 'Font-Oxygen', "//fonts.googleapis.com/css?family=Oxygen:400,300,700" );
    }     
    add_action( 'wp_enqueue_scripts', 'leslie_add_google_fonts', 5);

function leslie_widgets_init() {
        register_sidebar(array(
            'name' => __('Left of Menu', 'leslie'),
            'id' => 'sidebar',
            'description' => __('Main Left Sidebar', 'leslie'),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Right Content Sidebar', 'leslie'),
            'id' => 'sidebar-1',
            'description' => __('Far-Right Column shows only on Page if active.', 'leslie'),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Footer 1', 'leslie'),
            'id' => 'sidebar-2',
            'description' => __('Footer First', 'leslie'),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Footer 2', 'leslie'),
            'id' => 'sidebar-3',
            'description' => __('Footer Second', 'leslie'),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
}
add_action( 'widgets_init', 'leslie_widgets_init' );

    // footer credits added
function leslie_display_footer_credits() {

    $options           = get_option( 'leslie_theme_options' );
    $leslie_footer     = (!empty($options['leslie_footer'])) ? $options['leslie_footer'] : false;
    $leslie_footer_url = empty($options['leslie_footer_url']) ? home_url('/') : $options['leslie_footer_url'];
    $author_url        = "https://tradesouthwest.com/";

    if ( $leslie_footer ) {
    $html .= '<p><a href="'. esc_url($leslie_footer_url) .'"><small>' . esc_html( $leslie_footer )
             . '</small></a></p>';

    } else {
    $html .= '<p><a href="'. esc_url_raw($author_url) .'"><small>' . esc_html__( 'Theme Leslie by Tradesouthwest', 'leslie' ) 
             . '</small></a></p>';
    }
    echo $html;
    
}
add_action( 'leslie_footer_creditz', 'leslie_display_footer_credits' );

// numeric pagination
function leslie_pagination() {

	if( is_singular() )
		return;

	global $wp_query;

	/** Stop execution if there's only 1 page */
	if( $wp_query->max_num_pages <= 1 )
		return;

	$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	$max   = intval( $wp_query->max_num_pages );

	/**	Add current page to the array */
	if ( $paged >= 1 )
		$links[] = $paged;

	/**	Add the pages around the current page to the array */
	if ( $paged >= 3 ) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}

	if ( ( $paged + 2 ) <= $max ) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}

	echo '<div class="pagination"><ul>' . "\n";

	/**	Previous Post Link */
	if ( get_previous_posts_link() )
		printf( '<li>%s</li>' . "\n", get_previous_posts_link() );

	/**	Link to first page, plus ellipses if necessary */
	if ( ! in_array( 1, $links ) ) {
		$class = 1 == $paged ? ' class="active"' : '';

		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

		if ( ! in_array( 2, $links ) )
			echo '<li>...</li>';
	}

	/**	Link to current page, plus 2 pages in either direction if necessary */
	sort( $links );
	foreach ( (array) $links as $link ) {
		$class = $paged == $link ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
	}

	/**	Link to last page, plus ellipses if necessary */
	if ( ! in_array( $max, $links ) ) {
		if ( ! in_array( $max - 1, $links ) )
			echo '<li>...</li>' . "\n";

		$class = $paged == $max ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
	}

	/**	Next Post Link */
	if ( get_next_posts_link() )
		printf( '<li>%s</li>' . "\n", get_next_posts_link() );

	echo '</ul></div>' . "\n";
}

// pagination for archives and search results
global $wp_query;
$big = 999999999; // need an unlikely integer
echo paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $wp_query->max_num_pages
) );

?>