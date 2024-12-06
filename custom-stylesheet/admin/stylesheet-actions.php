<?php // Custom Stylesheet Actions

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Handle file upload
add_action('admin_init', function () {
    if (
        isset($_POST['stylesheet_upload_nonce']) &&
        wp_verify_nonce($_POST['stylesheet_upload_nonce'], 'stylesheet_upload_action')
    ) {
        if (!empty($_FILES['custom_stylesheet']['name'])) {
            $uploaded_file = $_FILES['custom_stylesheet'];
            $file_type = wp_check_filetype($uploaded_file['name']);
            $max_file_size = 200 * 1024; // 200 KB in bytes

            // Validate file type
            if ($file_type['ext'] === 'css') {
                // Validate file size.
                if ($uploaded_file['size'] > $max_file_size) {
                    add_action('admin_notices', function () {
                        echo '<div class="error"><p>File size exceeds the 200 KB limit. Please upload a smaller file.</p></div>';
                    });
                    return; // Exit early if the file is too large
                }

                $plugin_dir = plugin_dir_path(__DIR__);
                $css_dir = $plugin_dir . 'public/css';

                // Ensure the public/css directory exists
                if (!file_exists($css_dir)) {
                    wp_mkdir_p($css_dir);
                }

                $target_file = $css_dir . '/custom-stylesheet.css';

                if (move_uploaded_file($uploaded_file['tmp_name'], $target_file)) {
                    add_action('admin_notices', function () {
                        echo '<div class="updated"><p>Stylesheet uploaded successfully.</p></div>';
                    });
                } else {
                    add_action('admin_notices', function () {
                        echo '<div class="error"><p>File upload failed.</p></div>';
                    });
                }
            } else {
                add_action('admin_notices', function () {
                    echo '<div class="error"><p>Please upload a valid CSS file.</p></div>';
                });
            }
        }
    }
});

// Handle CSS file editing
add_action('admin_init', function () {
    if (
        isset($_POST['stylesheet_edit_nonce']) &&
        wp_verify_nonce($_POST['stylesheet_edit_nonce'], 'stylesheet_edit_action')
    ) {
        $plugin_dir = plugin_dir_path(__DIR__);
        $stylesheet_path = $plugin_dir . 'public/css/custom-stylesheet.css';

        if (file_exists($stylesheet_path) && isset($_POST['stylesheet_content'])) {
            $new_content = wp_unslash($_POST['stylesheet_content']);
            file_put_contents($stylesheet_path, $new_content);
            add_action('admin_notices', function () {
                echo '<div class="updated"><p>Stylesheet updated successfully.</p></div>';
            });
        } else {
            add_action('admin_notices', function () {
                echo '<div class="error"><p>Failed to update the stylesheet. Make sure it exists and is writable.</p></div>';
            });
        }
    }
});

// Enqueue the uploaded stylesheet
add_action('wp_enqueue_scripts', function () {
    $stylesheet_url = plugin_dir_url(__DIR__) . 'public/css/custom-stylesheet.css';
    if (file_exists(plugin_dir_path(__DIR__) . 'public/css/custom-stylesheet.css')) {
        wp_enqueue_style('custom-stylesheet', $stylesheet_url, [], null);
    }
});