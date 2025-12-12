<!-- Start of header area -->
<header class="header-area header-wrapper">
    <div class="header-top-bar black-bg clearfix">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-6">
                    <div class="login-register-area">
                        <ul>
                            @guest
                                <li><a href="{{ route('login') }}">Login</a></li>
                                <li><a href="{{ route('register') }}">Register</a></li>
                            @else
                                @if(auth()->user()->role == App\Models\User::ADMIN)
                                    <li><a href="{{ route('admin.index') }}">Admin Dashboard</a></li>
                                @endif
                                <li><a href="javascript:void(0)"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                </li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            @endguest
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 d-none d-md-block">
                    <div class="social-search-area text-center">
                        <div class="social-icon socile-icon-style-2">
                            {{-- <ul>
                                <li><a href="#" title="facebook"><i class="fa fa-facebook"></i></a> </li>
                                <li><a href="#" title="twitter"><i class="fa fa-twitter"></i></a> </li>
                                <li> <a href="#" title="dribble"><i class="fa fa-dribbble"></i></a></li>
                                <li> <a href="#" title="behance"><i class="fa fa-behance"></i></a> </li>
                                <li> <a href="#" title="rss"><i class="fa fa-rss"></i></a> </li>
                            </ul> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-6">
                    <div class="cart-currency-area login-register-area text-end">
                        <ul>
                            {{-- <li>
                                <div class="header-currency">
                                    <select>
                                        <option value="1">USD</option>
                                        <option value="2">Pound</option>
                                        <option value="3">Euro</option>
                                        <option value="4">Dinar</option>
                                    </select>
                                </div>
                            </li> --}}
                            <li>
                                <div class="header-cart">
                                    <div class="cart-icon"> <a href="#">Cart<i class="zmdi zmdi-shopping-cart"></i></a>
                                        <span>2</span>
                                    </div>
                                    <div class="cart-content-wraper">
                                        <div class="cart-single-wraper">
                                            <div class="cart-img">

                                                <a href="#"><img src="{{asset('assets/web/images/product/01.webp')}}"
                                                        alt=""></a>
                                            </div>
                                            <div class="cart-content">
                                                <div class="cart-name"> <a href="#">Aenean Eu Tristique</a>
                                                </div>
                                                <div class="cart-price"> $70.00 </div>
                                                <div class="cart-qty"> Qty: <span>1</span> </div>
                                            </div>
                                            <div class="remove"> <a href="#"><i class="zmdi zmdi-close"></i></a>
                                            </div>
                                        </div>
                                        <div class="cart-single-wraper">
                                            <div class="cart-img">

                                                <a href="#"><img src="{{asset('assets/web/images/product/02.webp')}}"
                                                        alt=""></a>
                                            </div>
                                            <div class="cart-content">
                                                <div class="cart-name"> <a href="#">Aenean Eu Tristique</a>
                                                </div>
                                                <div class="cart-price"> $70.00 </div>
                                                <div class="cart-qty"> Qty: <span>1</span> </div>
                                            </div>
                                            <div class="remove"> <a href="#"><i class="zmdi zmdi-close"></i></a>
                                            </div>
                                        </div>
                                        <div class="cart-subtotal"> Subtotal: <span>$200.00</span> </div>
                                        <div class="cart-check-btn">
                                            <div class="view-cart"> <a class="btn-def" href="cart.html">View
                                                    Cart</a> </div>
                                            <div class="check-btn"> <a class="btn-def" href="checkout.html">Checkout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="sticky-header" class="header-middle-area">
        <div class="container">
            <div class="full-width-mega-dropdown">
                <div class="row">
                    <div class="col-md-2">
                        <div class="logo ptb-20"><a href="index.html">
                                <img src="{{ asset('assets/web/images/logo/logo.png') }}" alt="main logo"></a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-10 d-none d-md-block">
                        <nav id="primary-menu">
                            <ul class="main-menu">
                                <li class=""><a class="" href="{{ route('web.index') }}">HOME</a></li>
                                <li class="mega-parent pos-rltv"><a href="{{ route('web.product.index') }}">PRODUCTS</a>
                                </li>

                                {{-- <li class="mega-parent"><a href="shop.html">Shortcut</a>
                                    <div class="mega-menu-area mma-970">
                                        <ul class="single-mega-item">
                                            <li class="menu-title uppercase">Shortcode-01</li>
                                            <li><a href="shortcode-banner.html">shortcode-banner</a></li>
                                            <li><a href="shortcode-best-top-on-sale-slider.html">too-on-sale</a>
                                            </li>
                                            <li><a href="shortcode-blog-item.html">Short Blog
                                                    Item</a></li>
                                            <li><a href="shortcode-brand-prodcut.html">Brand
                                                    Product</a></li>
                                            <li><a href="shortcode-brand-slider.html">Brand
                                                    Slider</a></li>
                                        </ul>
                                        <ul class="single-mega-item">
                                            <li class="menu-title uppercase">Shortcode-02</li>
                                            <li><a href="shortcode-breadcrumb.html">Breadcrumb</a></li>
                                            <li><a href="shortcode-related-product.html">Related
                                                    Product</a></li>
                                            <li><a href="shortcode-service.html">Service</a>
                                            </li>
                                            <li><a href="shortcode-skill.html">Skill</a></li>
                                            <li><a href="shortcode-slider.html">Slider</a></li>
                                        </ul>
                                        <ul class="single-mega-item">
                                            <li class="menu-title uppercase">Shortcode-03</li>
                                            <li><a href="shortcode-team.html">Team</a></li>
                                            <li><a href="shortcode-testimonial.html">Testimonial</a></li>
                                            <li><a href="shortcode-why-choose-us.html">Why
                                                    Choose Us</a></li>
                                        </ul>
                                    </div>
                                </li> --}}
                                <li class="mega-parent"><a href="{{ route('web.contact.index') }}">CONTACT US </a></li>
                                <li><a href="{{ route('web.blog.index') }}">BLOG</a></li>
                                <li><a href="{{ route('web.about.index') }}">ABOUT US</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-lg-3 d-none d-lg-block">
                        <div class="search-box global-table">
                            <div class="global-row">
                                <div class="global-cell">
                                    <form action="#">
                                        <div class="input-box">
                                            <input class="single-input" placeholder="Search anything" type="text">
                                            <button class="src-btn"><i class="fa fa-search"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- mobile-menu-area start -->
                    <div class="mobile-menu-area">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <nav id="dropdown">
                                        <ul>
                                            <li><a href="{{ route('web.index') }}">Home</a></li>

                                            <li><a href="{{ route('web.product.index') }}">Shop</a></li>
                                            <li><a href="{{ route('web.contact.index') }}">CONTACT US </a></li>
                                            <li><a href="{{ route('web.blog.index') }}">BLOG</a></li>
                                            <li><a href="{{ route('web.about.index') }}">ABOUT US</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--mobile menu area end-->
                </div>
            </div>
        </div>
    </div>
</header>
<!-- End of header area -->
