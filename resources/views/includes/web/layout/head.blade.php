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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
    @stack('styles')
    {{-- <style>
        .header-top .row {
            align-items: center;
            /* vertically center all columns */
        }

        .header-top .logo img {
            max-width: 120px;
            /* control size of logo */
            height: auto;
            display: inline-block;
        }

        .header-top .contact-number {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .header-top .contact-number i {
            font-size: 16px;
        }

        .header-top .col-md-4 {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-top .col-md-4:first-child {
            justify-content: flex-start;
            /* left side */
        }

        .header-top .col-md-4:last-child {
            justify-content: flex-end;
            /* right side */
        }
    </style> --}}
</head>
