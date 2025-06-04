<?php

// child theme

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_uri());
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css');
});


// Date Picker 
add_action('woocommerce_before_add_to_cart_button', 'add_custom_datepicker_field');

function add_custom_datepicker_field() {
    echo '<div class="custom-date-picker">';
    echo '<label for="custom_date">Choose a preferred date for your cake:</label>';
    echo '<input type="text" id="custom_date" name="custom_date" class="datepicker" required>';
    echo '</div>';

    // jQuery UI datepicker
    ?>
    <script>
        jQuery(function($){
            $("#custom_date").datepicker({
                dateFormat: 'yy-mm-dd',
                minDate: 1,
                showAnim: "fadeIn"
            });
        });
    </script>

    <style>
        .custom-date-picker {
            margin-top: 20px;
            margin-bottom: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .custom-date-picker label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        #custom_date {
            width: 100%;
            max-width: 280px;
            padding: 10px 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        #custom_date:focus {
            border-color: #ff8fa3;
            outline: none;
            box-shadow: 0 0 5px rgba(255, 143, 163, 0.5);
        }

        .ui-datepicker {
            font-size: 14px;
            padding: 10px;
        }
    </style>
    <?php
}

// add the date to shopping cart data
add_filter('woocommerce_add_cart_item_data', 'save_custom_datepicker_data', 10, 2);
function save_custom_datepicker_data($cart_item_data, $product_id) {
    if(isset($_POST['custom_date'])) {
        $cart_item_data['custom_date'] = sanitize_text_field($_POST['custom_date']);
    }
    return $cart_item_data;
}
// Display on cart and checkout pages
add_filter('woocommerce_get_item_data', 'display_custom_datepicker_data', 10, 2);
function display_custom_datepicker_data($item_data, $cart_item) {
    if(isset($cart_item['custom_date'])) {
        $item_data[] = array(
            'name' => 'date for cake order',
            'value' => $cart_item['custom_date']
        );
    }
    return $item_data;
}

// Save custom date to order
add_action('woocommerce_add_order_item_meta', 'save_custom_datepicker_to_order', 10, 3);
function save_custom_datepicker_to_order($item_id, $values, $cart_item_key) {
    if(isset($values['custom_date'])) {
        wc_add_order_item_meta($item_id, 'date for cake order', $values['custom_date']);
    }
}

add_filter('woocommerce_get_item_data', function($item_data, $cart_item) {
    if (isset($cart_item['custom_date'])) {
        $item_data[] = [
            'key'   => __('Preferred Date', 'your-text-domain'),
            'value' => wc_clean($cart_item['custom_date']),
        ];
    }

    return $item_data;
}, 10, 2);

add_filter('woocommerce_add_cart_item_data', function($cart_item_data, $product_id, $variation_id) {
    if (isset($_POST['custom_date'])) {
        $cart_item_data['custom_date'] = sanitize_text_field($_POST['custom_date']);
    }
    return $cart_item_data;
}, 10, 3);


// WooCommerce upload field for pet photo
add_action('woocommerce_before_add_to_cart_button', 'add_pet_photo_upload_field');
function add_pet_photo_upload_field() {
    echo '<div class="pet-photo-field"><label for="pet_photo"> Upload a pet photo (JPG/PNG, Max 5MB)</label><input type="file" name="pet_photo" accept=".jpg,.jpeg,.png" required></div>';
}

// // Validate upload field
// add_filter('woocommerce_add_to_cart_validation', 'validate_pet_photo_upload', 10, 3);
// function validate_pet_photo_upload($passed, $product_id, $quantity) {
//     if (!isset($_FILES['pet_photo']) || $_FILES['pet_photo']['error'] != 0) {
//         wc_add_notice('Please upload a pet photo (jpg/png)', 'error');
//         return false;
//     }
//     return $passed;
// }

// Add uploaded image to cart item data
add_filter('woocommerce_add_cart_item_data', 'save_pet_photo_to_cart_item', 10, 2);
function save_pet_photo_to_cart_item($cart_item_data, $product_id) {
    if (isset($_FILES['pet_photo']) && $_FILES['pet_photo']['error'] == 0) {
        $upload = wp_upload_bits($_FILES['pet_photo']['name'], null, file_get_contents($_FILES['pet_photo']['tmp_name']));
        if (!$upload['error']) {
            $cart_item_data['pet_photo_url'] = $upload['url'];
        }
    }
    return $cart_item_data;
}

// show uploaded image url in cart and checkout
// need to debug this
add_filter('woocommerce_get_item_data', 'display_pet_photo_in_cart', 10, 2);
function display_pet_photo_in_cart($item_data, $cart_item) {
    if (isset($cart_item['pet_photo_url'])) {
        $item_data[] = array(
            'name' => 'pet photo',
            'value' => '<a href="' . esc_url($cart_item['pet_photo_url']) . '" target="_blank">Photo uploaded!</a>',
        );
    }
    return $item_data;
}

// Save uploaded image URL to order item
add_action('woocommerce_add_order_item_meta', 'save_pet_photo_to_order_items', 10, 3);
function save_pet_photo_to_order_items($item_id, $values, $cart_item_key) {
    if (isset($values['pet_photo_url'])) {
        wc_add_order_item_meta($item_id, 'pet_photo_url', $values['pet_photo_url']);
    }
}

// show pet photo url in admin order details
add_action('woocommerce_before_order_itemmeta', 'display_pet_photo_in_admin', 10, 3);
function display_pet_photo_in_admin($item_id, $item, $product) {
    $photo_url = wc_get_order_item_meta($item_id, 'pet_photo_url');
    if ($photo_url) {
        echo '<p><strong>Pet Photo:</strong> <a href="' . esc_url($photo_url) . '" target="_blank">Photo uploaded!</a></p>';
    }
}

