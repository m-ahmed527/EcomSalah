@extends('layouts.auth.app')
@section('title', "Register | Salah Wears")
@section('content')
    <section class="signin-page account">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="block text-center">
                        <a class="logo logo-a w-100" href="{{ route('web.index') }}">
                            <img src="{{ setting('logo') ?: asset('assets/web/images/logo.png') }}" alt="logo">
                        </a>
                        <h2 class="text-center">Create Your Account</h2>
                        <form class="text-left clearfix" action="{{ route('register') }}" method="POST" id="register-form"
                            autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="First Name" name="first_name"
                                    autofocus>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Last Name" name="last_name">
                            </div>

                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Email" name="email">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Phone:(+923XXXXXXXXX / 03XX-XXXXXXX)"
                                    name="phone" id="phone">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Password" name="password">
                            </div>

                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Confirm Password"
                                    name="password_confirmation">
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-main text-center" id="register-btn">Register</button>
                            </div>
                        </form>
                        <p class="mt-20">Already hava an account ?<a href="{{ route('login') }}"> Login</a></p>
                        <p><a href="{{ route('forget-password') }}"> Forgot your password?</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    @include('includes.web.common.phone-number-script')
    @include('includes.auth.ajax-requests.register-script', ['redirectUrl' => route('web.index')])
@endpush
