<script>
    $(document).on('click', '.add-to-wishlist', function () {
        let url = $(this).data('url');
        let icon = $(this).find('i'); // ✅ Get <i> inside the button
        console.log(icon); // Check if <i> is selected

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                console.log(response);
                if (response.success) {
                    Toast.fire({
                        icon: "success",
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    if (icon.hasClass('fa-regular')) {
                        icon.removeClass('fa-regular').addClass('fa-solid');
                    } else {
                        icon.removeClass('fa-solid').addClass('fa-regular');
                    }
                    $('.wishlist-count').text(response.data.wishlist_count);
                }
                else {

                    Toast.fire({
                        icon: "warning",
                        title: response.message,
                        showConfirmButton: true,
                        timer: false
                    });
                   
                }
            },
            error: function (error) {
                console.log(error);
            }

        });
    })
</script>
