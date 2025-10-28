<!DOCTYPE html>

<!--
 // WEB/SITE: https://themefisher.com
 // TWITTER: https://twitter.com/themefisher
 // FACEBOOK: https://www.facebook.com/themefisher
 // GITHUB: https://github.com/themefisher/
-->

<html lang="en">

<head>

    <!-- Basic Page Needs
  ================================================== -->
    <meta charset="utf-8">
    <title>404 : Page Not Found</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
        content="@yield('meta_description', 'Shop premium quality T-shirts, hoodies, and fashion wear at Salah Wears. Stylish, comfortable, and made for every occasion.')">
    <meta name="keywords"
        content="@yield('meta_keywords', 'Salah Wears, clothing, fashion, t-shirts, hoodies, online store, men fashion, women fashion')">
    <meta name="author" content="Salah Wears Team">

    <!-- Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/web/images/favicon.png" ')}}/>

    <!-- Themefisher Icon font -->
    <link rel=" stylesheet" href="{{asset('assets/web/plugins/themefisher-font/style.css')}}">
    <!-- bootstrap.min css -->
    <link rel="stylesheet" href="{{asset('assets/web/plugins/bootstrap/css/bootstrap.min.css')}}">

    <!-- Animate css -->
    <link rel="stylesheet" href="{{asset('assets/web/plugins/animate/animate.css')}}">
    <!-- Slick Carousel -->
    <link rel="stylesheet" href="{{asset('assets/web/plugins/slick/slick.css')}}">
    <link rel="stylesheet" href="{{asset('assets/web/plugins/slick/slick-theme.css')}}">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{asset('assets/web/css/style.css')}}">

</head>

<body id="body">
    <section class="page-404">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <a href="index.html">
                        <img src="{{ asset('assets/web/images/logo.png') }}" alt="site logo" />
                    </a>
                    <h1>404</h1>
                    <h2>Page Not Found</h2>
                    <a href="{{ route('web.index') }}" class="btn btn-main"><i class="tf-ion-android-arrow-back"></i> Go
                        Home</a>
                    <p class="copyright-text">Copyright &copy;{{ date('Y') }}, Designed &amp; Developed by Salah Wears
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!--
    Essential Scripts
    =====================================-->

    <!-- Main jQuery -->
    <script src="{{asset('assets/web/plugins/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap 3.1 -->
    <script src="{{asset('assets/web/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- Bootstrap Touchpin -->
    <script src="{{asset('assets/web/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js')}}"></script>
    <!-- Instagram Feed Js -->
    <script src="{{asset('assets/web/plugins/instafeed/instafeed.min.js')}}"></script>
    <!-- Video Lightbox Plugin -->
    <script src="{{asset('assets/web/plugins/ekko-lightbox/dist/ekko-lightbox.min.js')}}"></script>
    <!-- Count Down Js -->
    <script src="{{asset('assets/web/plugins/syo-timer/build/jquery.syotimer.min.js')}}"></script>

    <!-- slick Carousel -->
    <script src="{{asset('assets/web/plugins/slick/slick.min.js')}}"></script>
    <script src="{{asset('assets/web/plugins/slick/slick-animation.min.js')}}"></script>

    <!-- Google Mapl -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC72vZw-6tGqFyRhhg5CkF2fqfILn2Tsw"></script>
    <script type="text/javascript" src="{{asset('assets/web/plugins/google-map/gmap.js')}}"></script>

    <!-- Main Js File -->
    <script src="{{asset('assets/web/js/script.js')}}"></script>



</body>

</html>
