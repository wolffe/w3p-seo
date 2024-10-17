<h2>Link Whisper</h2>

<?php
wp_enqueue_script( 'w3p-html5sortable' );

if ( isset( $_POST['save_links_settings'] ) ) {
    if ( ! isset( $_POST['w3p_settings_nonce'] ) || ! check_admin_referer( 'save_w3p_settings_action', 'w3p_settings_nonce' ) ) {
        wp_die( esc_html__( 'Nonce verification failed. Please try again.', 'wp-perfect-plugin' ) );
    }

    $value = [];

    foreach ( $_POST['w3p_link_repeater'] as $repeater ) {
        $value[] = [
            'title' => sanitize_text_field( $repeater['title'] ),
            'url'   => esc_url_raw( $repeater['url'] ),
            'rel'   => sanitize_text_field( $repeater['rel'] ),
        ];
    }

    update_option( 'w3p_link_repeater', $value );
}
?>

<form method="post" action="">
    <?php wp_nonce_field( 'save_w3p_settings_action', 'w3p_settings_nonce' ); ?>

    <div class="w3p-grid-container" style="grid-template-columns: repeat(1, 1fr);">
        <h3>Links/Phrases</h3>

        <p>Add as many links/phrases and URLs as you require. The order is optional.</p>
        <p>Rules:</p>
        <ol>
            <li>Links/phrases must be unique.</li>
            <li>URLs must be valid.</li>
            <li>Relationship attributes should look like "nofollow", "external follow", "external noopener", "nofollow noindex", or "sponsored".</li>
        </ol>

        <div class="w3p-repeater-container">
            <div class="w3p-repeater-fields">
                <?php
                // Repeater
                $saved_repeater = get_option( 'w3p_link_repeater', true );
                $value_repeater = is_array( $saved_repeater ) ? $saved_repeater : [];

                foreach ( $value_repeater as $i => $repeater ) {
                    ?>
                    <div class="w3p-repeater-field" data-index="<?php echo intval( $i ); ?>" draggable="true">
                        <span class="dashicons dashicons-move"></span>
                        <input type="text" class="regular-text" name="w3p_link_repeater[<?php echo intval( $i ); ?>][title]" placeholder="Title" value="<?php echo esc_attr( $repeater['title'] ); ?>">
                        <input type="url" class="regular-text" name="w3p_link_repeater[<?php echo intval( $i ); ?>][url]" placeholder="URL" value="<?php echo esc_url( $repeater['url'] ); ?>">
                        <input type="text" class="regular-text" name="w3p_link_repeater[<?php echo intval( $i ); ?>][rel]" placeholder="Relationship" value="<?php echo esc_attr( $repeater['rel'] ); ?>">
                        <button type="button" class="button button-secondary w3p-remove-repeater-field">Remove</button>
                    </div>
                <?php } ?>
            </div>

            <p>
                <button type="button" class="button w3p-add-repeater-field">Add Link</button>
            </p>
        </div>
    </div>

    <hr>

    <p>
        <input type="submit" name="save_links_settings" class="button button-primary" value="<?php esc_html_e( 'Save Changes', 'wp-perfect-plugin' ); ?>">
    </p>
</form>

<style>
.w3p-grid-container {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    grid-gap: 2em;

    background-color: #f8f9fa;
    margin: 0 0 2em 0;
    padding: 2em;
    border-radius: 2em;
}
@media screen and (max-width: 768px) {
    .w3p-grid-container {
        grid-template-columns: repeat(1, 1fr);
    }
}

.w3p-grid-container--item {
    background-color: #ffffff;
    padding: 2em;
    border-radius: 2em;
}

[draggable] {
    -moz-user-select: none;
    -khtml-user-select: none;
    -webkit-user-select: none;
    user-select: none;
    /* Required to make elements draggable in old WebKit */
    -khtml-user-drag: element;
    -webkit-user-drag: element;
}

.w3p-repeater-field {
    cursor: move;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 1em;
    margin: 0 0 1em 0;
    padding: .5em 0;
}
.w3p-repeater-field header {
    height: 20px;
    width: 150px;
    color: black;
    background-color: #ccc;
    padding: 5px;
    border-bottom: 1px solid #ddd;
    border-radius: 10px;
    border: 2px solid #666666;
}

.w3p-repeater-field.dragElem {
    opacity: 1;
}
.w3p-repeater-field.over {
    border-top: 3px dashed gray;
}
.w3p-class {
    border: 1px dotted gray;
}
.w3p-hover {
    background-color: lightyellow;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', () => {
    sortable('.w3p-repeater-fields', {
        forcePlaceholderSize: true,
        placeholderClass: 'w3p-class',
        hoverClass: 'w3p-hover',
    });
});
</script>
