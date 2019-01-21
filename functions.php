<?php
/**
 * Genesis Sample.
 *
 * This file adds functions to the Genesis Sample Theme.
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://www.studiopress.com/
 */

// Starts the engine.
require_once get_template_directory() . '/lib/init.php';

// Sets up the Theme.
require_once get_stylesheet_directory() . '/lib/theme-defaults.php';

add_action( 'after_setup_theme', 'genesis_sample_localization_setup' );
/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function genesis_sample_localization_setup() {

	load_child_theme_textdomain( 'genesis-sample', get_stylesheet_directory() . '/languages' );

}

// Adds helper functions.
require_once get_stylesheet_directory() . '/lib/helper-functions.php';

// Adds image upload and color select to Customizer.
require_once get_stylesheet_directory() . '/lib/customize.php';

// Includes Customizer CSS.
require_once get_stylesheet_directory() . '/lib/output.php';

// Adds WooCommerce support.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php';

// Adds the required WooCommerce styles and Customizer CSS.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php';

// Adds the Genesis Connect WooCommerce notice.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php';

// Defines the child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Genesis Sample TBD' );
define( 'CHILD_THEME_URL', 'https://www.studiopress.com/' );
define( 'CHILD_THEME_VERSION', '2.6.0' );

add_action( 'wp_enqueue_scripts', 'genesis_sample_tbd_enqueue_scripts_styles' );
/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function genesis_sample_tbd_enqueue_scripts_styles() {

	wp_enqueue_style(
		'genesis-sample-fonts',
		'//fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600,700',
		array(),
		CHILD_THEME_VERSION
	);
	wp_enqueue_style( 'dashicons' );

	// Child theme styles
	wp_enqueue_style( 'genesis-sample-child-style', get_stylesheet_directory_uri(). '/style.css' );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script(
		'genesis-sample-responsive-menu',
		get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js",
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);
	wp_localize_script(
		'genesis-sample-responsive-menu',
		'genesis_responsive_menu',
		genesis_sample_responsive_menu_settings()
	);

	wp_enqueue_script(
		'genesis-sample',
		get_stylesheet_directory_uri() . '/js/genesis-sample.js',
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);

}

/**
 * Defines responsive menu settings.
 *
 * @since 2.3.0
 */
function genesis_sample_responsive_menu_settings() {

	$settings = array(
		'mainMenu'         => __( 'Menu', 'genesis-sample' ),
		'menuIconClass'    => 'dashicons-before dashicons-menu',
		'subMenu'          => __( 'Submenu', 'genesis-sample' ),
		'subMenuIconClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'      => array(
			'combine' => array(
				'.nav-primary',
			),
			'others'  => array(),
		),
	);

	return $settings;

}

// Sets the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) {
	$content_width = 702; // Pixels.
}

// Adds support for HTML5 markup structure.
add_theme_support(
	'html5', array(
		'caption',
		'comment-form',
		'comment-list',
		'gallery',
		'search-form',
	)
);

// Adds support for accessibility.
add_theme_support(
	'genesis-accessibility', array(
		'404-page',
		'drop-down-menu',
		'headings',
		'rems',
		'search-form',
		'skip-links',
	)
);

// Adds viewport meta tag for mobile browsers.
add_theme_support(
	'genesis-responsive-viewport'
);

// Adds custom logo in Customizer > Site Identity.
add_theme_support(
	'custom-logo', array(
		'height'      => 120,
		'width'       => 700,
		'flex-height' => true,
		'flex-width'  => true,
	)
);

// Renames primary and secondary navigation menus.
add_theme_support(
	'genesis-menus', array(
		'primary'   => __( 'Header Menu', 'genesis-sample' ),
		'secondary' => __( 'Footer Menu', 'genesis-sample' ),
	)
);

// Adds support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Adds support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Removes header right widget area.
unregister_sidebar( 'header-right' );

// Removes secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Removes site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Removes output of primary navigation right extras.
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

add_action( 'genesis_theme_settings_metaboxes', 'genesis_sample_remove_metaboxes' );
/**
 * Removes output of unused admin settings metaboxes.
 *
 * @since 2.6.0
 *
 * @param string $_genesis_admin_settings The admin screen to remove meta boxes from.
 */
function genesis_sample_remove_metaboxes( $_genesis_admin_settings ) {

	remove_meta_box( 'genesis-theme-settings-header', $_genesis_admin_settings, 'main' );
	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_admin_settings, 'main' );

}

add_filter( 'genesis_customizer_theme_settings_config', 'genesis_sample_remove_customizer_settings' );
/**
 * Removes output of header settings in the Customizer.
 *
 * @since 2.6.0
 *
 * @param array $config Original Customizer items.
 * @return array Filtered Customizer items.
 */
function genesis_sample_remove_customizer_settings( $config ) {

	unset( $config['genesis']['sections']['genesis_header'] );
	return $config;

}

// Displays custom logo.
add_action( 'genesis_site_title', 'the_custom_logo', 0 );

// Repositions primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Repositions the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 10 );

add_filter( 'wp_nav_menu_args', 'genesis_sample_secondary_menu_args' );
/**
 * Reduces secondary navigation menu to one level depth.
 *
 * @since 2.2.3
 *
 * @param array $args Original menu options.
 * @return array Menu options with depth set to 1.
 */
function genesis_sample_secondary_menu_args( $args ) {

	if ( 'secondary' !== $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;
	return $args;

}

add_filter( 'genesis_author_box_gravatar_size', 'genesis_sample_author_box_gravatar' );
/**
 * Modifies size of the Gravatar in the author box.
 *
 * @since 2.2.3
 *
 * @param int $size Original icon size.
 * @return int Modified icon size.
 */
function genesis_sample_author_box_gravatar( $size ) {

	return 90;

}

add_filter( 'genesis_comment_list_args', 'genesis_sample_comments_gravatar' );
/**
 * Modifies size of the Gravatar in the entry comments.
 *
 * @since 2.2.3
 *
 * @param array $args Gravatar settings.
 * @return array Gravatar settings with modified size.
 */
function genesis_sample_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;
	return $args;

}

//* Beginning of Custom Edits
//* Modify the length of post excerpts
add_filter( 'excerpt_length', 'sp_excerpt_length' );
function sp_excerpt_length( $length ) {
	return 38; // pull first 38 words
}

// Change the footer text
add_filter('genesis_footer_creds_text', 'sp_footer_creds_filter');
function sp_footer_creds_filter( $creds ) {
	$creds = 'Copyright [footer_copyright] Create Your Start &middot; Ribbiter Media LLC<br />Made with <i class="icon ion-heart"></i> in Seattle';
	return $creds;
}

// Add Read More Link to Excerpts
add_filter('excerpt_more', 'get_read_more_link');
add_filter( 'the_content_more_link', 'get_read_more_link' );
function get_read_more_link() {
   return '...&nbsp;<a href="' . get_permalink() . '">Read&nbsp;More&nbsp;></a>';
}

// Remove Post Info from all but single posts
function not_single_remove_post_meta() {
	if (!is_single()) {
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
		}
}
add_action ( 'genesis_entry_header', 'not_single_remove_post_meta' );


// Customize entry meta header
add_filter( 'genesis_post_info', 'modify_post_info_filter' );
function modify_post_info_filter( $post_info ) {
	$post_info = 'By The Create Your Start Team [post_comments] </br> <i>THIS POST MAY CONTAIN AFFILIATE LINKS. PLEASE READ MY <a href="/affiliate-disclosure/">DISCLOSURE</a> FOR MORE INFO.</i>';
	return $post_info;
}

// Remove the post entry meta in the entry footer on homepage (requires HTML5 theme support)
function home_remove_post_meta() {
	if (is_home()) {
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
		}
}
add_action ( 'genesis_entry_header', 'home_remove_post_meta' );

// Customize entry meta footer
add_filter( 'genesis_post_meta', 'change_post_meta_filter' );
function change_post_meta_filter( $post_meta ) {
	$post_meta = '[post_categories]';
	return $post_meta;
}

// Registering 3rd Menu
function register_additional_menu() {
	register_nav_menu( 'third-menu' ,__( 'Third Navigation Menu' ));
}

add_action( 'init', 'register_additional_menu' );
add_action( 'genesis_after_header', 'add_third_nav_genesis' ); 
	
function add_third_nav_genesis() {
	wp_nav_menu( array( 'theme_location' => 'third-menu', 'container_class' => 'genesis-nav-menu thrid-nav-menu' ) );
}

// Register widget area for Front Page Hero.
genesis_register_sidebar( array(
	'id'          => 'front-page-top',
	'name'        => __( 'Front Page Top', 'genesis-sample-tbd' ),
	'description' => __( 'This is a widget that goes on the front page.', 'genesis-sample-tbd' ),
) );

// Enqueue Ionicons from ionicons.com
add_action( 'wp_enqueue_scripts', 'sp_enqueue_ionicons' );
function sp_enqueue_ionicons() {
	wp_enqueue_style( 'ionicons', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', array(), CHILD_THEME_VERSION );
}

// Add Google Tag Manager code in <head>
add_action( 'wp_head', 'sk_google_tag_manager1' );
function sk_google_tag_manager1() { ?>
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-TL6JK24');</script>
	<!-- End Google Tag Manager -->
	<meta name="google-site-verification" content="vwos7LJ7IahS3wMxYTQYJOUENChXPvRXibS6hJ6d2d8" />
<?php }

// Add Google Tag Manager second part code immediately below opening <body> tag
add_action( 'genesis_before', 'sk_google_tag_manager2' );
function sk_google_tag_manager2() { ?>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TL6JK24"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
<?php }

// Add featured image on single post
add_action( 'genesis_entry_content', 'themeprefix_featured_image', 1 );
function themeprefix_featured_image() {
	$image = genesis_get_image( array( // more options here -> genesis/lib/functions/image.php
			'format'  => 'html',
			'size'    => 'large',// add in your image size large, medium or thumbnail - for custom see the post
			'context' => '',
			'attr'    => array ( 'class' => 'aligncenter' ), // set a default WP image class
		) );
	if ( is_singular()) {
		if ( $image ) {
			printf( '<div class="featured-image-class">%s</div>', $image ); // wraps the featured image in a div with css class you can control
		}
	}
}

// Removes Title and Description on Paginated Archive, Taxonomy, Category, Tag Pages
add_action( 'genesis_after_header', 'sk_taxonomy_title_description' );
/**
 * Remove Taxonomy Title and Description on paginated pages.
 */
function sk_taxonomy_title_description() {
    global $wp_query;

    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    // if we are on the first page of pagination, abort.
    if ( 1 == $paged )  {
        return;
    }

    remove_action( 'genesis_after_header', 'genesis_do_taxonomy_title_description', 20 );
}

/**
 * Get rid of tags on posts.
 * https://ryanbenhase.com/remove-tags-categories-or-any-taxonomy/
 */
function ryanbenhase_unregister_tags() {
    unregister_taxonomy_for_object_type( 'post_tag', 'post' );
}
add_action( 'init', 'ryanbenhase_unregister_tags' );

/**
 * Allow shortcodes in genesis archive intro text.
 * @author Joshua David Nelson
 * https://joshuadnelson.com/code/allow-shortcodes-genesis-archive-intro-text/
 **/
// Custom Post Type Archive Intro Text
add_filter( 'genesis_cpt_archive_intro_text_output', 'do_shortcode' );
// Author Archive Intro Text
add_filter( 'genesis_author_intro_text_output', 'do_shortcode' );
// Term Archive Intro Text
add_filter( 'genesis_term_intro_text_output', 'do_shortcode' );

// Funtion to replace cat pages with WP Pages
// https://wordpress.stackexchange.com/questions/106042/force-wordpress-to-show-pages-instead-of-category
function wpa_alter_cat_links( $termlink, $term, $taxonomy ){
    if( 'category' != $taxonomy ) return $termlink;

    return str_replace( '/category', '', $termlink );
}
add_filter( 'term_link', 'wpa_alter_cat_links', 10, 3 );
