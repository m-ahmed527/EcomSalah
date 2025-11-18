<script>
    function toggleDeleteButton() {
        let selectedCount = $('.row-checkbox:checked').length;

        if (selectedCount > 0) {
            $('#delete-selected').removeClass('d-none');
        } else {
            $('#delete-selected').addClass('d-none');
        }
    }

    function updateSelectAllState() {
        let total = $('.row-checkbox').length;
        let checked = $('.row-checkbox:checked').length;

        // 🔥 If all individually checked → Select All ON
        $('#select-all').prop('checked', total === checked);
    }

    // 🔹 Select All Event
    $(document).on('change', '#select-all', function () {
        $('.row-checkbox').prop('checked', this.checked);
        toggleDeleteButton();
    });

    // 🔹 Single Row Checkbox Event
    $(document).on('change', '.row-checkbox', function () {

        // If any unchecked → uncheck Select All
        updateSelectAllState();

        toggleDeleteButton();
    });

    // 🔹 DELETE SELECTED with SweetAlert2
    $(document).on('click', '#delete-selected', function () {

        let ids = [];
        let url = $(this).data('url');
        $('.row-checkbox:checked').each(function () {
            ids.push($(this).val());
        });

        if (ids.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Selection',
                text: 'Please select at least one Item!',
            });
            return;
        }

        Swal.fire({
            title: "Are you sure?",
            text: `You are about to delete ${ids.length} Item(s). This action cannot be undone.`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        ids: ids,
                        _token: "{{ csrf_token() }}"
                    },
                    beforeSend: function () {
                        Swal.showLoading();
                    },
                    success: function (response) {
                        if (response.success) {

                            Toast.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });

                            // 🔥 Reload datatable
                            if ($.fn.DataTable.isDataTable('.dataTable')) {
                                $('.dataTable').DataTable().ajax.reload(null, false);
                            }

                            // 🔥 Reset states
                            $('#delete-selected').addClass('d-none');
                            $('#select-all').prop('checked', false);
                        }
                    },
                    error: function (error) {
                        Toast.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: error.responseJSON.message,
                        });
                    }
                });
            }
        });

    });
</script>
