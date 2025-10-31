<!-- Start Top Header Bar -->
<section class="top-header">
    <div class="container">
        <div class="header-top">
            <div class="row">
                <div class="col-md-4 col-xs-12 col-sm-4">
                    <div class="contact-number">
                        <i class="tf-ion-ios-telephone"></i>
                        <span>0129- 12323-123123</span>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12 col-sm-4">
                    <!-- Site Logo -->
                    <div class="logo text-center">
                        <a href="{{ route('web.index') }}" class="logo-a w-100">
                            <!-- replace logo here -->
                            <img src="{{ setting('logo') ?: asset('assets/web/images/logo.png') }}" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12 col-sm-4">
                    <!-- Cart -->
                    <ul class="top-menu text-right list-inline">
                        <li class="dropdown cart-nav dropdown-slide">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"
                                data-hover="dropdown"><i class="tf-ion-android-cart"></i> Cart</a>
                            <div class="dropdown-menu cart-dropdown">
                                <!-- Cart Item Start-->
                                <div class="media">
                                    <a class="pull-left" href="#!">
                                        <img class="media-object"
                                            src="{{ asset('assets/web/images/shop/cart/cart-1.jpg') }}" alt="image" />
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading"><a href="#!">Ladies Bag</a></h4>
                                        <div class="cart-price">
                                            <span>1 x</span>
                                            <span>1250.00</span>
                                        </div>
                                        <h5><strong>$1200</strong></h5>
                                    </div>
                                    <a href="#!" class="remove"><i class="tf-ion-close"></i></a>
                                </div><!-- / Cart Item End-->


                                <div class="cart-summary">
                                    <span>Total</span>
                                    <span class="total-price">$1799.00</span>
                                </div>
                                <ul class="text-center cart-buttons">
                                    <li><a href="{{ route('web.cart.index') }}" class="btn btn-small">View Cart</a></li>
                                    <li><a href="{{ route('web.checkout.index') }}"
                                            class="btn btn-small btn-solid-border">Checkout</a></li>
                                </ul>
                            </div>

                        </li><!-- / Cart -->

                        <!-- Search -->
                        <li class="dropdown search dropdown-slide">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"
                                data-hover="dropdown"><i class="tf-ion-ios-search-strong"></i> Search</a>
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
                                <i class="tf-ion-person"></i> Account
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
