<?php
// Schema.org JSON for breadcrumbs

// @todo https://gist.github.com/inetbiz/a84101b9d979da51afcf22cebf0015f2
// @todo https://xoocode.com/json-ld-code-examples/person/

function w3p_schema_breadcrumbs() {
    $page_for_posts = get_option( 'page_for_posts' );
    $site_name      = get_bloginfo( 'blogname' );

    if ( (int) get_option( 'page_for_posts' ) > 0 ) {
        $blog_posts_page_slug = get_permalink( $page_for_posts );
    } else {
        $blog_posts_page_slug = trailingslashit( get_site_url( 'url' ) );
    }

    if ( ! is_search() ) {
        $breadcrumbs = [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => [],
        ];

        if ( is_singular( 'post' ) ) {
            // Single blog post
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
                    '@id'  => esc_url( get_permalink() ),
                    'name' => esc_html( get_the_title() ),
                ],
            ];
        } elseif ( is_singular( 'product' ) ) {
            // Single product page
            global $post;
            $terms = wp_get_object_terms( $post->ID, 'product_cat' );
            if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
                $product_category_slug = $terms[0]->slug;
                $product_category_name = $terms[0]->name;

                $breadcrumbs['itemListElement'][] = [
                    '@type'    => 'ListItem',
                    'position' => 1,
                    'item'     => [
                        '@id'  => esc_url( get_bloginfo( 'url' ) . '/products/' . $product_category_slug . '/' ),
                        'name' => esc_html( $product_category_name ),
                    ],
                ];

                $breadcrumbs['itemListElement'][] = [
                    '@type'    => 'ListItem',
                    'position' => 2,
                    'item'     => [
                        '@id'  => esc_url( get_permalink() ),
                        'name' => esc_html( get_the_title() ),
                    ],
                ];
            }
        } elseif ( is_page() && ! is_front_page() ) {
            // Regular page
            global $post;

            if ( $post->post_parent ) {
                $parent_page_url   = get_permalink( $post->post_parent );
                $parent_page_title = get_the_title( $post->post_parent );

                $breadcrumbs['itemListElement'][] = [
                    '@type'    => 'ListItem',
                    'position' => 1,
                    'item'     => [
                        '@id'  => esc_url( $parent_page_url ),
                        'name' => esc_html( $parent_page_title ),
                    ],
                ];
            }

            $breadcrumbs['itemListElement'][] = [
                '@type'    => 'ListItem',
                'position' => $post->post_parent ? 2 : 1,
                'item'     => [
                    '@id'  => esc_url( get_permalink() ),
                    'name' => esc_html( get_the_title() ),
                ],
            ];
        } elseif ( is_home() ) {
            // Blog page
            $breadcrumbs['itemListElement'][] = [
                '@type'    => 'ListItem',
                'position' => 1,
                'item'     => [
                    '@id'  => esc_url( $blog_posts_page_slug ),
                    'name' => esc_html( $site_name ),
                ],
            ];
        } elseif ( is_category() || is_tag() ) {
            // Category or Tag archive
            $breadcrumbs['itemListElement'][] = [
                '@type'    => 'ListItem',
                'position' => 1,
                'item'     => [
                    '@id'  => esc_url( $blog_posts_page_slug ),
                    'name' => esc_html( $site_name ),
                ],
            ];

            if ( isset( $_SERVER['HTTP_HOST'] ) && isset( $_SERVER['REQUEST_URI'] ) ) {
                $breadcrumbs['itemListElement'][] = [
                    '@type'    => 'ListItem',
                    'position' => 2,
                    'item'     => [
                        '@id'  => esc_url( 'https://' . sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) . sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ),
                        'name' => is_category() ? single_cat_title( '', false ) : single_tag_title( '', false ),
                    ],
                ];
            }
        } elseif ( is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) {
            // Product category or tag archive
            $termname = ucfirst( get_query_var( 'term' ) );

            $breadcrumbs['itemListElement'][] = [
                '@type'    => 'ListItem',
                'position' => 1,
                'item'     => [
                    '@id'  => esc_url( get_bloginfo( 'url' ) ),
                    'name' => 'Store',
                ],
            ];

            if ( isset( $_SERVER['HTTP_HOST'] ) && isset( $_SERVER['REQUEST_URI'] ) ) {
                $breadcrumbs['itemListElement'][] = [
                    '@type'    => 'ListItem',
                    'position' => 2,
                    'item'     => [
                        '@id'  => esc_url( 'https://' . sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) . sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ),
                        'name' => esc_html( $termname ),
                    ],
                ];
            }
        } elseif ( is_archive() ) {
            // Date-based or other archive pages
            $breadcrumbs['itemListElement'][] = [
                '@type'    => 'ListItem',
                'position' => 1,
                'item'     => [
                    '@id'  => esc_url( $blog_posts_page_slug ),
                    'name' => esc_html( $site_name ),
                ],
            ];

            if ( isset( $_SERVER['HTTP_HOST'] ) && isset( $_SERVER['REQUEST_URI'] ) ) {
                $breadcrumbs['itemListElement'][] = [
                    '@type'    => 'ListItem',
                    'position' => 2,
                    'item'     => [
                        '@id'  => esc_url( 'https://' . sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) . sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ),
                        'name' => 'Archives',
                    ],
                ];
            }
        } else {
            // Default fallback
            if ( isset( $_SERVER['HTTP_HOST'] ) && isset( $_SERVER['REQUEST_URI'] ) ) {
                $breadcrumbs['itemListElement'][] = [
                    '@type'    => 'ListItem',
                    'position' => 1,
                    'item'     => [
                        '@id'  => esc_url( 'https://' . sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) . sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ),
                        'name' => 'Page',
                    ],
                ];
            }
        }

        // Output the JSON-LD Breadcrumbs
        echo '<script type="application/ld+json">' . wp_json_encode( $breadcrumbs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
    }
}


add_action( 'wp_footer', 'w3p_schema_breadcrumbs' );
