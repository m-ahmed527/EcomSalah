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

    {{-- jQuery required --}}

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


@endpush
