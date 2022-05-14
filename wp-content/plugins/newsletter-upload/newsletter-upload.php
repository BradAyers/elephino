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
 * Enqueue plugin specific scripts and styles
 */
add_action( 'wp_enqueue_scripts', 'elph_enqueue_scripts');

/**
 * Add "Upload News" to WP Admin Dashboard for manually uploading newsletters,
 * making changes to newsletter accounts, and whatever else this evolves to be.
 */
add_action( 'admin_menu', 'elph_upload_admin' );

/**
   * Add [elph_news_upload] shortcode to insert upload form in page
 */
add_shortcode( 'elph_news_upload', 'elph_news_load' );





/* This is just to test AJAX */
//add_action( 'wp_ajax_elph_upload_handler', 'my_enqueue' );
//add_action( 'wp_ajax_nopriv_elph_upload_handler', 'my_enqueue' );

//add_action('wp_head', 'elph_ajaxurl');
/*This is just to test AJAX */

/**
 * Enqueue AJAX script, may need to fold this into other enque rather than have
 * a separate function for this
 */

function elph_enqueue_ajax_script() {
    wp_enqueue_script(
        'elph-ajax',
        plugins_url( '/includes/elph-ajax.js', __FILE__ ),
        array( 'jquery' ),
        '1.0.0',
        true
    );

    $elph_nonce = wp_create_nonce( 'elph_nonce' );

    wp_localize_script(
        'ajax-script',
        'my_ajax_obj',
        array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => $elph_nonce,
        )
    );
}

add_action( 'wp_enqueue_scripts', 'elph_enqueue_ajax_script' );

function elph_upload($data) {
    $month = $_POST['month'];
    $year =  $_POST['year'];

    wp_send_json( esc_html( $month ) );
}

add_action( 'wp_ajax_elph_upload', 'elph_enqueue_ajax_script' );