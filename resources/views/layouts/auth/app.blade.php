<!DOCTYPE html>



<html lang="en">

<head>

    <!-- Basic Page Needs
  ================================================== -->
    <meta charset="utf-8">
    <title>@yield('title', 'Home | Salah Wears – Trendy & Comfortable Fashion')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
        content="@yield('meta_description', 'Shop premium quality T-shirts, hoodies, and fashion wear at Salah Wears. Stylish, comfortable, and made for every occasion.')">
    <meta name="keywords"
        content="@yield('meta_keywords', 'Salah Wears, clothing, fashion, t-shirts, hoodies, online store, men fashion, women fashion')">
    <meta name="author" content="Salah Wears Team">

    <!-- Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon"
        href="{{ setting('favicon') ?: asset('assets/web/images/favicon.png') }}" />

    <!-- Themefisher Icon font -->
    <link rel="stylesheet" href="{{asset('assets/web/plugins/themefisher-font/style.css')}}">

    <!-- Material Design Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.3.67/css/materialdesignicons.min.css" rel="stylesheet">

    <!-- bootstrap.min css -->
    <link rel="stylesheet" href="{{asset('assets/web/plugins/bootstrap/css/bootstrap.min.css')}}">

    <!-- Animate css -->
    <link rel="stylesheet" href="{{asset('assets/web/plugins/animate/animate.css')}}">
    <!-- Slick Carousel -->
    <link rel="stylesheet" href="{{asset('assets/web/plugins/slick/slick.css')}}">
    <link rel="stylesheet" href="{{asset('assets/web/plugins/slick/slick-theme.css')}}">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{asset('assets/web/css/style.css')}}">



    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
    @stack('styles')
</head>

<body id="body">



    @yield('content')











    <!--
    Essential Scripts
    =====================================-->

    <!-- Main jQuery -->
    <script src="{{asset('assets/web/plugins/jquery/dist/jquery.js')}}"></script>
    <script src="{{asset('assets/web/plugins/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap 3.1 -->
    <script src="{{asset('assets/web/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- Bootstrap Touchpin -->
    <script src="{{asset('assets/web/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js')}}"></script>
    <!-- Instagram Feed Js -->
    {{--
    <script src="{{asset('assets/web/plugins/instafeed/instafeed.min.js')}}"></script> --}}
    <!-- Video Lightbox Plugin -->
    <script src="{{asset('assets/web/plugins/ekko-lightbox/dist/ekko-lightbox.min.js')}}"></script>
    <!-- Count Down Js -->
    <script src="{{asset('assets/web/plugins/syo-timer/build/jquery.syotimer.min.js')}}"></script>

    <!-- slick Carousel -->
    <script src="{{asset('assets/web/plugins/slick/slick.min.js')}}"></script>
    <script src="{{asset('assets/web/plugins/slick/slick-animation.min.js')}}"></script>

    <!-- Google Mapl -->
    {{--
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC72vZw-6tGqFyRhhg5CkF2fqfILn2Tsw"></script>
    <script type="text/javascript" src="{{asset('assets/web/plugins/google-map/gmap.js')}}"></script> --}}


    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>





    <!-- Main Js File -->
    <script src="{{asset('assets/web/js/script.js')}}"></script>

    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
