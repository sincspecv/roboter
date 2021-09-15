<?php


namespace TFR;


use TFR\ACF\Groups;
use TFR\ACF\Layouts;
use TFR\ACF\OptionsPages;
use TFR\ACF\Repeaters;
use TFR\PostTypes;

class Bootstrap {
    public static function init() {
        Filters::init();
        
        self::hooks();
        self::filters();
        self::globals();

        /**
         * Options Pages
         */
        OptionsPages\SiteSettings::init();

        /**
         * Post Types
         */
        PostTypes\Services::init();
        PostTypes\Template::init();
        PostTypes\Testimonial::init();
        PostTypes\LandingPageTemplate::init();
    }

    /**
     * Add all WordPress action hooks
     */
    public static function hooks() {
        // Hide ACF From Admin Menu
        add_action('admin_menu', function() {
            remove_menu_page('edit.php?post_type=acf-field-group');
        });
    }

    /**
     * Add all WordPress filters
     */
    public static function filters() {
        // Move Yoast to the bottom of the edit screen
        add_filter( 'wpseo_metabox_prio', function() {
            return 'low';
        });

        // ACF Groups
        add_filter( 'acf_to_post/init/groups', function() {
            return [
                Groups\Page::class,
                Groups\Post::class,
	            Groups\LandingPage::class,
	            Groups\LandingPageFooter::class,
	            Groups\Testimonial::class,
            ];
        });

        // ACF Repeater Fields
        add_filter( 'acf_to_post/init/fields', function() {
            return [
                Repeaters\Modules::class,
                Repeaters\PostModules::class,
                Repeaters\LandingPageModules::class,
            ];
        });

        // ACF Layouts
        add_filter( 'acf_to_post/init/layouts', function() {
            return [
                Layouts\Hero::class,
                Layouts\Content::class,
                Layouts\FiftyFifty::class,
	            Layouts\ImageGrid::class,
	            Layouts\LandingPageHero::class,
	            Layouts\LandingPageFullWidthContent::class,
	            Layouts\LandingPageTestimonials::class,
	            Layouts\LandingPageFaq::class,
	            Layouts\LandingPageColumns::class,
            ];
        });
    }


    /**
     * Define global constants
     */
    public static function globals() {
        // Speed Demon configuration
        define('DELETE_EXPIRED_TRANSIENTS', true);
        define('DELETE_EXPIRED_TRANSIENTS_HOURS', '6');
        define('DELETE_EXPIRED_TRANSIENTS_MAX_EXECUTION_TIME', '10');
        define('DELETE_EXPIRED_TRANSIENTS_MAX_BATCH_RECORDS', '50');
        define('DISABLE_ADMIN_AJAX', false);
        define('DISABLE_CART_FRAGMENTS', true);
        define('DISABLE_EMBEDS', true);
        define('DISABLE_EMBEDS_ALLOWED_SOURCES', 'none');
        define('DISABLE_EMOJIS', true);
        define('DISABLE_GUTENBERG', true);
        define('DISABLE_JQUERY_MIGRATE', true);
        define('DISABLE_POST_VIA_EMAIL', true);
        define('DISABLE_WOOCOMMERCE_STATUS', false);
        define('DISABLE_WOOCOMMERCE_STYLES', false);
        define('DISABLE_WOOCOMMERCE_STYLES_NAMES', 'select2');
        define('DISABLE_WOOCOMMERCE_STYLES_PREFIXES', 'wc,woocommerce');
        define('DISABLE_XML_RPC', true);
        define('HEADER_CLEANUP', true);
        define('INLINE_STYLES', false);
        define('MINIFY_HTML', true);
        define('MINIFY_HTML_INLINE_STYLES', true);
        define('MINIFY_HTML_INLINE_STYLES_COMMENTS', true);
        define('MINIFY_HTML_REMOVE_COMMENTS', true);
        define('MINIFY_HTML_REMOVE_CONDITIONALS', true);
        define('MINIFY_HTML_REMOVE_EXTRA_SPACING', true);
        define('MINIFY_HTML_REMOVE_HTML5_SELF_CLOSING', false);
        define('MINIFY_HTML_REMOVE_LINE_BREAKS', true);
        define('MINIFY_HTML_INLINE_SCRIPTS', false);
        define('MINIFY_HTML_INLINE_SCRIPTS_COMMENTS', false);
        define('MINIFY_HTML_UTF8_SUPPORT', true);
        define('REMOVE_QUERY_STRINGS', true);
        define('REMOVE_QUERY_STRINGS_ARGS', 'v,ver,version');
        define('DASHBOARD_CLEANUP_THANKS_FOOTER', true);
        define('DASHBOARD_CLEANUP_WP_ORG_SHORTCUT_LINKS', true);
        define('DASHBOARD_CLEANUP_LINK_MANAGER_MENU', true);
        define('DASHBOARD_CLEANUP_ADD_PLUGIN_TABS', true);
        define('DASHBOARD_CLEANUP_ADD_THEME_TABS', true);
        define('DASHBOARD_CLEANUP_DISABLE_SEARCH', true);
        define('DASHBOARD_CLEANUP_IMPORT_EXPORT_MENU', true);
        define('DASHBOARD_CLEANUP_CSS_ADMIN_NOTICE', true);
        define('DASHBOARD_CLEANUP_WELCOME_TO_WORDPRESS', true);
        define('DASHBOARD_CLEANUP_QUICK_DRAFT', true);
        define('DASHBOARD_CLEANUP_EVENTS_AND_NEWS', true);
        define('DASHBOARD_CLEANUP_WOOCOMMERCE_CONNECT_STORE', true);
        define('DASHBOARD_CLEANUP_WOOCOMMERCE_PRODUCTS_BLOCK', true);
        define('DASHBOARD_CLEANUP_WOOCOMMERCE_FOOTER_TEXT', true);
        define('DASHBOARD_CLEANUP_WOOCOMMERCE_MARKETPLACE_SUGGESTIONS', true);
        define('DASHBOARD_CLEANUP_WOOCOMMERCE_TRACKER', true);
    }

    public static function initTemplateEngine() {

    }
}
