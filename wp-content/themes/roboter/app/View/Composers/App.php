<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class App extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        '*',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'siteName' => $this->siteName(),
            'siteBrand' => $this->siteBrand(),
        ];
    }

    /**
     * Returns the site name.
     *
     * @return string
     */
    public function siteName()
    {
        return get_bloginfo('name', 'display');
    }

    /**
     * Returns the site logo as configured in theme settings
     *
     * @return string|void
     */
    public function siteBrand() {
        $img_type = get_field('logo_type', 'site_settings');
        $img = get_field("site_logo_{$img_type}", 'site_settings');
        $logo = '';

        $siteBrandClasses = apply_filters('tfr/site_brand/classes', ['w-auto', 'h-full', 'max-h-full']);

        if($img_type === 'file') {
            $src = $img['sizes']['medium'];
            $alt = esc_attr($img['alt']);
            $srcset = esc_attr(wp_get_attachment_image_srcset($img['id']), [300, 300]);
//            $logo = '<img src="' . $src . '" srcset="' . $srcset . '" alt="' . $alt . '" />';
            $logo = sprintf('<img class="%s" src="%s" srcset="%s" alt="%s" />',
                implode(' ', $siteBrandClasses),
                $src,
                $srcset,
                $alt
            );
        }

        if($img_type === 'svg') {
            $logo = sprintf('<div class="svg-logo %s">%s</div>',
                implode(' ', $siteBrandClasses),
                $img
            );
        }

        return $logo ? $logo : get_bloginfo('name', 'display');
    }

    /**
     * Returns the proper page title
     *
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public static function title()
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return __('Latest Posts', 'sage');
        }
        if (is_archive()) {
            return get_the_archive_title();
        }
        if (is_search()) {
            return sprintf(__('Search Results for %s', 'sage'), get_search_query());
        }
        if (is_404()) {
            return __('404 Not Found', 'sage');
        }
        if(is_page()) {
            $page_heading = get_field('page_heading') ? get_field('page_heading') : '';
            $page_accent_heading = get_field('page_accent_heading') ? get_field('page_accent_heading') : '';

            if( !empty($page_heading) || !empty($page_accent_heading) ) {
                $title = '';
                if(!empty($page_heading)) $title .= '<span class="small-h1">' . $page_heading . '</span>';
                if(!empty($page_accent_heading)) $title .= '<span class="page-hero__heading-enhanced">' . $page_accent_heading . '</span>';
                return $title ;
            }
        }
        return get_the_title();
    }

    /**
     * Slug for ACF modules based on post type. This variable is used in the modules.blade.php template.
     *
     * @return string
     */
    public function modulesSlug() {
        return get_post_type() . '_modules';
    }

    public static function getGFForm($form_id) {
        gravity_form(
            $form_id,
            false,
            false,
            false,
            null,
            false,
            false,
            true
        );
        gravity_form_enqueue_scripts($form_id);
    }

    public function featured_image() {
        $thumbnail_id  = get_post_thumbnail_id($this->post);
        $thumbnail_url = !empty($thumbnail_id) ? get_the_post_thumbnail_url($this->post, 'full') : $this->default_hero();
        $thumbnail_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);

        $featured_image = new stdClass();
        $featured_image->id = $thumbnail_id;
        $featured_image->url = $thumbnail_url;
        $featured_image->alt = $thumbnail_alt;

        return $featured_image;
    }

    public function recent_posts() {
        return get_posts(
            [
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => 12,
            ]
        );
    }

    public function related_posts() {
        $terms = self::getTerms(get_the_ID()) || [];
        $taxonomy = self::getTaxonomy();
        $term_list = wp_list_pluck( $terms, 'slug' );

        return get_posts(
            [
                'post_type' => get_post_type(),
                'post_status' => 'publish',
                'posts_per_page' => 12,
                'post__not_in' => [get_the_ID()],
                'orderby' => 'rand',
                'tax_query' => [
                    [
                        'taxonomy' => $taxonomy,
                        'field' =>'slug',
                        'terms' => $term_list,
                    ]
                ],
            ]
        );
    }

    public function page_header_image() {
        $global_hero = $this->global_hero();

        if(is_home()) {
            return $this->archive_thumbnail()->url;
        } elseif (!empty($featured_image)) {
            return !empty($featured_image) ? $featured_image->url : $global_hero['sizes']['large'];
        } else {
            return !empty($global_hero) ? $global_hero['sizes']['large'] : 'data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJkZWZhdWx0LWltYWdlLXNvbGlkIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHg9IjBweCIgeT0iMHB4IiB2aWV3Qm94PSIwIDAgNDAwIDI2NSIgc3R5bGU9IndpZHRoOiA0MDBweDsgaGVpZ2h0OiAyNjVweDsiPg0KPHJlY3QgZmlsbD0iI0M2RDhFMSIgd2lkdGg9IjQwMCIgaGVpZ2h0PSIyNjUiLz4NCjxwYXRoIGZpbGw9IiNEOUUzRTgiIGQ9Ik0zOTUuMyw5Ni4yYy01LTAuOC02LjEsMS4xLTguNSwyLjljLTEtMi4zLTIuNi02LjItNy43LTVjMS41LTUuMy0yLjYtOC40LTcuNy04LjRjLTAuNiwwLTEuMiwwLjEtMS44LDAuMg0KCWMtMS44LTQuMS02LTYuOS0xMC43LTYuOWMtNi41LDAtMTEuOCw1LjMtMTEuOCwxMS44YzAsMC40LDAsMC45LDAuMSwxLjNjLTEuMi0wLjgtMi41LTEuMy0zLjktMS4zYy00LjMsMC03LjksNC4yLTcuOSw5LjQNCgljMCwxLjIsMC4yLDIuNCwwLjYsMy41Yy0wLjUtMC4xLTEtMC4xLTEuNi0wLjFjLTYuOSwwLTEyLjUsNS41LTEyLjcsMTIuNGMtMC45LTAuMi0xLjktMC40LTIuOS0wLjRjLTYuNCwwLTExLjcsNS4yLTEyLjUsMTEuOA0KCWMtMS4yLTAuNC0yLjUtMC42LTMuOS0wLjZjLTUuOSwwLTEwLjgsMy44LTEyLjEsOC45Yy0yLjQtMi01LjUtMy4yLTguOS0zLjJjLTYsMC0xMS4xLDMuNy0xMi44LDguOGMtMS41LTEuNC0zLjgtMi4zLTYuMy0yLjMNCgljLTIuMSwwLTQuMSwwLjYtNS41LDEuN2gtMC4xYy0xLjMtNS41LTYuMi05LjUtMTIuMS05LjVjLTIuNCwwLTQuNywwLjctNi42LDEuOWMtMS40LTAuNy0zLTEuMi00LjgtMS4yYy0wLjMsMC0wLjUsMC0wLjgsMA0KCWMtMS41LTQuMS01LjItNy05LjUtN2MtMy4xLDAtNS45LDEuNS03LjgsMy45Yy0yLjItNC44LTYuOC04LjItMTIuMi04LjJjLTUuNiwwLTEwLjUsMy43LTEyLjUsOC44Yy0yLjEtMC45LTQuNC0xLjUtNi45LTEuNQ0KCWMtNi44LDAtMTIuNSwzLjktMTQuNSw5LjNjLTAuMiwwLTAuNSwwLTAuNywwYy01LjIsMC05LjYsMy4yLTExLjQsNy44Yy0yLjctMi44LTctNC41LTExLjgtNC41Yy0zLjMsMC02LjQsMC45LTguOSwyLjMNCgljLTIuMS02LjUtOC0xMi4yLTE4LjEtOS45Yy0yLjctMi4zLTYuMy0zLjctMTAuMS0zLjdjLTIuNSwwLTQuOCwwLjYtNi45LDEuNmMtMi4yLTUuOS03LjktMTAuMS0xNC42LTEwLjFjLTguNiwwLTE1LjYsNy0xNS42LDE1LjYNCgljMCwwLjksMC4xLDEuNywwLjIsMi41Yy0yLjYtNS03LjgtOC40LTEzLjgtOC40Yy04LjMsMC0xNS4xLDYuNS0xNS42LDE0LjZjLTIuOS0zLjItNy01LjMtMTEuNy01LjNjLTcuNCwwLTEzLjUsNS4xLTE1LjIsMTINCgljLTIuOS0zLjUtOS44LTYtMTQuNy02djExOS4yaDQwMFYxMDJDNDAwLDEwMiw0MDAsOTcsMzk1LjMsOTYuMnoiLz4NCjxwYXRoIGZpbGw9IiM4RUE4QkIiIGQ9Ik00MDAsMjA2LjJjMCwwLTI1LjMtMTkuMi0zMy42LTI1LjdjLTEzLjQtMTAuNi0yMy4xLTEyLjktMzEuNy03cy0yMy45LDE5LjctMjMuOSwxOS43cy01OC45LTYzLjktNjEuNS02Ni40DQoJYy0xLjUtMS40LTMuNi0xLjctNS41LTAuOWMtNS4yLDIuNC0xNy42LDkuNy0yNC41LDEyLjdjLTYuOSwyLjktNDEtNTAuNy00OS42LTUzcy04NC4zLDgzLjMtMTAxLjQsNzUuMXMtMjYuOS0yLjMtMzUuNCwzLjUNCgljLTguNiw1LjktMTEsNS45LTE1LjksOC4ycy0xNy4xLTUuOS0xNy4xLTUuOVYyNjVjMCwwLDQwMCwwLjIsNDAwLDB2LTU4LjhINDAweiIvPg0KPHBhdGggZmlsbD0iIzdFOTZBNiIgZD0iTTMzMy40LDE3OWMtMTMuMS05LjMtNDAsNC42LTU1LjEsMTAuN2MtMjMuNiw5LjYtOTQtNTQuNC0xMDcuMi01OS43YzAsMC00LjIsMy43LTkuNiw3LjYNCgljLTMuNS0wLjQtOC40LTUuNy05LjktNC43Yy00LjYsMy4xLTE3LjgsMTUuNC0yOC4zLDI2LjZjLTEwLjUsMTEuMy0xMS43LDAtMTUuOC0wLjZjLTIuNS0wLjQtNTQuMSw0Mi41LTU4LjcsNDMuMQ0KCUMyMi4zLDIwNS4zLDAsMTk3LjUsMCwxOTcuNVYyNjVsNDAwLTAuMXYtNTMuM0M0MDAsMjExLjYsMzQ0LjgsMTg3LjEsMzMzLjQsMTc5eiIvPg0KPHBhdGggZmlsbD0iIzc4OEY5RSIgZD0iTTAsMjY0Ljl2LTU4LjZjMCwwLDguMiwxLjgsMTEuMyw1LjNjMy4xLDMuNiwyNi4xLTQuMiwyNi4xLDQuN3MwLjUsNC4yLDAuNSwxNC44YzAsMTAuNywyMy00LjIsMzguMS0xOC40DQoJczM0LjktNDkuMiwzNi0zNWMxLDE0LjItMTUuMSwzOS4yLTI0LDU2LjRDNzkuMSwyNTEuNCw1MS43LDI2NSw1MS43LDI2NUwwLDI2NC45eiIvPg0KPHBhdGggZmlsbD0iIzc4OEY5RSIgZD0iTTEwMCwyNjVjMCwwLDY2LjctMTI1LjEsNjguMy0xMTYuOHMtNi44LDI5LjcsMi4xLDI2LjFjOC45LTMuNiwxNC42LTE2LDE4LjgtOS41czE2LjIsMzguNiwyMS45LDMzLjgNCgljNS43LTQuNywyMS40LTEzLjEsMjIuNC02LjVjMSw2LjUtMSw1LjMtNS43LDIwLjJDMjIzLjEsMjI3LjEsMjAwLDI2NSwyMDAsMjY1aC0xMGMwLDAsNi0yNC44LDguNi0zNC45YzIuNi0xMC4xLTMuNy0xOS0xMi04LjMNCglzLTIzLDIyLTI0LDE3LjhzLTUuNy0zMC4zLTE4LjgtMTQuMmMtMTMsMTYtMzMuOCwzOS43LTMzLjgsMzkuN2gtMTBWMjY1eiIvPg0KPHBhdGggZmlsbD0iIzc4OEY5RSIgZD0iTTI0NSwyNjVjMCwwLDE5LjgtNTQuNywzMy40LTY0LjJzNTMuNy0yNy45LDQ2LjktMTMuNmMtNi44LDE0LjItMTEsMzQuNC0yMC4zLDQ5LjgNCgljLTkuNCwxNS40LTE4LjgsMjYuMS0xNC4xLDEzLjZjNC43LTEyLjUsNi40LTIzLjMsMy43LTIzLjFDMjcxLjMsMjI5LjEsMjYwLDI2NSwyNjAsMjY1SDI0NXoiLz4NCjwvc3ZnPg0K';
        }
    }

    public function banner() {
        $banner = new \stdClass();

        $banner->button = get_field('banner_button', 'site_settings');

        return json_decode(json_encode($banner));
    }

    public function show_date_on_single() {
        if(!is_single()
            || is_woocommerce()
            || tribe_is_event()
        ) {
            return false;
        }

        return true;
    }

    /**
     * Return object of social media links
     *
     * @return false|mixed
     */
    public function social_links() {
        if(!get_field('social_accounts', 'site_settings')) {
            return false;
        }

        return json_decode(json_encode(get_field('social_accounts', 'site_settings')));
    }

    /**
     * Return field values for global CTA
     *
     * @return false|mixed
     */
    public function global_cta() {
        $global_cta = new \stdClass();

        $global_cta->heading = get_field('global_cta_heading', 'site_settings');
        $global_cta->subheading = get_field('global_cta_subheading', 'site_settings');
        $global_cta->text = get_field('global_cta_text', 'site_settings');
        $global_cta->button = get_field('global_cta_button', 'site_settings');
        $global_cta->image = get_field('global_cta_image', 'site_settings');


//        return $global_cta;
        return json_decode(json_encode($global_cta));
    }

    /**
     * Return field values for the footer
     *
     * @return false|mixed
     */
    public function footer() {
        $footer = new \stdClass();

        $footer->logo             = get_field('footer_logo', 'site_settings');
        $footer->cta_one          = get_field('footer_cta_one', 'site_settings');
        $footer->cta_two          = get_field('footer_cta_two', 'site_settings');

        return json_decode(json_encode($footer));
    }

    /**
     * Foundation Pagination.
     *
     * Echos Foundation styled paginated links (https://get.foundation/sites/docs/pagination.html).
     *
     * @since 0.0.1
     *
     * @param array $args {
     *     An array of arguments. Optional.
     *     @type bool 'echo'           If true, pagination is echoed. Otherwise is is returned.
     *                                 Default true. Accepts true|false.
     *     @type WP_Query 'query'      Allows you to specify a custom query to paginate (avoids the dreaded query_posts()).
     *                                 Default $GLOBALS['wp_query']. Accepts WP_Query object.
     *     @type bool 'show_all'       If set to True, then it will show all of the pages instead of a short list of the pages near the current page.
     *                                 Default false. Accepts true|false.
     *     @type bool 'prev_next'      Wheter to include the previous and next links in the list or not.
     *                                 Default true. Accepts true|false.
     *     @type string 'prev_text'    The previous page text which is only shown to screenreaders. Works only if 'prev_next' argument is set to true.
     *                                 Default ''. Accepts string.
     *     @type string 'next_text'    The next page text which is only shown to screenreaders. Works only if 'prev_next' argument is set to true.
     *                                 Default ''. Accepts string.
     * }
     * @return string Foundation classed HTML for pagination list if 'echo' is set to false.
     * @return void Value is echoed if 'echo' is set to true.
     */
    public static function pagination($args = []) {
        $defaults = array(
            'echo' => true,
            'query' => $GLOBALS['wp_query'],
            'show_all' => false,
            'prev_next' => true,
            'prev_text' => __('Previous Page', 'enollo'),
            'next_text' => __('Next Page', 'enollo'),
        );

        $args = wp_parse_args( $args, $defaults );
        extract($args, EXTR_SKIP);

        // Stop execution if there's only 1 page
        if( $query->max_num_pages <= 1 ) {
            return;
        }

        $pagination = '';
        $links = array();

        $paged = max( 1, absint( $query->get( 'paged' ) ) );
        $max   = intval( $query->max_num_pages );

        if ( $show_all ) {
            $links = range(1, $max);
        } else {
            // Add the pages before the current page to the array
            if ( $paged >= 2 + 1 ) {
                $links[] = $paged - 2;
                $links[] = $paged - 1;
            }

            // Add current page to the array
            if ( $paged >= 1 ) {
                $links[] = $paged;
            }

            // Add the pages after the current page to the array
            if ( ( $paged + 2 ) <= $max ) {
                $links[] = $paged + 1;
                $links[] = $paged + 2;
            }
        }

        $pagination .= "\n" . '<nav class="content-container pagination" aria-label="Pagination">';
        $pagination .= "\n" . '<ul class="pagination-list">' . "\n";

        // Previous Post Link
        if ( $prev_next && get_previous_posts_link() ) {
            $pagination .= sprintf( '<li class="prev">%s</li>', get_previous_posts_link('&laquo;<span class="show-for-sr">' . $prev_text . '</span>') );
        }

        $pagination .= "\n";

        // Link to first page, plus ellipses if necessary
        if ( ! in_array( 1, $links ) ) {
            $class = 1 == $paged ? ' class="current"' : '';

            $pagination .= sprintf( '<li%s><a href="%s">%s</a></li>', $class, esc_url( get_pagenum_link( 1 ) ), '1' );
            $pagination .= "\n";
            if ( ! in_array( 2, $links ) ) {
                $pagination .= '<li class="ellipsis"><span>' . __( '&hellip;' ) . '</span></li>';
            }
            $pagination .= "\n";
        }

        // Link to current page, plus $mid_size pages in either direction if necessary
        sort( $links );
        foreach ( (array) $links as $link ) {
            $class = $paged == $link ? ' class="active"' : '';
            $pagination .= sprintf( '<li%s><a href="%s" aria-label="Page %s">%s</a></li>', $class, esc_url( get_pagenum_link( $link ) ), $link, $link );
            $pagination .= "\n";
        }

        // Link to last page, plus ellipses if necessary
        if ( ! in_array( $max, $links ) ) {
            if ( ! in_array( $max - 1, $links ) ) {
                $pagination .= '<li class="ellipsis" aria-hidden="true"></li>';
                $pagination .= "\n";
            }

            $class = $paged == $max ? ' class="active"' : '';
            $pagination .= sprintf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
            $pagination .= "\n";
        }

        // Next Post Link
        if ( $prev_next && get_next_posts_link() && $paged <= $max ) {
            $pagination .= sprintf( '<li class="next">%s</li>' . "\n", get_next_posts_link('<span class="show-for-sr">' . $next_text . '</span>&raquo;') );
        }

        $pagination .= "</ul><!-- /.pagination -->\n";
        $pagination .= "</nav><!-- /nav -->\n";

        if ( $echo ) {
            echo $pagination;
        } else {
            return $pagination;
        }
    }

    public function wc_id() {
        if(!function_exists('wc_get_page_id')) {
            return false;
        }

        $wc_id = new \stdClass();
        $wc_id->myaccount     = wc_get_page_id( 'myaccount' );
        $wc_id->shop          = wc_get_page_id( 'shop' );
        $wc_id->cart          = wc_get_page_id( 'cart' );
        $wc_id->checkout      = wc_get_page_id( 'checkout' );
        $wc_id->terms         = wc_get_page_id( 'terms' );

        return $wc_id;
    }

    public function event() : object {
        $event = new \stdClass();

        $event->label_singular = \tribe_get_event_label_singular();
        $event->label_plural   = \tribe_get_event_label_plural();

        if(class_exists('Tribe__Events__Main')) {
            $event->id = \Tribe__Events__Main::postIdHelper( get_the_ID() );
        }

        /**
         * Allows filtering of the event ID.
         *
         * @since 6.0.1
         *
         * @param int $event->id
         */
        $event->id = apply_filters( 'tec_events_single_event->id', $event->id );

        /**
         * Allows filtering of the single event template title classes.
         *
         * @since 5.8.0
         *
         * @param array  $title_classes List of classes to create the class string from.
         * @param string $event->id The ID of the displayed event.
         */
        $event->title_classes = apply_filters( 'tribe_events_single_event_title_classes', [ 'tribe-events-single-event-title' ], $event->id );
        $event->title_classes = implode( ' ', tribe_get_classes( $event->title_classes ) );

        /**
         * Allows filtering of the single event template title before HTML.
         *
         * @since 5.8.0
         *
         * @param string $before HTML string to display before the title text.
         * @param string $event->id The ID of the displayed event.
         */
        $event->before = apply_filters( 'tribe_events_single_event_title_html_before', '<h1 class="' . $event->title_classes . '">', $event->id );

        /**
         * Allows filtering of the single event template title after HTML.
         *
         * @since 5.8.0
         *
         * @param string $after HTML string to display after the title text.
         * @param string $event->id The ID of the displayed event.
         */
        $event->after = apply_filters( 'tribe_events_single_event_title_html_after', '</h1>', $event->id );

        /**
         * Allows filtering of the single event template title HTML.
         *
         * @since 5.8.0
         *
         * @param string $after HTML string to display. Return an empty string to not display the title.
         * @param string $event->id The ID of the displayed event.
         */
        $event->title = apply_filters( 'tribe_events_single_event_title_html', the_title( $event->before, $event->after, false ), $event->id );

        return $event;
    }
}
