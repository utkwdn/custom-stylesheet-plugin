<?php // Custom Stylesheet Settings Page

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Render the settings page with conditional file upload and editing capabilities
function render_custom_stylesheet_page() {

    // Check if user is allowed access
	if ( ! current_user_can( 'manage_options' ) ) return;

    $plugin_dir = plugin_dir_path(__DIR__);
    $stylesheet_path = $plugin_dir . 'public/css/custom-stylesheet.css';
    $stylesheet_url = plugin_dir_url(__FILE__) . 'public/css/custom-stylesheet.css';
    $stylesheet_content = '';

    // Check if the file exists and load its contents
    $file_exists = file_exists($stylesheet_path);
    if ($file_exists) {
        $stylesheet_content = file_get_contents($stylesheet_path);
    }

    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

        <?php if ($file_exists): ?>
            <!-- File Editor Section -->
            <form method="post">
                <?php wp_nonce_field('stylesheet_edit_action', 'stylesheet_edit_nonce'); ?>
                <h2>Edit Stylesheet</h2>
                <textarea name="stylesheet_content" rows="20" style="width: 100%;"><?php echo esc_textarea($stylesheet_content); ?></textarea>
                <?php submit_button('Save Changes'); ?>
            </form>
        <?php else: ?>
            <!-- File Upload Section -->
            <form method="post" enctype="multipart/form-data">
                <?php wp_nonce_field('stylesheet_upload_action', 'stylesheet_upload_nonce'); ?>
                <h2>Upload a New Stylesheet</h2>
                <input type="file" name="custom_stylesheet" accept=".css" />
                <?php submit_button('Upload Stylesheet'); ?>
            </form>
        <?php endif; ?>
    </div>
    <?php
}