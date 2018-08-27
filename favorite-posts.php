<?php
/*
 * Plugin Name: Favorites posts
 * Plugin URI: https://wordpress/plugin
 * Description: Authorized user can add posts to favorites
 * Version: 1.1.1
 * Author: vk
 * License: GPLv2 or later
 */

require __DIR__ . '/functions.php';
require __DIR__ . '/favorites_widget.php';

add_filter('the_content', 'favorites_content');
add_action('wp_enqueue_scripts','favorites_scripts');
add_action('wp_ajax_add', 'wp_ajax_add');
add_action('wp_ajax_delete', 'wp_ajax_delete');
add_action('wp_ajax_delete_all', 'wp_ajax_delete_all');
add_action('wp_dashboard_setup', 'favorites_dashboard_widget');
add_action('admin_enqueue_scripts', 'favorites_admin_scripts');
add_action('widgets_init', 'favorites_widget');
function favorites_widget() {
	register_widget('Favorites_Widget');
}