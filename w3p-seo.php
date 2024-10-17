<?php
/**
 * Plugin Name: W3P SEO
 * Plugin URI: https://getbutterfly.com/wordpress-plugins/w3p-seo/
 * Description: W3P SEO aims to provide advanced options for any web developer. W3P SEO has options for search engines, such as ownership verification, local business JSON-LD data, Open Graph, analytics, header and footer easy code insertion and optimised SEO defaults.
 * Author: Ciprian Popescu
 * Author URI: https://getbutterfly.com/
 * Version: 1.8.1
 * Requires PHP: 7.0
 * Requires CP: 2.0
 * Text Domain: w3p-seo
 *
 * W3P SEO
 * Copyright (C) 2010-2024 Ciprian Popescu (getbutterfly@gmail.com)
 * Copyright (C) 2010-2011 Crunchify (http://crunchify.com/)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'W3P_URL', WP_PLUGIN_URL . '/' . dirname( plugin_basename( __FILE__ ) ) );
define( 'W3P_PATH', plugin_dir_path( __FILE__ ) );
define( 'W3P_VERSION', '1.8.1' );

require 'includes/functions.php';
require 'includes/meta.php';

require 'includes/schema-breadcrumbs.php';

require 'modules/w3p-settings.php';
require 'modules/w3p-list-subpages.php';
require 'modules/w3p-search-console.php';

require 'modules/w3p-image.php';

add_action( 'admin_menu', 'w3p_settings_menu' );

function w3p_settings_menu() {
    add_menu_page( __( 'W3P SEO', 'w3p-seo' ), __( 'W3P SEO', 'w3p-seo' ), 'manage_options', 'w3p', 'w3p_settings', plugins_url( '/assets/images/w3p-logo-mini.svg', __FILE__ ), 88 );
}


register_activation_hook( __FILE__, 'w3p_on_activation' );

function w3p_on_activation() {
    delete_option( 'w3p_sitemap_types' );
    delete_option( 'wot-verification' );
    delete_option( 'w3p_topic_clustering' );
}

function w3p_admin_enqueue_scripts() {
    wp_enqueue_style( 'datatable', plugins_url( 'assets/css/datatable.min.css', __FILE__ ), [], W3P_VERSION );
    wp_enqueue_style( 'ui', plugins_url( 'assets/css/ui.css', __FILE__ ), [], W3P_VERSION );

    wp_enqueue_script( 'datatable', plugins_url( 'assets/js/datatable.min.js', __FILE__ ), [], W3P_VERSION, true );
    wp_enqueue_script( 'ui', plugins_url( 'assets/js/ui.js', __FILE__ ), [ 'datatable' ], W3P_VERSION, true );

    wp_register_script( 'w3p-html5sortable', plugins_url( 'assets/js/html5sortable.js', __FILE__ ), [], W3P_VERSION, true );
}

add_action( 'admin_enqueue_scripts', 'w3p_admin_enqueue_scripts' );
