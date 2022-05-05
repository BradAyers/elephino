<?php

/* Create DB table for this plugin (is this firing every time?  I may need to
/* place it in a conditional that only executes if there is not table) */
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

// Function to register plugin specific styles & scripts when init fired
function register_elph_scripts() {
  // register CSS
  wp_register_style( 'bootstrap_style', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'); // Bootstrap CSS
  wp_register_style( 'datepicker_style', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css'); // Datepicker CSS
  wp_register_style( 'elph_style', plugins_url( '/includes/elph-style.css', __FILE__ ) ); // PDF Upload plugin CSS

  // register JQuery (Since my JS test indicated jquery ISN'T already loaded by this WP Twenty Twenty-One theme)
  wp_register_script( 'jquery_3.2.1_script', 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'); // DELETE unless this absolutely has to stay here

  // register JS
  wp_register_script( 'bootstrap_script', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'); // Bootstrap JS
  wp_register_script( 'datepicker_script', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js'); // Datepicker JS
  wp_register_script( 'ajax_script', plugins_url( '/ajax_script.js', __FILE__ ) ); // AJAX JS
}

// Function to enqueue plugin specific styles and scripts when plugin page is loaded
function enqueue_scripts_onpageload() {
  $page_list = array('Newsletter Upload Sandbox', 43); // pages that will need to enqueue scripts
  if ( is_page( $page_list ) ) {
    // enqueue CSS
    wp_enqueue_style( 'bootstrap_style' ); // Bootstrap CSS
    wp_enqueue_style( 'datepicker_style' ); // Datepicker CSS
    wp_enqueue_style( 'elph_style' ); // currently PDF Upload plugin CSS

    // enqueue JQuery (Since my JS test indicated jquery ISN'T already loaded by this WP Twenty Twenty-One theme)
    wp_enqueue_script( 'jquery_3.2.1_script' ); // DELETE unless this absolutely has to stay here

    // enqueue JS
    wp_enqueue_script( 'bootstrap_script' ); // Bootstrap JS
    wp_enqueue_script( 'datepicker_script' ); // Datepicker JS
    wp_enqueue_script( 'ajax_script', $in_footer = true ); // Ajax JS
  }
}

// When shortcode 'elph_news_upload' is called this function ads upload form
function elph_news_load() {
  include_once( ABSPATH . 'wp-content/plugins/newsletter-upload/includes/elph_upload_form.php' );
}

// Adds "Upload News" admin page to WP Dashboard
function elph_upload_admin() {
  add_menu_page( 'Upload News', 'Upload News', 'manage_options', 'pdf-upload', 'test_init' );
}

// Functions below add the Upload News functionality to the WP Dashboard
function test_init(){
    test_handle_post();
?>
    <h2>Upload PDF Newsletter</h2>
    <!-- Form to handle the upload - The enctype value here is very important -->
    <form  method="post" enctype="multipart/form-data">
        <input type='file' id='test_upload_pdf' name='test_upload_pdf' />
        <input type='submit' value='Upload PDF Newsletter' />
    </form>
<?php
}

function test_handle_post(){
    // First check if the file appears on the _FILES array
    if(isset($_FILES['test_upload_pdf'])){
        $pdf = $_FILES['test_upload_pdf'];

        /*Use the wordpress function to upload
        * test_upload_pdf corresponds to the position in the $_FILES array
        * 0 means the content is not associated with any other posts
        */
        $uploaded=media_handle_upload('test_upload_pdf', 0);
        // Error checking using WP functions
        if(is_wp_error($uploaded)){
            echo "Error uploading file: " . $uploaded->get_error_message();
        }else{
            echo "File upload successful!";
        }
    }
}
// Functions above add the Upload News functionality to the WP Dashboard

// THis is just ot test AJAS
function my_action() {
  echo 'Ajax call output:';

  echo '<pre>';
  var_dump($_POST);
  echo "<script>console.log('Don\'t fight it and make yourself at home ...');</script>";
  echo '</pre>';

  wp_die();
}