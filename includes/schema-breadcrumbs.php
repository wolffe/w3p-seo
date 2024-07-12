<?php
// Schema.org JSON for breadcrumbs

// @todo https://gist.github.com/inetbiz/a84101b9d979da51afcf22cebf0015f2
// @todo https://xoocode.com/json-ld-code-examples/person/

function w3p_schema_breadcrumbs() {
    $page_for_posts = get_option( 'page_for_posts' );
    $site_name      = get_bloginfo( 'blogname' );

    if ( (int) get_option( 'page_for_posts' ) > 0 ) {
        $blog_posts_page_slug = get_permalink( get_option( 'page_for_posts' ) );
    } else {
        $blog_posts_page_slug = trailingslashit( get_site_url( 'url' ) );
    }

    if ( ! is_search() ) { ?>
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement":
            [
            <?php if ( is_singular( 'post' ) ) { // if on a single blog post ?>
                {
                    "@type": "ListItem",
                    "position": 1,
                    "item":
                    {
                        "@id": "<?php echo $blog_posts_page_slug; ?>",
                        "name": "<?php echo $site_name; ?>"
                    }
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "item":
                    {
                        "@id": "<?php echo get_permalink(); ?>",
                        "name": "<?php echo get_the_title(); ?>"
                    }
                }
                <?php
            } elseif ( is_singular( 'product' ) ) { // if on a single product page
                global $post;

                $terms = wp_get_object_terms( $post->ID, 'product_cat' );
                if ( ! is_wp_error( $terms ) ) {
                    $product_category_slug = $terms[0]->slug;
                    $product_category_name = $terms[0]->name;
                }
                ?>
                {
                    "@type": "ListItem",
                    "position": 1,
                    "item":
                    {
                        "@id": "<?php echo get_bloginfo( 'url' ); ?>/products/<?php echo $product_category_slug; ?>/",
                        "name": "<?php echo $product_category_name; ?>"
                    }
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "item":
                    {
                        "@id": "<?php echo get_permalink(); ?>",
                        "name": "<?php echo get_the_title(); ?>"
                    }
                }
                <?php
            } elseif ( is_page() && ! is_front_page() ) { // if on a regular WP Page
                global $post;

                if ( is_page() && $post->post_parent ) { // if is a child page
                    $post_data         = get_post( $post->post_parent );
                    $parent_page_slug  = $post_data->post_name;
                    $parent_page_url   = get_bloginfo( 'url' ) . '/' . $parent_page_slug . '/';
                    $parent_page_title = ucfirst( $parent_page_slug );
                    $position_number   = '2';
                } else {
                    $page_url        = get_permalink();
                    $page_title      = '';
                    $position_number = '1';
                }

                if ( is_page() && $post->post_parent ) {
                    ?>
                    {
                        "@type": "ListItem",
                        "position": 1,
                        "item":
                        {
                            "@id": "<?php echo $parent_page_url; ?>",
                            "name": "<?php echo $parent_page_title; ?>"
                        }
                    },
                    <?php
                }
                ?>
                {
                    "@type": "ListItem",
                    "position": <?php echo $position_number; ?>,
                    "item":
                    {
                        "@id": "<?php echo get_permalink(); ?>",
                        "name": "<?php echo get_the_title(); ?>"
                    }
                }
                <?php
            } elseif ( is_home() ) { // if on the blog page
                ?>
                {
                    "@type": "ListItem",
                    "position": 1,
                    "item":
                    {
                        "@id": "<?php echo $blog_posts_page_slug; ?>",
                        "name": "<?php echo $site_name; ?>"
                    }
                }
                <?php
            } elseif ( is_category() || is_tag() ) {
                ?>
                {
                    "@type": "ListItem",
                    "position": 1,
                    "item":
                    {
                        "@id": "<?php echo $blog_posts_page_slug; ?>",
                        "name": "<?php echo $site_name; ?>"
                    }
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "item":
                    {
                        "@id": "<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>",
                        "name": "<?php echo ( is_category() ) ? single_cat_title( '', false ) : single_tag_title( '', false ); ?>"
                    }
                }
                <?php
            } elseif ( is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) { // product category and taxonomy pages
                global $post;

                $termname = get_query_var( 'term' );
                $termname = ucfirst( $termname );
                ?>
                {
                    "@type": "ListItem",
                    "position": 1,
                    "item":
                    {
                        "@id": "<?php echo get_bloginfo( 'url' ); ?>",
                        "name": "Store"
                    }
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "item":
                    {
                        "@id": "<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>",
                        "name": "<?php echo $termname; ?>"
                    }
                }
                <?php
            } elseif ( is_archive() ) { // date based archives and a catch all for the rest
                ?>
                {
                    "@type": "ListItem",
                    "position": 1,
                    "item":
                    {
                        "@id": "<?php echo $blog_posts_page_slug; ?>",
                        "name": "<?php echo $site_name; ?>"
                    }
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "item":
                    {
                        "@id": "<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>",
                        "name": "Archives"
                    }
                }
                <?php
            } else {
                ?>
                {
                    "@type": "ListItem",
                    "position": 1,
                    "item":
                        {
                        "@id": "<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>",
                        "name": "Page"
                    }
                }
                <?php
            }
            ?>
            ]
        }
        </script>
        <?php
    }
}

add_action( 'wp_footer', 'w3p_schema_breadcrumbs' );
