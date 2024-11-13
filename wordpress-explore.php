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
    require_once WP_MY_PLUGIN_DIR . 'topics/hooks/hooks.php';
}

add_action('plugins_loaded', 'plugin_load');


function admin_menus_callback()
{
    add_menu_page('Rest Api', 'Rest Api', 'manage_options', 'rest-api', 'my_rest_api', 'dashicons-book', 10);

}

add_action('admin_menu', 'admin_menus_callback');

function my_rest_api()
{
    ?>
    <div id="posts"></div>
    <script>
        const postsContainer = document.querySelector('#posts');
        fetch('http://v.local/wp-json/wp/v2/posts/')
            .then(response => response.json())
            .then((data) => {
                mydata(data);
            })
            .catch(error => console.error('Error:', error));

        function mydata(data) {
            data.forEach((data) => {
                let title_tag = document.createElement('h2');
                title_tag.innerText = data.title.rendered
                postsContainer.append(title_tag)
            })
        }
    </script>
    <?php
}