<script>
        $(document).ready(function () {

            $(document).on('click', '.remove-from-cart', function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                let btnId = "#remove-from-cart-" + id;
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        disableButtons(btnId);
                        $.ajax({
                            url: "{{ route('web.cart.remove') }}",
                            type: "POST",
                            data: {
                                id: id,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function (response) {
                                console.log(response);
                                enableButtons(btnId);

                                if (response.success) {
                                    Toast.fire({
                                        icon: "success",
                                        title: response.message,
                                        timer: 1500
                                    });

                                    $('.cart-product-list').html(response.data.html);
                                    if (response.data.cartIsEmpty) {
                                        window.location.href = "{{ route('web.index') }}";
                                    }

                                } else {
                                    Toast.fire({
                                        icon: "error",
                                        title: response.message
                                    });

                                }
                            },
                            error: function (xhr) {
                                enableButtons(btnId);
                                Toast.fire({
                                    icon: "error",
                                    title: xhr.responseJSON.message
                                });
                            }
                        });

                    }
                })

            })



            // update
            $(document).on('input', '[name="quantity"]', function (e) {
                e.preventDefault();
                if ($(this).val() <= 0) {
                    Toast.fire('Invalid Quantity', 'Please enter a valid quantity.', 'warning');
                    return;
                }
                let quantity = $(this).val();
                let id = $(this).data('id');
                console.log(quantity, id);
                $.ajax({
                    url: "{{ route('web.cart.update') }}",
                    type: "POST",
                    data: {
                        id: id,
                        quantity: quantity,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        console.log(response);

                        if (response.success) {

                            $('.cart-product-list').html(response.data.html);

                        }
                    },
                    error: function (error) {
                        Toast.fire({
                            icon: "error",
                            title: "Oops!",
                            text: error.responseJSON.message
                        });
                    }
                });

            })
        })



    </script>