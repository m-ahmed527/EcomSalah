<!doctype html>
<html class="no-js" lang="en">

<body>
    @include('includes.web.layout.head')
    <!-- Body main wrapper start -->
    <div class="wrapper home-one">

        @if (!in_array(request()->path(), ['login', 'register']))
            @include('includes.web.layout.header')
        @endif


        @yield('content')
        @if (!in_array(request()->path(), ['login', 'register']))
            @include('includes.web.layout.footer')
        @endif
    </div>
    <!-- Body main wrapper end -->
    @include('includes.web.layout.foot')
</body>

</html>
