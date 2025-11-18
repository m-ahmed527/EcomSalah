@include('includes.web.layout.head')

<body id="body">
    @include('includes.web.layout.header')
    @include('includes.web.layout.menu')
    @yield('content')
    @include('includes.web.layout.footer')
</body>

</html>


{{-- Saifu se banwaya hua --}}
{{-- @include('includes.web.layout.head')

<body id="body">
    @include('includes.web.layout.header')
    @yield('content')
    @include('includes.web.layout.footer')
</body>

</html> --}}