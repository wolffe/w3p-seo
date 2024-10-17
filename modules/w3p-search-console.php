<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function w3p_search_console_head() {
    $w3p_google_meta    = get_option( 'w3p_google_webmaster' );
    $w3p_bing_meta      = get_option( 'w3p_bing_webmaster' );
    $w3p_yandex_meta    = get_option( 'w3p_yandex_webmaster' );
    $w3p_pinterest_meta = get_option( 'w3p_pinterest_webmaster' );
    $w3p_baidu_meta     = get_option( 'w3p_baidu_webmaster' );

    $twitter_author_rel = get_option( 'w3p_twitter_author' );

    /**
     * Add search engine meta verification tags
     */
    if ( ! empty( $w3p_google_meta ) ) {
        echo '<meta name="google-site-verification" content="' . esc_attr( $w3p_google_meta ) . '">';
    }
    if ( ! empty( $w3p_bing_meta ) ) {
        echo '<meta name="msvalidate.01" content="' . esc_attr( $w3p_bing_meta ) . '">';
    }
    if ( ! empty( $w3p_yandex_meta ) ) {
        echo '<meta name="yandex-verification" content="' . esc_attr( $w3p_yandex_meta ) . '">';
    }
    if ( ! empty( $w3p_pinterest_meta ) ) {
        echo '<meta name="p:domain_verify" content="' . esc_attr( $w3p_pinterest_meta ) . '">';
    }
    if ( ! empty( $w3p_baidu_meta ) ) {
        echo '<meta name="baidu-site-verification" content="' . esc_attr( $w3p_baidu_meta ) . '">';
    }

    /**
     * Add custom social relationship
     */
    if ( ! empty( $twitter_author_rel ) ) {
        echo '<link rel="me" href="https://twitter.com/' . esc_attr( $twitter_author_rel ) . '">';
    }
}



function w3p_search_console_footer() {
    $out = '';

    $w3p_local             = get_option( 'w3p_local' );
    $w3p_local_locality    = get_option( 'w3p_local_locality' );
    $w3p_local_region      = get_option( 'w3p_local_region' );
    $w3p_local_address     = get_option( 'w3p_local_address' );
    $w3p_local_postal_code = get_option( 'w3p_local_postal_code' );
    $w3p_local_country     = get_option( 'w3p_local_country' );
    $w3p_telephone         = get_option( 'w3p_telephone' );

    $twitter_author_rel = get_option( 'w3p_twitter_author' );

    $name = get_bloginfo( 'name' );
    $url  = get_bloginfo( 'url' );

    if ( (int) $w3p_local === 1 ) {
        // Create Organization schema
        $organization_schema = [
            '@context'    => 'https://schema.org',
            '@type'       => 'Organization',
            'image'       => [
                esc_url( get_option( 'w3p_local_image_1' ) ),
                esc_url( get_option( 'w3p_local_image_2' ) ),
            ],
            'name'        => esc_html( $name ),
            'url'         => esc_url( $url ),
            'description' => esc_html( get_bloginfo( 'description' ) ),
            'address'     => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => esc_html( $w3p_local_address ),
                'addressLocality' => esc_html( $w3p_local_locality ),
                'addressRegion'   => esc_html( $w3p_local_region ),
                'postalCode'      => esc_html( $w3p_local_postal_code ),
                'addressCountry'  => esc_html( $w3p_local_country ),
            ],
            'telephone'   => esc_html( $w3p_telephone ),
        ];

        // Create LocalBusiness schema
        $local_business_schema = [
            '@context'   => 'https://schema.org',
            '@type'      => 'LocalBusiness',
            'image'      => [
                esc_url( get_option( 'w3p_local_image_1' ) ),
                esc_url( get_option( 'w3p_local_image_2' ) ),
            ],
            'name'       => esc_html( $name ),
            'url'        => esc_url( $url ),
            'address'    => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => esc_html( $w3p_local_address ),
                'addressLocality' => esc_html( $w3p_local_locality ),
                'addressRegion'   => esc_html( $w3p_local_region ),
                'postalCode'      => esc_html( $w3p_local_postal_code ),
                'addressCountry'  => esc_html( $w3p_local_country ),
            ],
            'telephone'  => esc_html( $w3p_telephone ),
            'priceRange' => '$$',
            'sameAs'     => [
                esc_url( $twitter_author_rel ),
            ],
        ];

        // Output the JSON-LD Organization and LocalBusiness
        $out .= '<!-- W3P Local -->';
        $out .= '<script type="application/ld+json">' . wp_json_encode( $organization_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
        $out .= '<script type="application/ld+json">' . wp_json_encode( $local_business_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
    }

    echo $out;
}



// Add Open Graph language attributes
function w3p_opengraph_doctype( $output ) {
    return $output . ' prefix="og: https://ogp.me/ns# fb: https://ogp.me/ns/fb#"';
}

if ( (int) get_option( 'w3p_og' ) === 1 ) {
    add_filter( 'language_attributes', 'w3p_opengraph_doctype' );
}



/**
 * Remove HTML comments
 *
 * @param string $content
 * @return string
 */
function w3p_remove_html_comments( $content = '' ) {
    return preg_replace( '/<!--(.|\s)*?-->/', '', $content );
}



/**
 * Add Open Graph meta info
 *
 * @return void
 */
function w3p_head_og() {
    global $post;

    if ( empty( $post->ID ) ) {
        return;
    }

    $out = '';

    $w3p_excerpt = w3p_get_excerpt( $post->ID );
    $w3p_excerpt = strip_shortcodes( $w3p_excerpt );
    $w3p_excerpt = wp_strip_all_tags( $w3p_excerpt );

    if ( empty( $w3p_excerpt ) ) {
        $w3p_excerpt = w3p_remove_html_comments( get_the_content( '', '', $post->ID ) );
        $w3p_excerpt = strip_shortcodes( $w3p_excerpt );
        $w3p_excerpt = wp_strip_all_tags( $w3p_excerpt );
        $w3p_excerpt = substr( $w3p_excerpt, 0, 300 );
    }

    if ( is_category() ) {
        $w3p_excerpt = wp_strip_all_tags( category_description() );
    }

    if ( is_front_page() ) {
        $out .= '<meta property="og:type" content="website">';
    } else {
        $out .= '<meta property="og:type" content="article">';
    }

    $title      = esc_html( wp_strip_all_tags( get_the_title() ) );
    $permalink  = esc_url( get_permalink() );
    $home_url   = esc_url( home_url() );
    $parsed_url = wp_parse_url( $home_url );
    $domain_url = esc_attr( str_replace( 'www.', '', $parsed_url['host'] ) );

    // Open Graph
    $out .= '<meta property="og:locale" content="' . esc_attr( get_locale() ) . '">
    <meta property="og:url" content="' . $permalink . '">
    <meta property="og:site_name" content="' . esc_html( get_bloginfo( 'name' ) ) . '">
    <meta property="og:title" content="' . $title . '">
    <meta property="og:description" content="' . esc_attr( $w3p_excerpt ) . '">

    <meta property="article:published_time" content="' . esc_attr( get_the_date( 'c' ) ) . '">
    <meta property="article:modified_time" content="' . esc_attr( get_the_modified_date( 'c' ) ) . '">
    <meta property="article:author" content="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">

    <meta name="pinterest-rich-pin" content="true">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="' . $domain_url . '">
    <meta property="twitter:url" content="' . $permalink . '">

    <meta property="twitter:site" content="@' . esc_attr( get_option( 'w3p_twitter_author' ) ) . '">
    <meta property="twitter:creator" content="@' . esc_attr( get_option( 'w3p_twitter_author' ) ) . '">
    <meta property="twitter:title" content="' . $title . '">
    <meta property="twitter:description" content="' . esc_attr( $w3p_excerpt ) . '">';

    // Facebook
    if ( ! has_post_thumbnail( $post->ID ) ) {
        if ( ! empty( get_option( 'w3p_fb_default_image' ) ) ) {
            $out .= '<meta property="og:image" content="' . esc_url( get_option( 'w3p_fb_default_image' ) ) . '">';
        }
    } else {
        $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
        $thumbnail_alt = esc_attr( get_post_meta( get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true ) );

        if ( $thumbnail_src ) {
            $out .= '<meta property="og:image" content="' . esc_url( $thumbnail_src[0] ) . '">
            <meta property="og:image:width" content="' . esc_attr( $thumbnail_src[1] ) . '">
            <meta property="og:image:height" content="' . esc_attr( $thumbnail_src[2] ) . '">
            <meta property="og:image:alt" content="' . $thumbnail_alt . '">
            <meta property="twitter:image" content="' . esc_url( $thumbnail_src[0] ) . '">';
        }
    }

    // Define allowed tags and attributes
    $allowed_tags         = wp_kses_allowed_html( 'post' );
    $allowed_tags['meta'] = [
        'property' => true,
        'content'  => true,
        'name'     => true,
    ];

    // Output sanitized HTML
    echo wp_kses( $out, $allowed_tags );
}




add_action( 'wp_footer', 'w3p_search_console_footer' );



/*
 * Microdata Breadcrumbs
 *
 * #reference https://developers.google.com/search/docs/data-types/breadcrumbs
 */
function w3p_breadcrumb_wrapper( $title, $link, $class, $counter ) {
    if ( $link !== '#' ) {
        $item = '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="' . $class . '"><a itemscope itemtype="https://schema.org/Thing" itemprop="item" href="' . $link . '"><span itemprop="name">' . $title . '</span></a><meta itemprop="position" content="' . $counter . '"></li>';
    } else {
        $item = '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="' . $class . '"><span itemprop="name">' . $title . '</span><meta itemprop="position" content="' . $counter . '"></li>';
    }

    return $item;
}

function w3p_breadcrumbs() {
    global $post, $wp_query;

    // Settings
    $counter = 1;

    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy = 'product_cat';

    // Do not display on the homepage
    if ( ! is_front_page() ) {
        echo '<ol itemscope itemtype="https://schema.org/BreadcrumbList" class="w3p-breadcrumbs">';

        // Home page
        echo wp_kses_data( w3p_breadcrumb_wrapper( 'Home', get_home_url(), 'item-home', $counter ) );
        ++$counter;

        if ( is_archive() && ! is_tax() && ! is_category() && ! is_tag() ) {
            echo wp_kses_data( w3p_breadcrumb_wrapper( post_type_archive_title( $prefix, false ), '#', 'item-current item-archive', $counter ) );
            ++$counter;
        } elseif ( is_archive() && is_tax() && ! is_category() && ! is_tag() ) {
            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if ( $post_type !== 'post' ) {
                $post_type_object  = get_post_type_object( $post_type );
                $post_type_archive = get_post_type_archive_link( $post_type );

                echo wp_kses_data( w3p_breadcrumb_wrapper( $post_type_object->labels->name, $post_type_archive, 'item-cat item-custom-post-type-' . $post_type . '', $counter ) );
                ++$counter;
            }

            $custom_tax_name = get_queried_object()->name;
            echo wp_kses_data( w3p_breadcrumb_wrapper( $custom_tax_name, '#', 'item-current item-archive', $counter ) );
            ++$counter;
        } elseif ( is_single() ) {
            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if ( $post_type !== 'post' ) {
                $post_type_object  = get_post_type_object( $post_type );
                $post_type_archive = get_post_type_archive_link( $post_type );

                echo wp_kses_data( w3p_breadcrumb_wrapper( $post_type_object->labels->name, $post_type_archive, 'item-cat item-custom-post-type-' . $post_type . '', $counter ) );
                ++$counter;
            }

            // Get post category info
            $category = get_the_category();

            if ( ! empty( $category ) ) {
                // Get last category post is in
                $last_category = end( array_values( $category ) );

                // Get parent any categories and create array
                $get_cat_parents = rtrim( get_category_parents( $last_category->term_id, true, ',' ), ',' );
                $cat_parents     = explode( ',', $get_cat_parents );

                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach ( $cat_parents as $parents ) {
                    $cat_display .= wp_kses_data( w3p_breadcrumb_wrapper( $parents, '#', 'item-cat', $counter ) );
                    ++$counter;
                }
            }

            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists( $custom_taxonomy );
            if ( empty( $last_category ) && ! empty( $custom_taxonomy ) && $taxonomy_exists ) {
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link( $taxonomy_terms[0]->term_id, $custom_taxonomy );
                $cat_name       = $taxonomy_terms[0]->name;
            }

            // Check if the post is in a category
            if ( ! empty( $last_category ) ) {
                echo $cat_display;
                echo wp_kses_data( w3p_breadcrumb_wrapper( get_the_title(), '#', 'item-current item-' . $post->ID . '', $counter ) );
                ++$counter;

                // Else if post is in a custom taxonomy
            } elseif ( ! empty( $cat_id ) ) {
                echo wp_kses_data( w3p_breadcrumb_wrapper( $cat_name, $cat_link, 'item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '', $counter ) );
                ++$counter;

                echo wp_kses_data( w3p_breadcrumb_wrapper( get_the_title(), '#', 'item-current item-' . $post->ID . '', $counter ) );
                ++$counter;
            } else {
                echo wp_kses_data( w3p_breadcrumb_wrapper( get_the_title(), '#', 'item-current item-' . $post->ID . '', $counter ) );
                ++$counter;
            }
        } elseif ( is_category() ) {
            // Category page
            echo wp_kses_data( w3p_breadcrumb_wrapper( single_cat_title( '', false ), '#', 'item-current item-cat', $counter ) );
            ++$counter;
        } elseif ( is_page() ) {
            // Standard page
            if ( $post->post_parent ) {
                // If child page, get parents
                $anc = get_post_ancestors( $post->ID );

                // Get parents in the right order
                $anc = array_reverse( $anc );

                // Parent page loop
                if ( ! isset( $parents ) ) {
                    $parents = null;
                }

                foreach ( $anc as $ancestor ) {
                    $parents .= wp_kses_data( w3p_breadcrumb_wrapper( get_the_title( $ancestor ), get_permalink( $ancestor ), 'item-parent item-parent-' . $ancestor . '', $counter ) );
                    ++$counter;
                }

                // Display parent pages
                echo $parents;

                // Current page
                echo wp_kses_data( w3p_breadcrumb_wrapper( get_the_title(), '#', 'item-current item-' . $post->ID . '', $counter ) );
                ++$counter;
            } else {
                // Just display current page if not parents
                echo wp_kses_data( w3p_breadcrumb_wrapper( get_the_title(), '#', 'item-current item-' . $post->ID . '', $counter ) );
                ++$counter;
            }
        } elseif ( is_tag() ) {
            // Tag page

            // Get tag information
            $term_id       = get_query_var( 'tag_id' );
            $terms         = get_terms(
                [
                    'taxonomy' => 'post_tag',
                    'include'  => $term_id,
                ]
            );
            $get_term_id   = $terms[0]->term_id;
            $get_term_slug = $terms[0]->slug;
            $get_term_name = $terms[0]->name;

            // Display the tag name
            echo wp_kses_data( w3p_breadcrumb_wrapper( $get_term_name, '#', 'item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '', $counter ) );
            ++$counter;
        } elseif ( is_day() ) {
            // Day archive

            // Year link
            echo wp_kses_data( w3p_breadcrumb_wrapper( get_the_time( 'Y' ), get_year_link( get_the_time( 'Y' ) ), 'item-year item-year-' . get_the_time( 'Y' ) . '', $counter ) );
            ++$counter;

            // Month link
            echo wp_kses_data( w3p_breadcrumb_wrapper( get_the_time( 'M' ), get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ), 'item-month item-month-' . get_the_time( 'm' ) . '', $counter ) );
            ++$counter;

            // Day display
            echo wp_kses_data( w3p_breadcrumb_wrapper( get_the_time( 'jS' ) . ' ' . get_the_time( 'M' ), '#', 'item-current item-' . get_the_time( 'j' ) . '', $counter ) );
            ++$counter;
        } elseif ( is_month() ) {
            // Month Archive

            // Year link
            echo wp_kses_data( w3p_breadcrumb_wrapper( get_the_time( 'Y' ), '#', 'item-current item-year item-year-' . get_the_time( 'Y' ) . '', $counter ) );
            ++$counter;

            // Month display
            echo wp_kses_data( w3p_breadcrumb_wrapper( get_the_time( 'M' ), '#', 'item-current item-month item-month-' . get_the_time( 'm' ) . '', $counter ) );
            ++$counter;
        } elseif ( is_year() ) {
            // Display year archive
            echo wp_kses_data( w3p_breadcrumb_wrapper( get_the_time( 'Y' ), '#', 'item-current item-current-' . get_the_time( 'Y' ) . '', $counter ) );
            ++$counter;
        } elseif ( is_author() ) {
            // Author archive

            // Get the author information
            global $author;
            $userdata = get_userdata( $author );

            // Display author name
            echo wp_kses_data( w3p_breadcrumb_wrapper( $userdata->display_name, '#', 'item-current item-current-' . $userdata->user_nicename . '', $counter ) );
            ++$counter;
        } elseif ( get_query_var( 'paged' ) ) {
            // Paginated archives
            echo wp_kses_data( w3p_breadcrumb_wrapper( get_query_var( 'paged' ), '#', 'item-current item-current-' . get_query_var( 'paged' ) . '', $counter ) );
            ++$counter;
        } elseif ( is_search() ) {
            // Search results page
            echo wp_kses_data( w3p_breadcrumb_wrapper( get_search_query(), '#', 'item-current item-current-' . get_search_query() . '', $counter ) );
            ++$counter;
        } elseif ( is_404() ) {
            // 404 page
            echo wp_kses_data( w3p_breadcrumb_wrapper( '404', '#', '', $counter ) );
            ++$counter;
        }
        echo '</ol>';
    }
}
