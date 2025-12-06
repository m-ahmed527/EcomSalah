<script>
    $(document).on('click', '.modalProductShow', function () {
        var url = $(this).data('url');
        console.log(url);
        // AJAX request to fetch product details
        $.ajax({
            url: url,
            method: 'GET',
            beforeSend: function () {
                // Show loader or overlay if needed
                $('.modal-content').LoadingOverlay("show");
            },
            success: function (response) {
                $('.modal-content').LoadingOverlay("hide");

                if (response.success) {
                    $('#productModal .modal-content').html(response.data.html);
                }
            },
            error: function (error) {
                $('.modal-content').LoadingOverlay("hide");

                $('#productModal .modal-content').html('<p class="text-danger text-center">Failed to load product details.</p>');
                console.log('AJAX Error: ' + error.responseJSON.message);
            }
        });
        $('#productModal').modal('show');
    });
</script>