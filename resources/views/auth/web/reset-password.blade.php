@extends('layouts.auth.app')
@section('title', "Reset Password | Salah Wears")
@section('content')

    <section class="forget-password-page account">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="block text-center">
                        <a class="logo" href="{{ route('web.index') }}">
                            <img src="{{ setting('logo') ?: asset('assets/web/images/logo.png') }}" alt="" width="150px">
                        </a>
                        <h2 class="text-center">Welcome Back</h2>
                        <form class="text-left clearfix">
                            <p>Please enter your new password and confirm it.</p>
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-main text-center">Reset Password</button>
                            </div>
                        </form>
                        <p class="mt-20"><a href="{{ route('login') }}">Back to log in</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
