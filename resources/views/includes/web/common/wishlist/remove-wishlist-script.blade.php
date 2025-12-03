<script>
    $(document).on('click', '.remove-from-wishlist', function (e) {
        e.preventDefault();
        let id = $(this).data('id') ?? null;
        let btnId = "#remove-from-wishlist-" + id;
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
                    url: "{{ route('web.wishlist.remove') }}",
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

                            $('.wishlist-product-list').html(response.data.html);
                            if (response.data.cartIsEmpty || response.data.wishilistIsEmpty) {
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
</script>
