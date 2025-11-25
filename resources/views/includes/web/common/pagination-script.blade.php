<script>
        // AJAX Pagination
        $(document).on('click', '.pagination a', function (event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            fetch_data(page);
        });

        function fetch_data(page) {
            $.ajax({
                url: "{{ route('web.product.index') }}?page=" + page,
                beforeSend: function () {
                    if (!$('.product-list-div .loader-overlay').length) {
                        $('.product-list-div').append(`<div class="loader-overlay"><i class="fa fa-spinner fa-spin fa-2x"></i></div>`);
                    }
                },
                success: function (response) {
                    $('.product-list-div .loader-overlay').remove();
                    $('.product-list-div').html(response.data.html);
                    $('.pagination-div').html(response.data.pagination);
                    $('#showing-results-container').html(response.data.showing_results);
                },
                error: function (xhr, status, error) {
                    $('.product-list-div').html('<p class="text-danger text-center">Failed to load content.</p>');
                    console.log('AJAX Error: ' + status + error);
                }
            });
        }
    </script>
