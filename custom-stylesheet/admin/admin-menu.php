<?php // Custom Stylesheet Admin Menu

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Register the settings page.
add_action('admin_menu', function () {
    add_menu_page(
        'Custom Stylesheet',
        'Custom Stylesheet',
        'manage_options',
        'custom-stylesheet',
        'render_custom_stylesheet_page',
        'dashicons-admin-customizer',
        null
    );
});