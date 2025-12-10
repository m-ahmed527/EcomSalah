<!doctype html>
<html class="no-js" lang="en">

<body>
    @include('includes.web.layout.head')
    <!-- Body main wrapper start -->
    <div class="wrapper home-one">
        @include('includes.web.layout.header')


        @yield('content')


        @include('includes.web.layout.footer')

    </div>
    <!-- Body main wrapper end -->
    @include('includes.web.layout.foot')
</body>

</html>
