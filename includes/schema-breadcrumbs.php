<?php
// Schema.org JSON for breadcrumbs

// @todo https://gist.github.com/inetbiz/a84101b9d979da51afcf22cebf0015f2
// @todo https://xoocode.com/json-ld-code-examples/person/

function w3p_schema_breadcrumbs() {
    // Cache options that rarely change
    static $page_for_posts = null;
    static $site_name = null;
    static $blog_posts_page_slug = null;
    
    if ( $page_for_posts === null ) {
        $page_for_posts = get_option( 'page_for_posts' );
    }
    if ( $site_name === null ) {
        $site_name = get_bloginfo( 'name' );
    }
    if ( $blog_posts_page_slug === null ) {
        $blog_posts_page_slug = $page_for_posts ? get_permalink( $page_for_posts ) : trailingslashit( get_site_url() );
    }

    if ( ! is_search() ) {
        $breadcrumbs = [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => [],
        ];

        global $post;

        // Ensure $post is valid
        if ( is_int( $post ) ) {
            $post = get_post( $post );
        }

        if ( ! ( $post instanceof WP_Post ) ) {
            return; // Bail if $post is still invalid.
        }

        // Use post object properties directly to avoid queries
        $post_permalink = get_permalink( $post->ID );
        $post_title     = $post->post_title;

        // Single Post
        if ( is_singular( 'post' ) ) {
            $breadcrumbs['itemListElement'][] = [
                '@type'    => 'ListItem',
                'position' => 1,
                'item'     => [
                    '@id'  => esc_url( $blog_posts_page_slug ),
                    'name' => esc_html( $site_name ),
                ],
            ];
            $breadcrumbs['itemListElement'][] = [
                '@type'    => 'ListItem',
                'position' => 2,
                'item'     => [
                    '@id'  => esc_url( $post_permalink ),
                    'name' => esc_html( $post_title ),
                ],
            ];
        } elseif ( is_singular( 'product' ) ) {
            // Single Product
            $terms = wp_get_object_terms( $post->ID, 'product_cat', [ 'number' => 1 ] );
            if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
                $term = $terms[0];
                $term_link = get_term_link( $term );

                $breadcrumbs['itemListElement'][] = [
                    '@type'    => 'ListItem',
                    'position' => 1,
                    'item'     => [
                        '@id'  => esc_url( $term_link ),
                        'name' => esc_html( $term->name ),
                    ],
                ];
                $breadcrumbs['itemListElement'][] = [
                    '@type'    => 'ListItem',
                    'position' => 2,
                    'item'     => [
                        '@id'  => esc_url( $post_permalink ),
                        'name' => esc_html( $post_title ),
                    ],
                ];
            }
        } elseif ( is_page() && ! is_front_page() ) {
            // Pages (Including Parent-Child Hierarchy)
            if ( $post->post_parent ) {
                $parent_post = get_post( $post->post_parent );
                if ( $parent_post ) {
                    $parent_page_url   = get_permalink( $parent_post->ID );
                    $parent_page_title = $parent_post->post_title;

                    $breadcrumbs['itemListElement'][] = [
                        '@type'    => 'ListItem',
                        'position' => 1,
                        'item'     => [
                            '@id'  => esc_url( $parent_page_url ),
                            'name' => esc_html( $parent_page_title ),
                        ],
                    ];
                }
            }

            $breadcrumbs['itemListElement'][] = [
                '@type'    => 'ListItem',
                'position' => $post->post_parent ? 2 : 1,
                'item'     => [
                    '@id'  => esc_url( $post_permalink ),
                    'name' => esc_html( $post_title ),
                ],
            ];
        } elseif ( is_home() || is_front_page() ) {
            $breadcrumbs['itemListElement'][] = [
                '@type'    => 'ListItem',
                'position' => 1,
                'item'     => [
                    '@id'  => esc_url( $blog_posts_page_slug ),
                    'name' => esc_html( $site_name ),
                ],
            ];
        } else {
            $breadcrumbs['itemListElement'][] = [
                '@type'    => 'ListItem',
                'position' => 1,
                'item'     => [
                    '@id'  => esc_url( $blog_posts_page_slug ),
                    'name' => esc_html( $site_name ),
                ],
            ];
            $breadcrumbs['itemListElement'][] = [
                '@type'    => 'ListItem',
                'position' => 2,
                'item'     => [
                    '@id'  => esc_url( $post_permalink ),
                    'name' => esc_html( $post_title ),
                ],
            ];
        }

        // Output Breadcrumb JSON-LD
        echo '<script type="application/ld+json">' . wp_json_encode( $breadcrumbs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
    }
}
add_action( 'wp_head', 'w3p_schema_breadcrumbs' );
