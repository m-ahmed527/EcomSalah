<script>
    // 🛒 Cart submission
    $(document).ready(function () {
        console.log($('.cart-count').text());
        $('#cart-form input').on('keypress', function (e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#add-to-cart').trigger('click'); // optional — trigger AJAX save
            }
        });
        $(document).on('click', '#add-to-cart', function (e) {
            e.preventDefault();
            const isVariantRequired = {{ $attributes->isEmpty() ? 'false' : 'true' }};
            const variantId = $('#selected-variant-id').val();
            const quantity = $('#quantity').val() ?? 1;

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
                    console.log(response.data.total_items);

                    if (response.success) {
                        Toast.fire({
                            icon: "success",
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        // Update cart count in header
                        $('span.cart-count').text(response.data.total_items);
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