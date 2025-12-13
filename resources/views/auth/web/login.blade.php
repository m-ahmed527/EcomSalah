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
                <div class="col-md-6">
                    <form action="{{ route('login') }}" method="POST" id="login-form" class="login-side">
                        @csrf
                        <div class="login-reg">
                            <h3>Login</h3>
                            <div class="input-box mb-20">
                                <label class="control-label">E-Mail</label>
                                <input type="email" placeholder="E-Mail" value="" name="email" id="login-email"
                                    class="info">
                            </div>
                            <div class="input-box">
                                <label class="control-label">Password</label>
                                <input type="password" placeholder="Password" value="" name="password" id="login-password"
                                    class="info password">
                                <!-- 👁 Eye icon -->
                                <span class="toggle-password"
                                    style="position:absolute; right:15px; top:40px; cursor:pointer; font-size:17px;">
                                    <i class="fa fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        <div class="frm-action">
                            <div class="input-box tci-box">
                                <a type="button" id="login-btn" class="btn-def btn2">Login</a>
                            </div>
                            <span>
                                <input class="remr" type="checkbox"> Remember me
                            </span>
                            <a href="#" class="forgotten forg">Forgotten Password.</a>
                            <a href="{{ route('register') }}" class="forgotten forg">Don't have an account?</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Account Area End -->

@endsection
@push('scripts')
    @include('includes.auth.ajax-requests.login-script', ['redirectUrl' => route('web.index')])


@endpush
