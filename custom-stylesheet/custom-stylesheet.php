<?php
/**
* Plugin Name:  Custom Stylesheet
* Description:  A simple plugin to upload, edit and enqueue a custom stylesheet
* Plugin URI:   https://www.utk.edu
* Author:       UT OCM
* Version:      1.0
* Text Domain:  custom_stylesheet
* Domain Path:  /languages
* License:      GPL v2 or later
* License URI:  https://www.gnu.org/licenses/gpl-2.0.txt
**/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include plugin dependencies
require_once plugin_dir_path( __FILE__ ) . 'admin/admin-menu.php';
require_once plugin_dir_path( __FILE__ ) . 'admin/settings-page.php';
require_once plugin_dir_path( __FILE__ ) . 'admin/stylesheet-actions.php';
