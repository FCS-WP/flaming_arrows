<?php

add_action('wp_ajax_add_product_to_enquiry', 'add_product_to_enquiry');
add_action('wp_ajax_nopriv_add_product_to_enquiry', 'add_product_to_enquiry');

function add_product_to_enquiry() {
    if ( ! isset($_POST['product_id']) ) {
        wp_send_json_error('Missing product_id');
    }

    $product_id = absint($_POST['product_id']);
    $quantity   = isset($_POST['quantity']) ? absint($_POST['quantity']) : 1;

    if ( ! WC()->session ) {
        wc_load_cart();
    }

    $enquiry = WC()->session->get('enquiry_products', []);

    if ( isset($enquiry[$product_id]) ) {
        $enquiry[$product_id] += $quantity;
    } else {
        $enquiry[$product_id] = $quantity;
    }

    WC()->session->set('enquiry_products', $enquiry);

    wp_send_json_success($enquiry);
}

add_action('wp_ajax_update_enquiry_item', 'update_enquiry_item');
add_action('wp_ajax_nopriv_update_enquiry_item', 'update_enquiry_item');

function update_enquiry_item() {
    if ( ! WC()->session ) {
        wc_load_cart();
    }

    $product_id = absint($_POST['product_id'] ?? 0);
    $quantity   = absint($_POST['quantity'] ?? 0);

    $enquiry = WC()->session->get('enquiry_products', []);

    if ( $product_id && isset($enquiry[$product_id]) ) {
        if ( $quantity > 0 ) {
            $enquiry[$product_id] = $quantity;
        } else {
            unset($enquiry[$product_id]);
        }
        WC()->session->set('enquiry_products', $enquiry);
    }

    wp_send_json_success();
}



add_action('woocommerce_after_single_product_summary', 'add_enquiry_quantity_and_button', 15);

function add_enquiry_quantity_and_button() {
    if ( ! is_product() ) return;

    global $product;
    if ( ! $product ) return;
    ?>
    <div class="enquiry-box">
        <input
            type="number"
            id="enquiry_qty"
            class="enquiry-qty-input"
            min="1"
            value="1">

        <button
            type="button"
            class="button enquiry-button"
            data-product-id="<?php echo esc_attr($product->get_id()); ?>">
            Enquiry
        </button>
    </div>
    <?php
}





add_shortcode('enquiry_cart', 'render_enquiry_cart_shortcode');

function render_enquiry_cart_shortcode() {
    if ( ! WC()->session ) {
        wc_load_cart();
    }

    $enquiry = WC()->session->get('enquiry_products', []);

    if ( empty($enquiry) ) {
        return '<p class="cart-empty">No products in enquiry.</p>';
    }

    ob_start();
    ?>
    <form class="woocommerce-cart-form enquiry-cart-form">
        <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents">
            <thead>
                <tr>
                    <th class="product-remove">&nbsp;</th>
                    <th class="product-thumbnail">&nbsp;</th>
                    <th class="product-name"><?php esc_html_e('Product'); ?></th>
                    <th class="product-quantity"><?php esc_html_e('Quantity'); ?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($enquiry as $product_id => $qty):
                $product = wc_get_product($product_id);
                if (!$product) continue;
            ?>
                <tr>
                    <td class="product-remove">
                        <a href="#" class="remove remove-enquiry-item" data-product-id="<?php echo esc_attr($product_id); ?>">&times;</a>
                    </td>
                    <td class="product-thumbnail"><?php echo $product->get_image('woocommerce_thumbnail'); ?></td>
                    <td class="product-name"><?php echo esc_html($product->get_name()); ?></td>
                    <td class="product-quantity">
                        <input type="number" min="1" class="input-text qty text enquiry-qty"
                               data-product-id="<?php echo esc_attr($product_id); ?>"
                               value="<?php echo esc_attr($qty); ?>">
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <div class="enquiry-cart-actions">
            <a href="<?php echo esc_url(site_url('/enquiry-checkout')); ?>"
               class="button enquiry-now-button">
                Enquiry Now
            </a>
        </div>
    </form>
    <?php
    return ob_get_clean();
}


add_shortcode('enquiry_checkout', 'render_enquiry_checkout_shortcode');

function render_enquiry_checkout_shortcode() {
    if ( ! WC()->session ) {
        wc_load_cart();
    }

    $enquiry = WC()->session->get('enquiry_products', []);

    if ( empty($enquiry) ) {
        return '<p class="cart-empty">Your enquiry list is empty.</p>';
    }

    ob_start();
    ?>
    <form class="enquiry-checkout-form" id="enquiry-checkout-form" method="post">
        <?php wp_nonce_field('submit_enquiry', 'enquiry_nonce'); ?>

        <h3>Enquiry Products</h3>
        <table class="shop_table cart">
            <thead>
                <tr>
                    <th><?php esc_html_e('Product'); ?></th>
                    <th><?php esc_html_e('Quantity'); ?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($enquiry as $product_id => $qty):
                $product = wc_get_product($product_id);
                if ( ! $product ) continue;
            ?>
                <tr>
                    <td><?php echo esc_html($product->get_name()); ?></td>
                    <td><?php echo esc_html($qty); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Customer Information</h3>

        <p class="form-row">
            <label>Customer Name *</label>
            <input type="text" name="customer_name" required>
        </p>

        <p class="form-row">
            <label>Customer Email *</label>
            <input type="email" name="customer_email" required>
        </p>

        <p class="form-row">
            <label>Message</label>
            <textarea name="customer_message" rows="5"></textarea>
        </p>

        <button type="submit" name="submit_enquiry" class="button enquiry-submit">
            Enquire
        </button>
        <div class="enquiry-loading" style="display:none;">
            Processing enquiry…
        </div>
    </form>
    <?php
    return ob_get_clean();
}


add_action('wp_ajax_submit_enquiry_checkout', 'submit_enquiry_checkout_api');
add_action('wp_ajax_nopriv_submit_enquiry_checkout', 'submit_enquiry_checkout_api');

function submit_enquiry_checkout_api() {
    check_ajax_referer('submit_enquiry', 'nonce');

    if ( ! WC()->session ) {
        wc_load_cart();
    }

    $enquiry = WC()->session->get('enquiry_products', []);
    if ( empty($enquiry) ) {
        wp_send_json_error('Enquiry is empty');
    }

    $customer_name  = sanitize_text_field($_POST['customer_name'] ?? '');
    $customer_email = sanitize_email($_POST['customer_email'] ?? '');
    $message        = sanitize_textarea_field($_POST['customer_message'] ?? '');

    if ( empty($customer_name) || empty($customer_email) ) {
        wp_send_json_error('Missing required fields');
    }

    // Create order
    $order = wc_create_order();

    foreach ($enquiry as $product_id => $qty) {
        $product = wc_get_product($product_id);
        if ($product) {
            $order->add_product($product, $qty);
        }
    }

    $order->set_billing_first_name($customer_name);
    $order->set_billing_email($customer_email);

    if ($message) {
        $order->update_meta_data('_enquiry_message', $message);
    }

    // Pending enquiry
    $order->set_status('pending');
    $order->calculate_totals();
    $order->save();

    // ===== SEND EMAIL =====
    WC()->mailer()->emails['WC_Email_New_Order']->trigger($order->get_id());
    WC()->mailer()->emails['WC_Email_Customer_Processing_Order']->trigger($order->get_id());

    // Clear session
    WC()->session->__unset('enquiry_products');

    wp_send_json_success([
        'order_id' => $order->get_id()
    ]);
}


add_action('woocommerce_email_after_order_table', 'show_enquiry_message_in_email', 10, 4);

function show_enquiry_message_in_email($order, $sent_to_admin, $plain_text, $email) {
    $message = $order->get_meta('_enquiry_message');
    if ( ! $message ) return;

    if ( $plain_text ) {
        echo "\nEnquiry Message:\n" . $message . "\n";
    } else {
        echo '<p><strong>Enquiry Message:</strong><br>' . nl2br(esc_html($message)) . '</p>';
    }
}


add_action('woocommerce_admin_order_data_after_billing_address', 'show_enquiry_message_in_admin');

function show_enquiry_message_in_admin($order) {
    $message = $order->get_meta('_enquiry_message');
    if ( ! $message ) return;
    ?>
    <div class="order_data_column">
        <h4>Enquiry Message</h4>
        <p><?php echo nl2br(esc_html($message)); ?></p>
    </div>
    <?php
}
