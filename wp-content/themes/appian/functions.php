<?php
/**
 * Outside Traineeship Biolerplate functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Outside_Traineeship_Biolerplate
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

function vite_assets($entry) {
    static $manifest;

    if (!$manifest) {
        $manifestPath = __DIR__ . '/public/.vite/manifest.json';

        $manifest = json_decode(
            file_get_contents($manifestPath),
            true
        );
    }
    if (!isset($manifest[$entry])) {
        return null;
    }
    return get_template_directory_uri() . '/public/' . $manifest[$entry]['file'];
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function outside_traineeship_biolerplate_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Outside Traineeship Biolerplate, use a find and replace
		* to change 'outside-traineeship-biolerplate' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'outside-traineeship-biolerplate', get_template_directory() . '/languages' );

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
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'outside-traineeship-biolerplate' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'outside_traineeship_biolerplate_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'outside_traineeship_biolerplate_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function outside_traineeship_biolerplate_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'outside_traineeship_biolerplate_content_width', 640 );
}
add_action( 'after_setup_theme', 'outside_traineeship_biolerplate_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function outside_traineeship_biolerplate_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'outside-traineeship-biolerplate' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'outside-traineeship-biolerplate' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'outside_traineeship_biolerplate_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function outside_traineeship_biolerplate_scripts() {
	wp_enqueue_style('app-css', vite_assets ('resources/styles/app.scss'), true, null, );
    wp_enqueue_script('app-js', vite_assets ('resources/scripts/app.js'), [''], null, true);
}
add_action('wp_enqueue_scripts', 'outside_traineeship_biolerplate_scripts', 2);


function is_block_preview(){
	return is_admin() ? true : false;
}

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

require get_template_directory() . '/acf-block.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

require_once get_template_directory() . '/inc/vite.php';

function theme_assets() {

    $is_dev = defined('WP_ENV')
        && WP_ENV === 'development';

    // Vite HMR
    if ( $is_dev ) {

        wp_enqueue_script(
            'vite-client',
            'http://localhost:5173/@vite/client',
            [],
            null,
            true
        );

        wp_enqueue_script(
            'theme-app',
            'http://localhost:5173/resources/scripts/app.js',
            [],
            null,
            true
        );

        return;
    }

    $manifest = theme_vite_manifest();

    $entry = $manifest['resources/scripts/app.js'] ?? false;

    if ( ! $entry ) {
        return;
    }

    // CSS
    if ( ! empty( $entry['css'] ) ) {

        foreach ( $entry['css'] as $css ) {

            wp_enqueue_style(
                'theme-app',
                get_template_directory_uri() . '/public/' . $css,
                [],
                null
            );
        }
    }

    // JS
    wp_enqueue_script(
        'theme-app',
        get_template_directory_uri() . '/public/' . $entry['file'],
        [],
        null,
        true
    );
}

add_action( 'wp_enqueue_scripts', 'theme_assets' );

/**
 * Enqueue block editor assets (Gutenberg) built by Vite.
 */
function theme_block_editor_assets() {

	$is_dev = defined( 'WP_ENV' )
		&& WP_ENV === 'development';

	/**
	 * Development (Vite HMR)
	 */
	if ( $is_dev ) {

		// Vite client
		wp_enqueue_script(
			'vite-client',
			'http://localhost:5173/@vite/client',
			[],
			null,
			true
		);

		// Editor entry
		// IMPORTANT:
		// editor.js should import ../styles/editor.scss
		wp_enqueue_script(
			'theme-editor',
			'http://localhost:5173/resources/scripts/editor.js',
			[],
			null,
			true
		);

		return;
	}

	/**
	 * Production
	 */
	$manifest = theme_vite_manifest();

	$entry = $manifest['resources/scripts/editor.js'] ?? false;

	if ( ! $entry ) {
		return;
	}

	// Enqueue extracted CSS from manifest
	if ( ! empty( $entry['css'] ) ) {

		foreach ( $entry['css'] as $css ) {
            wp_enqueue_style(
                'theme-editor-css',
                get_template_directory_uri() . '/public/' . $css,
                [],
                null
            );
        }

	}

	// Enqueue JS
	wp_enqueue_script(
		'theme-editor-js',
		get_template_directory_uri() . '/public/' . $entry['file'],
		[],
		null,
		true
	);
}

add_action(
	'enqueue_block_editor_assets',
	'theme_block_editor_assets'
);

add_action( 'enqueue_block_editor_assets', 'theme_block_editor_assets' );
