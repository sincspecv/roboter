<?php

namespace App\Providers;

use Roots\Acorn\Sage\Sage;
use Roots\Acorn\Sage\SageServiceProvider;

class ThemeServiceProvider extends SageServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->bindDaisyNavClasses();
    }

    public function bindDaisyNavClasses() : void {
        add_filter('nav_menu_submenu_css_class', [self::class, 'navSubmenuClasses'], 99, 3);
        add_filter('nav_menu_css_class', [self::class, 'navMenuItemClasses'], 99, 4);
        add_filter('nav_menu_item_args', [self::class, 'navMenuItemArgs'], 99, 3);
        add_filter('nav_menu_link_attributes', [self::class, 'navMenuLinkAttributes'], 99, 4);
    }

    public static function navMenuItemClasses(array $classes, \WP_Post $menu_item, \stdClass $args, int $depth) : array {
        if($depth === 0) {
            $classes[] = 'hover:bg-darkerBlue';
        }
        return $classes;
    }

    public static function navMenuItemArgs(\stdClass $args, \WP_Post $item,  int $depth) : object {
        return $args;
    }

    public static function navMenuLinkAttributes(array $atts, \WP_Post $menu_item, \stdClass $args, int $depth) : array {
        $atts['class'] = 'hover:text-blue';
        return $atts;
    }

    public static function navSubmenuClasses(array $classes, \stdClass $args, int $depth) : array {
        $classes[] = 'menu';
        $classes[] = 'p-4';
        $classes[] = 'w-full';
        $classes[] = 'bg-clip-content';
        $classes[] = 'bg-primaryWhite';
        $classes[] = '!text-primaryBlack';

        return $classes;
    }
}
