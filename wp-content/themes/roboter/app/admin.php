<?php

namespace App;

/**
 * Theme customizer
 */
add_action('customize_register', function (\WP_Customize_Manager $wp_customize) {
    // Add postMessage support
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->selective_refresh->add_partial('blogname', [
        'selector' => '.brand',
        'render_callback' => function () {
            bloginfo('name');
        }
    ]);
});

/**
 * Customizer JS
 */
add_action('customize_preview_init', function () {
    wp_enqueue_script('sage/customizer.js', asset_path('scripts/customizer.js'), ['customize-preview'], null, true);
});

/**
 * Remove Gutenberg CSS from the front end
 */
add_action('wp_print_styles', function () {
    wp_dequeue_style('wp-block-library');
}, 100);

/**
 * Social Icons Sprite
 */
add_action('wp_body_open', function () {
    $files = glob(get_theme_file_path() . "/resources/assets/sprites/*.svg");
    if(!empty($files)) {
        foreach($files as $file) {
            readfile($file);
        }
    }
});
