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
        function( $entry, $post ) {
            $entry['lastmod'] = $post->post_modified_gmt;
            return $entry;
        },
        10,
        2
    );

    add_filter(
        'wp_sitemaps_max_urls',
        function( $limit ) {
            return ( (int) get_option( 'w3p_sitemap_links' ) ) ? (int) get_option( 'w3p_sitemap_links' ) : 2000;
        },
        10,
        1
    );
}

function w3p_remove_post_type_from_wp_sitemap( $post_types ) {
    if ( $post_types ) {
        foreach ( $post_types as $type ) {
            if ( (int) get_option( 'w3p_enable_sitemap_' . strtolower( $type->name ) ) === 0 ) {
                unset( $post_types[ $type->name ] );
            }
        }
    }

    return $post_types;
}

function w3p_remove_tax_from_sitemap( $taxonomies ) {
    if ( $taxonomies ) {
        foreach ( $taxonomies as $taxonomy ) {
            if ( (int) get_option( 'w3p_enable_sitemap_' . $taxonomy->name ) === 0 ) {
                unset( $taxonomies[ $taxonomy->name ] );
            }
        }
    }

    return $taxonomies;
}

function w3p_remove_users_from_sitemap( $provider, $name ) {
    return ( $name === 'users' ) ? false : $provider;
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

    if ( (string) get_post_meta( $post->ID, '_w3p_title', true ) !== '' ) {
        $title = get_post_meta( $post->ID, '_w3p_title', true );
    }

    return $title;
}



function w3p_get_excerpt( $post_id ) {
    $excerpt = esc_attr( strip_tags( get_the_excerpt( $post_id ) ) );

    if ( (string) get_post_meta( $post_id, '_w3p_excerpt', true ) !== '' ) {
        $excerpt = get_post_meta( $post_id, '_w3p_excerpt', true );
    }

    return $excerpt;
}



if ( (int) get_option( 'w3p_enable_title_description' ) === 1 ) {
    add_filter( 'pre_get_document_title', 'w3p_document_title', 10 );
    //add_filter( 'wp_title', 'w3p_document_title', 10, 2 );
}



function w3p_wp_head() {
    if ( (int) get_option( 'w3p_enable_title_description' ) === 1 ) {
        if ( is_single() || is_page() ) {
            $excerpt = w3p_get_excerpt( get_the_ID() );
        } else {
            $excerpt = get_bloginfo( 'description' );
        }

        echo '<meta name="description" content="' . $excerpt . '">';
    }

    if ( (int) get_option( 'w3p_og' ) === 1 ) {
        add_action( 'wp_head', 'w3p_head_og' );
    }

    w3p_add_kg_schema();

    w3p_search_console_head();
}
add_action( 'wp_head', 'w3p_wp_head', 1 );



/**
 * Knowledge Graph & Schema.org
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

    if ( $w3p_kg_logo ) {
        $w3p_kg_logo_id       = attachment_url_to_postid( $w3p_kg_logo );
        $w3p_kg_logo_metadata = wp_get_attachment_metadata( $w3p_kg_logo_id );
        $w3p_kg_logo_width    = $w3p_kg_logo_metadata['width'];
        $w3p_kg_logo_height   = $w3p_kg_logo_metadata['height'];

        //$image_attributes = wp_get_attachment_image_src( $w3p_kg_logo_id );
        //if ( $image_attributes ) {
        //    $w3p_kg_logo_width  = $image_attributes[1];
        //    $w3p_kg_logo_height = $image_attributes[2];
        //}
    }

    $w3p_kg_same_as = '';

    if ( get_option( 'w3p_kg_same_as' ) !== '' ) {
        $w3p_kg_same_as = array_map( 'trim', explode( PHP_EOL, get_option( 'w3p_kg_same_as' ) ) );
        $w3p_kg_same_as = array_unique( array_filter( $w3p_kg_same_as ) );

        $w3p_kg_same_as = sprintf( '"%s"', implode( '","', $w3p_kg_same_as ) );
    }

    $out = '<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@graph": [';

            if ( $w3p_kg_type === 'organization' ) {
                $out .= '{
                    "@type": "Organization",
                    "@id": "' . $home_url . '#organization",
                    "name": "' . $w3p_kg_name . '",
                    "url": "' . $home_url . '",
                    "sameAs": [ ' . $w3p_kg_same_as . ' ],
                    "logo": {
                        "@type": "ImageObject",
                        "@id": "' . $home_url . '#logo",
                        "inLanguage": "' . $website_language . '",
                        "url": "' . $w3p_kg_logo . '",
                        "contentUrl": "' . $w3p_kg_logo . '",
                        "width": ' . $w3p_kg_logo_width . ',
                        "height": ' . $w3p_kg_logo_height . ',
                        "caption": "' . $w3p_kg_name . '"
                    },
                    "image": {
                        "@id": "' . $home_url . '#logo"
                    }
                },';
            } elseif ( $w3p_kg_type === 'person' ) {
                $out .= '{
                    "@type": [
                        "Person",
                        "Organization"
                    ],
                    "@id": "' . $home_url . '#/schema/person/befdcbacc39f99e9674d54b0979b20b6",
                    "name": "' . $w3p_kg_name . '",
                    "logo": {
                        "@id": "' . $home_url . '#personlogo"
                    }
                },';
            }

            // https://developers.google.com/search/docs/advanced/structured-data/sitelinks-searchbox#guidelines
            $out .= '{
                "@type": "WebSite",
                "@id": "' . $home_url . '#website",
                "url": "' . $home_url . '",
                "name": "' . $website_name . '",
                "description": "' . $website_description . '",
                "publisher": {
                    "@id": "' . $home_url . '#organization"
                },
                "inLanguage": "' . $website_language . '",
                "potentialAction": [{
                    "@type": "SearchAction",
                    "target": {
                        "@type": "EntryPoint",
                        "urlTemplate": "' . $home_url . '?q={search_term_string}"
                    },
                    "query-input": "required name=search_term_string"
                }]
            },';

            if ( has_post_thumbnail( $post->ID ) ) {
                $w3p_featured_image_metadata = get_post_thumbnail_id( $post->ID );
                $image_attributes            = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
                $width                       = '';
                $height                      = '';

                if ( $image_attributes ) {
                    $w3p_featured_image_width  = $image_attributes[1];
                    $w3p_featured_image_height = $image_attributes[2];

                    $width  = ',"width": ' . $w3p_featured_image_width;
                    $height = ',"height": ' . $w3p_featured_image_height;
                }

                $license = '';
                if ( get_option( 'w3p_image_license_url' ) !== '' ) {
                    $license = ',"license": "' . get_option( 'w3p_image_license_url' ) . '"';
                }
                $acquire_license_page = '';
                if ( get_option( 'w3p_image_acquire_license_url' ) !== '' ) {
                    $acquire_license_page = ',"acquireLicensePage": "' . get_option( 'w3p_image_acquire_license_url' ) . '"';
                }

                $out .= '{
                    "@type": "ImageObject",
                    "@id": "' . $home_url . '#primaryimage",
                    "inLanguage": "' . $website_language . '",
                    "url": "' . get_the_post_thumbnail_url( $post->ID ) . '",
                    "contentUrl": "' . get_the_post_thumbnail_url( $post->ID ) . '"
                    ' . $width . '
                    ' . $height . '
                    ' . $license . '
                    ' . $acquire_license_page . '
                },';
            }

            $out .= '{
                "@type": "WebPage",
                "@id": "' . get_permalink( $post->ID ) . '#webpage",
                "url": "' . get_permalink( $post->ID ) . '",
                "name": "' . get_the_title( $post->ID ) . '",
                "isPartOf": {
                    "@id": "' . $home_url . '#website"
                },
                "about": {
                    "@id": "' . $home_url . '#organization"
                },
                "primaryImageOfPage": {
                    "@type": "ImageObject",
                    "@id": "' . get_permalink( $post->ID ) . '#primaryimage"
                },
                "datePublished": "' . get_the_date( 'c', $post->ID ) . '",
                "dateModified": "' . get_the_modified_time( 'c', $post->ID ) . '",
                "description": "' . addcslashes( w3p_get_excerpt( $post->ID ), '"' ) . '",
                "inLanguage": "' . $website_language . '",
                "potentialAction": {
                    "@type": "ReadAction",
                    "target": {
                        "@type": "EntryPoint",
                        "urlTemplate": "' . get_permalink( $post->ID ) . '",
                        "actionPlatform": [
                            "http://schema.org/DesktopWebPlatform",
                            "http://schema.org/IOSPlatform",
                            "http://schema.org/AndroidPlatform"
                        ]
                    }
                }
            }
        ]
    }
    </script>';

    echo $out;
}



/** ALPHA */
function w3p_breadcrumbs_schema() {
    if ( is_home() || is_front_page() ) {
        return;
    }

    global $post;

    $out = '<div class="w3p-breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">';
        $out .= '<span itemprop="itemListElement" position="1" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( home_url( '/' ) ) . '" class="home-link" itemprop="item" rel="home"><span itemprop="name">' . __( 'Home', 'wp-perfect-plugin' ) . '</span></a></span>';

        if ( is_singular( 'post' ) ) {
            foreach ( wp_get_post_categories( $post->ID ) as $c ) {
                $cat  = get_category( $c );
                $out .= '<span itemprop="itemListElement" position="2" itemscope itemtype="http://schema.org/ListItem"><a href="' . get_category_link( $cat ) . '" itemprop="item"><span itemprop="name">' . esc_html( $cat->name ) . '</span></a></span>';
            }

            $out .= '<span class="current-page" itemprop="itemListElement" position="3" itemscope itemtype="http://schema.org/ListItem"><a href="' . get_permalink( $post->ID ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_title( $post->ID ) ) . '</span></a></span>';
        } elseif ( is_page() && ! $post->post_parent ) {
            $out .= '<span class="current-page" itemprop="itemListElement" position="2" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . esc_html( get_the_title( $post->ID ) ) . '</span></span>';
        } elseif ( is_page() && $post->post_parent ) {
            $parent_id   = $post->post_parent;
            $breadcrumbs = [];

            while ( $parent_id ) {
                $page = get_page( $parent_id );

                $breadcrumbs[] .= '<span itemprop="itemListElement" position="2" itemscope itemtype="http://schema.org/ListItem"><a href="' . get_permalink( $page->ID ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_title( $page->ID ) ) . '</span></a></span>';
                $parent_id      = $page->post_parent;
            }

            $breadcrumbs = array_reverse( $breadcrumbs );

            foreach ( $breadcrumbs as $crumb ) {
                $out .= $crumb;
            }

            $out .= '<span class="current-page" itemprop="itemListElement" position="3" itemscope itemtype="http://schema.org/ListItem"><a href="' . get_permalink( $post->ID ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_title( $post->ID ) ) . '</span></a></span>';
        }

        if ( get_query_var( 'paged' ) ) {
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
                echo ' (';
            }

            $out .= __( 'Page' ) . ' ' . get_query_var( 'paged' );

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




function w3p_redirect_to_category( $template ) {
    if ( ! is_404() ) {
        return $template;
    }

    global $wp_rewrite;
    global $wp_query;

    if ( '/%category%/%postname%/' !== $wp_rewrite->permalink_structure ) {
        return $template;
    }

    if ( ! $post = get_page_by_path( $wp_query->query['category_name'], OBJECT, 'post' ) ) {
        return $template;
    }

    $permalink = get_permalink( $post->ID );

    wp_redirect( $permalink, 301 );

    exit;
}



/**
 * Topic Clustering
 */
if ( (int) get_option( 'w3p_topic_clustering' ) === 1 ) {
    add_filter( '404_template', 'w3p_redirect_to_category' );
}

if ( (int) get_option( 'w3p_schema_breadcrumbs' ) === 1 ) {
    add_filter( 'the_content', 'w3p_breadcrumbs_filter' );
}



/**
 * Link Whisper
 */
function w3p_replace_words_with_links( $content ) {
    if ( is_main_query() && in_the_loop() && is_singular( [ 'post', 'page', 'property', 'faq' ] ) ) {
        $words = get_option( 'w3p_link_repeater' );

        if ( $words ) {
            foreach ( $words as $word_data ) {
                $word = $word_data['title'];
                $link = $word_data['url'];
                $rel  = isset( $word_data['rel'] ) ? $word_data['rel'] : '';

                // Create a regular expression pattern with word boundaries
                // $pattern = '/\b' . preg_quote( $word, '/' ) . '\b/';

                // Create a regular expression pattern with word boundaries, excluding words already inside <a> tags
                $pattern = '/\b(?!<a[^>]*?>)' . preg_quote( $word, '/' ) . '(?!<\/a>)\b/';

                $link_html = '<a href="' . esc_url( $link ) . '"';
                if ( ! empty( $rel ) ) {
                    $link_html .= ' rel="' . esc_attr( $rel ) . '"';
                }
                $link_html .= '>' . $word . '</a>';

                // Use preg_replace_callback to replace only full words
                $content = preg_replace_callback(
                    $pattern,
                    function ( $matches ) use ( $link_html ) {
                        return $link_html;
                    },
                    $content
                );
            }
        }
    }

    return $content;
}

if ( (int) get_option( 'w3p_enable_link_whisper' ) === 1 ) {
    add_filter( 'the_content', 'w3p_replace_words_with_links', 10 );
}

if ( (int) get_option( 'w3p_noindex_queries' ) === 1 ) {
    function w3p_noindex_all_queries() {
        if ( ! empty( $_SERVER['QUERY_STRING'] ) && ! is_admin() ) {
            header( 'X-Robots-Tag: noindex' );

            echo '<meta name="robots" content="noindex">';

            return;
        }
    }

    add_action( 'wp_head', 'w3p_noindex_all_queries' );
}
