<?php

// Create DB table for this plugin
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
