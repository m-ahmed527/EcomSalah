<!-- Main Menu Section -->
<section class="menu">
    <nav class="navbar navigation">
        <div class="container">
            <div class="navbar-header">
                <h2 class="menu-title">Main Menu</h2>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

            </div><!-- / .navbar-header -->

            <!-- Navbar Links -->
            <div id="navbar" class="navbar-collapse collapse text-center">
                <ul class="nav navbar-nav">


                    <li class="dropdown">
                        <a href="{{ route('web.index') }}">Home</a>
                    </li>



                    <li class="dropdown dropdown-slide">
                        <a href="{{ route('web.product.index') }}">Products </a>

                    </li>



                    <li class="dropdown full-width dropdown-slide">
                        <a href="{{ route('web.about.index') }}">About Us </a>
                    </li>



                    <li class="dropdown dropdown-slide">
                        <a href="{{ route('web.blog.index') }}">Blog</a>

                    </li>

                    @auth
                        <li class="dropdown dropdown-slide">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"
                                data-hover="dropdown" data-delay="350" role="button" aria-haspopup="true"
                                aria-expanded="false">Dashboard <span class="tf-ion-ios-arrow-down"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('web.dashboard.profile.index') }}">Profile</a></li>
                                <li><a href="{{ route('web.dashboard.orders.index') }}">Orders</a></li>

                            </ul>
                        </li>
                    @endauth
                </ul><!-- / .nav .navbar-nav -->

            </div>
            <!--/.navbar-collapse -->
        </div><!-- / .container -->
    </nav>
</section>
@php
    $routeName = request()->route()->getName();
    $show = str_contains($routeName, 'show');
    $index = $routeName != 'web.index';
@endphp
@if($index)
    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1 class="page-name">@yield('page')</h1>
                        <ol class="breadcrumb">
                            <li><a href="{{ route('web.index') }}">Home</a></li>
                            <li class="{{ $show ? 'active' : '' }}">
                                @if($show)
                                    <a href=@yield('url')>@yield('page')</a>
                                @else
                                    @yield('page')
                                @endif
                            </li>
                            @if($show)
                                <li class="active">@yield('detail')</li>
                            @endif
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
