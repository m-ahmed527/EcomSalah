@extends('layouts.web.app')

@section('title', 'Blogs By Salah Wears')
@section('page', 'Blog')

@section('content')
    <div class="page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="post">
                        <div class="post-thumb">
                            <a href="blog-single.html">
                                <img class="img-responsive" src="{{ asset('assets/web/images/blog/blog-post-1.jpg') }}"
                                    alt="">
                            </a>
                        </div>
                        <h2 class="post-title"><a href="blog-single.html">How To Wear Bright Shoes</a></h2>
                        <div class="post-meta">
                            <ul>
                                <li>
                                    <i class="tf-ion-ios-calendar"></i> 20, MAR 2017
                                </li>
                                <li>
                                    <i class="tf-ion-android-person"></i> POSTED BY ADMIN
                                </li>
                                <li>
                                    <a href="blog-grid.html"><i class="tf-ion-ios-pricetags"></i> LIFESTYLE</a>,<a
                                        href="blog-grid.html"> TRAVEL</a>, <a href="blog-grid.html">FASHION</a>
                                </li>
                                <li>
                                    <a href="#!"><i class="tf-ion-chatbubbles"></i> 4 COMMENTS</a>
                                </li>
                            </ul>
                        </div>
                        <div class="post-content">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit vitae placeat ad architecto
                                nostrum
                                asperiores vel aperiam, veniam eum nulla. Maxime cum magnam, adipisci architecto quibusdam
                                cumque veniam
                                fugiat quae. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio vitae ab
                                doloremque accusamus
                                sit, eos dolorum officiis a perspiciatis aliquid. Lorem ipsum dolor sit amet, consectetur
                                adipisicing
                                elit. Quod, facere. </p>
                            <a href="blog-single.html" class="btn btn-main">Continue Reading</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="post">
                        <div class="post-thumb">
                            <a href="blog-single.html">
                                <img class="img-responsive" src="{{ asset('assets/web/images/blog/blog-post-1.jpg') }}"
                                    alt="">
                            </a>
                        </div>
                        <h2 class="post-title"><a href="blog-single.html">Two Ways To Wear Straight Shoes</a></h2>
                        <div class="post-meta">
                            <ul>
                                <li>
                                    <i class="tf-ion-ios-calendar"></i> 20, MAR 2017
                                </li>
                                <li>
                                    <i class="tf-ion-android-person"></i> POSTED BY ADMIN
                                </li>
                                <li>
                                    <a href="blog-left-sidebar.html"><i class="tf-ion-ios-pricetags"></i> LIFESTYLE</a>,<a
                                        href="blog-left-sidebar.html"> TRAVEL</a>, <a
                                        href="blog-left-sidebar.html">FASHION</a>
                                </li>
                                <li>
                                    <a href="#!"><i class="tf-ion-chatbubbles"></i> 4 COMMENTS</a>
                                </li>
                            </ul>
                        </div>
                        <div class="post-content">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit vitae placeat ad architecto
                                nostrum
                                asperiores vel aperiam, veniam eum nulla. Maxime cum magnam, adipisci architecto quibusdam
                                cumque veniam
                                fugiat quae. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio vitae ab
                                doloremque accusamus
                                sit, eos dolorum officiis a perspiciatis aliquid. Lorem ipsum dolor sit amet, consectetur
                                adipisicing
                                elit. Quod, facere</p>
                            <a href="blog-single.html" class="btn btn-main">Continue Reading</a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="text-center">
                <ul class="pagination post-pagination">
                    <li><a href="blog-left-sidebar.html">Prev</a>
                    </li>
                    <li class="active"><a href="blog-left-sidebar.html">1</a>
                    </li>
                    <li><a href="blog-left-sidebar.html">2</a>
                    </li>
                    <li><a href="blog-left-sidebar.html">3</a>
                    </li>
                    <li><a href="blog-left-sidebar.html">4</a>
                    </li>
                    <li><a href="blog-left-sidebar.html">5</a>
                    </li>
                    <li><a href="blog-left-sidebar.html">Next</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

@endsection
