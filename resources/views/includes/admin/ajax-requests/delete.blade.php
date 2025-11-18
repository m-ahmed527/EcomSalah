<script>
    $(document).ready(function () {
        $(document).on('click', '#delete-btn, .remove-gallery', function (e) {
            e.preventDefault();
            let button = $(this);
            console.log(123);
            if ($('.remove-gallery').length > 0) {
                if (!button.data('id')) {
                    button.closest('div').remove();
                    return;
                }

            }
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

                    let url = button.data("url"); // route ya api endpoint
                    disableButtons('#delete-btn');
                    console.log(url, button);
                    $.ajax({
                        url: url,
                        type: "GET",
                        // data: {
                        //     _token: "{{ csrf_token() }}"
                        // },
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            console.log(response);
                            enableButtons('#delete-btn');
                            if (response.success) {
                                Toast.fire({
                                    icon: "success",
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                if ($.fn.DataTable.isDataTable('.dataTable')) {
                                    $('.dataTable').DataTable().ajax.reload(null, false);
                                }
                                if ($('.remove-gallery').length > 0) {
                                    button.closest('div').remove();
                                }
                            } else {
                                Toast.fire({
                                    icon: "error",
                                    title: response.message,
                                    timer: 2000
                                })
                            }

                        },
                        error: function (error) {
                            // console.log(error.responseJSON.message);
                            enableButtons('#delete-btn');
                            Toast.fire({
                                icon: "error",
                                title: error.responseJSON.message,
                                showConfirmButton: true,
                            })
                        }
                    })
                }
            })

        })

    })
</script>
