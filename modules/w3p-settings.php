<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function w3p_settings() { ?>
    <div class="wrap wrap--w3p">
        <h2><?php esc_html_e( 'W3P SEO Settings', 'wp-perfect-plugin' ); ?></h2>

        <?php $tab = isset( $_GET['tab'] ) ? (string) sanitize_text_field( $_GET['tab'] ) : 'dashboard'; ?>

        <h2 class="nav-tab-wrapper">
            <a href="<?php echo admin_url( 'admin.php?page=w3p&amp;tab=dashboard' ); ?>" class="nav-tab <?php echo $tab === 'dashboard' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Dashboard', 'wp-perfect-plugin' ); ?></a>
            <a href="<?php echo admin_url( 'admin.php?page=w3p&amp;tab=settings' ); ?>" class="nav-tab <?php echo $tab === 'settings' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'General Settings', 'wp-perfect-plugin' ); ?></a>
            <a href="<?php echo admin_url( 'admin.php?page=w3p&amp;tab=console' ); ?>" class="nav-tab <?php echo $tab === 'console' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Search Engine Console', 'wp-perfect-plugin' ); ?></a>
            <a href="<?php echo admin_url( 'admin.php?page=w3p&amp;tab=image' ); ?>" class="nav-tab <?php echo $tab === 'image' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Image SEO', 'wp-perfect-plugin' ); ?></a>
            <a href="<?php echo admin_url( 'admin.php?page=w3p&amp;tab=clustering' ); ?>" class="nav-tab <?php echo $tab === 'clustering' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Topic Clustering', 'wp-perfect-plugin' ); ?></a>
            <a href="<?php echo admin_url( 'admin.php?page=w3p&amp;tab=meta' ); ?>" class="nav-tab <?php echo $tab === 'meta' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Meta Report (Pages)', 'wp-perfect-plugin' ); ?></a>
            <a href="<?php echo admin_url( 'admin.php?page=w3p&amp;tab=meta-posts' ); ?>" class="nav-tab <?php echo $tab === 'meta-posts' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Meta Report (Posts)', 'wp-perfect-plugin' ); ?></a>

            <?php if ( (int) get_option( 'w3p_enable_link_whisper' ) === 1 ) { ?>
                <a href="<?php echo admin_url( 'admin.php?page=w3p&amp;tab=links' ); ?>" class="nav-tab <?php echo $tab === 'links' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Link Whisper', 'wp-perfect-plugin' ); ?></a>
            <?php } ?>
        </h2>

        <?php if ( $tab === 'dashboard' ) { ?>
            <div class="w3p-intro">
                <img src="<?php echo W3P_URL; ?>/assets/images/w3p-logo.svg" width="72" alt="">
                <b>W3P</b> SEO <span class="w3p-intro--version">v<?php echo W3P_VERSION; ?></span>
            </div>

            <div class="gb-ad">
                <h3><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 68 68"><defs/><rect width="100%" height="100%" fill="none"/><g class="currentLayer"><path fill="#313457" d="M34.76 33C22.85 21.1 20.1 13.33 28.23 5.2 36.37-2.95 46.74.01 50.53 3.8c3.8 3.8 5.14 17.94-5.04 28.12-2.95 2.95-5.97 5.84-5.97 5.84L34.76 33"/><path fill="#313457" d="M43.98 42.21c5.54 5.55 14.59 11.06 20.35 5.3 5.76-5.77 3.67-13.1.98-15.79-2.68-2.68-10.87-5.25-18.07 1.96-2.95 2.95-5.96 5.84-5.96 5.84l2.7 2.7m-1.76 1.75c5.55 5.54 11.06 14.59 5.3 20.35-5.77 5.76-13.1 3.67-15.79.98-2.69-2.68-5.25-10.87 1.95-18.07 2.85-2.84 5.84-5.96 5.84-5.96l2.7 2.7"/><path fill="#313457" d="M33 34.75c-11.9-11.9-19.67-14.67-27.8-6.52-8.15 8.14-5.2 18.5-1.4 22.3 3.8 3.79 17.95 5.13 28.13-5.05 3.1-3.11 5.84-5.97 5.84-5.97L33 34.75"/></g></svg> Thank you for using W3P SEO!</h3>
                <p>W3P aims to provide advanced SEO options for any web developer.</p>
                <p>If you enjoy this plugin, do not forget to <a href="https://wordpress.org/support/plugin/wp-perfect-plugin/reviews/?filter=5" rel="external">rate it on WordPress.org</a>! We work hard to update it, fix bugs, add new features and make it compatible with the latest web technologies.</p>
                <p style="font-size:14px">
                    <b>Featured plugins:</b>&#32;
                    🔥 <a href="https://getbutterfly.com/wordpress-plugins/active-analytics/" target="_blank" rel="external noopener">Active Analytics</a> and&#32;
                    🚀 <a href="https://getbutterfly.com/wordpress-plugins/lighthouse/" target="_blank" rel="external noopener">WP Lighthouse</a>&#32;
                    Have you tried our other <a href="https://getbutterfly.com/wordpress-plugins/">WordPress plugins</a> or <a href="https://directory.classicpress.net/developer/getbutterfly/">ClassicPress plugins</a>?
                </p>
            </div>

            <hr>
            <h3><?php _e( 'Shortcodes & Functions', 'wp-perfect-plugin' ); ?></h3>
            <ul>
                <li><strong>List Subpages</strong> - Use the <code>[subpages]</code> shortcode to list the subpages of the current page as a <code>ul/li</code> list, allowing you to use parent pages in a similar way to categories. The <code>ul</code> structure is ready for styling using the <code>.w3p-subpages</code> CSS class.</li>
                <li><strong>Microdata Breadcrumbs</strong> - Use the <code>&lt;php if ( function_exists( 'w3p_breadcrumbs' ) ) { w3p_breadcrumbs(); } ?&gt;</code> template function to display breadcrumbs. Note that they are displayed as an <code>ol/li</code> list, and are unstyled.</li>
            </ul>

            <hr>
            <p>&copy;<?php echo gmdate( 'Y' ); ?> <a href="https://getbutterfly.com/" rel="external"><strong>getButterfly</strong>.com</a> &middot; <small>Code wrangling since 2005</small></p>
            <?php
        } elseif ( $tab === 'settings' ) {
            if ( isset( $_POST['info_update1'] ) && current_user_can( 'manage_options' ) ) {
                update_option( 'w3p_enable_title_description', (int) sanitize_text_field( $_POST['w3p_enable_title_description'] ) );
                update_option( 'w3p_enable_sitemap', (int) sanitize_text_field( $_POST['w3p_enable_sitemap'] ) );
                update_option( 'w3p_enable_link_whisper', (int) sanitize_text_field( $_POST['w3p_enable_link_whisper'] ) );
                update_option( 'w3p_enable_yoast_migrator', (int) sanitize_text_field( $_POST['w3p_enable_yoast_migrator'] ) );

                delete_option( 'w3p_module_mat' );
                delete_option( 'w3p_module_seo' );

                echo '<div class="updated notice is-dismissible"><p>Settings updated!</p></div>';
            }
            ?>
            <form method="post" action="">
                <h3><?php _e( 'Module Settings', 'wp-perfect-plugin' ); ?></h3>

                <p><span class="dashicons dashicons-editor-help"></span> This section allows you to configure your modules.</p>
                <p>
                    <input name="w3p_enable_title_description" id="w3p_enable_title_description" type="checkbox" value="1" <?php checked( 1, (int) get_option( 'w3p_enable_title_description' ) ); ?>> <label for="w3p_enable_title_description">Enable custom SEO titles and descriptions</label>
                </p>
                <p>
                    <input name="w3p_enable_sitemap" id="w3p_enable_sitemap" type="checkbox" value="1" <?php checked( 1, (int) get_option( 'w3p_enable_sitemap' ) ); ?>> <label for="w3p_enable_sitemap">Enable XML sitemaps</label>
                </p>
                <p>
                    <input name="w3p_enable_link_whisper" id="w3p_enable_link_whisper" type="checkbox" value="1" <?php checked( 1, (int) get_option( 'w3p_enable_link_whisper' ) ); ?>> <label for="w3p_enable_link_whisper">Enable Link Whisper</label>
                </p>

                <hr>

                <p>
                    <input name="w3p_enable_yoast_migrator" id="w3p_enable_yoast_migrator" type="checkbox" value="1" <?php checked( 1, (int) get_option( 'w3p_enable_yoast_migrator' ) ); ?>> <label for="w3p_enable_yoast_migrator">Enable Yoast migrator</label>
                    <br><small>Show Yoast's title and description next to W3P's title and description</small>
                </p>

                <hr>

                <p>
                    <input type="submit" name="info_update1" class="button button-primary" value="<?php _e( 'Save Changes', 'wp-perfect-plugin' ); ?>">
                </p>
            </form>
            <?php
        } elseif ( $tab === 'console' ) {
            $sub_tab = isset( $_GET['tab2'] ) ? (string) sanitize_text_field( $_GET['tab2'] ) : 'verification';
            ?>
            <h2>Search Engine Console Settings</h2>

            <h3 class="nav-tab-wrapper">
                <a href="<?php echo admin_url( 'admin.php?page=w3p&tab=console&tab2=verification' ); ?>" class="nav-tab <?php echo $sub_tab === 'verification' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Verification and Relationships', 'wp-perfect-plugin' ); ?></a>
                <a href="<?php echo admin_url( 'admin.php?page=w3p&tab=console&tab2=local' ); ?>" class="nav-tab <?php echo $sub_tab === 'local' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Local', 'wp-perfect-plugin' ); ?></a>
                <a href="<?php echo admin_url( 'admin.php?page=w3p&tab=console&tab2=kg' ); ?>" class="nav-tab <?php echo $sub_tab === 'kg' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Knowledge Graph', 'wp-perfect-plugin' ); ?></a>
                <a href="<?php echo admin_url( 'admin.php?page=w3p&tab=console&tab2=analytics' ); ?>" class="nav-tab <?php echo $sub_tab === 'analytics' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Analytics', 'wp-perfect-plugin' ); ?></a>
                <a href="<?php echo admin_url( 'admin.php?page=w3p&tab=console&tab2=header_footer' ); ?>" class="nav-tab <?php echo $sub_tab === 'header_footer' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Header and Footer', 'wp-perfect-plugin' ); ?></a>
                <a href="<?php echo admin_url( 'admin.php?page=w3p&tab=console&tab2=opengraph' ); ?>" class="nav-tab <?php echo $sub_tab === 'opengraph' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Open Graph', 'wp-perfect-plugin' ); ?></a>
                <a href="<?php echo admin_url( 'admin.php?page=w3p&tab=console&tab2=crawl' ); ?>" class="nav-tab <?php echo $sub_tab === 'crawl' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Crawl Optimization', 'wp-perfect-plugin' ); ?></a>

                <?php if ( (int) get_option( 'w3p_enable_sitemap' ) === 1 ) { ?>
                    <a href="<?php echo admin_url( 'admin.php?page=w3p&tab=console&tab2=sitemap-cpt' ); ?>" class="nav-tab <?php echo $sub_tab === 'sitemap-cpt' ? 'nav-tab-active' : ''; ?>"><?php _e( 'XML Sitemaps (Post Types)', 'wp-perfect-plugin' ); ?></a>
                    <a href="<?php echo admin_url( 'admin.php?page=w3p&tab=console&tab2=sitemap-tax' ); ?>" class="nav-tab <?php echo $sub_tab === 'sitemap-tax' ? 'nav-tab-active' : ''; ?>"><?php _e( 'XML Sitemaps (Taxonomies)', 'wp-perfect-plugin' ); ?></a>
                <?php } ?>
            </h3>

            <?php
            if ( $sub_tab === 'verification' ) {
                if ( isset( $_POST['info_update1'] ) && current_user_can( 'manage_options' ) ) {
                    update_option( 'w3p_google_webmaster', sanitize_text_field( $_POST['w3p_google_webmaster'] ) );
                    update_option( 'w3p_bing_webmaster', sanitize_text_field( $_POST['w3p_bing_webmaster'] ) );
                    update_option( 'w3p_yandex_webmaster', sanitize_text_field( $_POST['w3p_yandex_webmaster'] ) );
                    update_option( 'w3p_pinterest_webmaster', sanitize_text_field( $_POST['w3p_pinterest_webmaster'] ) );
                    update_option( 'w3p_baidu_webmaster', sanitize_text_field( $_POST['w3p_baidu_webmaster'] ) );

                    update_option( 'w3p_twitter_author', sanitize_text_field( $_POST['w3p_twitter_author'] ) );

                    delete_option( 'w3p_wot_webmaster' );
                    delete_option( 'w3p_majestic_webmaster' );

                    echo '<div class="updated notice is-dismissible"><p>Settings updated!</p></div>';
                }
                ?>
                <form method="post" action="">
                    <h3><?php _e('Search Engine Verification And Link Relationships', 'wp-perfect-plugin'); ?></h3>

                    <p><span class="dashicons dashicons-editor-help"></span> This section allows you to verify ownership of your site with Google Search Console, Bing Webmaster Tools, Yandex, Pinterest, and Baidu and Web of Trust.</p>
                    <p>
                        <input name="w3p_google_webmaster" type="text" class="regular-text" value="<?php echo get_option('w3p_google_webmaster'); ?>"> <label>Google Search Console</label>
                        <br><small>&lt;meta name="google-site-verification" content="Volxdfasfasd3i3e_wATasfdsSDb0uFqvNVhLk7ZVY"&gt;</small>
                    </p>
                    <p>
                        <input name="w3p_bing_webmaster" type="text" class="regular-text" value="<?php echo get_option('w3p_bing_webmaster'); ?>"> <label>Bing Webmaster Tools</label>
                        <br><small>&lt;meta name="msvalidate.01" content="ASBKDW71D43Z67AB2D39636C89B88A"&gt;</small>
                    </p>
                    <p>
                        <input name="w3p_yandex_webmaster" type="text" class="regular-text" value="<?php echo get_option('w3p_yandex_webmaster'); ?>"> <label>Yandex Verification</label>
                        <br><small>&lt;meta name="yandex-verification" content="48b322931315c6df"&gt;</small>
                    </p>
                    <p>
                        <input name="w3p_pinterest_webmaster" type="text" class="regular-text" value="<?php echo get_option('w3p_pinterest_webmaster'); ?>"> <label>Pinterest Verification</label>
                        <br><small>&lt;meta name="p:domain_verify" content="3d392d258cd7fb8a5676ba12d06be0c6"&gt;</small>
                    </p>
                    <p>
                        <input name="w3p_baidu_webmaster" type="text" class="regular-text" value="<?php echo get_option('w3p_baidu_webmaster'); ?>"> <label>Baidu Verification</label>
                        <br><small>&lt;meta name="baidu-site-verification" content="7V6m4wr5F2q2"&gt;</small>
                    </p>

                    <p>Missing a verification tag? Use the <a href="<?php echo admin_url('admin.php?page=w3p_search_console&tab=header_footer'); ?>">Header and Footer</a> section to add custom <code>meta</code> tags.</p>

                    <hr>
                    <p><span class="dashicons dashicons-editor-help"></span> This section allows you to specify link relationships with X (Twitter).</p>
                    <p>
                        @<input name="w3p_twitter_author" type="text" class="regular-text" value="<?php echo get_option('w3p_twitter_author'); ?>"> <label>X (Twitter) Username</label>
                        <br><small>e.g. <span>getButterfly</span></small>
                    </p>

                    <p><input type="submit" name="info_update1" class="button button-primary" value="<?php _e('Save Changes', 'wp-perfect-plugin'); ?>"></p>
                </form>
                <?php
            } else if ((string) $sub_tab === 'local') {
                wp_enqueue_media();

                if ( isset( $_POST['info_update1'] ) && current_user_can( 'manage_options' ) ) {
                    update_option( 'w3p_local', (int) sanitize_text_field( $_POST['w3p_local'] ) );

                    update_option( 'w3p_local_locality', sanitize_text_field( $_POST['w3p_local_locality'] ) );
                    update_option( 'w3p_local_region', sanitize_text_field( $_POST['w3p_local_region'] ) );
                    update_option( 'w3p_local_address', sanitize_text_field( $_POST['w3p_local_address'] ) );
                    update_option( 'w3p_local_postal_code', sanitize_text_field( $_POST['w3p_local_postal_code'] ) );
                    update_option( 'w3p_local_country', sanitize_text_field( $_POST['w3p_local_country'] ) );
                    update_option( 'w3p_telephone', sanitize_text_field( $_POST['w3p_telephone'] ) );

                    update_option( 'w3p_local_image_1', sanitize_url( $_POST['w3p_local_image_1'] ) );
                    update_option( 'w3p_local_image_2', sanitize_url( $_POST['w3p_local_image_2'] ) );

                    echo '<div class="updated notice is-dismissible"><p>Settings updated!</p></div>';
                }
                ?>
                <form method="post" action="">
                    <h3>Local Business Details</h3>
                    <p><span class="dashicons dashicons-editor-help"></span> This section allows you to control your local listing, your Knowledge Graph and various site schemas, such as <code>Organization</code> and <code>LocalBusiness</code>.</p>
                    <p>Note that all fields below are mandatory for search engines to display your local listing.</p>

                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th scope="row"><label>Local Info</label></th>
                                <td>
                                    <p>
                                        <input name="w3p_local" id="w3p_local" type="checkbox" value="1" <?php checked( 1, (int) get_option( 'w3p_local' ) ); ?>> <label for="w3p_local">Enable Local Info</label>
                                        <br><small>Only check this box if you have a physical address/business location.</small>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label>Postal Address: Street Address</label></th>
                                <td>
                                    <p>
                                        <input name="w3p_local_address" type="text" class="regular-text" value="<?php echo get_option( 'w3p_local_address' ); ?>">
                                        <br><small>e.g. <span>1600 Amphitheatre Parkway</span></small>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label>Postal Address: Locality</label></th>
                                <td>
                                    <p>
                                        <input name="w3p_local_locality" type="text" class="regular-text" value="<?php echo get_option( 'w3p_local_locality' ); ?>">
                                        <br><small>e.g. <span>Mountain View</span></small>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label>Postal Address: Region</label></th>
                                <td>
                                    <p>
                                        <input name="w3p_local_region" type="text" class="regular-text" value="<?php echo get_option( 'w3p_local_region' ); ?>">
                                        <br><small>e.g. <span>CA</span></small>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label>Postal Address: Postal Code</label></th>
                                <td>
                                    <p>
                                        <input name="w3p_local_postal_code" type="text" class="regular-text" value="<?php echo get_option( 'w3p_local_postal_code' ); ?>">
                                        <br><small>e.g. <span>94043</span></small>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label>Postal Address: Country</label></th>
                                <td>
                                    <p>
                                        <input name="w3p_local_country" type="text" class="regular-text" value="<?php echo get_option( 'w3p_local_country' ); ?>">
                                        <br><small>e.g. <span>United States of America</span></small>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label>Telephone</label></th>
                                <td>
                                    <p>
                                        <input name="w3p_telephone" type="text" class="regular-text" value="<?php echo get_option( 'w3p_telephone' ); ?>">
                                        <br><small>e.g. <span>+1 650-253-0000</span></small>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label>Image 1</label></th>
                                <td>
                                    <div>
                                        <?php
                                        if ( get_option( 'w3p_local_image_1' ) ) {
                                            $image_url = get_option( 'w3p_local_image_1' );
                                            echo '<p><img src="' . $image_url . '" style="max-width: 400px;" alt=""></p>';
                                        } else {
                                            echo '<p>No image selected.</p>';
                                        }

                                        if ( ! empty( $_POST['image_1'] ) ) {
                                            $image_url = $_POST['image_1'];
                                        }
                                        ?>
                                        <input id="w3p-image-url-1" type="hidden" name="w3p_local_image_1" value="<?php echo get_option( 'w3p_local_image_1' ); ?>">
                                        <input id="w3p-upload-image-btn-1" type="button" class="button button-secondary" value="Upload or Select Image">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label>Image 2</label></th>
                                <td>
                                    <div>
                                        <?php
                                        if ( get_option( 'w3p_local_image_2' ) ) {
                                            $image_url = get_option( 'w3p_local_image_2' );
                                            echo '<p><img src="' . $image_url . '" style="max-width: 400px;" alt=""></p>';
                                        } else {
                                            echo '<p>No image selected.</p>';
                                        }

                                        if ( ! empty( $_POST['image_2'] ) ) {
                                            $image_url = $_POST['image_2'];
                                        }
                                        ?>
                                        <input id="w3p-image-url-2" type="hidden" name="w3p_local_image_2" value="<?php echo get_option( 'w3p_local_image_2' ); ?>">
                                        <input id="w3p-upload-image-btn-2" type="button" class="button button-secondary" value="Upload or Select Image">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <p><input type="submit" name="info_update1" class="button button-primary" value="<?php _e('Save Changes', 'wp-perfect-plugin'); ?>"></p>
                </form>

                <script>
                jQuery(document).ready(function () {
                    var mediaUploader;

                    jQuery('#w3p-upload-image-btn-1').click(function (e) {
                        e.preventDefault();

                        // If the uploader object has already been created, reopen the dialog
                        if (mediaUploader) {
                            mediaUploader.open();
                            return;
                        }
                        // Extend the wp.media object
                        mediaUploader = wp.media.frames.file_frame = wp.media({
                            title: 'Choose Image',
                            button: {
                                text: 'Choose Image'
                            },
                            multiple: false
                        });

                        // When a file is selected, grab the URL and set it as the text field's value
                        mediaUploader.on('select', function () {
                            var attachment = mediaUploader.state().get('selection').first().toJSON();
                            jQuery('#w3p-image-url-1').val(attachment.url);
                        });

                        // Open the uploader dialog
                        mediaUploader.open();
                    });

                    jQuery('#w3p-upload-image-btn-2').click(function (e) {
                        e.preventDefault();

                        // If the uploader object has already been created, reopen the dialog
                        if (mediaUploader) {
                            mediaUploader.open();
                            return;
                        }
                        // Extend the wp.media object
                        mediaUploader = wp.media.frames.file_frame = wp.media({
                            title: 'Choose Image',
                            button: {
                                text: 'Choose Image'
                            },
                            multiple: false
                        });

                        // When a file is selected, grab the URL and set it as the text field's value
                        mediaUploader.on('select', function () {
                            var attachment = mediaUploader.state().get('selection').first().toJSON();
                            jQuery('#w3p-image-url-2').val(attachment.url);
                        });

                        // Open the uploader dialog
                        mediaUploader.open();
                    });
                });
                </script>
                <?php
            } elseif ( (string) $sub_tab === 'kg' ) {
                if ( isset( $_POST['info_update'] ) ) {
                    update_option( 'w3p_kg_type', sanitize_text_field( $_POST['w3p_kg_type'] ) );
                    update_option( 'w3p_kg_name', sanitize_text_field( $_POST['w3p_kg_name'] ) );
                    update_option( 'w3p_kg_logo', sanitize_url( $_POST['w3p_kg_logo'] ) );

                    $w3p_kg_same_as = isset( $_POST['w3p_kg_same_as'] ) ? sanitize_textarea_field( $_POST['w3p_kg_same_as'] ) : '';
                    update_option( 'w3p_kg_same_as', $w3p_kg_same_as );

                    echo '<div class="updated notice is-dismissible"><p>Settings updated successfully!</p></div>';
                }
                ?>
                <form method="post" action="">
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th scope="row" colspan="2"><h3><?php _e( 'Knowledge Graph &amp; Schema.org', 'wp-perfect-plugin' ); ?></h3></th>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="w3p_kg_type">
                                        <?php _e( 'Website Type', 'wp-perfect-plugin' ); ?>
                                    </label>
                                </th>
                                <td>
                                    <p><?php _e( 'Choose whether the website represents an organization or a person.', 'wp-perfect-plugin' ); ?></p>

                                    <select name="w3p_kg_type" id="w3p_kg_type">
                                        <option value="organization" <?php selected( 'organization', get_option( 'w3p_kg_type' ) ); ?>><?php _e( 'Organization', 'wp-perfect-plugin' ); ?></option>
                                        <option value="person" <?php selected( 'person', get_option( 'w3p_kg_type' ) ); ?>><?php _e( 'Person', 'wp-perfect-plugin' ); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="w3p_kg_name">
                                        <?php _e( 'Organization/Person Name', 'wp-perfect-plugin' ); ?>
                                    </label>
                                </th>
                                <td>
                                    <input type="text" name="w3p_kg_name" id="w3p_kg_name" class="regular-text" value="<?php echo get_option( 'w3p_kg_name' ); ?>">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label>Logo</label></th>
                                <td>
                                    <div>
                                        <?php
                                        if ( get_option( 'w3p_kg_logo' ) ) {
                                            $image_url = get_option( 'w3p_kg_logo' );
                                            echo '<p><img src="' . $image_url . '" style="max-width: 400px;" alt=""></p>';
                                        } else {
                                            echo '<p>No image selected.</p>';
                                        }

                                        if ( ! empty( $_POST['image'] ) ) {
                                            $image_url = $_POST['image'];
                                        }

                                        wp_enqueue_media();
                                        ?>
                                        <input id="w3p-image-url" type="hidden" name="w3p_kg_logo" value="<?php echo get_option( 'w3p_kg_logo' ); ?>">
                                        <input id="w3p-upload-image-btn" type="button" class="button button-secondary" value="Upload or Select Logo">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label>Social Links</label></th>
                                <td>
                                    <p>
                                        <textarea class="large-text" rows="6" name="w3p_kg_same_as"><?php echo get_option( 'w3p_kg_same_as' ); ?></textarea>
                                        <br><small>Add one or more social links (Facebook, X (Twitter), LinkedIn, Instagram, YouTube, one URL per line).</small>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"></th>
                                <td>
                                    <p>
                                        <input type="submit" name="info_update" class="button button-primary" value="<?php _e( 'Save Changes', 'wp-perfect-plugin' ); ?>">
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>

                <script>
                jQuery(document).ready(function () {
                    var mediaUploader;

                    jQuery('#w3p-upload-image-btn').click(function (e) {
                        e.preventDefault();

                        // If the uploader object has already been created, reopen the dialog
                        if (mediaUploader) {
                            mediaUploader.open();
                            return;
                        }
                        // Extend the wp.media object
                        mediaUploader = wp.media.frames.file_frame = wp.media({
                            title: 'Choose Image',
                            button: {
                                text: 'Choose Image'
                            },
                            multiple: false
                        });

                        // When a file is selected, grab the URL and set it as the text field's value
                        mediaUploader.on('select', function () {
                            var attachment = mediaUploader.state().get('selection').first().toJSON();
                            jQuery('#w3p-image-url').val(attachment.url);
                        });

                        // Open the uploader dialog
                        mediaUploader.open();
                    });
                });
                </script>
                <?php
            } elseif ( (string) $sub_tab === 'analytics' ) {
                if ( isset( $_POST['info_update1'] ) && current_user_can( 'manage_options' ) ) {
                    update_option( 'w3p_google_analytics', sanitize_text_field( $_POST['w3p_google_analytics'] ) );
                    update_option( 'w3p_google_tag_manager', sanitize_text_field( $_POST['w3p_google_tag_manager'] ) );

                    echo '<div class="updated notice is-dismissible"><p>Settings updated!</p></div>';
                }
                ?>
                <form method="post" action="">
                    <h3>Analytics and Tag Management</h3>
                    <p><span class="dashicons dashicons-editor-help"></span> This section allows you to set Google Analytics and/or Google Tag Manager.</p>
                    <p>
                        <input name="w3p_google_analytics" type="text" class="regular-text" value="<?php echo get_option( 'w3p_google_analytics' ); ?>"> <label>Google Analytics</label>
                        <br><small>(Web Property ID: <span>G-1234567890</span>)</small>
                    </p>
                    <p>
                        <input name="w3p_google_tag_manager" type="text" class="regular-text" value="<?php echo get_option( 'w3p_google_tag_manager' ); ?>"> <label>Google Tag Manager</label>
                        <br><small>(Container ID: <span>GTM-A1B2C3D</span>)</small>
                    </p>

                    <p><input type="submit" name="info_update1" class="button button-primary" value="<?php _e( 'Save Changes', 'wp-perfect-plugin' ); ?>"></p>
                </form>
                <?php
            } elseif ( (string) $sub_tab === 'header_footer' ) {
                if ( isset( $_POST['info_update1'] ) && current_user_can( 'manage_options' ) ) {
                    update_option( 'w3p_head_section', stripslashes_deep( sanitize_text_field( $_POST['w3p_head_section'] ) ) );
                    update_option( 'w3p_footer_section', stripslashes_deep( sanitize_text_field( $_POST['w3p_footer_section'] ) ) );

                    echo '<div class="updated notice is-dismissible"><p>Settings updated!</p></div>';
                }
                ?>
                <form method="post" action="">
                    <h3>Header/Footer Management</h3>
                    <p><span class="dashicons dashicons-editor-help"></span> This section allows you to add custom HTML code to header (<small>&lt;head&gt;</small>) and footer areas.</p>
                    <p>
                        Add code to the header of your site<br>
                        <textarea name="w3p_head_section" class="large-text code" rows="6"><?php echo get_option( 'w3p_head_section' ); ?></textarea>
                    </p>
                    <p>
                        Add code to the footer of your site<br>
                        <textarea name="w3p_footer_section" class="large-text code" rows="6"><?php echo get_option( 'w3p_footer_section' ); ?></textarea>
                    </p>

                    <p><input type="submit" name="info_update1" class="button button-primary" value="<?php _e( 'Save Changes', 'wp-perfect-plugin' ); ?>"></p>
                </form>
                <?php
            } else if ((string) $sub_tab === 'opengraph') {
                if (isset($_POST['info_update1']) && current_user_can('manage_options')) {
                    update_option('w3p_og', (int) $_POST['w3p_og']);
                    update_option('w3p_fb_default_image', esc_url($_POST['w3p_fb_default_image']));

                    delete_option('w3p_fb_app_id');

                    delete_option('w3p_homepage_description');
                    delete_option('w3p_fb_admin_id');
                    delete_option('w3p_od');

                    echo '<div class="updated notice is-dismissible"><p>Settings updated!</p></div>';
                }
                ?>
                <h3>Open Graph</h3>

                <p><span class="dashicons dashicons-editor-help"></span> This section allows you to enable/disable automatic Open Graph tags. Open Graph data is used primarily for Facebook, X (Twitter) and Pinterest.</p>
                <p><span class="dashicons dashicons-lightbulb"></span> Debug your Open Graph details by using the <a href="https://developers.facebook.com/tools/debug/" rel="external noopener">Facebook Sharing Debugger</a> tool or the <a href="https://www.linkedin.com/post-inspector/inspect/" rel="external noopener">LinkedIn Inspector</a>.</p>

                <form method="post" action="">
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th scope="row"><label>Open Graph</label></th>
                                <td>
                                    <p>
                                        <input name="w3p_og" id="w3p_og" type="checkbox" value="1" <?php checked( 1, (int) get_option( 'w3p_og' ) ); ?>> <label for="w3p_og">Enable Open Graph</label>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label>Default Open Graph image</label></th>
                                <td>
                                    <div>
                                        <?php
                                        if ( get_option( 'w3p_fb_default_image' ) ) {
                                            $image_url = get_option( 'w3p_fb_default_image' );
                                            echo '<p><img src="' . $image_url . '" style="max-width: 400px;" alt=""></p>';
                                        } else {
                                            echo '<p>No image selected.</p>';
                                        }

                                        if ( ! empty( $_POST['image'] ) ) {
                                            $image_url = $_POST['image'];
                                        }

                                        wp_enqueue_media();
                                        ?>
                                        <input id="w3p-image-url" type="hidden" name="w3p_fb_default_image" value="<?php echo get_option( 'w3p_fb_default_image' ); ?>">
                                        <input id="w3p-upload-image-btn" type="button" class="button button-secondary" value="Upload or Select Image">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <p><input type="submit" name="info_update1" class="button button-primary" value="<?php _e( 'Save Changes', 'wp-perfect-plugin' ); ?>"></p>
                </form>

                <script>
                jQuery(document).ready(function () {
                    var mediaUploader;

                    jQuery('#w3p-upload-image-btn').click(function (e) {
                        e.preventDefault();

                        // If the uploader object has already been created, reopen the dialog
                        if (mediaUploader) {
                            mediaUploader.open();
                            return;
                        }
                        // Extend the wp.media object
                        mediaUploader = wp.media.frames.file_frame = wp.media({
                            title: 'Choose Image',
                            button: {
                                text: 'Choose Image'
                            },
                            multiple: false
                        });

                        // When a file is selected, grab the URL and set it as the text field's value
                        mediaUploader.on('select', function () {
                            var attachment = mediaUploader.state().get('selection').first().toJSON();
                            jQuery('#w3p-image-url').val(attachment.url);
                        });

                        // Open the uploader dialog
                        mediaUploader.open();
                    });
                });
                </script>
                <?php
            } elseif ( $sub_tab === 'crawl' ) {
                if ( isset( $_POST['crawl_update'] ) && current_user_can( 'manage_options' ) ) {
                    update_option( 'w3p_noindex_queries', (int) sanitize_text_field( $_POST['w3p_noindex_queries'] ) );

                    echo '<div class="updated notice is-dismissible"><p>Settings updated!</p></div>';
                }
                ?>
                <form method="post" action="">
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th scope="row" colspan="2"><h3>General Settings</h3></th>
                            </tr>
                            <tr>
                                <th scope="row"><label>Crawl Optimization</label></th>
                                <td>
                                    <p>
                                        <input name="w3p_noindex_queries" id="w3p_noindex_queries" type="checkbox" value="1" <?php checked( 1, (int) get_option( 'w3p_noindex_queries' ) ); ?>> <label for="w3p_noindex_queries">Noindex URLs with parameters</label>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"></th>
                                <td>
                                    <p>
                                        <input type="submit" name="crawl_update" class="button button-primary" value="<?php _e( 'Save Changes', 'wp-perfect-plugin' ); ?>">
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                <?php
            } elseif ( $sub_tab === 'sitemap-cpt' ) {
                $get_cpt_args = [
                    'public' => true,
                ];

                $post_types = get_post_types( $get_cpt_args, 'object' );

                if ( isset( $_POST['info_update1'] ) && current_user_can( 'manage_options' ) ) {
                    update_option( 'w3p_sitemap_links', (int) $_POST['w3p_sitemap_links'] );

                    if ( $post_types ) {
                        foreach ( $post_types as $type ) {
                            $value = ( isset( $_POST[ 'w3p_enable_sitemap_' . $type->name ] ) ) ? 1 : 0;

                            update_option( 'w3p_enable_sitemap_' . strtolower( $type->name ), $value );
                        }
                    }

                    echo '<div class="updated notice is-dismissible"><p>Settings updated!</p></div>';
                }
                ?>
                <p>This section allows you to customize which post types you want displayed in your XML sitemap.</p>
                <p>By default, when you install W3P, all post types are hidden. You can include post types by ticking the boxes below.</p>

                <p><a href="<?php echo trailingslashit( home_url( '/' ) ); ?>wp-sitemap.xml">See your sitemap here.</a></p>

                <form method="post" action="">
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th scope="row" colspan="2"><h3>General Settings</h3></th>
                            </tr>
                            <tr>
                                <th scope="row"><label>Links per sitemap</label></th>
                                <td>
                                    <p>
                                        <input name="w3p_sitemap_links" id="w3p_sitemap_links" type="number" value="<?php echo get_option( 'w3p_sitemap_links' ); ?>" placeholder="2000"> <label for="w3p_sitemap_links">Links per sitemap (default is 2000)</label>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" colspan="2">
                                    <h3>Post Types</h3>
                                </th>
                            </tr>
                            <tr>
                                <th scope="row"><label>Post types</label></th>
                                <td>
                                    <?php
                                    if ( $post_types ) {
                                        foreach ( $post_types as $type ) {
                                            echo '<details open>
                                                <summary>
                                                    <span class="summary-title">' . $type->label . ' (<code>' . $type->name . '</code>)</span>
	                                            	<div class="summary-chevron-up">
			                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                            		</div>
                                                </summary>
                                                <div class="summary-content">
                                                    <p>
                                                        <input name="w3p_enable_sitemap_' . strtolower( $type->name ) . '" id="w3p_enable_sitemap_' . strtolower( $type->name ) . '" type="checkbox" value="1" ' . checked( 1, (int) get_option( 'w3p_enable_sitemap_' . strtolower( $type->name ) ), false ) . '> <label for="w3p_enable_sitemap_' . strtolower( $type->name ) . '">Show <b>' . $type->label . '</b> in sitemap</label>
                                                    </p>
                                                </div>
                                            </details>';
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"></th>
                                <td>
                                    <p>
                                        <input type="submit" name="info_update1" class="button button-primary" value="<?php _e( 'Save Changes', 'wp-perfect-plugin' ); ?>">
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                <?php
            } elseif ( $sub_tab === 'sitemap-tax' ) {
                $get_tax_args = [
                    'public' => true,
                ];

                $taxonomies = get_taxonomies( $get_tax_args, 'object', 'and' );

                if ( isset( $_POST['info_update1'] ) && current_user_can( 'manage_options' ) ) {
                    update_option( 'w3p_enable_sitemap_users', (int) $_POST['w3p_enable_sitemap_users'] );

                    if ( $taxonomies ) {
                        foreach ( $taxonomies as $taxonomy ) {
                            $value = ( isset( $_POST[ 'w3p_enable_sitemap_' . $taxonomy->name ] ) ) ? 1 : 0;

                            update_option( 'w3p_enable_sitemap_' . $taxonomy->name, $value );
                        }
                    }

                    echo '<div class="updated notice is-dismissible"><p>Settings updated!</p></div>';
                }
                ?>
                <p>This section allows you to customize which taxonomies you want displayed in your XML sitemap.</p>
                <p>By default, when you install W3P, all taxonomies are hidden. You can include taxonomies by ticking the boxes below.</p>

                <form method="post" action="">
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th scope="row" colspan="2">
                                    <h3>Taxonomies</h3>
                                </th>
                            </tr>
                            <tr>
                                <th scope="row"><label>Taxonomies</label></th>
                                <td>
                                    <?php
                                    if ( $taxonomies ) {
                                        foreach ( $taxonomies  as $taxonomy ) {
                                            echo '<details open>
                                                <summary>
                                                    <span class="summary-title">' . $taxonomy->label . ' (<code>' . $taxonomy->name . '</code>)</span>
	                                            	<div class="summary-chevron-up">
			                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                            		</div>
                                                </summary>
                                                <div class="summary-content">
                                                    <p>
                                                        <input name="w3p_enable_sitemap_' . $taxonomy->name . '" id="w3p_enable_sitemap_' . $taxonomy->name . '" type="checkbox" value="1" ' . checked( 1, (int) get_option( 'w3p_enable_sitemap_' . $taxonomy->name ), false ) . '> <label for="w3p_enable_sitemap_' . $taxonomy->name . '">Show <b>' . $taxonomy->label . '</b> in sitemap</label>
                                                    </p>
                                                </div>
                                            </details>';
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Users</th>
                                <td>
                                    <p>
                                        <input name="w3p_enable_sitemap_users" id="w3p_enable_sitemap_users" type="checkbox" value="1" <?php checked( 1, (int) get_option( 'w3p_enable_sitemap_users' ) ); ?>> <label for="w3p_enable_sitemap_users">Show <b>Users</b> in sitemap</label>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"></th>
                                <td>
                                    <p>
                                        <input type="submit" name="info_update1" class="button button-primary" value="<?php _e( 'Save Changes', 'wp-perfect-plugin' ); ?>">
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                <?php
            }
        } elseif ( (string) $tab === 'image' ) {
            if ( isset( $_POST['info_update1'] ) && current_user_can( 'manage_options' ) ) {
                update_option( 'w3p_image_alt', (int) $_POST['w3p_image_alt'] );

                update_option( 'w3p_image_license_url', sanitize_url( $_POST['w3p_image_license_url'] ) );
                update_option( 'w3p_image_acquire_license_url', sanitize_url( $_POST['w3p_image_acquire_license_url'] ) );

                echo '<div class="updated notice is-dismissible"><p>Settings updated!</p></div>';
            }
            ?>
            <form method="post" action="">
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row" colspan="2">
                                <h3>Image SEO</h3>
                            </th>
                        </tr>
                        <tr>
                            <th scope="row"><label>Image SEO</label></th>
                            <td>
                                <p>
                                    <input name="w3p_image_alt" id="w3p_image_alt" type="checkbox" value="1" <?php checked( 1, (int) get_option( 'w3p_image_alt' ) ); ?>> <label for="w3p_image_alt">Auto add image attributes (<code>ALT</code>) from image filename</label>
                                    <br><small>Automatically add image caption, description and ALT text from image title for all new uploads.</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label>Image License</label></th>
                            <td>
                                <p>
                                    <label>Image license page (<code>license</code>)</label><br>
                                    <input type="url" name="w3p_image_license_url" class="regular-text" placeholder="https://" value="<?php echo get_option( 'w3p_image_license_url' ); ?>">
                                    <br><small>A license document that applies to images, typically indicated by URL.</small>
                                </p>
                                <p>
                                    <label>Image license purchase page (<code>acquireLicensePage</code>, optional)</label><br>
                                    <input type="url" name="w3p_image_acquire_license_url" class="regular-text" placeholder="https://" value="<?php echo get_option( 'w3p_image_acquire_license_url' ); ?>">
                                    <br><small>Indicates a page documenting how image licenses can be purchased or otherwise acquired, for the current item.</small>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <hr>
                <p><input type="submit" name="info_update1" class="button button-primary" value="<?php _e( 'Save Changes', 'wp-perfect-plugin' ); ?>"></p>
            </form>
            <?php
        } elseif ( (string) $tab === 'clustering' ) {
            if ( isset( $_POST['info_update1'] ) && current_user_can( 'manage_options' ) ) {
                update_option( 'w3p_topic_clustering', (int) $_POST['w3p_topic_clustering'] );
                update_option( 'w3p_schema_breadcrumbs', (int) $_POST['w3p_schema_breadcrumbs'] );

                if ( (int) $_POST['w3p_topic_clustering'] === 1 ) {
                    update_option( 'permalink_structure', '/%category%/%postname%/' );
                    update_option( 'category_base', 'category' );

                    flush_rewrite_rules();
                }

                echo '<div class="updated notice is-dismissible"><p>Settings updated!</p></div>';
            }
            ?>
            <form method="post" action="">
                <h3>Topic Clustering</h3>

                <h4>Prerequisites</h4>
                <p>Topic clustering requires the following changes to your website's structure:</p>
                <ol>
                    <li>Permalinks changed to <code>/%category%/%postname%/</code></li>
                    <li>Category base changed to <code>category</code> (or not empty)</li>
                    <li>Schema-enabled breadcrumbs on posts and pages</li>
                </ol>

                <p><b>Note:</b> If you want both category and subcategory to appear in the URL and permalink, only assign a child category, otherwise, if you pick both parent and child categories, then it will show the parent only in the URL and permalink.</p>

                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row" colspan="2">
                                <h3>Permalinks</h3>
                            </th>
                        </tr>
                        <tr>
                            <th scope="row"><label>Topic Clustering</label></th>
                            <td>
                                <p>
                                    <input name="w3p_topic_clustering" id="w3p_topic_clustering" type="checkbox" value="1" <?php checked( 1, (int) get_option( 'w3p_topic_clustering' ) ); ?>> <label for="w3p_topic_clustering">Enable topic clustering enhancements</label>
                                    <br><small><b>Note:</b> This option will change your permalinks to <code>/%category%/%postname%/</code> and it will make sure posts are 301 redirected to their updated category permalinks.</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label>Breadcrumbs</label></th>
                            <td>
                                <p>
                                    <input name="w3p_schema_breadcrumbs" id="w3p_schema_breadcrumbs" type="checkbox" value="1" <?php checked( 1, (int) get_option( 'w3p_schema_breadcrumbs' ) ); ?>> <label for="w3p_schema_breadcrumbs">Enable Schema breadcrumbs</label>
                                    <br><small>This option will add breadcrumbs before content for posts and pages.</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"></th>
                            <td>
                                <p>
                                    <input type="submit" name="info_update1" class="button button-primary" value="<?php _e( 'Save Changes', 'wp-perfect-plugin' ); ?>">
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <?php
        } elseif ( (string) $tab === 'meta' ) {
            ?>
            <h3>Meta Report</h3>

            <table data-replace="jtable" data-search="true" data-locale="en">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>SEO Title</th>
                        <th>SEO Description (excerpt)</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                $all_page_ids = get_posts(
                    [
                        'fields'         => 'ids',
                        'posts_per_page' => -1,
                        'post_type'      => 'page',
                    ]
                );

                foreach ( $all_page_ids as $page_id ) {
                    echo '<tr>
                        <td><small><code>' . $page_id . '</code></small></td>
                        <td>
                            <b>' . get_the_title( $page_id ) . '</b>
                            <br><small><a href="' . get_permalink( $page_id ) . '">' . get_permalink( $page_id ) . '</a></small>
                            <br>
                            <a href="' . get_permalink( $page_id ) . '">View</a>
                            <a href="' . admin_url( 'post.php?post=' . $page_id . '&action=edit' ) . '">Edit</a>
                        </td>
                        <td>' .
                            get_post_meta( $page_id, '_w3p_title', true );

                            if ( (int) get_option( 'w3p_enable_yoast_migrator' ) === 1 ) {
                                echo '<br><small><b>Yoast Migrator:</b> ' . get_post_meta( $page_id, '_yoast_wpseo_title', true ) . '</small>';
                            }

                        echo '</td>
                        <td>' .
                            w3p_get_excerpt( $page_id );

                            if ( (int) get_option( 'w3p_enable_yoast_migrator' ) === 1 ) {
                                echo '<br><small><b>Yoast Migrator:</b> ' . get_post_meta( $page_id, '_yoast_wpseo_metadesc', true ) . '</small>';
                            }

                        echo '</td>
                    </tr>';
                }
                ?>

                </tbody>
            </table>

            <?php
        } elseif ( (string) $tab === 'meta-posts' ) {
            ?>
            <h3>Meta Report</h3>

            <table data-replace="jtable" data-search="true" data-locale="en">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>SEO Title</th>
                        <th>SEO Description (excerpt)</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                $all_page_ids = get_posts(
                    [
                        'fields'         => 'ids',
                        'posts_per_page' => -1,
                        'post_type'      => 'post',
                    ]
                );

                foreach ( $all_page_ids as $page_id ) {
                    echo '<tr>
                        <td><small><code>' . $page_id . '</code></small></td>
                        <td>
                            <b>' . get_the_title( $page_id ) . '</b>
                            <br><small><a href="' . get_permalink( $page_id ) . '">' . get_permalink( $page_id ) . '</a></small>
                            <br>
                            <a href="' . get_permalink( $page_id ) . '">View</a>
                            <a href="' . admin_url( 'post.php?post=' . $page_id . '&action=edit' ) . '">Edit</a>
                        </td>
                        <td>' .
                            get_post_meta( $page_id, '_w3p_title', true );

                            if ( (int) get_option( 'w3p_enable_yoast_migrator' ) === 1 ) {
                                echo '<br><small><b>Yoast Migrator:</b> ' . get_post_meta( $page_id, '_yoast_wpseo_title', true ) . '</small>';
                            }

                        echo '</td>
                        <td>' .
                            w3p_get_excerpt( $page_id );

                            if ( (int) get_option( 'w3p_enable_yoast_migrator' ) === 1 ) {
                                echo '<br><small><b>Yoast Migrator:</b> ' . get_post_meta( $page_id, '_yoast_wpseo_metadesc', true ) . '</small>';
                            }

                        echo '</td>
                    </tr>';
                }
                ?>

                </tbody>
            </table>

            <?php
        } elseif ( (string) $tab === 'links' ) {
            include 'w3p-settings-links.php';
        }
        ?>
    </div>
    <?php
}
