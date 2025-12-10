<!doctype html>
<html class="no-js" lang="en">

<body>
    @include('includes.auth.layout.head')
    <!-- Body main wrapper start -->
    <div class="wrapper login">
        @include('includes.auth.layout.header')


        @yield('content')


        @include('includes.auth.layout.footer')

    </div>
    <!-- Body main wrapper end -->
    @include('includes.auth.layout.foot')
</body>

</html>
