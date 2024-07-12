<?php
/**
 * Add meta box
 *
 * @param post $post The post object
 */
function w3p_add_meta_boxes( $post ) {
    add_meta_box( 'w3p_meta_box', __( 'W3P SEO Settings', 'wp-perfect-plugin' ), 'w3p_build_meta_box', [ 'post', 'page', 'faq' ], 'normal', 'high' );
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
    ?>
    <p>
        <label for="w3p-title">SEO Title</label>
        <input type="text" name="w3p_title" id="w3p-title" class="regular-text" style="width: 100%;" value="<?php echo $w3p_title; ?>">
    </p>

    <?php if ( (int) get_option( 'w3p_enable_yoast_migrator' ) === 1 ) { ?>
        <p><b>Yoast Migrator:</b> <?php echo get_post_meta( $post->ID, '_yoast_wpseo_title', true ); ?></p>
    <?php } ?>

    <div class="meter-container">
        <meter id="w3p-meter--title" min="0" max="60" value="0" low="20" high="40" optimum="50"></meter>
    </div>

    <p>
        <label for="w3p-excerpt">SEO Meta Description</label>
        <textarea type="text" name="w3p_excerpt" id="w3p-excerpt" class="regular-text large" style="width: 100%;" rows="4"><?php echo $w3p_excerpt; ?></textarea>
        <br><small>This description is used for SEO meta description(s), Open Graph tags and post excerpt.</small>
    </p>

    <?php if ( (int) get_option( 'w3p_enable_yoast_migrator' ) === 1 ) { ?>
        <p><b>Yoast Migrator:</b> <?php echo get_post_meta( $post->ID, '_yoast_wpseo_metadesc', true ); ?></p>
    <?php } ?>

    <div class="meter-container">
        <meter id="w3p-meter--excerpt" min="0" max="160" value="0" low="120" high="140" optimum="150"></meter>
    </div>
    <?php
}



/**
 * Store custom field meta box data
 *
 * @param int $post_id The post ID.
 */
function w3p_save_meta_box_data( $post_id ) {
    if ( ! isset( $_POST['w3p_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['w3p_meta_box_nonce'], basename( __FILE__ ) ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $w3p_title   = isset( $_POST['w3p_title'] ) ? sanitize_text_field( $_POST['w3p_title'] ) : get_the_title( $post_id );
    $w3p_excerpt = isset( $_POST['w3p_excerpt'] ) ? sanitize_textarea_field( $_POST['w3p_excerpt'] ) : w3p_get_excerpt( $post_id );

    update_post_meta( $post_id, '_w3p_title', $w3p_title );
    update_post_meta( $post_id, '_w3p_excerpt', $w3p_excerpt );
}

add_action( 'save_post', 'w3p_save_meta_box_data' );
