<script>
    $(document).ready(function () {
        $('.view-cart-btn, .view-wishlist-btn').on('click', function (e) {
            e.preventDefault();
            let isWishlistBtn = $(this).hasClass('view-wishlist-btn');
            $.ajax({
                url: isWishlistBtn ? "{{ route('web.wishlist.index') }}" : "{{ route('web.cart.index') }}",
                type: "GET",

                success: function (response) {

                    if (response.success === false) {
                        Swal.fire({
                            icon: 'warning',
                            title: response.message,
                        });
                    } else {
                        // If success true OR page returned (HTML)
                        window.location.href = isWishlistBtn ? "{{ route('web.wishlist.index') }}" : "{{ route('web.cart.index') }}";
                    }
                },

                error: function (error) {
                    Swal.fire({
                        icon: 'error',
                        title: error.responseJSON?.message
                    });
                }
            });
        });

    });
</script>
