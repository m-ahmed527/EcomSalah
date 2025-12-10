@extends('layouts.auth.app')
@section('content')
    <!-- Account Area Start -->
    <div class="account-area ptb-80">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('login') }}" method="POST" id="login-form input" class="login-side">
                        @csrf
                        <div class="login-reg">
                            <h3>Login</h3>
                            <div class="input-box mb-20">
                                <label class="control-label">E-Mail</label>
                                <input type="email" placeholder="E-Mail" value="" name="email" class="info">
                            </div>
                            <div class="input-box">
                                <label class="control-label">Password</label>
                                <input type="password" placeholder="Password" value="" name="password" class="info">
                            </div>
                        </div>
                        <div class="frm-action">
                            <div class="input-box tci-box">
                                <a type="button" id="login-btn" class="btn-def btn2">Login</a>
                            </div>
                            <span>
                                <input class="remr" type="checkbox"> Remember me
                            </span>
                            <a href="#" class="forgotten forg">Forgotten Password</a>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 lr2">
                    <form action="#">
                        <div class="login-reg">
                            <h3>Register</h3>
                            <div class="input-box mb-20">
                                <label class="control-label">E-Mail</label>
                                <input type="email" class="info" placeholder="E-Mail" value="" name="email">
                            </div>
                            <div class="input-box">
                                <label class="control-label">Password</label>
                                <input type="password" class="info" placeholder="Password" value="" name="password">
                            </div>
                        </div>
                        <div class="frm-action">
                            <div class="input-box tci-box">
                                <a href="#" class="btn-def btn2">Register</a>
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
    @include('includes.auth.ajax-requests.login-script',['redirectUrl' => route('web.index')])
@endpush
