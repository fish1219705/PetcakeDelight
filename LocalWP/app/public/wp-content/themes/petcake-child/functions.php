<?php
// 載入父主題和子主題樣式
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_uri());
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css');
});


// 在 WooCommerce 單一商品頁中加入圖片上傳欄位
add_action('woocommerce_before_add_to_cart_button', 'add_pet_photo_upload_field');
function add_pet_photo_upload_field() {
    echo '<div class="pet-photo-field"><label for="pet_photo"> Upload a pet photo (JPG/PNG, Max 5MB)</label><input type="file" name="pet_photo" accept=".jpg,.jpeg,.png" required></div>';
}

// // 驗證上傳欄位
// add_filter('woocommerce_add_to_cart_validation', 'validate_pet_photo_upload', 10, 3);
// function validate_pet_photo_upload($passed, $product_id, $quantity) {
//     if (!isset($_FILES['pet_photo']) || $_FILES['pet_photo']['error'] != 0) {
//         wc_add_notice('請上傳一張寵物照片（jpg/png）', 'error');
//         return false;
//     }
//     return $passed;
// }

// 將上傳的圖片加入到購物車項目資料
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

// 在購物車和結帳頁顯示圖片連結
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

// 將圖片連結儲存到訂單項目
add_action('woocommerce_add_order_item_meta', 'save_pet_photo_to_order_items', 10, 3);
function save_pet_photo_to_order_items($item_id, $values, $cart_item_key) {
    if (isset($values['pet_photo_url'])) {
        wc_add_order_item_meta($item_id, 'pet_photo_url', $values['pet_photo_url']);
    }
}

// 在後台訂單中顯示圖片連結
add_action('woocommerce_before_order_itemmeta', 'display_pet_photo_in_admin', 10, 3);
function display_pet_photo_in_admin($item_id, $item, $product) {
    $photo_url = wc_get_order_item_meta($item_id, 'pet_photo_url');
    if ($photo_url) {
        echo '<p><strong>Pet Photo:</strong> <a href="' . esc_url($photo_url) . '" target="_blank">Photo uploaded!</a></p>';
    }
}

