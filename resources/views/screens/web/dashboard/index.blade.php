@extends('layouts.web.app')
@section('title', 'Dashboard')
@section('page', 'Dashboard')

@section('content')
    <section class="user-dashboard page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <ul class="list-inline dashboard-menu text-center">
                        <li>
                            <a href="javascript:void(0);"
                                class="tab-ajax {{ request()->routeIs('web.dashboard.orders.index') ? 'active' : '' }}"
                                data-url="{{ route('web.dashboard.orders.index') }}">
                                Orders
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);"
                                class="tab-ajax {{ request()->routeIs('web.dashboard.profile.index') ? 'active' : '' }}"
                                data-url="{{ route('web.dashboard.profile.index') }}">
                                Profile Details
                            </a>
                        </li>
                    </ul>

                    <div class="dashboard-wrapper user-dashboard" id="dashboard-content">
                        {{-- Default content will load here via AJAX --}}
                        @if (request()->routeIs('web.dashboard.orders.index'))
                            @include('includes.web.dashboard-components.order')
                        @elseif (request()->routeIs('web.dashboard.profile.index'))
                            @include('includes.web.dashboard-components.profile')
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- Edit Profile Modal -->
    <div id="editProfileModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Profile</h4>
                </div>
                <!-- Profile Image (outside modal form) -->
                <div class="text-center" style="margin-bottom:20px;">
                    <img id="previewImage" src="{{ $user?->avatar ?? asset('assets/web/images/no-user.png') }}"
                        class="img-circle" alt="Profile" width="120" height="120"
                        style="object-fit:cover; border:3px solid #ddd;">

                    <!-- Small "Change Image" button -->
                    <div style="margin-top:10px;">
                        <label class="btn btn-default btn-sm">
                            Change Image
                            <input type="file" id="profile_image" name="profile_image" accept="image/*"
                                style="display:none;">
                        </label>
                    </div>
                </div>

                <!-- Edit Profile Modal Form -->
                <form id="submit-form" enctype="multipart/form-data" method="POST"
                    action="{{ route('web.dashboard.profile.update') }}">
                    @csrf
                    <div class="modal-body">
                        <!-- Name -->
                        <div class="form-group">
                            <label for="name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name">
                        </div>

                        <!-- Last Name -->
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name">
                        </div>

                        <!-- Phone -->
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" placeholder="Phone:(+923XXXXXXXXX / 03XX-XXXXXXX)"
                                name="phone" id="phone">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" placeholder="Address" name="address" id="address">
                        </div>
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" placeholder="Country" name="country" id="country">
                        </div>
                        <div class="form-group">
                            <label for="province">Province</label>
                            <input type="text" class="form-control" placeholder="Province" name="province" id="province">
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" placeholder="City" name="city" id="city">
                        </div>
                        <div class="form-group">
                            <label for="zip">Zip</label>
                            <input type="text" class="form-control" placeholder="Zip" name="zip" id="zip">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-small btn-solid-border" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-small" id="submit-btn">Update Profile</button>
                    </div>
                </form>


            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        $(document).ready(function () {

            function loadDashboardContent(url, clickedLink) {
                $('#dashboard-content').html('<div class="text-center py-5"><i class="fa fa-spinner fa-spin fa-2x"></i></div>');

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (response) {
                        $('#dashboard-content').html(response.html);
                        $('.tab-ajax').removeClass('active');
                        $(clickedLink).addClass('active');
                    },
                    error: function () {
                        $('#dashboard-content').html('<p class="text-danger text-center">Failed to load content.</p>');
                    }
                });
            }

            // Default load (Orders tab)
            let defaultUrl = $('.tab-ajax.active').data('url');
            loadDashboardContent(defaultUrl, $('.tab-ajax.active'));

            // Handle tab click
            $('.tab-ajax').on('click', function (e) {
                e.preventDefault();
                let url = $(this).data('url');
                loadDashboardContent(url, this);
            });
        });
    </script>

    @include('includes.web.ajax-requests.profile-image')
    @include('includes.web.ajax-requests.create')
    @include('includes.web.common.phone-number-script')

@endpush