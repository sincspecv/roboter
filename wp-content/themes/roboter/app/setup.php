<?php

namespace App;

use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;

/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('sage/main.css', asset_path('styles/main.css'), false, null);
    wp_enqueue_script('sage/main.js', asset_path('scripts/main.js'), ['jquery'], null, true);

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}, 100);

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
    /**
     * Enable features from Soil when plugin is activated
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil-clean-up');
//    add_theme_support('soil-jquery-cdn');
    add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');
//    add_theme_support('soil-google-analytics', 'UA-XXXXX-Y');
//    add_theme_support('soil-relative-urls');

    /**
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage')
    ]);

    /**
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    /**
     * Enable selective refresh for widgets in customizer
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Use main stylesheet for visual editor
     * @see resources/assets/styles/layouts/_tinymce.scss
     */
    add_editor_style(asset_path('styles/main.css'));
}, 20);

/**
 * Register sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ];
    register_sidebar([
        'name'          => __('Primary', 'sage'),
        'id'            => 'sidebar-primary'
    ] + $config);
    register_sidebar([
        'name'          => __('Footer', 'sage'),
        'id'            => 'sidebar-footer'
    ] + $config);
});

/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action('the_post', function ($post) {
    sage('blade')->share('post', $post);
});

/**
 * Setup Sage options
 */
add_action('after_setup_theme', function () {
    /**
     * Add JsonManifest to Sage container
     */
    sage()->singleton('sage.assets', function () {
        return new JsonManifest(config('assets.manifest'), config('assets.uri'));
    });

    /**
     * Add Blade to Sage container
     */
    sage()->singleton('sage.blade', function (Container $app) {
        $cachePath = config('view.compiled');
        if (!file_exists($cachePath)) {
            wp_mkdir_p($cachePath);
        }
        (new BladeProvider($app))->register();
        return new Blade($app['view']);
    });

    /**
     * Create @asset() Blade directive
     */
    sage('blade')->compiler()->directive('asset', function ($asset) {
        return "<?= " . __NAMESPACE__ . "\\asset_path({$asset}); ?>";
    });
});

/**
 * Head Scripts
 */
add_action('wp_head', function() {
    if(function_exists('get_field')) {
        $head_scripts = get_field('head_scripts', 'site_settings');
        echo !empty($head_scripts) ? htmlspecialchars_decode(html_entity_decode($head_scripts, ENT_COMPAT, 'UTF-8')) : '';
    }
});

/**
 * Body Scripts
 */
add_action('wp_body_open', function() {
    if(function_exists('get_field')) {
        $body_scripts = get_field('body_scripts', 'site_settings');
        echo !empty($body_scripts) ? htmlspecialchars_decode(html_entity_decode($body_scripts, ENT_COMPAT)) : '';
    }
}, 1);

/**
 * Footer Scripts
 */
add_action('wp_footer', function() {
    if(function_exists('get_field')) {
        $footer_scripts = get_field('footer_scripts', 'site_settings');
        echo !empty($footer_scripts) ? htmlspecialchars_decode(html_entity_decode($footer_scripts, ENT_COMPAT)) : '';
    }
});

/**
 * Google Fonts
 */
add_action('wp_head', function() {
    $google_font_url = '';
    if(!empty($google_font_url)) :
        ?>
        <link rel="preconnect" href="https://fonts.googleapis.com/" crossorigin>
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
        <link href="<?=$google_font_url?>" rel="stylesheet">
    <?php endif;
});

/**
 * Typekit
 */
add_action('wp_head', function() {
    $proj_id = 'wdq1klo';

    if(!empty($proj_id)) : ?>
        <link rel="preconnect" href="https://use.typekit.net" crossorigin>
        <link rel="preconnect" href="https://p.typekit.net" crossorigin>
        <link rel="stylesheet" href="https://use.typekit.net/<?=$proj_id?>.css">
    <?php endif;
});
