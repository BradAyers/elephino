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

include_once ( ABSPATH . 'wp-content/plugins/newsletter-upload/functions.php' );

// Create DB table when plugin is activated
register_activation_hook( __FILE__, 'elph_install' );

// El_Stylo Function that applies to Upload form
function elph_head() {
  ?>
  <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Local Fallback -->
    <script type="text/javascript">
    if (typeof jQuery == 'undefined') {
        document.write(unescape("%3Cscript src='assets/js/jquery_3.2.1_jquery.min.js' type='text/javascript'%3E%3C/script%3E"));
    }
    </script>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Local Fallback -->
    <script>
    if (!$.fn.modal) {
        document.write(unescape("%3Cscript src='assets/js/bootstrap_3.3.7.min.js' type='text/javascript'%3E%3C/script%3E"));
        document.write(unescape("%3Clink rel='stylesheet' href='assets/css/bootstrap_3.3.7.min.css' type='text/css'%3E"));
    }
    </script>

    <!-- Datepicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <!-- Local Fallback -->
    <script>
    if (!$('#user-date').data('datepicker')) {
        document.write(unescape("%3Cscript src='assets/js/bootstrap-datepicker_1.9.0.min.js' type='text/javascript'%3E%3C/script%3E"));
        document.write(unescape("%3Clink rel='stylesheet' href='assets/css/bootstrap-datepicker_1.9.0.min.css' type='text/css'%3E"));
    }
    </script>

    <!-- Google Icons (Remove these if not using) -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Gloria+Hallelujah&family=Indie+Flower&display=swap" rel="stylesheet">

    <!-- Local style and script -->
    <link rel="stylesheet" href="http://localhost/mysites/index/css/style.css"/>
    <script type="text/javascript" src="assets/js/script.js"></script>
  <?php
}

add_action( 'wp_head', 'elph_head' );


function elph_news_load() {






  include_once 'includes/elph_upload_form.php';
  //return "<h2>Otra vez, por favor!</h2>";
}

// Add shortcode to insert upload form in page
add_shortcode('elph_news_upload', 'elph_news_load');
