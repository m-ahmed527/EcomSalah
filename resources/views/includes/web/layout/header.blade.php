<!-- Start Top Header Bar -->
<section class="top-header">
    <div class="container">
        <div class="header-top">
            <div class="row d-flex align-items-center">
                <div class="col-md-4 col-xs-12 col-sm-4">
                    <div class="contact-number">
                        <i class="tf-ion-ios-telephone"></i>
                        <span>0129- 12323-123123</span>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12 col-sm-4">
                    <!-- Site Logo -->
                    <div class="logo text-center">
                        <a href="{{ route('web.index') }}" class="logo-a">
                            <!-- replace logo here -->
                            <img src="{{ setting('logo') ?: asset('assets/web/images/logo.png') }}" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12 col-sm-4">
                    <!-- Cart -->
                    <ul class="top-menu text-right list-inline">
                        <li class="dropdown cart-nav dropdown-slide">
                            <a href="javascript:void(0);" data-hover="dropdown"><i
                                    class="tf-ion-android-cart view-cart-btn"></i><span class="cart-count"
                                    title="Cart">{{ session('cart.total_items', 0) }}</span> </a>
                            <div class="dropdown-menu cart-dropdown">
                                <!-- Cart Item Start-->
                                <div class="media" id="cart-drop">
                                    @php
                                        $first = collect(session('cart.items', []))->last();
                                    @endphp
                                    @if($first)
                                        <a class="pull-left" href="javascript:void(0);">
                                            <img class="media-object" id="cart-product-image"
                                                src="{{$first['product']['featured_image']  }}" alt="image" />
                                        </a>
                                        <div class="media-body">
                                            <h4 class="media-heading cart-product-name" id="cart-product-name">
                                                {{ $first['product']['name'] }}
                                            </h4>
                                            <div class="cart-price">
                                                <span id="cart-product-quantity">{{ $first['quantity'] }}x</span>
                                                <span
                                                    id="cart-product-price">{{ number_format($first['product']['base_price'] + ($first['variant']['price'] ?? 0), 2) }}</span>
                                            </div>
                                            <h5><strong id="cart-product-total">PKR
                                                    {{ number_format($first['total_price'], 2) }}</strong>
                                            </h5>
                                        </div>
                                    @else
                                        <div class="media-body">
                                            <p class="text-center">Your cart is empty</p>
                                        </div>
                                    @endif

                                </div><!-- / Cart Item End-->


                                <div class="cart-summary">
                                    <span>Total Items</span>
                                    <span class="total-price"
                                        id="cart-total-items">{{ session('cart.total_items', 0) }}</span>

                                </div>
                                <div class="cart-summary">
                                    <span>Total Amount</span>
                                    <span class="total-price" id="cart-total-amount">PKR
                                        {{ session('cart.total_amount', 0) }}</span>

                                </div>
                                <ul class="text-center cart-buttons">
                                    <li><a href="javascript:void(0);" class="btn btn-small view-cart-btn">View
                                            Cart</a></li>
                                    <li><a href="{{ route('web.checkout.index') }}"
                                            class="btn btn-small btn-solid-border">Checkout</a></li>
                                </ul>
                            </div>

                        </li><!-- / Cart -->

                        <!--wihsilist-->
                        <li class="dropdown wishlist-nav dropdown-slide">
                            <a href="javascript:void(0);" title="Wishlist"> <i
                                    class="fa-solid fa-heart view-wishlist-btn"></i>
                                <span class="wishlist-count">{{ auth()?->user()?->wishlistCount() ?? 0 }}</span>
                            </a>
                        </li>


                        <!-- Search -->

                        <li class="dropdown search dropdown-slide">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"
                                data-hover="dropdown"><i class="tf-ion-ios-search-strong"></i></a>
                            <ul class="dropdown-menu search-dropdown">
                                <li>
                                    <form action="post"><input type="search" class="form-control"
                                            placeholder="Search...">
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <!-- Auth Dropdown -->
                        <li class="dropdown auth-nav dropdown-slide">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"
                                data-hover="dropdown">
                                <i class="tf-ion-person"></i>
                            </a>
                            <ul class="dropdown-menu">
                                @guest
                                    <li><a href="{{ route('login') }}"><i class="tf-ion-log-in"></i> Login</a></li>
                                    <li><a href="{{ route('register') }}"><i class="tf-ion-plus-circled"></i> Register</a>
                                    </li>
                                @else
                                    @if(auth()->user()->role == App\Models\User::ADMIN)
                                        <li><a href="{{ route('admin.index') }}"><i class="tf-ion-ios-speedometer"></i> Admin
                                                Dashboard</a></li>
                                    @endif
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="tf-ion-log-out"></i> Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                @endguest
                            </ul>
                        </li>
                    </ul><!-- / .nav .navbar-nav .navbar-right -->
                </div>
            </div>
        </div>
    </div>
</section><!-- End Top Header Bar -->


{{-- Saifu se banwaya hua --}}
{{-- <section class="top-header">
    <div class="container">
        <div class="header-top">
            <div class="row-custom">

                <div class="col-md-3 col-xs-12 col-sm-3" style="padding: 0">
                    <!-- Site Logo -->
                    <div class="logo">
                        <a href="{{ route('web.index') }}">
                            <!-- replace logo here -->
                            <img src="{{ setting('logo') ?: asset('assets/web/images/logo.png') }}" alt="" width="100px"
                                height="110px">
                        </a>
                    </div>
                </div>

                <div class="col-md-6 col-xs-12 col-sm-6">
                    @include('includes.web.layout.menu')
                </div>

                <div class="col-md-3 col-xs-12 col-sm-3">
                    <div class="header-menu-area">
                        <!-- Cart -->
                        <ul class="top-menu text-right list-inline-2">
                            <li class="dropdown cart-nav dropdown-slide">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"
                                    data-hover="dropdown"><i class="tf-ion-android-cart"></i></a>
                                <div class="dropdown-menu cart-dropdown">
                                    <!-- Cart Item Start-->

                                    <div class="new-class">
                                        <div class="media">
                                            <a class="pull-left" href="#!">
                                                <img class="media-object"
                                                    src="{{ asset('assets/web/images/shop/cart/cart-1.jpg') }}"
                                                    alt="image" />
                                            </a>
                                            <div class="media-body">
                                                <h4 class="media-heading"><a class="" data-original-html="Ladies Bag"
                                                        href="#!">Ladies Bag</a></h4>
                                                <div class="cart-price">
                                                    <span>1 x</span>
                                                    <span>1250.00</span>
                                                </div>
                                                <h5><strong>$1200</strong></h5>
                                            </div>
                                            <a class="remove"
                                                data-original-html="&lt;i class=&quot;tf-ion-close&quot;&gt;&lt;/i&gt;"
                                                href="#!"><i class="tf-ion-close"></i></a>
                                        </div>
                                    </div>
                                    <div class="cart-summary">
                                        <span>Total</span>
                                        <span class="total-price">$1799.00</span>
                                    </div>
                                    <ul class="text-center cart-buttons">
                                        <li><a href="{{ route('web.cart.index') }}" class="btn btn-small">View Cart</a>
                                        </li>
                                        <li><a href="{{ route('web.checkout.index') }}"
                                                class="btn btn-small btn-solid-border">Checkout</a></li>
                                    </ul>
                                </div>

                            </li><!-- / Cart -->

                            <!-- Search -->
                            <li class="dropdown search dropdown-slide">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"
                                    data-hover="dropdown"><i class="tf-ion-ios-search-strong"></i></a>
                                <ul class="dropdown-menu search-dropdown">
                                    <li>
                                        <form action="post"><input type="search" class="form-control"
                                                placeholder="Search...">
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            <!-- Auth Dropdown -->
                            <li class="dropdown auth-nav dropdown-slide">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"
                                    data-hover="dropdown">
                                    <i class="tf-ion-person"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    @guest
                                    <li><a href="{{ route('login') }}"><i class="tf-ion-log-in"></i> Login</a></li>
                                    <li><a href="{{ route('register') }}"><i class="tf-ion-plus-circled"></i>
                                            Register</a>
                                    </li>
                                    @else
                                    @if (auth()->user()->role == App\Models\User::ADMIN)
                                    <li><a href="{{ route('admin.index') }}"><i class="tf-ion-ios-speedometer"></i>
                                            Admin
                                            Dashboard</a></li>
                                    @endif
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="tf-ion-log-out"></i> Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                    @endguest
                                </ul>
                            </li>

                        </ul><!-- / .nav .navbar-nav .navbar-right -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed my-menu" data-target="#navbar"
                                aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>

                        </div><!-- / .navbar-header -->

                        <div class="side-bar-custom">
                            <div class="position-relative">
                                <button class="cross-btn">
                                    x
                                </button>
                            </div>
                            @include('includes.web.layout.menu')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- End Top Header Bar --> --}}

{{-- @php
$routeName = request()->route()->getName();
$show = str_contains($routeName, 'show');
$index = $routeName != 'web.index';
@endphp
@if ($index)
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="content">
                    <h1 class="page-name">@yield('page')</h1>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('web.index') }}">Home</a></li>
                        <li class="{{ $show ? 'active' : '' }}">
                            @if ($show)
                            <a href=@yield('url')>@yield('page')</a>
                            @else
                            @yield('page')
                            @endif
                        </li>
                        @if ($show)
                        <li class="active">@yield('detail')</li>
                        @endif
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<script>
    let menuBtn = document.querySelector(".my-menu");
    let crossBtn = document.querySelector(".cross-btn");
    let sideBar = document.querySelector(".side-bar-custom");

    menuBtn.addEventListener("click", () => {
        if (sideBar.classList.contains("active")) {
            sideBar.classList.remove("active")
        } else {
            sideBar.classList.add("active")
        }
    });

    crossBtn.addEventListener("click", () => {
        sideBar.classList.remove("active");
    })
</script> --}}
