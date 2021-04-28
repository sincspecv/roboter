<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class App extends Controller
{
    public function siteName()
    {
        return get_bloginfo('name');
    }

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
            return __('Not Found', 'sage');
        }
        return get_the_title();
    }

    /**
     * Slug for ACF modules based on post type. This variable is used in the modules.blade.php template.
     *
     * @return string
     */
    public function modules_slug() {
        return get_post_type() . '_modules';
    }

    /**
     *
     * @return string|void
     */
    public function site_brand() {
        $img_type = get_field('logo_type', 'site_settings');
        $img = get_field("site_logo_{$img_type}", 'site_settings');
        $logo = '';

        if($img_type === 'file') {
            $src = esc_url_raw($img['sizes']['medium']);
            $alt = esc_attr($img['alt']);
            $srcset = esc_attr(wp_get_attachment_image_srcset($img['id']), [300, 300]);
            $logo = '<img src="' . $src . '" srcset="' . $srcset . '" alt="' . $alt . '" />';
        }

        if($img_type === 'svg') {
            $logo = '<div class="svg-logo">' . $img . '</div>';
        }

        return $logo ? $logo : get_bloginfo('name', 'display');
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

    public static function getTestimonial($post_id) {
        $testimonial = new \stdClass();
        $testimonial->text = esc_attr(get_field('testimonial', $post_id));
        $testimonial->name = esc_attr(get_field('name', $post_id));
        $testimonial->org  = esc_attr(get_field('company', $post_id));

        return $testimonial;
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

        $pagination .= "\n" . '<nav class="grid-container text-center" aria-label="Pagination">';
        $pagination .= "\n" . '<ul class="pagination">' . "\n";

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
}
