@extends('layouts.web.app')
@section('content')
    <!--404 area start-->
    <div class="area-404 ptb-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="content-404 text-center">
                        <img src="images/img_404.png" alt="">
                        <div class="text-404">
                            <h1>404: Not Found</h1>
                            <h1>Oops ! that page can't be found.</h1>

                        </div>
                        <div class="search-box serch-404">
                            <div class="input-box tci-box">
                                <a type="button" id="login-btn" class="btn-def btn2"
                                    onclick="event.preventDefault(); history.back()">
                                    <i class="fa fa-arrow-left"></i>Go Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--404 area end-->
@endsection
