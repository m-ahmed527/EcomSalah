@extends('layouts.admin.app')
@section('title', 'Profile')
@section('page', 'Profile')
@section('content')
    {{-- <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Profile</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header --> --}}

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-8">

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Update Profile</h3>
                            </div>

                            <form id="submit-form" enctype="multipart/form-data"
                                action="{{ route('admin.profile.update') }}" method="POST" data-reset="true">
                                @csrf

                                <div class="card-body">

                                    {{-- Profile Image --}}
                                    <div class="form-group text-center">
                                        <div class="position-relative d-inline-block">
                                            <img id="profilePreview"
                                                src="{{ auth()?->user()?->avatar ?: asset('assets/web/images/no-user.png') }}"
                                                alt="Profile Image" class="img-thumbnail rounded-circle"
                                                style="width: 150px; height: 150px; object-fit: cover;">
                                            <button type="button"
                                                class="btn btn-danger btn-sm position-absolute remove-image"
                                                style="top:5px; right:5px; display:none;">&times;</button>
                                        </div>

                                        {{-- ✅ File input perfectly centered --}}
                                        <div class="mt-3 d-flex justify-content-center">
                                            <div style="width: fit-content;">
                                                <label for="avatarInput" class="btn btn-outline-secondary btn-sm mb-0">
                                                    <i class="fas fa-upload mr-1"></i> Choose Image
                                                </label>
                                                <input type="file" name="avatar" id="avatarInput" class="d-none"
                                                    accept="image/*">
                                            </div>
                                        </div>
                                    </div>


                                    <hr>

                                    {{-- First Name --}}
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" name="first_name" class="form-control"
                                            value="{{auth()?->user()?->first_name}}" placeholder="First Name">
                                    </div>

                                    {{-- Last Name --}}
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" name="last_name" class="form-control"
                                            value="{{auth()?->user()?->last_name}}" placeholder="Last Name">
                                    </div>

                                    {{-- Email --}}
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{auth()?->user()?->email}}" disabled placeholder="Enail">
                                    </div>

                                    {{-- Phone --}}
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" name="phone" class="form-control"
                                            value="{{auth()?->user()?->phone}}"
                                            placeholder="Phone:(+923XXXXXXXXX / 03XX-XXXXXXX)">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" placeholder="Address" name="address"
                                            value="{{auth()?->user()?->address}}" id="address">
                                    </div>
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <input type="text" class="form-control" placeholder="Country" name="country"
                                            value="{{auth()?->user()?->country}}" id="country">
                                    </div>
                                    <div class="form-group">
                                        <label for="province">Province</label>
                                        <input type="text" class="form-control" placeholder="Province" name="province"
                                            value="{{auth()?->user()?->province}}" id="province">
                                    </div>
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" class="form-control" placeholder="City" name="city" id="city"
                                            value="{{auth()?->user()?->city}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="zip">Zip</label>
                                        <input type="text" class="form-control" placeholder="Zip" name="zip" id="zip"
                                            value="{{auth()?->user()?->zip}}">
                                    </div>
                                    {{-- Password --}}
                                    <div class="form-group">
                                        <label>New Password</label>
                                        <input type="password" name="password" class="form-control"
                                            placeholder="Leave blank to keep current">
                                    </div>

                                </div>

                                <div class="card-footer text-right">
                                    <button type="button" class="btn btn-primary" id="submit-btn">Save Changes</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        {{--
    </div> --}}
@endsection

@push('scripts')

    <script>
        $(function () {

            // 🔹 Preview image instantly
            $('#avatarInput').on('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    $('#profilePreview').attr('src', URL.createObjectURL(file));
                    $('.remove-image').show();
                }
            });

            // 🔹 Remove image
            $('.remove-image').on('click', function () {
                $('#avatarInput').val('');
                $('#profilePreview').attr('src', "{{ asset('assets/web/images/no-user.png') }}");
                $(this).hide();
            });


        });
    </script>

    @include('includes.admin.ajax-requests.create', ['redirectUrl' => null])
@endpush