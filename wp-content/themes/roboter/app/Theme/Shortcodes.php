<?php


namespace App\Theme;

class Shortcodes {
    public static function init() {
        $methods = get_class_methods(self::class);
        foreach($methods as $method) {
            add_shortcode($method, [self::class, $method]);
        }
    }

    public static function button( $attributes, $content = '' ): string {
        $atts = shortcode_atts( array(
            'url' => false,
            'target' => 'self',
            'class' => 'primary',
        ), $attributes );

        $target = $atts['target'] == 'blank' || $atts['target'] == '_blank' ? '_blank' : '_self';

        return '<a class="button '. $atts['class'] .'" href="' . esc_url_raw( $atts['url'] ) . '" target="' . $target . '">' .  esc_attr( $content ) . '</a>';
    }
}
