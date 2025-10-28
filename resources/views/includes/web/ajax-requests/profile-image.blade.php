<script>
    $('#profile_image').on('change', function () {
        var file = this.files[0];
        if (file) {
            $('#previewImage').attr('src', URL.createObjectURL(file));
            // Optionally trigger AJAX call here if you want immediate upload
            uploadProfileImage(file);
        }
    });

    function uploadProfileImage(file) {
        var formData = new FormData();
        formData.append('profile_image', file);
        formData.append('_token', '{{ csrf_token() }}'); // <-- token yahan add karo

        $.ajax({
            url: "{{ route('web.dashboard.update.profile.image') }}", // apni route daalna
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.success) {
                    $('.user-img').attr('src', response.data.image_url);
                    Toast.fire({
                        icon: "success",
                        title: response.message,
                        timer: 1500
                    });
                }
            },
            error: function (error) {
                Toast.fire({
                    icon: "error",
                    title: error.responseJSON.message,
                    timer: 2000
                })
            }
        });
    }
</script>
