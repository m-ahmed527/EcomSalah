<script>
    $(document).ready(function () {
        $(document).on('click', '#submit-btn', function (e) {
            e.preventDefault();
            let form = $('#submit-form');
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
                        form[0].reset();
                        if ($('#editProfileModal').length) {
                            $('#editProfileModal').modal('hide');
                        }
                        if (response.data && response.data.user) {
                            updateProfileUI(response.data.user);
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
                    enableButtons();
                    // $.LoadingOverlay("hide");
                    let errors = error.responseJSON.errors;


                    if (errors) {
                        handleValidationErrors(errors);
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

        $(document).on('input change keydown', 'input, select, textarea', function () {
            $(this).next('span.error-message').text('');
            $(this).removeClass('is-invalid');
        });


        // ✅ Dynamic Profile Update Function
        function updateProfileUI(user) {
            $('#profile-name').text((user.first_name ?? '') + ' ' + (user.last_name ?? ''));
            $('#profile-phone').text(user.phone ?? '');
            $('#profile-email').text(user.email ?? '');
            $('#profile-address').text(user.address ?? '');
            $('#profile-country').text(user.country ?? '');
            $('#profile-province').text(user.province ?? '');
            $('#profile-city').text(user.city ?? '');
            $('#profile-zip').text(user.zip ?? '');
        }

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
                    if (nameAttr === "rating") {
                        // sirf pehli rating div ke neeche error lagana hai
                        if ($(".rating-main-div .error-message").length === 0) {
                            $(".rating-main-div").after(
                                `<span class="error-message text-danger">${messages[0]}</span>`
                            );
                        }
                    } else {
                        // normal fields
                        let errorMessage = $(`<span class="error-message text-danger">${messages[0]}</span>`);
                        inputField.last().after(errorMessage);
                    }
                } else {
                    console.log("No input found for", nameAttr);
                }
            });
        }
    })
</script>