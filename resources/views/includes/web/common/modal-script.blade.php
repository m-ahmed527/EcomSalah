<script>
    $(document).on('click', '.modalProductShow', function () {
        var url = $(this).data('url');
        // AJAX request to fetch product details
        $.ajax({
            url: url,
            method: 'GET',
            beforeSend: function () {
                // Show loader or overlay if needed
                if (!$('.modal-content .loader-overlay').length) {
                    $('.modal-content').append(`<div class="loader-overlay"><i class="fa fa-spinner fa-spin fa-2x"></i></div>`);
                }
            },
            success: function (response) {
                $('.modal-content .loader-overlay').remove();
                if (response.success) {
                    $('#product-modal .modal-content').html(response.data.html);
                }
            },
            error: function (error) {
                $('#product-modal .modal-content').html('<p class="text-danger text-center">Failed to load product details.</p>');
                console.log('AJAX Error: ' + error.responseJSON.message);
            }
        });
        $('#product-modal').modal('show');
    });
</script>
