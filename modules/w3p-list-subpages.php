<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function w3p_subpages( $atts ) {
    global $post;

    $attributes = shortcode_atts(
        [
            'orderby' => 'menu_order',
        ],
        $atts
    );

    $args = [
        'post_type'      => 'page',
        'posts_per_page' => -1,
        'post_parent'    => $post->ID,
        'post_status'    => 'publish',
        'orderby'        => $attributes['orderby'],
    ];

    if ( sanitize_text_field( $attributes['orderby'] ) === 'menu_order' ) {
        $args['order'] = 'ASC';
    } elseif ( sanitize_text_field( $attributes['orderby'] ) === 'modified' ) {
        $args['order'] = 'DESC';
    }

    $parent = new WP_Query( $args );
    $out    = '';

    if ( $parent->have_posts() ) {
        while ( $parent->have_posts() ) {
            $parent->the_post();

            $out .= '<div id="post-' . $post->ID . '" class="post-' . $post->ID . ' post type-page status-publish format-standard hentry">
                <h2><a href="' . get_permalink( $post->ID ) . '" rel="bookmark" title="' . get_the_title( $post->ID ) . '">' . get_the_title( $post->ID ) . '</a></h2>

                <p class="has-small-font-size" style="line-height:1">
                    ' . get_the_modified_date( get_option( 'date_format' ) ) . '
                </p>

                <div class="entry">
                    <p>' . w3p_get_excerpt( $post->ID ) . '
                </div>
            </div>';
        }
    }

    wp_reset_postdata();

    return $out;
}

add_shortcode( 'subpages', 'w3p_subpages' );
