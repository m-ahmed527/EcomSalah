<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | Salah Wears</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Material Design Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.3.67/css/materialdesignicons.min.css" rel="stylesheet">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="shortcut icon" type="image/x-icon"
        href="{{ setting('favicon') ?: asset('assets/web/images/favicon.png') }}" />
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{asset('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/jqvmap/jqvmap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/admin/dist/css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/summernote/summernote-bs4.min.css')}}">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet"
        href="{{asset('assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet"
        href="{{asset('assets/admin/plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css')}}">



    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
    @stack('styles')
    <style>
        .image-viewer-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.95);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .image-viewer-img {
            max-width: 90%;
            max-height: 80%;
            transition: transform 0.3s ease;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
        }

        .image-viewer-controls {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 2rem;
            color: #fff;
            cursor: pointer;
            user-select: none;
        }

        .image-viewer-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 3rem;
            color: #fff;
            cursor: pointer;
            user-select: none;
            padding: 0 20px;
        }

        .image-viewer-arrow.left {
            left: 0;
        }

        .image-viewer-arrow.right {
            right: 0;
        }

        .image-viewer-zoom-controls {
            position: absolute;
            bottom: 30px;
            display: flex;
            gap: 15px;
        }

        .image-viewer-zoom-btn {
            font-size: 1.8rem;
            color: #fff;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 15px;
            border-radius: 8px;
            cursor: pointer;
            user-select: none;
            transition: background 0.3s;
        }

        .image-viewer-zoom-btn:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        .action-buttons .btn {
            margin-left: 8px !important;
        }

        /* For classic select2 (single select) */
        .select2-container--default .select2-selection--single.is-invalid {
            border-color: #dc3545 !important;
            padding-right: 2.25rem;
            background-position: right calc(.375em + .1875rem) center;
            background-repeat: no-repeat;
            background-size: calc(.75em + .375rem) calc(.75em + .375rem);
        }

        /* For multiple select */
        .select2-container--default .select2-selection--multiple.is-invalid {
            border-color: #dc3545 !important;
        }
    </style>

</head>
