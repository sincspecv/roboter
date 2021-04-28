<?php


namespace App\Navigation;

use Roots\Soil\Nav\NavWalker as SoilNavWalker;

/**
 * @author QWp6t
 * @license OSL-3.0
 * @see https://gist.github.com/QWp6t/8f94b7096bb0d3a72fedba68f73033a5
 */
class FoundationDrilldown extends SoilNavWalker
{

    public function __construct()
    {
        parent::__construct();
        remove_filter('nav_menu_css_class', [$this, 'cssClasses'], 10);
        add_filter('nav_menu_css_class', [$this, 'itemClasses'], 10, 4);
        add_filter('wp_nav_menu_args', [$this, 'argsFilter']);
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
        $output .= '<ul class="menu vertical nested">';
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
                    return 'has-submenu';
                default:
                    return $class;
            }
        }, parent::cssClasses($classes, $item)));
    }

    public function argsFilter($args) {
        if($args['menu_class'] == 'vertical menu drilldown') {
            $args['items_wrap'] = '<ul id="%1$s" class="%2$s" data-drilldown data-parent-link="true">%3$s</ul>';
        }

        return $args;
    }
}
