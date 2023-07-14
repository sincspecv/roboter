<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

add_filter( 'allowed_block_types_all', function( $allowed_blocks, $editor_context ): array {
    $allowed_blocks = [
        'core/paragraph',
        'core/heading',
        'core/list',
        'core/list-item',
        'core/code',
        'core/quote',
        'core/pullquote',
        'core/table',
        'core/gallery',
        'core/image',
        'core/video',
        'core/separator',
        'core/shortcode',
        'core/embed',
    ];
    return $allowed_blocks;
}, 100, 2 );
