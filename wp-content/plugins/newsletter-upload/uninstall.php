<?php

// If uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

$option_name = 'newsletter-upload';

delete_option($option_name);

// For site options in Multisite
delete_site_option($option_name);

// Drop custom database table
global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}newsletters");

?>
