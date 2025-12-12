@extends('layouts.web.app')
@section('content')

    <!--breadcumb area start -->
    <div class="breadcumb-area breadcumb-2 overlay pos-rltv">
        <div class="bread-main">
            <div class="bred-hading text-center">
                <h5>Product Grid View</h5>
            </div>
            <ol class="breadcrumb">
                <li class="home"><a title="Go to Home Page" href="index.html">Home</a></li>
                <li class="active">Shop</li>
            </ol>
        </div>
    </div>
    <!--breadcumb area end -->

    <!--shop main area are start-->
    <div class="shop-main-area grid-view_area ptb-70">
        <div class="container">
            <div class="row">
                <!--main-shop-product start-->
                <div class="col-lg-9 col-md-8 order-lg-2 order-md-2 order-1">
                    <div class="shop-wraper">
                        <div class="col-lg-12">
                            <div class="shop-area-top">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-9 col-md-9">

                                        <div class="sort product-type">
                                            <label>Sort By</label>
                                            <select id="input-sort">
                                                <option value="">Default</option>
                                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)
                                                </option>
                                                <option value="price_low_high" {{ request('sort') == 'price_low_high' ? 'selected' : '' }}>Price
                                                    (Low &gt; High)</option>
                                                <option value="price_high_low" {{ request('sort') == 'price_high_low' ? 'selected' : '' }}>Price
                                                    (High &gt; Low)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3">
                                        <div class="list-grid-view text-center">
                                            <ul class="nav" role="tablist">
                                                {{-- <li role="presentation"><a class="active" href="#grid"
                                                        aria-controls="grid" role="tab" data-bs-toggle="tab"><i
                                                            class="zmdi zmdi-widgets"></i></a>
                                                </li> --}}
                                                {{-- <li role="presentation"><a href="#list" aria-controls="list" role="tab"
                                                        data-bs-toggle="tab"><i class="zmdi zmdi-view-list-alt"></i></a>
                                                </li> --}}
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 d-lg-none d-xl-block d-none">
                                        <div class="total-showing text-end showing-res" id="showing-results-container">
                                            Showing <span class="fw-semibold">{{ $products->firstItem() }}</span>
                                            to <span class="fw-semibold">{{ $products->lastItem() }}</span>
                                            of <span class="fw-semibold">{{ $products->total() }}</span> results
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-12">
                            <div class="shop-total-product-area clearfix mt-35">
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <!--tab grid are start-->
                                    <div role="tabpanel" class="tab-pane fade show active " id="grid">
                                        <div class="total-shop-product-grid row product-list">
                                            @include('screens.web.product.partials.list')
                                        </div>
                                    </div>
                                    <!--shop grid are end-->



                                    <!--pagination start-->
                                    <div class="col-lg-12 pagination-div">
                                        @include('screens.web.product.partials.pagination')
                                    </div>
                                    <!--pagination end-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--main-shop-product start-->

                <!--shop sidebar start-->
                <div class="col-lg-3 col-md-4 order-lg-1 order-md-1 order-2">
                    <div class="shop-sidebar">
                        <!--single aside start-->
                        <aside class="single-aside search-aside search-box">
                            <form action="#">
                                <div class="input-box">
                                    <input class="single-input" placeholder="Search...." type="text">
                                    <button class="src-btn sb-2"><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </aside>
                        <!--single aside end-->

                        <!--single aside start-->
                        <aside class="single-aside catagories-aside">
                            <div class="heading-title aside-title pos-rltv">
                                <h5 class="uppercase">categories</h5>
                            </div>
                            <div id="cat-treeview" class="product-cat">
                                <ul>
                                    @foreach($categories as $cat)
                                        <li class="{{ $cat->childrenRecursive->count() ? 'closed' : ''}}">
                                            <a href="#">{{ $cat->name }}</a>
                                            @if($cat->childrenRecursive->count())
                                                <ul>
                                                    @include('screens.web.product.partials.categories-recursion', ['children' => $cat->childrenRecursive])
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        </aside>
                        <!--single aside end-->

                        <!--single aside start-->
                        <aside class="single-aside price-aside fix">
                            <div class="heading-title aside-title pos-rltv">
                                <h5 class="uppercase">price</h5>
                            </div>
                            <div class="price_filter">
                                <div id="slider-range"></div>
                                <div class="price_slider_amount d-flex justify-content-center">
                                    <div class="" id="amount"></div>
                                    <input type="hidden" id="min_price" name="min_price">
                                    <input type="hidden" id="max_price" name="max_price">
                                </div>
                                <button class="btn btn-secondary" id="price-range-btn">Filter</button>
                            </div>
                        </aside>
                        <!--single aside end-->



                        <!--single aside start-->
                        <aside class="single-aside tag-aside">
                            <div class="heading-title aside-title pos-rltv">
                                <h5 class="uppercase">Product Tags</h5>
                            </div>
                            <ul class="tag-filter mt-30">
                                <li><a href="#">Fashion</a></li>
                                <li><a href="#">Women</a></li>
                                <li><a href="#">Winter</a></li>
                                <li><a href="#">Street Style</a></li>
                                <li><a href="#">Style</a></li>
                                <li><a href="#">Shop</a></li>
                                <li><a href="#">Collection</a></li>
                                <li><a href="#">Spring 2022</a></li>
                            </ul>
                        </aside>
                        <!--single aside end-->

                        {{-- <!--single aside start-->
                        <aside class="single-aside product-aside">
                            <div class="heading-title aside-title pos-rltv">
                                <h5 class="uppercase">Recent Product</h5>
                            </div>
                            <div class="recent-prodcut-wraper total-rectnt-slider">
                                <div class="single-rectnt-slider">
                                    <!-- single product start-->
                                    <div class="single-product recent-single-product">
                                        <div class="product-img">
                                            <div class="single-prodcut-img  product-overlay pos-rltv">
                                                <a href="single-product.html"> <img alt=""
                                                        src="{{asset('assets/web/images/product/rp01.webp')}}"
                                                        class="primary-image">
                                                    <img alt="" src="{{asset('assets/web/images/product/rp02.webp')}}"
                                                        class="secondary-image"> </a>
                                            </div>
                                        </div>
                                        <div class="product-text">
                                            <div class="prodcut-name"> <a href="single-product.html">Copenhagen
                                                    Spitfire Chair</a> </div>
                                            <div class="prodcut-ratting-price">
                                                <div class="prodcut-ratting"> <a href="#"><i class="fa fa-star"></i></a> <a
                                                        href="#"><i class="fa fa-star"></i></a> <a href="#"><i
                                                            class="fa fa-star"></i></a> <a href="#"><i
                                                            class="fa fa-star"></i></a> <a href="#"><i
                                                            class="fa fa-star-o"></i></a> </div>
                                                <div class="prodcut-price">
                                                    <div class="new-price"> $220 </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- single product end-->

                                    <!-- single product start-->
                                    <div class="single-product recent-single-product">
                                        <div class="product-img">
                                            <div class="single-prodcut-img  product-overlay pos-rltv">
                                                <a href="single-product.html"> <img alt=""
                                                        src="{{asset('assets/web/images/product/rp03.webp')}}"
                                                        class="primary-image">
                                                    <img alt="" src="{{asset('assets/web/images/product/rp04.webp')}}"
                                                        class="secondary-image"> </a>
                                            </div>
                                        </div>
                                        <div class="product-text">
                                            <div class="prodcut-name"> <a href="single-product.html">Copenhagen
                                                    Spitfire Chair</a> </div>
                                            <div class="prodcut-ratting-price">
                                                <div class="prodcut-ratting"> <a href="#"><i class="fa fa-star"></i></a> <a
                                                        href="#"><i class="fa fa-star"></i></a> <a href="#"><i
                                                            class="fa fa-star"></i></a> <a href="#"><i
                                                            class="fa fa-star"></i></a> <a href="#"><i
                                                            class="fa fa-star-o"></i></a> </div>
                                                <div class="prodcut-price">
                                                    <div class="new-price"> $220 </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- single product end-->

                                    <!-- single product start-->
                                    <div class="single-product recent-single-product">
                                        <div class="product-img">
                                            <div class="single-prodcut-img  product-overlay pos-rltv">
                                                <a href="single-product.html"> <img alt=""
                                                        src="{{asset('assets/web/images/product/rp02.webp')}}"
                                                        class="primary-image">
                                                    <img alt="" src="{{asset('assets/web/images/product/rp03.webp')}}"
                                                        class="secondary-image"> </a>
                                            </div>
                                        </div>
                                        <div class="product-text">
                                            <div class="prodcut-name"> <a href="single-product.html">Copenhagen
                                                    Spitfire Chair</a> </div>
                                            <div class="prodcut-ratting-price">
                                                <div class="prodcut-ratting"> <a href="#"><i class="fa fa-star"></i></a> <a
                                                        href="#"><i class="fa fa-star"></i></a> <a href="#"><i
                                                            class="fa fa-star"></i></a> <a href="#"><i
                                                            class="fa fa-star"></i></a> <a href="#"><i
                                                            class="fa fa-star-o"></i></a> </div>
                                                <div class="prodcut-price">
                                                    <div class="new-price"> $220 </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- single product end-->

                                    <!-- single product start-->
                                    <div class="single-product recent-single-product">
                                        <div class="product-img">
                                            <div class="single-prodcut-img  product-overlay pos-rltv">
                                                <a href="single-product.html"> <img alt=""
                                                        src="{{asset('assets/web/images/product/rp04.webp')}}"
                                                        class="primary-image">
                                                    <img alt="" src="{{asset('assets/web/images/product/rp01.webp')}}"
                                                        class="secondary-image"> </a>
                                            </div>
                                        </div>
                                        <div class="product-text">
                                            <div class="prodcut-name"> <a href="single-product.html">Copenhagen
                                                    Spitfire Chair</a> </div>
                                            <div class="prodcut-ratting-price">
                                                <div class="prodcut-ratting"> <a href="#"><i class="fa fa-star"></i></a> <a
                                                        href="#"><i class="fa fa-star"></i></a> <a href="#"><i
                                                            class="fa fa-star"></i></a> <a href="#"><i
                                                            class="fa fa-star"></i></a> <a href="#"><i
                                                            class="fa fa-star-o"></i></a> </div>
                                                <div class="prodcut-price">
                                                    <div class="new-price"> $220 </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- single product end-->
                                </div>
                                <div class="single-rectnt-slider">
                                    <!-- single product start-->
                                    <div class="single-product recent-single-product">
                                        <div class="product-img">
                                            <div class="single-prodcut-img  product-overlay pos-rltv">
                                                <a href="single-product.html"> <img alt=""
                                                        src="{{asset('assets/web/images/product/rp01.webp')}}"
                                                        class="primary-image">
                                                    <img alt="" src="{{asset('assets/web/images/product/rp02.webp')}}"
                                                        class="secondary-image"> </a>
                                            </div>
                                        </div>
                                        <div class="product-text">
                                            <div class="prodcut-name"> <a href="single-product.html">Copenhagen
                                                    Spitfire Chair</a> </div>
                                            <div class="prodcut-ratting-price">
                                                <div class="prodcut-ratting"> <a href="#"><i class="fa fa-star"></i></a> <a
                                                        href="#"><i class="fa fa-star"></i></a> <a href="#"><i
                                                            class="fa fa-star"></i></a> <a href="#"><i
                                                            class="fa fa-star"></i></a> <a href="#"><i
                                                            class="fa fa-star-o"></i></a> </div>
                                                <div class="prodcut-price">
                                                    <div class="new-price"> $220 </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- single product end-->

                                    <!-- single product start-->
                                    <div class="single-product recent-single-product">
                                        <div class="product-img">
                                            <div class="single-prodcut-img  product-overlay pos-rltv">
                                                <a href="single-product.html"> <img alt=""
                                                        src="{{asset('assets/web/images/product/rp03.webp')}}"
                                                        class="primary-image">
                                                    <img alt="" src="{{asset('assets/web/images/product/rp04.webp')}}"
                                                        class="secondary-image"> </a>
                                            </div>
                                        </div>
                                        <div class="product-text">
                                            <div class="prodcut-name"> <a href="single-product.html">Copenhagen
                                                    Spitfire Chair</a> </div>
                                            <div class="prodcut-ratting-price">
                                                <div class="prodcut-ratting"> <a href="#"><i class="fa fa-star"></i></a> <a
                                                        href="#"><i class="fa fa-star"></i></a> <a href="#"><i
                                                            class="fa fa-star"></i></a> <a href="#"><i
                                                            class="fa fa-star"></i></a> <a href="#"><i
                                                            class="fa fa-star-o"></i></a> </div>
                                                <div class="prodcut-price">
                                                    <div class="new-price"> $220 </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- single product end-->

                                    <!-- single product start-->
                                    <div class="single-product recent-single-product">
                                        <div class="product-img">
                                            <div class="single-prodcut-img  product-overlay pos-rltv">
                                                <a href="single-product.html"> <img alt=""
                                                        src="{{asset('assets/web/images/product/rp02.webp')}}"
                                                        class="primary-image">
                                                    <img alt="" src="{{asset('assets/web/images/product/rp03.webp')}}"
                                                        class="secondary-image"> </a>
                                            </div>
                                        </div>
                                        <div class="product-text">
                                            <div class="prodcut-name"> <a href="single-product.html">Copenhagen
                                                    Spitfire Chair</a> </div>
                                            <div class="prodcut-ratting-price">
                                                <div class="prodcut-ratting"> <a href="#"><i class="fa fa-star"></i></a> <a
                                                        href="#"><i class="fa fa-star"></i></a> <a href="#"><i
                                                            class="fa fa-star"></i></a> <a href="#"><i
                                                            class="fa fa-star"></i></a> <a href="#"><i
                                                            class="fa fa-star-o"></i></a> </div>
                                                <div class="prodcut-price">
                                                    <div class="new-price"> $220 </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- single product end-->

                                    <!-- single product start-->
                                    <div class="single-product recent-single-product">
                                        <div class="product-img">
                                            <div class="single-prodcut-img  product-overlay pos-rltv">
                                                <a href="single-product.html"> <img alt=""
                                                        src="{{asset('assets/web/images/product/rp04.webp')}}"
                                                        class="primary-image">
                                                    <img alt="" src="{{asset('assets/web/images/product/rp01.webp')}}"
                                                        class="secondary-image"> </a>
                                            </div>
                                        </div>
                                        <div class="product-text">
                                            <div class="prodcut-name"> <a href="single-product.html">Copenhagen
                                                    Spitfire Chair</a> </div>
                                            <div class="prodcut-ratting-price">
                                                <div class="prodcut-ratting"> <a href="#"><i class="fa fa-star"></i></a> <a
                                                        href="#"><i class="fa fa-star"></i></a> <a href="#"><i
                                                            class="fa fa-star"></i></a> <a href="#"><i
                                                            class="fa fa-star"></i></a> <a href="#"><i
                                                            class="fa fa-star-o"></i></a> </div>
                                                <div class="prodcut-price">
                                                    <div class="new-price"> $220 </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- single product end-->
                                </div>
                            </div>

                        </aside>
                        <!--single aside end-->

                        <!--single aside start-->
                        <aside class="single-aside add-aside">
                            <a href="single-product.html"><img src="{{ asset('assets/web/images/banner/add.webp') }}"
                                    alt=""></a>
                        </aside>
                        <!--single aside end--> --}}
                    </div>
                </div>
                <!--shop sidebar end-->
            </div>
        </div>
    </div>
    <!--shop main area are end-->
    @include('screens.web.product.partials.modal')
@endsection
@push('scripts')
    @include('includes.web.common.pagination-script')
    @include('includes.web.common.modal-script')
@endpush