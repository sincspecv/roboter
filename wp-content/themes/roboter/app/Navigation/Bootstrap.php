<?php

namespace App\Navigation;

use Roots\Soil\Nav\NavWalker as SoilNavWalker;

/**
 * @author QWp6t
 * @license OSL-3.0
 * @see https://gist.github.com/QWp6t/8f94b7096bb0d3a72fedba68f73033a5
 */
class Bootstrap extends SoilNavWalker
{

    public function __construct()
    {
        parent::__construct();
        remove_filter('nav_menu_css_class', [$this, 'cssClasses'], 10);
        add_filter('nav_menu_css_class', [$this, 'itemClasses'], 10, 4);
        add_filter('nav_menu_link_attributes', [$this, 'linkAttributes'], 10, 4);
    }

    /**
     * @param string $output
     * @param int $depth
     * @param array $args
     * @SuppressWarnings(PHPMD.CamelCaseMethodName) This method overrides its parent
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) This method overrides its parent
     */
    // @codingStandardsIgnoreLine
    public function start_lvl(&$output, $depth = 0, $args = [])
    {
        $output .= '<ul class="dropdown-menu">';
    }

    /**
     * @param $classes
     * @param $item
     * @param $args
     * @param $depth
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) This method overrides its parent
     */
    public function itemClasses($classes, $item, /** @noinspection PhpUnusedParameterInspection */ $args, $depth)
    {
        return array_filter(array_map(function ($class) use ($depth) {
            switch ($class) {
                case 'menu-item-has-children':
                    return 'dropdown';
                case 'menu-item':
                    return ($depth > 0 ? '' : 'nav-item');
                default:
                    return $class;
            }
        }, parent::cssClasses($classes, $item)));
    }

    /**
     * @param $atts
     * @param $item
     * @param $args
     * @param $depth
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) This method overrides its parent
     */
    public function linkAttributes($atts, $item, /** @noinspection PhpUnusedParameterInspection */ $args, $depth)
    {
        $atts['class'] = $depth ? 'dropdown-item' : 'nav-link';
        if ($item->current || $item->current_item_ancestor) {
            $atts['class'] .= ' active';
        }
        if ($item->is_subitem) {
            $atts['class'] .= ' dropdown-toggle';
            $atts += [
                'data-toggle' => 'dropdown',
                'role' => 'button',
                'aria-haspopup' => 'true',
                'aria-expanded' => 'false'
            ];
        }
        return $atts;
    }
}
