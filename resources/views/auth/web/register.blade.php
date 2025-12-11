@extends('layouts.web.app')
@section('content')
    <!-- Account Area Start -->
    <div class="account-area ptb-80">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-12 d-flex justify-content-center align-items-center">
                    <div class="logo ptb-20"><a href="{{ route('web.index') }}">
                            <img src="{{ asset('assets/web/images/logo/logo.png') }}" alt="main logo"></a>
                    </div>
                </div>
                <div class="col-md-12 lr2">
                    <form action="{{ route('register') }}" method="POST" id="register-form">
                        @csrf
                        <div class="login-reg">
                            <div class="row">
                                <h3>Register</h3>
                                <div class="input-box mb-20 col-md-6">
                                    <label class="control-label">First Name</label>
                                    <input type="text" class="info" placeholder="First Name" name="first_name">
                                </div>
                                <div class="input-box mb-20 col-md-6">
                                    <label class="control-label">Last Name</label>
                                    <input type="text" class="info" placeholder="Last Name" name="last_name">
                                </div>
                                <div class="input-box mb-20 col-md-6">
                                    <label class="control-label">E-Mail</label>
                                    <input type="email" class="info" placeholder="E-Mail" name="email">
                                </div>
                                <div class="input-box mb-20 col-md-6">
                                    <label class="control-label">Phone</label>
                                    <input type="text" class="info" placeholder="Phone:(+923XXXXXXXXX / 03XX-XXXXXXX)"
                                        name="phone" id="phone">
                                </div>
                                <div class="input-box col-md-6">
                                    <label class="control-label">Password</label>
                                    <input type="password" class="info" placeholder="Password" name="password">
                                </div>
                                <div class="input-box col-md-6">
                                    <label class="control-label">Password</label>
                                    <input type="password" class="info" placeholder="Confirm Password"
                                        name="password_confirmation">
                                </div>
                            </div>
                        </div>
                        <div class="frm-action">
                            <div class="input-box tci-box">
                                <a href="#" class="btn-def btn2" id="register-btn">Register</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Account Area End -->

@endsection
@push('scripts')
    @include('includes.web.common.phone-number-script')
    @include('includes.auth.ajax-requests.register-script', ['redirectUrl' => route('web.index')])
@endpush
