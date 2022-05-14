<?php

/**
 * Create DB table for this plugin >>? (is this firing every time?  I may need to
 * place it in a conditional that only executes if there is not table). Also, can
 * this code be placed in an "install.php" file to only be called on install ?<<
 */
global $elph_db_version;
$elph_db_version = '1.0';

// Function to install DB table
function elph_install() {
    global $wpdb;
    global $elph_db_version;

    $table_name = $wpdb->prefix . 'newsletters';

    $charset_collate = $wpdb->get_charset_collate();

    // Check to see if the table exists already, if not, then create it
    if($wpdb->get_var( "show tables like '$table_name'" ) != $table_name) {
        $sql = "CREATE TABLE `". $table_name . "` (
              id int(9) NOT NULL AUTO_INCREMENT,
              timestamp datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
              userid int(9) NOT NULL,
              username varchar(100) NOT NULL DEFAULT '',
              org varchar(100) NOT NULL,
              orgnum varchar(100) NOT NULL,
              file_path varchar(100) NOT NULL,
              file_name varchar(100) NOT NULL,
              senddate varchar(100) NOT NULL DEFAULT '',
              action varchar(100) NOT NULL DEFAULT '',
              PRIMARY KEY  (id)
        ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    add_option( 'elph_db_version', $elph_db_version );
    }
}

/**
 * Enqueue the plugin specific scripts.
 */

function elph_enqueue_scripts() {

    /**
     * Only load scripts in pages that contain the shortcode [elph_news_upload]
     * >>? Is there a method that sniffs for the pages containing this shortcode so
     * that $page_list can dynamically construct this array ?<<
     */

    //$page_list = array('Newsletter Upload Sandbox', 43); // pages that will need to enqueue scripts

    global $post;

    //if ( is_page( $page_list ) ) {
    if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'elph_news_upload') ) {

        wp_enqueue_style(
            'bootstrap-style',
            'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'
        );

        wp_enqueue_style(
            'datepicker-style',
            'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css',
        );

        wp_enqueue_style( // newsletter-upload CSS
            'elph-style',
            plugins_url( '/includes/elph-style.css', __FILE__ )
        );

        /**
         * Enqueue JQuery (Since my JS test indicated jquery ISN'T already loaded by
         * WP Twenty Twenty-One theme). DELETE unless this ABSOLUTELY has to stay
         */
        wp_enqueue_script(
            'jquery-3.2.1-script',
            'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js',
            array( 'jquery' ),
            false,
            true
        );

        wp_enqueue_script(
            'bootstrap-script',
            'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
            '',
            false,
            true
        );

        wp_enqueue_script(
            'datepicker-script',
            'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js',
            '',
            false,
            true
        );
    }
}

// When shortcode 'elph_news_upload' is called this function adds upload form
function elph_news_load() {
    include_once( ABSPATH . 'wp-content/plugins/newsletter-upload/includes/elph-upload-form.php' );
}

/**
 * Admin functions for the WP Dashboard
 */

function elph_upload_admin() {
    add_menu_page( 'Upload News', 'Upload News', 'manage_options', 'pdf-upload', 'elph_admin_page' );
}

//
function elph_admin_page() {
    elph_handle_post();
    ?>
    <h2>Upload PDF Newsletter</h2>
    <!-- Form to handle the upload - The enctype value here is very important -->
    <form  method="post" enctype="multipart/form-data">
        <input type='file' id='elph_upload_pdf' name='elph_upload_pdf' />
        <input type='submit' value='Upload PDF Newsletter' />
    </form>
    <?php
}

function elph_handle_post() {
    // First check if the file appears on the _FILES array
    if ( isset( $_FILES['elph_upload_pdf'] ) ) {
        $pdf = $_FILES['elph_upload_pdf'];

        /**
         * Use the Wordpress function to upload
         * elph_upload_pdf corresponds to the position in the $_FILES array
         * 0 means the content is not associated with any other posts
         */
        $uploaded=media_handle_upload('elph_upload_pdf', 0);
        // Error checking using WP functions
        if (is_wp_error($uploaded)){
            echo "Error uploading file: " . $uploaded->get_error_message();
        } else {
            echo "File upload successful!";
        }
    }
}

/**
 * Functions that could be loaded after "Upload" is clicked and may want to move
 * these to a separate file i.e "upload_functions"
 */