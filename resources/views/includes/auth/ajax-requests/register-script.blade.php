<script>
    $(document).ready(function () {
        $(document).on('click', '#register-btn', function (e) {
            e.preventDefault();
            let form = $('#register-form');
            let formData = new FormData(form[0]);
            disableButtons();
            // $.LoadingOverlay("show");
            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    enableButtons();
                    // $.LoadingOverlay("hide");
                    if (response.success) {
                        Toast.fire({
                            icon: "success",
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(function () {
                            window.location.href = "{{ route('web.index') }}";
                        }, 1500)
                    } else {
                        Toast.fire({
                            icon: "error",
                            title: "Something went wrong",
                            showConfirmButton: true,
                            timer: 2000
                        })
                    }
                },
                error: function (error) {
                    enableButtons();
                    // $.LoadingOverlay("hide");
                    let errors = error.responseJSON.errors;

                    // pehle sab error messages aur red borders hata do
                    $('.error-message').remove();
                    $('.form-control').removeClass('is-invalid');

                    if (errors) {
                        $.each(errors, function (key, value) {
                            let inputField = $(`input[name="${key}"]`);

                            // red border lagao
                            inputField.addClass('is-invalid');

                            // error message dikhayo
                            let errorMessage = $(`
                                            <span class='error-message text-danger small d-block mt-1'>
                                                ${value}
                                            </span>
                                        `);
                            inputField.after(errorMessage);
                        });
                    } else {
                        Toast.fire({
                            icon: "error",
                            title: "An error occurred. Please try again.",
                            showConfirmButton: true,
                            timer: 2000
                        });
                    }
                }

            })
        })

    })
    $(document).on('input change keydown', 'input, select, textarea', function () {
        $(this).next('span.error-message').text('');
        $(this).removeClass('is-invalid');
    });
</script>
