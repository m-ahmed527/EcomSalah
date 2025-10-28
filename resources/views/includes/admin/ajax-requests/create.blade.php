<script>
    reset = reset || false;
    $(document).ready(function () {

        $(document).on("click", '#submit-btn', function (e) {
            e.preventDefault();

            let form = $('#submit-form');
            let formData = new FormData(form[0]);

            $.ajax({
                url: form.attr('action'), // 👈 your route
                method: form.attr('method'),
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    disableButtons('#submit-btn');
                },
                success: function (response) {
                    enableButtons('#submit-btn');
                    // $.LoadingOverlay("hide");
                    if (response.success) {
                        Toast.fire({
                            icon: "success",
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });

                    } else {
                        Toast.fire({
                            icon: "error",
                            title: response.message,
                            timer: 2000
                        })
                    }
                    if (reset) {
                        form[0].reset();
                    }
                },
                error: function (error) {
                    enableButtons('#submit-btn');
                    // $.LoadingOverlay("hide");
                    let errors = error.responseJSON.errors;


                    if (errors) {
                        handleValidationErrors(errors);
                    } else {
                        Toast.fire({
                            icon: "error",
                            title: error.responseJSON.message,
                            showConfirmButton: true,
                            timer: 2000
                        });
                    }
                },
                complete: function () {
                    enableButtons('#submit-btn');
                    // form.find("button[type='submit']").prop("disabled", false).text("Save Changes");
                }
            });
        });


        $(document).on('input change keydown', 'input, select, textarea', function () {
            $(this).next('span.error-message').text('');
            $(this).removeClass('is-invalid');
        });


        function handleValidationErrors(errors) {
            // pehle sab error messages aur red borders hata do
            $('.error-message').remove();
            $('.form-control').removeClass('is-invalid');


            $.each(errors, function (key, messages) {
                // Laravel key ko [ ] notation me convert karna
                // "modules.0.module_id" => "modules[0][module_id]"
                let nameAttr = key.replace(/\.(\d+)/g, "[$1]").replace(/\.(\w+)/g, "[$1]");

                // Input/Select/Textarea dhoondo with that name
                let inputField = $(
                    `input[name="${nameAttr}"], select[name="${nameAttr}"], textarea[name="${nameAttr}"]`
                );
                inputField.addClass('is-invalid');
                if (inputField.length > 0) {
                    // normal fields
                    let errorMessage = $(`<span class="error-message text-danger">${messages[0]}</span>`);
                    inputField.last().after(errorMessage);

                } else {
                    console.log("No input found for", nameAttr);
                }
            });
        }
    });
</script>
