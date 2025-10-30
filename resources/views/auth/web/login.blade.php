@extends('layouts.auth.app')
@section('title', "Login | Salah Wears")
@section('content')

    <section class="signin-page account">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="block text-center">
                        <a class="logo logo-a" href="{{ route('web.index') }}">
                            <img src="{{ setting('logo') ?: asset('assets/web/images/logo.png') }}" alt="" width="150px"
                                height="110px">
                        </a>
                        <h2 class="text-center">Welcome Back</h2>
                        <form class="text-left clearfix" action="{{ route('login') }}" method="POST" id="login-form"
                            autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Email" name="email" autofocus>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Password" name="password">
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-main text-center" id="login-btn">Login</button>
                            </div>
                        </form>
                        <p class="mt-20">New in this site ?<a href="{{ route('register') }}"> Create New Account</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    @include('includes.auth.ajax-requests.login-script', ['redirectUrl' => route('web.index')])
@endpush
