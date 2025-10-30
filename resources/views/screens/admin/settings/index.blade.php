@extends('layouts.admin.app')
@section('title', 'Settings')
@section('page', 'Settings')
@section('content')

    {{-- <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Settings</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Settings</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header --> --}}

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary card-outline">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills" id="settings-tabs">
                            <li class="nav-item"><a class="nav-link active" href="#general" data-toggle="tab">General</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#social" data-toggle="tab">Social Links</a></li>
                            <li class="nav-item"><a class="nav-link" href="#email" data-toggle="tab">Email Settings</a></li>
                            <li class="nav-item"><a class="nav-link" href="#theme" data-toggle="tab">Theme Customization</a>
                            </li>

                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content">
                            {{-- General --}}
                            <div class="tab-pane active" id="general">
                                <form action="#" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label>Site Name</label>
                                        <input type="text" name="site_name" class="form-control"
                                            value="{{ $settings['site_name'] }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Site Email</label>
                                        <input type="email" name="site_email" class="form-control"
                                            value="{{ $settings['site_email'] }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Site Phone</label>
                                        <input type="text" name="site_phone" class="form-control"
                                            value="{{ $settings['site_phone'] }}">
                                    </div>
                                    <div class="row">
                                        {{-- ✅ Site Logo --}}
                                        <div class="form-group col-sm-6">
                                            <label>Site Logo</label>
                                            <div class="preview-wrapper position-relative" style="width: 100px;">
                                                <img id="logoPreview"
                                                    src="{{ $settings['logo'] ?: asset('uploads/settings/no-image.jpg') }}"
                                                    alt="Logo Preview" class="img-thumbnail mb-2"
                                                    style="width: 100%; height: auto;">
                                                <button type="button" class="btn btn-sm btn-danger remove-image"
                                                    data-target="#logoPreview" data-input="logoInput"
                                                    style="position:absolute; top:5px; right:5px; display: none">
                                                    &times;
                                                </button>
                                            </div>
                                            <input type="file" name="logo" id="logoInput" class="form-control-file">
                                        </div>

                                        {{-- ✅ Favicon --}}
                                        <div class="form-group col-sm-6">
                                            <label>Favicon</label>
                                            <div class="preview-wrapper position-relative" style="width: 100px;">
                                                <img id="faviconPreview"
                                                    src="{{ $settings['favicon'] ?: asset('uploads/settings/no-image.jpg') }}"
                                                    alt="Favicon Preview" class="img-thumbnail mb-2"
                                                    style="width: 100%; height: auto;">
                                                <button type="button" class="btn btn-sm btn-danger remove-image"
                                                    data-target="#faviconPreview" data-input="faviconInput"
                                                    style="position:absolute; top:5px; right:5px; display: none">
                                                    &times;
                                                </button>
                                            </div>
                                            <input type="file" name="favicon" id="faviconInput" class="form-control-file">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-secondary setting-update-btn">Save Changes</button>
                                </form>
                            </div>


                            {{-- Social Links --}}
                            <div class="tab-pane" id="social">
                                <form action="#" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Facebook</label>
                                        <input type="url" name="facebook" class="form-control"
                                            value="{{ $settings['facebook'] }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Twitter</label>
                                        <input type="url" name="twitter" class="form-control"
                                            value="{{ $settings['twitter'] }}">
                                    </div>
                                    <button type="submit" class="btn btn-secondary setting-update-btn">Save Changes</button>
                                </form>
                            </div>



                            {{-- Email Settings --}}
                            <div class="tab-pane" id="email">
                                <form action="#" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>SMTP Host</label>
                                        <input type="text" name="mail_host" class="form-control" value="smtp.gmail.com">
                                    </div>
                                    <div class="form-group">
                                        <label>SMTP Port</label>
                                        <input type="number" name="mail_port" class="form-control" value="587">
                                    </div>
                                    <div class="form-group">
                                        <label>SMTP Username</label>
                                        <input type="text" name="mail_username" class="form-control" value="">
                                    </div>
                                    <div class="form-group">
                                        <label>SMTP Password</label>
                                        <input type="password" name="mail_password" class="form-control" value="">
                                    </div>
                                    <button type="submit" class="btn btn-secondary setting-update-btn">Save Changes</button>
                                </form>
                            </div>

                            {{-- Theme Customization --}}
                            <div class="tab-pane" id="theme">
                                <div class="form-group">
                                    <label>Theme Mode</label>
                                    <select id="themeMode" class="form-control">
                                        <option value="light-mode">Light</option>
                                        <option value="dark-mode">Dark</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Navbar Color</label>
                                    <select id="navbarColor" class="form-control">
                                        <option value="navbar-light navbar-white">Light</option>
                                        <option value="navbar-dark navbar-primary">Primary</option>
                                        <option value="navbar-dark navbar-success">Success</option>
                                        <option value="navbar-dark navbar-danger">Danger</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Sidebar Color</label>
                                    <select id="sidebarColor" class="form-control">
                                        <option value="sidebar-dark-primary">Dark Primary</option>
                                        <option value="sidebar-light-primary">Light Primary</option>
                                        <option value="sidebar-dark-success">Dark Success</option>
                                        <option value="sidebar-dark-danger">Dark Danger</option>
                                    </select>
                                </div>

                                <button id="saveThemeBtn" class="btn btn-secondary">Save Theme</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    {{-- </div> --}}
    <!-- /.content-wrapper -->
@endsection
@push('scripts')

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Handle image preview for file inputs
            const handlePreview = (inputId, previewId, removeBtn) => {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);
                const removeButton = document.querySelector(`[data-target="#${previewId}"]`);

                input.addEventListener('change', function (e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            preview.src = e.target.result;
                            removeButton.style.display = 'block';
                        }
                        reader.readAsDataURL(file);
                    }
                });

                removeButton.addEventListener('click', function () {
                    preview.src = "asset('uploads/settings/no-image.jpg') }}";
                    input.value = "";
                    removeButton.style.display = 'none';
                });
            };

            handlePreview('logoInput', 'logoPreview');
            handlePreview('faviconInput', 'faviconPreview');
        });



        $(document).ready(function () {

            // 🔹 Handle all settings form submissions
            $(".tab-content form").on("submit", function (e) {
                e.preventDefault();

                let form = $(this);
                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('admin.settings.update') }}", // 👈 your route
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        disableButtons('.setting-update-btn');
                    },
                    success: function (response) {
                        enableButtons('.setting-update-btn');
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
                    },
                    error: function (error) {
                        enableButtons('.setting-update-btn');
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
                    },
                    complete: function () {
                        enableButtons('.setting-update-btn');
                        form.find("button[type='submit']").prop("disabled", false).text("Save Changes");
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


@endpush
