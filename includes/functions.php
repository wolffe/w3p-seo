<?php
/**
 * Auto Add Image Attributes From Image Filename
 *
 */
function w3p_auto_image_attributes( $post_id ) {
    $attachment = get_post( $post_id );

    $attachment_title = ucwords( strtr( $attachment->post_title, '-_', '  ' ) );

    wp_update_post(
        [
            'ID'           => $post_id,
            'post_title'   => $attachment_title,
            'post_excerpt' => $attachment_title,
            'post_content' => $attachment_title,
        ]
    );

    update_post_meta( $post_id, '_wp_attachment_image_alt', $attachment_title ); // Image ALT text
}

if ( (int) get_option( 'w3p_image_alt' ) === 1 ) {
    add_action( 'add_attachment', 'w3p_auto_image_attributes' );
}



/**
 * Convert filename to lowercase
 *
 */
function w3p_convert_filename_to_lowercase( $file ) {
    $image_extensions = [
        'image/jpeg',
        'image/gif',
        'image/png',
        'image/bmp',
        'image/tiff',
        'image/webp',
        'ico',
    ];

    // Return if file is not an image file
    if ( ! in_array( $file['type'], $image_extensions ) ) {
        return $file;
    }

    $image_extension = pathinfo( $file['name'] );
    $image_name      = strtolower( $image_extension['filename'] );
    $file['name']    = $image_name . '.' . $image_extension['extension'];

    return $file;
}

add_filter( 'wp_handle_upload_prefilter', 'w3p_convert_filename_to_lowercase', 20 );



// Sitemaps
if ( (int) get_option( 'w3p_enable_sitemap' ) === 0 ) {
    add_filter( 'wp_sitemaps_enabled', '__return_false' );
} else {
    add_filter( 'wp_sitemaps_post_types', 'w3p_remove_post_type_from_wp_sitemap' );
    add_filter( 'wp_sitemaps_taxonomies', 'w3p_remove_tax_from_sitemap' );

    if ( (int) get_option( 'w3p_enable_sitemap_users' ) === 0 ) {
        add_filter( 'wp_sitemaps_add_provider', 'w3p_remove_users_from_sitemap', 10, 2 );
    }

    add_filter(
        'wp_sitemaps_posts_entry',
        function ( $entry, $post ) {
            if ( ! empty( $post->post_modified_gmt ) ) {
                $entry['lastmod'] = mysql2date( 'Y-m-d\TH:i:s+00:00', $post->post_modified_gmt, false );
            }
            return $entry;
        },
        10,
        2
    );

    add_filter(
        'wp_sitemaps_max_urls',
        function ( $limit ) {
            $sitemap_links = (int) get_option( 'w3p_sitemap_links' );
            return $sitemap_links ? $sitemap_links : 2000;
        },
        10,
        1
    );

    // Exclude posts/pages with noindex meta from sitemap
    add_filter( 'wp_sitemaps_posts_query_args', 'w3p_exclude_noindex_from_sitemap', 10, 2 );
}

function w3p_remove_post_type_from_wp_sitemap( $post_types ) {
    if ( empty( $post_types ) ) {
        return $post_types;
    }

    static $cached_options = [];

    $filtered_post_types = [];
    foreach ( $post_types as $type ) {
        $option_name = 'w3p_enable_sitemap_' . strtolower( $type->name );
        if ( ! isset( $cached_options[ $option_name ] ) ) {
            $cached_options[ $option_name ] = (int) get_option( $option_name, 1 );
        }
        if ( $cached_options[ $option_name ] !== 0 ) {
            $filtered_post_types[ $type->name ] = $type;
        }
    }

    return $filtered_post_types;
}

function w3p_remove_tax_from_sitemap( $taxonomies ) {
    if ( empty( $taxonomies ) ) {
        return $taxonomies;
    }

    static $cached_options = [];

    $filtered_taxonomies = [];
    foreach ( $taxonomies as $taxonomy ) {
        $option_name = 'w3p_enable_sitemap_' . $taxonomy->name;
        if ( ! isset( $cached_options[ $option_name ] ) ) {
            $cached_options[ $option_name ] = (int) get_option( $option_name, 1 );
        }
        if ( $cached_options[ $option_name ] !== 0 ) {
            $filtered_taxonomies[ $taxonomy->name ] = $taxonomy;
        }
    }

    return $filtered_taxonomies;
}

function w3p_remove_users_from_sitemap( $provider, $name ) {
    return ( $name === 'users' ) ? false : $provider;
}

function w3p_exclude_noindex_from_sitemap( $args, $post_type ) {
    if ( ! isset( $args['meta_query'] ) ) {
        $args['meta_query'] = [];
    }

    $args['meta_query'][] = [
        'relation' => 'OR',
        [
            'key'     => '_w3p_noindex',
            'compare' => 'NOT EXISTS',
        ],
        [
            'key'     => '_w3p_noindex',
            'value'   => '1',
            'compare' => '!=',
        ],
    ];

    if ( $post_type === 'page' ) {
        $exclude_ids = [];

        static $has_edd  = null;
        static $has_wc   = null;
        static $has_mepr = null;

        if ( $has_edd === null ) {
            $has_edd = function_exists( 'edd_get_option' );
        }
        if ( $has_wc === null ) {
            $has_wc = function_exists( 'wc_get_page_id' );
        }
        if ( $has_mepr === null ) {
            $has_mepr = function_exists( 'mepr_get_option' );
        }

        // Easy Digital Downloads
        if ( $has_edd ) {
            $edd_noindex_pages = [
                edd_get_option( 'purchase_page', 0 ),
                edd_get_option( 'success_page', 0 ),
                edd_get_option( 'failure_page', 0 ),
                edd_get_option( 'purchase_history_page', 0 ),
            ];

            foreach ( $edd_noindex_pages as $page_id ) {
                if ( $page_id ) {
                    $exclude_ids[] = $page_id;
                }
            }
        }

        // WooCommerce
        if ( $has_wc ) {
            $wc_noindex_pages = [
                wc_get_page_id( 'checkout' ),
                wc_get_page_id( 'cart' ),
                wc_get_page_id( 'myaccount' ),
            ];

            foreach ( $wc_noindex_pages as $page_id ) {
                if ( $page_id ) {
                    $exclude_ids[] = $page_id;
                }
            }
        }

        // MemberPress
        if ( $has_mepr ) {
            $mepr_noindex_pages = [
                mepr_get_option( 'account_page_id' ),
                mepr_get_option( 'login_page_id' ),
                mepr_get_option( 'thankyou_page_id' ),
            ];

            foreach ( $mepr_noindex_pages as $page_id ) {
                if ( $page_id ) {
                    $exclude_ids[] = $page_id;
                }
            }
        }

        if ( ! empty( $exclude_ids ) ) {
            $args['post__not_in'] = isset( $args['post__not_in'] ) ? array_merge( $args['post__not_in'], $exclude_ids ) : $exclude_ids;
        }
    }

    return $args;
}



function w3p_theme_slug_setup() {
    add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'w3p_theme_slug_setup' );

function w3p_document_title( $title ) {
    global $post;

    if ( ! $post ) {
        return $title;
    }

    $custom_title = get_post_meta( $post->ID, '_w3p_title', true );
    if ( (string) $custom_title !== '' ) {
        $title = $custom_title;
    }

    return $title;
}



function w3p_get_excerpt( $post_id ) {
    $custom_excerpt = get_post_meta( $post_id, '_w3p_excerpt', true );
    if ( (string) $custom_excerpt !== '' ) {
        return esc_attr( $custom_excerpt );
    }

    $post = get_post( $post_id );
    if ( ! $post ) {
        return '';
    }

    if ( ! empty( $post->post_excerpt ) ) {
        return esc_attr( wp_strip_all_tags( $post->post_excerpt ) );
    }

    $content = strip_shortcodes( $post->post_content );
    $content = sanitize_text_field( $content );
    $content = str_replace( [ '&nbsp;', "\xC2\xA0" ], ' ', $content );

    if ( mb_strlen( $content ) > 155 ) {
        $excerpt = mb_substr( $content, 0, 155 ) . '...';
    } else {
        $excerpt = $content;
    }

    return esc_attr( $excerpt );
}



if ( (int) get_option( 'w3p_enable_title_description' ) === 1 ) {
    add_filter( 'pre_get_document_title', 'w3p_document_title', 10 );
}



function w3p_wp_head() {
    remove_action( 'wp_head', 'rel_canonical' );

    w3p_add_canonical_link();

    if ( (int) get_option( 'w3p_enable_title_description' ) === 1 ) {
        if ( is_single() || is_page() ) {
            $excerpt = w3p_get_excerpt( get_the_ID() );
        } elseif ( is_category() || is_tag() || is_tax() ) {
            $desc    = term_description();
            $excerpt = $desc ? wp_strip_all_tags( $desc ) : get_bloginfo( 'description' );
        } else {
            $excerpt = get_bloginfo( 'description' );
        }

        echo '<meta name="description" content="' . esc_html( $excerpt ) . '">';
    }

    if ( (int) get_option( 'w3p_og' ) === 1 ) {
        w3p_head_og();
    }

    w3p_add_kg_schema();

    w3p_search_console_head();
}
add_action( 'wp_head', 'w3p_wp_head', 1 );



/**
 * Add canonical link to head section
 *
 * @return void
 */
function w3p_add_canonical_link() {
    $canonical_url = '';

    if ( is_front_page() ) {
        $canonical_url = home_url( '/' );
    } elseif ( is_singular() ) {
        $canonical_url = get_permalink();
    } elseif ( is_category() || is_tag() || is_tax() ) {
        $term = get_queried_object();
        if ( $term && ! is_wp_error( $term ) ) {
            if ( is_category() ) {
                $request_uri   = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '';
                $current_url   = home_url( $request_uri );
                $canonical_url = strtok( $current_url, '?' );
            } else {
                $canonical_url = get_term_link( $term );
            }

            if ( is_wp_error( $canonical_url ) ) {
                $request_uri   = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '';
                $current_url   = home_url( $request_uri );
                $canonical_url = strtok( $current_url, '?' );
            }
        }
    } elseif ( is_author() ) {
        $author_id = get_queried_object_id();
        if ( $author_id ) {
            $canonical_url = get_author_posts_url( $author_id );
        }
    } elseif ( is_date() ) {
        $year = get_query_var( 'year' );
        if ( is_year() ) {
            $canonical_url = get_year_link( $year );
        } elseif ( is_month() ) {
            $monthnum      = get_query_var( 'monthnum' );
            $canonical_url = get_month_link( $year, $monthnum );
        } elseif ( is_day() ) {
            $monthnum      = get_query_var( 'monthnum' );
            $day           = get_query_var( 'day' );
            $canonical_url = get_day_link( $year, $monthnum, $day );
        }
    } elseif ( is_home() && ! is_front_page() ) {
        $page_for_posts = get_option( 'page_for_posts' );
        if ( $page_for_posts ) {
            $canonical_url = get_permalink( $page_for_posts );
        }
    } elseif ( is_search() ) {
        $canonical_url = get_search_link();
    }

    if ( ! empty( $canonical_url ) && ! is_wp_error( $canonical_url ) ) {
        echo '<link rel="canonical" href="' . esc_url( $canonical_url ) . '">' . "\n";
    }
}



/**
 * Knowledge Panel & Schema.org
 *
 * @todo https://issemantic.net/schema-markup-validator
 * @todo https://validator.schema.org/
 */
function w3p_add_kg_schema() {
    global $post;

    if ( ! $post ) {
        return;
    }

    add_filter( 'excerpt_more', '__return_empty_string' );

    $w3p_kg_type = get_option( 'w3p_kg_type' );
    $w3p_kg_name = get_option( 'w3p_kg_name' );
    $w3p_kg_logo = get_option( 'w3p_kg_logo' );

    if ( ! $w3p_kg_type || ! $w3p_kg_name || ! $w3p_kg_logo ) {
        return;
    }

    $home_url            = trailingslashit( get_home_url() );
    $website_name        = get_bloginfo( 'name' );
    $website_language    = get_bloginfo( 'language' );
    $website_description = get_bloginfo( 'description' );

    $w3p_kg_logo_width  = 0;
    $w3p_kg_logo_height = 0;
    if ( $w3p_kg_logo ) {
        $transient_key     = 'w3p_kg_logo_dimensions_' . md5( $w3p_kg_logo );
        $cached_dimensions = get_transient( $transient_key );

        if ( false !== $cached_dimensions ) {
            $w3p_kg_logo_width  = (int) $cached_dimensions['width'];
            $w3p_kg_logo_height = (int) $cached_dimensions['height'];
        } else {
            $attachment_id_transient_key = 'w3p_kg_logo_attachment_id_' . md5( $w3p_kg_logo );
            $attachment_id               = get_transient( $attachment_id_transient_key );

            if ( false === $attachment_id ) {
                $attachment_id = attachment_url_to_postid( $w3p_kg_logo );
                set_transient( $attachment_id_transient_key, $attachment_id, WEEK_IN_SECONDS );
            }

            if ( $attachment_id ) {
                $metadata = wp_get_attachment_metadata( $attachment_id );
                if ( $metadata && isset( $metadata['width'] ) && isset( $metadata['height'] ) ) {
                    $w3p_kg_logo_width  = (int) $metadata['width'];
                    $w3p_kg_logo_height = (int) $metadata['height'];
                }
            }

            set_transient(
                $transient_key,
                [
                    'width'  => $w3p_kg_logo_width,
                    'height' => $w3p_kg_logo_height,
                ],
                WEEK_IN_SECONDS
            );
        }
    }

    // Get sameAs URLs
    $w3p_kg_same_as = [];
    if ( get_option( 'w3p_kg_same_as' ) !== '' ) {
        $w3p_kg_same_as = array_map( 'trim', explode( PHP_EOL, get_option( 'w3p_kg_same_as' ) ) );
        $w3p_kg_same_as = array_unique( array_filter( $w3p_kg_same_as ) );
    }

    $schema = [
        '@context' => 'https://schema.org',
        '@graph'   => [],
    ];

    // Organization Schema
    if ( $w3p_kg_type === 'organization' ) {
        $organization       = [
            '@type'  => 'Organization',
            '@id'    => $home_url . '#organization',
            'name'   => $w3p_kg_name,
            'url'    => $home_url,
            'sameAs' => $w3p_kg_same_as,
            'logo'   => [
                '@type'      => 'ImageObject',
                '@id'        => $home_url . '#logo',
                'inLanguage' => $website_language,
                'url'        => $w3p_kg_logo,
                'contentUrl' => $w3p_kg_logo,
                'width'      => $w3p_kg_logo_width,
                'height'     => $w3p_kg_logo_height,
                'caption'    => $w3p_kg_name,
            ],
            'image'  => [
                '@id' => $home_url . '#logo',
            ],
        ];
        $schema['@graph'][] = $organization;
    }

    // Person Schema
    if ( $w3p_kg_type === 'person' ) {
        $person             = [
            '@type' => [ 'Person', 'Organization' ],
            '@id'   => $home_url . '#/schema/person/befdcbacc39f99e9674d54b0979b20b6',
            'name'  => $w3p_kg_name,
            'logo'  => [
                '@id' => $home_url . '#personlogo',
            ],
        ];
        $schema['@graph'][] = $person;
    }

    // Website Schema
    $website            = [
        '@type'           => 'WebSite',
        '@id'             => $home_url . '#website',
        'url'             => $home_url,
        'name'            => $website_name,
        'description'     => $website_description,
        'publisher'       => [
            '@id' => $home_url . '#organization',
        ],
        'inLanguage'      => $website_language,
        'potentialAction' => [
            [
                '@type'       => 'SearchAction',
                'target'      => [
                    '@type'       => 'EntryPoint',
                    'urlTemplate' => $home_url . '?q={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ],
    ];
    $schema['@graph'][] = $website;

    // Image Schema if a featured image exists
    if ( has_post_thumbnail( $post->ID ) ) {
        $image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
        if ( $image_attributes ) {
            $image_schema       = [
                '@type'      => 'ImageObject',
                '@id'        => $home_url . '#primaryimage',
                'inLanguage' => $website_language,
                'url'        => get_the_post_thumbnail_url( $post->ID ),
                'contentUrl' => get_the_post_thumbnail_url( $post->ID ),
                'width'      => $image_attributes[1],
                'height'     => $image_attributes[2],
            ];
            $schema['@graph'][] = $image_schema;
        }
    }

    // WebPage Schema for taxonomy archives
    if ( is_category() || is_tag() || is_tax() ) {
        $term = get_queried_object();
        if ( $term && ! is_wp_error( $term ) ) {
            $term_name          = $term->name;
            $term_url           = get_term_link( $term );
            $term_desc          = $term->description ? wp_strip_all_tags( $term->description ) : $website_description;
            $taxonomy_webpage   = [
                '@type'       => 'WebPage',
                '@id'         => $term_url . '#webpage',
                'url'         => $term_url,
                'name'        => $term_name,
                'isPartOf'    => [ '@id' => $home_url . '#website' ],
                'about'       => [ '@id' => $home_url . '#organization' ],
                'description' => addcslashes( $term_desc, '"' ),
                'inLanguage'  => $website_language,
            ];
            $schema['@graph'][] = $taxonomy_webpage;
        }
    } else {
        $webpage            = [
            '@type'              => 'WebPage',
            '@id'                => get_permalink( $post->ID ) . '#webpage',
            'url'                => get_permalink( $post->ID ),
            'name'               => get_the_title( $post->ID ),
            'isPartOf'           => [ '@id' => $home_url . '#website' ],
            'about'              => [ '@id' => $home_url . '#organization' ],
            'primaryImageOfPage' => [
                '@type' => 'ImageObject',
                '@id'   => get_permalink( $post->ID ) . '#primaryimage',
            ],
            'datePublished'      => get_the_date( 'c', $post->ID ),
            'dateModified'       => get_the_modified_time( 'c', $post->ID ),
            'description'        => addcslashes( w3p_get_excerpt( $post->ID ), '"' ),
            'inLanguage'         => $website_language,
            'potentialAction'    => [
                '@type'  => 'ReadAction',
                'target' => [
                    '@type'          => 'EntryPoint',
                    'urlTemplate'    => get_permalink( $post->ID ),
                    'actionPlatform' => [
                        'https://schema.org/DesktopWebPlatform',
                        'https://schema.org/IOSPlatform',
                        'https://schema.org/AndroidPlatform',
                    ],
                ],
            ],
        ];
        $schema['@graph'][] = $webpage;
    }

    // Output JSON-LD script
    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}




/** ALPHA */
function w3p_breadcrumbs_schema() {
    if ( is_home() || is_front_page() ) {
        return;
    }

    global $post;

    $out = '<div class="w3p-breadcrumbs" itemscope itemtype="https://schema.org/BreadcrumbList">
        <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a href="' . esc_url( home_url( '/' ) ) . '" class="home-link" itemprop="item" rel="home"><span itemprop="name">' . __( 'Home', 'w3p-seo' ) . '</span></a>
            <meta itemprop="position" content="1">
        </span>';

    if ( is_singular( 'post' ) ) {
        foreach ( wp_get_post_categories( $post->ID ) as $c ) {
            $cat  = get_category( $c );
            $out .= '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a href="' . get_category_link( $cat ) . '" itemprop="item"><span itemprop="name">' . esc_html( $cat->name ) . '</span></a>
                <meta itemprop="position" content="2">
            </span>';
        }

        $out .= '<span class="current-page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a href="' . get_permalink( $post->ID ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_title( $post->ID ) ) . '</span></a>
            <meta itemprop="position" content="3">
        </span>';
    } elseif ( is_page() && ! $post->post_parent ) {
        $out .= '<span class="current-page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <span itemprop="name">' . esc_html( get_the_title( $post->ID ) ) . '</span>
            <meta itemprop="position" content="2">
        </span>';
    } elseif ( is_page() && $post->post_parent ) {
        $parent_id   = $post->post_parent;
        $breadcrumbs = [];

        while ( $parent_id ) {
            $page = get_page( $parent_id );

            $breadcrumbs[] .= '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a href="' . get_permalink( $page->ID ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_title( $page->ID ) ) . '</span></a>
                <meta itemprop="position" content="2">
            </span>';
            $parent_id      = $page->post_parent;
        }

        $breadcrumbs = array_reverse( $breadcrumbs );

        foreach ( $breadcrumbs as $crumb ) {
            $out .= $crumb;
        }

        $out .= '<span class="current-page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a href="' . get_permalink( $post->ID ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_title( $post->ID ) ) . '</span></a>
            <meta itemprop="position" content="3">
        </span>';
    }

    if ( get_query_var( 'paged' ) ) {
        if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
            echo ' (';
        }

        $out .= __( 'Page', 'w3p-seo' ) . ' ' . get_query_var( 'paged' );

        if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
            echo ')';
        }
    }

    $out .= '</div>
    <style>.w3p-breadcrumbs{margin:16px 0;font-size:13px}.w3p-breadcrumbs>span:not(:last-child)::after{content:"›";padding:0 6px}.w3p-breadcrumbs .current-page{font-weight:500}</style>';

    return $out;
}



function w3p_cats() {
    $out = '';

    foreach ( wp_get_post_categories( get_the_ID() ) as $c ) {
        $cat  = get_category( $c );
        $out .= '<li><a href="' . get_category_link( $cat ) . '" title="' . $cat->name . '" class="category">' . $cat->name . '</a></li>';
    }

    return $out;
}




function w3p_breadcrumbs_filter( $content ) {
    $custom_content  = w3p_breadcrumbs_schema();
    $custom_content .= $content;

    return $custom_content;
}



if ( (int) get_option( 'w3p_schema_breadcrumbs' ) === 1 ) {
    add_filter( 'the_content', 'w3p_breadcrumbs_filter' );
}

/**
 * Robots meta handling using WordPress 5.7+ native filter.
 *
 * This sets:
 * - noindex (for query-string pages when enabled, or per-post/post-type rules)
 * - nofollow (for per-post/post-type noindex case)
 * - Default preview/snippet directives when no other conditions are met
 */
function w3p_filter_wp_robots( $robots ) {
    if ( is_admin() ) {
        return $robots;
    }

    if ( (int) get_option( 'w3p_noindex_queries' ) === 1 && ! empty( $_SERVER['QUERY_STRING'] ) ) {
        $robots['noindex'] = true;

        return $robots;
    }

    if ( is_singular() ) {
        global $post;

        if ( ! isset( $post->ID ) ) {
            return $robots;
        }

        $post_type = $post->post_type;
        if ( empty( $post_type ) ) {
            $post_type = get_post_type( $post->ID );
        }

        if ( $post_type && (
            (int) get_post_meta( $post->ID, '_w3p_noindex', true ) === 1 ||
            ( (int) get_option( 'w3p_enable_sitemap' ) === 1 && (int) get_option( 'w3p_enable_sitemap_' . strtolower( $post_type ) ) === 0 )
        ) ) {
            $robots['noindex']  = true;
            $robots['nofollow'] = true;

            return $robots;
        }
    }

    // WooCommerce noindex
    if ( function_exists( 'WC' ) && ! empty( $_GET ) ) {
        $blocked_params = [
            'add-to-cart',
            'variation_id',
            'attribute_',
            'wc-ajax',
        ];

        $get_keys = array_keys( $_GET );

        foreach ( $blocked_params as $param ) {
            foreach ( $get_keys as $key ) {
                if ( stripos( $key, $param ) !== false ) {
                    $robots['noindex'] = true;

                    return $robots;
                }
            }
        }
    }

    if ( ! array_key_exists( 'max-image-preview', $robots ) ) {
        $robots['max-image-preview'] = 'large';
    }
    if ( ! array_key_exists( 'max-snippet', $robots ) ) {
        $robots['max-snippet'] = '-1';
    }
    if ( ! array_key_exists( 'max-video-preview', $robots ) ) {
        $robots['max-video-preview'] = '-1';
    }

    return $robots;
}
add_filter( 'wp_robots', 'w3p_filter_wp_robots', 99 );
