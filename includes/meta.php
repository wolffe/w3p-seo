<?php
/**
 * Add meta box
 *
 * @param post $post The post object
 */
function w3p_add_meta_boxes( $post ) {
    add_meta_box( 'w3p_meta_box', __( 'W3P SEO Settings', 'w3p-seo' ), 'w3p_build_meta_box', [ 'post', 'page', 'faq' ], 'normal', 'high' );
}

if ( (int) get_option( 'w3p_enable_title_description' ) === 1 ) {
    add_action( 'add_meta_boxes', 'w3p_add_meta_boxes' );
}



/**
 * Build custom field meta box
 *
 * @param post $post The post object
 */
function w3p_build_meta_box( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'w3p_meta_box_nonce' );

    $w3p_title   = get_post_meta( $post->ID, '_w3p_title', true );
    $w3p_excerpt = get_post_meta( $post->ID, '_w3p_excerpt', true );

    $enable_yoast_migrator    = (int) get_option( 'w3p_enable_yoast_migrator' );
    $enable_rankmath_migrator = (int) get_option( 'w3p_enable_rankmath_migrator' );
    ?>
    <p>
        <label for="w3p-title">SEO Title</label>
        <input type="text" name="w3p_title" id="w3p-title" class="regular-text" style="width: 100%;" value="<?php echo esc_html( $w3p_title ); ?>">
    </p>

    <?php if ( $enable_yoast_migrator === 1 ) { ?>
        <p><b>Yoast Migrator:</b> <?php echo esc_html( get_post_meta( $post->ID, '_yoast_wpseo_title', true ) ); ?></p>
    <?php } ?>
    <?php if ( $enable_rankmath_migrator === 1 ) { ?>
        <p><b>Rank Math Migrator:</b> <?php echo esc_html( get_post_meta( $post->ID, 'rank_math_title', true ) ); ?></p>
    <?php } ?>

    <div class="meter-container">
        <span class="meter-counter" id="w3p-title-counter"><span class="meter-current">0</span>/60</span>
    </div>

    <p>
        <label for="w3p-excerpt">SEO Meta Description</label>
        <textarea type="text" name="w3p_excerpt" id="w3p-excerpt" class="regular-text large" style="width: 100%;" rows="4"><?php echo esc_html( $w3p_excerpt ); ?></textarea>
        <br><small>This description is used for SEO meta description(s), Open Graph tags and post excerpt.</small>
    </p>

    <?php if ( $enable_yoast_migrator === 1 ) { ?>
        <p><b>Yoast Migrator:</b> <?php echo esc_html( get_post_meta( $post->ID, '_yoast_wpseo_metadesc', true ) ); ?></p>
    <?php } ?>
    <?php if ( $enable_rankmath_migrator === 1 ) { ?>
        <p><b>Rank Math Migrator:</b> <?php echo esc_html( get_post_meta( $post->ID, 'rank_math_description', true ) ); ?></p>
    <?php } ?>

    <div class="meter-container">
        <span class="meter-counter" id="w3p-excerpt-counter"><span class="meter-current">0</span>/160</span>
    </div>
    
    <p>
        <input name="w3p_noindex" id="w3p-noindex" type="checkbox" value="1" <?php checked( 1, (int) get_post_meta( $post->ID, '_w3p_noindex', true ) ); ?>>
        <label for="w3p-noindex">Hide from search engines (noindex, nofollow)</label>
        <br><small>Check this box to prevent search engines from indexing this page and following links on it.</small>
    </p>
    <script>
    (function() {
        const title = document.getElementById('w3p-title');
        const excerpt = document.getElementById('w3p-excerpt');
        const titleCounter = document.querySelector('#w3p-title-counter .meter-current');
        const excerptCounter = document.querySelector('#w3p-excerpt-counter .meter-current');

        titleCounter.textContent = title.value.length;
        title.addEventListener('input', () => {
            titleCounter.textContent = title.value.length;
        });

        excerptCounter.textContent = excerpt.value.length;
        excerpt.addEventListener('input', () => {
            excerptCounter.textContent = excerpt.value.length;
        });
    })();
    </script>
    <?php
}



/**
 * Store custom field meta box data
 *
 * @param int $post_id The post ID.
 */
function w3p_save_meta_box_data( $post_id ) {
    if ( ! isset( $_POST['w3p_meta_box_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['w3p_meta_box_nonce'] ) ), basename( __FILE__ ) ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $w3p_title   = isset( $_POST['w3p_title'] ) ? sanitize_text_field( wp_unslash( $_POST['w3p_title'] ) ) : esc_html( get_the_title( $post_id ) );
    $w3p_excerpt = isset( $_POST['w3p_excerpt'] ) ? sanitize_textarea_field( wp_unslash( $_POST['w3p_excerpt'] ) ) : esc_textarea( w3p_get_excerpt( $post_id ) );
    $w3p_noindex = isset( $_POST['w3p_noindex'] ) ? 1 : 0;

    update_post_meta( $post_id, '_w3p_title', $w3p_title );
    update_post_meta( $post_id, '_w3p_excerpt', $w3p_excerpt );
    update_post_meta( $post_id, '_w3p_noindex', $w3p_noindex );
}

add_action( 'save_post', 'w3p_save_meta_box_data' );
