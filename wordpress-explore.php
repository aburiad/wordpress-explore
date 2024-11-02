<?php
/*
Plugin Name: Wordpress Learn
Plugin URI: https://example.com
Description: A simple example of creating a custom REST API route.
text-domain: learn.
Version: 1.0
Author: Abu Riad
Author URI: https://example.com
License: GPLv2 or later
*/

if (!defined('ABSPATH')) {
    exit;
}

if (!defined('WP_MY_PLUGIN_DIR')) {
    define('WP_MY_PLUGIN_DIR', plugin_dir_path(__FILE__));
}
if (!defined('WP_MY_PLUGIN_DIR')) {
    define('WP_MY_PLUGIN_DIR', plugin_dir_url(__FILE__));
}
if (!defined('WP_MY_VERSION')) {
    define('WP_MY_VERSION', '1.0');
}

function plugin_load()
{
    require_once WP_MY_PLUGIN_DIR . 'topics/wp-column-management/column-management.php';

}

add_action('plugins_loaded', 'plugin_load');