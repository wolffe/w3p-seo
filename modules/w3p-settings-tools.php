<h1><?php esc_html_e( 'SEO Plugin Cleanup Tools', 'w3p-seo' ); ?></h1>

<p><?php esc_html_e( 'Use these tools to clean up leftover data from other SEO plugins when migrating to W3P SEO.', 'w3p-seo' ); ?></p>

<h2><?php esc_html_e( 'SEO Plugin Data Cleanup', 'w3p-seo' ); ?></h2>

<div class="notice notice-warning">
    <p><strong><?php esc_html_e( '⚠️ WARNING:', 'w3p-seo' ); ?></strong> <?php esc_html_e( 'This is destructive. It will permanently delete AIOSEO or Yoast SEO data from custom tables, options, transients, usermeta, postmeta, termmeta, and commentmeta.', 'w3p-seo' ); ?></p>
    <p><strong><?php esc_html_e( 'Run once only when you are 100% sure.', 'w3p-seo' ); ?></strong></p>
</div>

<?php
if ( isset( $_POST['w3p_aioseo_cleanup'] ) && wp_verify_nonce( $_POST['w3p_cleanup_tools_nonce'], 'w3p_cleanup_tools' ) ) {
    global $wpdb;

    // --- 1. Drop AIOSEO custom tables.
    $tables = [
        "{$wpdb->prefix}aioseo_cache",
        "{$wpdb->prefix}aioseo_crawl_cleanup_blocked_args",
        "{$wpdb->prefix}aioseo_crawl_cleanup_logs",
        "{$wpdb->prefix}aioseo_notifications",
        "{$wpdb->prefix}aioseo_posts",
        "{$wpdb->prefix}aioseo_redirects",
        "{$wpdb->prefix}aioseo_redirects_404",
        "{$wpdb->prefix}aioseo_redirects_404_logs",
        "{$wpdb->prefix}aioseo_redirects_hits",
        "{$wpdb->prefix}aioseo_redirects_logs",
        "{$wpdb->prefix}aioseo_revisions",
        "{$wpdb->prefix}aioseo_search_statistics_keywords",
        "{$wpdb->prefix}aioseo_search_statistics_keyword_groups",
        "{$wpdb->prefix}aioseo_search_statistics_keyword_relationships",
        "{$wpdb->prefix}aioseo_search_statistics_objects",
        "{$wpdb->prefix}aioseo_seo_analyzer_objects",
        "{$wpdb->prefix}aioseo_seo_analyzer_results",
        "{$wpdb->prefix}aioseo_terms",
        "{$wpdb->prefix}aioseo_writing_assistant_keywords",
        "{$wpdb->prefix}aioseo_writing_assistant_posts",
    ];

    foreach ( $tables as $table ) {
        $wpdb->query( "DROP TABLE IF EXISTS `$table`" ); // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
    }

    // --- 2. Delete AIOSEO options.
    $wpdb->query(
        $wpdb->prepare(
            "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name IN ('widget_aioseo-breadcrumb-widget','widget_aioseo-html-sitemap-widget')",
            'aioseo_%'
        )
    );

    // --- 3. Delete AIOSEO transients.
    $wpdb->query(
        $wpdb->prepare(
            "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s",
            '_transient_aioseo_%',
            '_transient_timeout_aioseo_%'
        )
    );

    // --- 4. Delete AIOSEO usermeta.
    $wpdb->query(
        $wpdb->prepare(
            "DELETE FROM {$wpdb->usermeta} WHERE meta_key LIKE %s",
            'aioseo_%'
        )
    );

    // --- 5. Delete AIOSEO postmeta.
    $wpdb->query(
        $wpdb->prepare(
            "DELETE FROM {$wpdb->postmeta} WHERE meta_key LIKE %s",
            'aioseo_%'
        )
    );

    // --- 6. Delete AIOSEO termmeta.
    $wpdb->query(
        $wpdb->prepare(
            "DELETE FROM {$wpdb->termmeta} WHERE meta_key LIKE %s",
            'aioseo_%'
        )
    );

    // --- 7. (Optional) Delete AIOSEO commentmeta.
    $wpdb->query(
        $wpdb->prepare(
            "DELETE FROM {$wpdb->commentmeta} WHERE meta_key LIKE %s",
            'aioseo_%'
        )
    );

    // --- 8. Optimize AIOSEO tables.
	$tables = $wpdb->get_col( 'SHOW TABLES' );

	foreach ( $tables as $table ) {
		$wpdb->query( "OPTIMIZE TABLE `$table`" ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
	}

    echo '<div class="notice notice-success is-dismissible"><p><strong>✅ AIOSEO data cleanup completed successfully!</strong> All AIOSEO tables, options, and metadata have been removed from your database.</p></div>';
}

if ( isset( $_POST['w3p_yoast_cleanup'] ) && wp_verify_nonce( $_POST['w3p_cleanup_tools_nonce'], 'w3p_cleanup_tools' ) ) {
    global $wpdb;

    // --- 1. Drop Yoast SEO custom tables.
    $tables = [
        "{$wpdb->prefix}yoast_indexable",
        "{$wpdb->prefix}yoast_indexable_hierarchy",
        "{$wpdb->prefix}yoast_migrations",
        "{$wpdb->prefix}yoast_primary_term",
        "{$wpdb->prefix}yoast_seo_links",
    ];

    foreach ( $tables as $table ) {
        $wpdb->query( "DROP TABLE IF EXISTS `$table`" ); // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
    }

    // --- 2. Delete Yoast SEO options.
    $wpdb->query(
        $wpdb->prepare(
            "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s",
            'wpseo_%'
        )
    );

    // --- 3. Delete Yoast SEO transients.
    $wpdb->query(
        $wpdb->prepare(
            "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s",
            '_transient_wpseo_%',
            '_transient_timeout_wpseo_%'
        )
    );

    // --- 4. Delete Yoast SEO usermeta.
    $wpdb->query(
        $wpdb->prepare(
            "DELETE FROM {$wpdb->usermeta} WHERE meta_key LIKE %s",
            'wpseo_%'
        )
    );

    // --- 5. Delete Yoast SEO postmeta.
    $wpdb->query(
        $wpdb->prepare(
            "DELETE FROM {$wpdb->postmeta} WHERE meta_key LIKE %s",
            '_yoast_%'
        )
    );

    // --- 6. Delete Yoast SEO termmeta.
    $wpdb->query(
        $wpdb->prepare(
            "DELETE FROM {$wpdb->termmeta} WHERE meta_key LIKE %s",
            'wpseo_%'
        )
    );

    // --- 7. Delete Yoast SEO commentmeta.
    $wpdb->query(
        $wpdb->prepare(
            "DELETE FROM {$wpdb->commentmeta} WHERE meta_key LIKE %s",
            'wpseo_%'
        )
    );

    // --- 8. Optimize Yoast SEO tables.
	$tables = $wpdb->get_col( 'SHOW TABLES' );

	foreach ( $tables as $table ) {
		$wpdb->query( "OPTIMIZE TABLE `$table`" ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
	}

    echo '<div class="notice notice-success is-dismissible"><p><strong>✅ Yoast SEO data cleanup completed successfully!</strong> All Yoast SEO tables, options, and metadata have been removed from your database.</p></div>';
}
?>

<form method="post" action="">
    <?php wp_nonce_field( 'w3p_cleanup_tools', 'w3p_cleanup_tools_nonce' ); ?>

    <table class="form-table">
        <tr>
            <th scope="row"><?php esc_html_e( 'Clean up leftover AIOSEO data', 'w3p-seo' ); ?></th>
            <td>
                <input type="submit" name="w3p_aioseo_cleanup" class="button button-primary" value="<?php esc_attr_e( 'Clean up leftover AIOSEO data', 'w3p-seo' ); ?>" onclick="return confirm('<?php esc_attr_e( 'Are you sure you want to permanently delete all AIOSEO data? This action cannot be undone.', 'w3p-seo' ); ?>');" />
                <p class="description"><?php esc_html_e( 'This will remove all AIOSEO tables, options, transients, and metadata from your database.', 'w3p-seo' ); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php esc_html_e( 'Clean up leftover Yoast SEO data', 'w3p-seo' ); ?></th>
            <td>
                <input type="submit" name="w3p_yoast_cleanup" class="button button-primary" value="<?php esc_attr_e( 'Clean up leftover Yoast SEO data', 'w3p-seo' ); ?>" onclick="return confirm('<?php esc_attr_e( 'Are you sure you want to permanently delete all Yoast SEO data? This action cannot be undone.', 'w3p-seo' ); ?>');" />
                <p class="description"><?php esc_html_e( 'This will remove all Yoast SEO tables, options, transients, and metadata from your database.', 'w3p-seo' ); ?></p>
            </td>
        </tr>
    </table>
</form>
