<script>
    // 🛒 Cart submission
    $(document).ready(function () {
        $('#cart-form input').on('keypress', function (e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#add-to-cart').trigger('click'); // optional — trigger AJAX save
            }
        });
        $(document).on('click', '#add-to-cart', function (e) {
            e.preventDefault();
            const isVariantRequired = {{ $product->has_variants ? 'true' : 'false' }};
            const variantId = $('#selected-variant-id').val();
            const quantity = $('#quantity').val() ?? 1;
            console.log(isVariantRequired, variantId, quantity);
            if (cartConditions(quantity, variantId, isVariantRequired)) {
                addToCart();
            }
        });

        function cartConditions(quantity, variantId, isVariantRequired) {
            if (isVariantRequired && !variantId) {
                Toast.fire('Select Variant', 'Please select a valid product variant before adding to cart.', 'warning');
                return;
            }
            if (!quantity || quantity <= 0) {
                Toast.fire('Invalid Quantity', 'Please enter a valid quantity.', 'warning');
                return;
            }
            if (variantId) {
                let stock = $('#stock').val();
                if (stock <= 0) {
                    Toast.fire('Out of Stock', 'The selected variant is currently out of stock.', 'warning');
                    return;
                }
            }
            return true;
        }

        function addToCart() {
            let form = $('#cart-form');
            let formData = new FormData(form[0]);
            disableButtons('#add-to-cart');
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                processData: false,
                contentType: false,
                data: formData,
                success: function (response) {
                    enableButtons('#add-to-cart');
                    console.log(response.data);

                    if (response.success) {
                        Toast.fire({
                            icon: "success",
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#cart-drop').html(''); // Clear existing items
                        // Update cart count in header
                        $('span.cart-count').text(response.data.total_items ?? 0);
                        $('#cart-total-amount').text(`PKR ${response.data.total_amount ?? 0}`);
                        $('#cart-total-items').text(response.data.total_items ?? 0);
                        $('#cart-drop').append(`
                            <a class="pull-left" href="javascript:void(0);">
                                <img class="media-object" id="cart-product-image" src="${response.data.item.product.featured_image}"
                                    alt="image" />
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading cart-product-name" id="cart-product-name">${response.data.item.product.name}</h4>
                                <div class="cart-price">
                                    <span id="cart-product-quantity">${response.data.item.quantity}x</span>
                                    <span id="cart-product-price">${(() => {
                                        const base = parseFloat(response.data.item.product.base_price);
                                        const variant = parseFloat(response?.data?.item?.variant?.price);
                                        return ((isNaN(base) ? 0 : base) + (isNaN(variant) ? 0 : variant)).toFixed(2);
                                    })()}</span>
                                </div>
                                <h5><strong id="cart-product-total">PKR ${(response.data.item.total_price).toFixed(2)}</strong></h5>
                            </div>

                        `);
                    }

                },
                error: function (error) {
                    enableButtons('#add-to-cart');
                    let errors = error.responseJSON.errors;

                    if (errors) {
                        handleValidationErrors(errors);
                    } else {
                        Toast.fire({
                            icon: "error",
                            title: "Validation Error",
                            text: error.responseJSON.message,
                            showConfirmButton: true,
                            timer: false
                        });
                    }
                }
            });
        }


        function handleValidationErrors(errors) {
            $.each(errors, function (key, messages) {
                messages.forEach(function (message) {
                    Toast.fire({
                        icon: "warning",
                        title: message,
                        showConfirmButton: true,
                        timer: false
                    });
                });

            });
        }
    });

</script>
