<?php
/*
Plugin Name: Newsletter Upload
Plugin URI: https://elephino.org/
Description: Plugin to upload a PDF newsletter and prepare it for archival.
Version: 1.0
Author: Brad Ayers
Author URI: https://bradayers.com/
License: GPLv2 or later
Text Domain: elephino
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// Define Path to Plugin Directory
if ( ! defined( 'ABSPATH' ) ) {
 exit; // Exit if accessed directly.
}

/**
 * Include the functions.php file that contains the custom coded PDF upload
 * functions. >>> May want to separate into two files: 1) for functions necessary
 * on page load and 2) functions that are only needed when "Upload" is clicked,
 * thus are only loaded on submit. <<<
 */
include_once ( ABSPATH . 'wp-content/plugins/newsletter-upload/functions.php' );

// Create DB table when plugin is activated
register_activation_hook( __FILE__, 'elph_install' );

/**
 * Register any plugin specific scripts and styles when init hook is fired so
 * they're ready for enqueue
 */
add_action( 'init', 'register_elph_scripts' );

// Only enqueue plugin specific scripts and styles on page load
add_action( 'wp_enqueue_scripts', 'enqueue_scripts_onpageload');

/**
 * Add "Upload News" to WP Admin Dashboard for manually uploading newsletters,
 * making changes to newsletter accounts, and whatever else this evolves to be.
 */
add_action('admin_menu', 'elph_upload_admin');

// Add shortcode to insert upload form in page
add_shortcode('elph_news_upload', 'elph_news_load');





/** This is just to test AJAX */
add_action( 'wp_ajax_test_action', 'test_action' );
add_action( 'wp_ajax_nopriv_test_action', 'test_action' );

add_action('wp_head', 'elph_ajaxurl');
/* /This is just to test AJAX */