import "../lib/slick/slick.min"


$('.js-slider > .elementor-container > .elementor-column > .elementor-widget-wrap').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    autoplay: true,
    autoplaySpeed: 4000,
    pauseOnHover: false,
    pauseOnFocus: false,
});

$('body').on('click', '.enquiry-button', function(e){
    e.preventDefault();

    const wrapper    = $(this).closest('.enquiry-box');
    const product_id = $(this).data('product-id');
    const quantity   = parseInt(wrapper.find('.enquiry-qty-input').val(), 10) || 1;

    $.post(wc_add_to_cart_params.ajax_url, {
        action: 'add_product_to_enquiry',
        product_id: product_id,
        quantity: quantity
    }, function(res){
        if (res.success) {
            alert("Product added to enquiry cart.");
        } else {
            alert("Failed to add product to enquiry cart.");
        }
    });
})


.on('change', '.enquiry-qty', function(){
    $.post(wc_add_to_cart_params.ajax_url, {
        action: 'update_enquiry_item',
        product_id: $(this).data('product-id'),
        quantity: $(this).val()
    });
})

.on('click', '.remove-enquiry-item', function(e){
    e.preventDefault();

    const row = $(this).closest('tr');

    $.post(wc_add_to_cart_params.ajax_url, {
        action: 'update_enquiry_item',
        product_id: $(this).data('product-id'),
        quantity: 0
    }, function(){
        row.remove();
    });
})

.on('submit', '#enquiry-checkout-form', function (e) {
    e.preventDefault();

    const form = $(this);

    form.find('.enquiry-submit').prop('disabled', true);
    form.find('.enquiry-loading').show();

    $.post(wc_add_to_cart_params.ajax_url, {
        action: 'submit_enquiry_checkout',
        nonce: form.find('input[name="enquiry_nonce"]').val(),
        customer_name: form.find('[name="customer_name"]').val(),
        customer_email: form.find('[name="customer_email"]').val(),
        customer_message: form.find('[name="customer_message"]').val()
    }, function (res) {
        if (res.success) {
            form.replaceWith(
                '<p class="woocommerce-message">Enquiry submitted successfully.</p>'
            );
            setTimeout(function () {
                window.location.href = '/';
            }, 1500);
        } else {
            console.log(res);
            form.find('.enquiry-submit').prop('disabled', false);
            form.find('.enquiry-loading').hide();
        }
    }).fail(function () {
        form.find('.enquiry-submit').prop('disabled', false);
        form.find('.enquiry-loading').hide();
    });
});