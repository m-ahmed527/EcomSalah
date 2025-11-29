<script>
    $(document).ready(function () {


        const variantMap = @json($variantMap);
        const priceDisplay = $('#variant-price');
        const stockDisplay = $('#variant-stock');
        let currentVariantId = null;

        function getSelectedAttributes() {
            const selected = {};
            $('.variant-radio:checked').each(function () {
                const attrId = $(this).data('attribute-id');
                selected[attrId] = parseInt($(this).val());
            });

            return selected;
        }

        function filterRadios(changedInput = null) {
            const selected = getSelectedAttributes();

            $('.variant-radio').prop('disabled', false); // reset all first

            if (changedInput && !$(changedInput).is(':checked')) {
                // If radio was unchecked (user clicked same again), stop here
                // priceDisplay.text('-');
                // stockDisplay.text('-');
                $('#selected-variant-id').val('');
                currentVariantId = null;
                return;
            }

            // Loop through all attribute radios
            $('.variant-radio').each(function () {
                const currentAttr = $(this).data('attribute-id');
                const currentVal = parseInt($(this).val());


                const otherSelected = {
                    ...selected
                };

                delete otherSelected[currentAttr]; // remove self from filtering

                const isValid = variantMap.some(function (combo) {
                    let match = true;
                    for (const key in otherSelected) {
                        if (combo[key] !== otherSelected[key]) {
                            match = false;
                            break;
                        }
                    }
                    return match && combo[currentAttr] === currentVal;
                });

                if (!isValid) {
                    $(this).prop('disabled', true);
                    // Uncheck if already selected and invalid now
                    if ($(this).is(':checked')) {
                        $(this).prop('checked', false);
                    }
                }
            });

            // Check if full selection done
            if (Object.keys(selected).length === {{ $attributes->count() }}) {
                let basePrice = {{ $product->base_price }};
                $.ajax({
                    url: "{{ route('web.product.get.variant') }}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    contentType: 'application/json',
                    data: JSON.stringify({
                        product_id: {{ $product->id }},
                        attribute_value_ids: Object.values(selected)
                    }),
                    success: function (response) {
                        if (response.success) {
                            console.log(parseFloat(response.data.price),basePrice);
                            // Update UI with variant data
                            if (response.data.price) {
                                priceDisplay.text(`PKR ${response.data.price}`);
                                stockDisplay.html(response.data.stock > 0 ?
                                    `<span class="label label-success label-lg">In Stock</span>` :
                                    `<span class="label label-danger label-lg">Out of stock</span>`);

                                $('.product-price').text(`PKR ${parseFloat(parseFloat(response.data.price) + parseFloat(basePrice)).toFixed(2)}`);
                                $('#stock').val(response.data.stock);

                            } else {
                                priceDisplay.text('-');
                                stockDisplay.html(`<span class="label label-success label-lg">In Stock</span>`);
                            }

                            if (response.data.variant_id) {
                                $('#selected-variant-id').val(response.data.variant_id);
                                currentVariantId = response.data.variant_id;
                            }
                            checkVariantIdToDisableCartButton();

                        } else {
                            Swal.fire('Not available', response.message, 'info');
                            checkVariantIdToDisableCartButton();

                        }
                    },
                    error: function (error) {
                        Swal.fire('Error', error.responseJSON.message, 'error');
                        checkVariantIdToDisableCartButton();

                    }
                });
            } else {
                // priceDisplay.text('-');
                // stockDisplay.text('-');
                $('#selected-variant-id').val('');
                currentVariantId = null;
            }
        }

        // 🔄 On radio change
        $('.variant-radio').on('change', function () {
            filterRadios(this);
        });
        $('.reset-attribute').on('click', function () {
            const attrId = $(this).data('attribute-id');

            // Uncheck selected radio of this attribute
            $(`.variant-radio[data-attribute-id="${attrId}"]`).prop('checked', false);

            // Trigger filtering logic to update UI
            filterRadios();
            checkVariantIdToDisableCartButton();
        });
        function checkVariantIdToDisableCartButton() {
            let variant_id = $('#selected-variant-id').val();
            console.log('variant_di :', variant_id);
            if (!variant_id) {
                $('#add-to-cart').prop('disabled', true);
            } else {
                $('#add-to-cart').prop('disabled', false);
            }
        }

    });
</script>