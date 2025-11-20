<script>
    redirectUrl = @json($redirectUrl);
    $(document).ready(function () {
        $('#submit-form input').on('keypress', function (e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#submit-btn').trigger('click'); // optional — trigger AJAX save
            }
        });
        $(document).on("click", '#submit-btn', function (e) {
            e.preventDefault();

            let form = $('#submit-form');
            if (!form.parsley().validate()) {
                Toast.fire({
                    icon: "warning",
                    title: "Please fill all the required fields!",
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }
            // 🔹 ensure Summernote data syncs to textarea before FormData creation
            if (window.jQuery && $.fn && $.fn.summernote && $('.summernote').length) {
                $('.summernote').each(function () {
                    $(this).val($(this).summernote('code'));
                });
            }
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
                    handleFormSuccess(form, response);
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
                        });
                    }
                },
                complete: function () {
                    enableButtons('#submit-btn');
                    // form.find("button[type='submit']").prop("disabled", false).text("Save Changes");
                }
            });
        });




        // ✅ helper: handle success logic conditionally
        function handleFormSuccess(form, response) {
            // close modal if inside
            let modal = form.closest('.modal');
            if (modal.length) {
                modal.modal('hide');
            }
            // console.log($.fn.DataTable.isDataTable('.dataTable'));
            // reload datatable if exists
            if ($.fn.DataTable.isDataTable('.dataTable')) {
                $('.dataTable').DataTable().ajax.reload(null, false);
            }

            // reset form if attribute is set
            if (form.data('reset') === true || form.attr('data-reset') === "true") {
                form[0].reset();
            }

            // ✅ redirect condition (either from response or form attributes)


            // if (response.redirect_url) {
            //     redirectUrl = response.redirect_url;
            // } else if (form.data('redirect') === true || form.attr('data-redirect') === "true") {
            //     redirectUrl = form.data('redirect-url') || form.attr('data-redirect-url');
            // }

            if (redirectUrl) {
                // thoda delay taake Toast visible rahe
                setTimeout(() => {
                    window.location.href = redirectUrl;
                }, 1200);
            }

            // optional: custom callback for extra actions
            if (typeof window.onFormSuccess === "function") {
                window.onFormSuccess(form, response);
            }
        }



        function handleValidationErrors(errors) {
            $('.error-message').remove();
            $('.form-control').removeClass('is-invalid');

            $.each(errors, function (key, messages) {
                let nameAttr = key.replace(/\.(\d+|\w+)/g, "[$1]");
                console.log(nameAttr);

                // Fallback: agar array index nahi milta to [] version bhi try kare
                let inputField = $(
                    `input[name="${nameAttr}"], select[name="${nameAttr}"], textarea[name="${nameAttr}"]`
                );
                // get the name of the first matched element (null if none)
                // let inputName = inputField.length ? inputField.first().attr('name') : null;
                // console.log(inputName);
                // if (inputField.length === 0) {
                //     // e.g. convert variants[1][attribute_value_ids][0] → variants[1][attribute_value_ids][]
                //     let fallbackName = nameAttr.replace(/\[\d+\]$/, "[]");
                //     inputField = $(
                //         `input[name="${fallbackName}"], select[name="${fallbackName}"], textarea[name="${fallbackName}"]`
                //     );
                // }
                if (inputField.length > 0) {
                    inputField.addClass('is-invalid');
                    let errorMessage = $(`<span class="error-message text-danger">${messages[0]}</span>`);

                    // 1️⃣ If inside an input-group (like password + eye icon)
                    if (inputField.closest('.input-group').length > 0) {
                        let group = inputField.closest('.input-group');
                        group.after(errorMessage);
                        return;
                    }

                    // 2️⃣ If input is select2
                    if (inputField.hasClass('select2')) {
                        let select2Container = inputField.next('.select2-container');
                        let selection = select2Container.find('.select2-selection');
                        selection.addClass('is-invalid');
                        select2Container.after(errorMessage);
                        return;
                    }

                    // 3️⃣ Normal input
                    inputField.after(errorMessage);

                } else {
                    console.log("⚠️ No input found for:", nameAttr);
                }

                // if (inputField.length > 0) {
                //     inputField.addClass('is-invalid');
                //     let errorMessage = $(`<span class="error-message text-danger">${messages[0]}</span>`);
                //     inputField.last().after(errorMessage);
                // } else {
                //     console.log("⚠️ No input found for:", nameAttr);
                // }

            });
        }


        $(document).on('input change keydown', 'input, select, textarea', function () {
            var $el = $(this);

            // remove validation styling
            $el.removeClass('is-invalid');

            // remove error message immediately after the field
            var $nextErr = $el.next('span.error-message');
            if ($nextErr.length) {
                $nextErr.remove();
            }

            // if field is inside an input-group, remove error message after the group
            var $group = $el.closest('.input-group');
            if ($group.length) {
                var $groupErr = $group.next('span.error-message');
                if ($groupErr.length) {
                    $groupErr.remove();
                }
            }

            // handle select2: remove invalid class on the selection and its error message
            if ($el.hasClass('select2')) {
                var $select2Container = $el.next('.select2-container');
                if ($select2Container.length) {
                    $select2Container.find('.select2-selection').removeClass('is-invalid');
                    var $selErr = $select2Container.next('span.error-message');
                    if ($selErr.length) $selErr.remove();
                }
            }
        });

    });
</script>
{{-- window.onFormSuccess = function (form, response) {
console.log("Custom success callback chala for:", form.attr('id'));

// example: kisi div me updated data inject karna
if (response.updated_html) {
$('#content-area').html(response.updated_html);
}
} --}}
