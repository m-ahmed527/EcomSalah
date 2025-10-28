@extends('layouts.web.app')
@section('title', 'Your Orders')
@section('page', 'Your Orders')
@section('content')
    <section class="user-dashboard page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="list-inline dashboard-menu text-center">
                        <li><a class="active" href="{{ route('web.dashboard.orders.index') }}">Orders</a></li>
                        <li><a href="{{ route('web.dashboard.profile.index') }}">Profile Details</a></li>
                    </ul>
                    <div class="dashboard-wrapper user-dashboard">
                        @include('includes.web.dashboard-components.order')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
