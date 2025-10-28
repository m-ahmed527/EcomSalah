@extends('layouts.web.app')

@section('title', 'Details of a Product of Salah Wears')
@section('page', 'Products')
@section('url', route('web.product.index'))
@section('detail', 'Product Details')
@section('content')

    <section class="single-product">
        <div class="container">

            <div class="row mt-20">
                <div class="col-md-5">
                    <div class="single-product-slider">
                        <div id='carousel-custom' class='carousel slide' data-ride='carousel'>
                            <div class='carousel-outer'>
                                <!-- me art lab slider -->
                                <div class='carousel-inner '>
                                    <div class='item active'>
                                        <img src='{{asset('assets/web/images/shop/single-products/product-1.jpg')}}' alt=''
                                            data-zoom-image="{{asset('assets/web/images/shop/single-products/product-1.jpg')}}" />
                                    </div>
                                    <div class='item'>
                                        <img src='{{asset('assets/web/images/shop/single-products/product-2.jpg')}}' alt=''
                                            data-zoom-image="{{asset('assets/web/images/shop/single-products/product-2.jpg')}}" />
                                    </div>

                                    <div class='item'>
                                        <img src='{{asset('assets/web/images/shop/single-products/product-3.jpg')}}' alt=''
                                            data-zoom-image="{{asset('assets/web/images/shop/single-products/product-3.jpg')}}" />
                                    </div>
                                    <div class='item'>
                                        <img src='{{asset('assets/web/images/shop/single-products/product-4.jpg')}}' alt=''
                                            data-zoom-image="{{asset('assets/web/images/shop/single-products/product-4.jpg')}}" />
                                    </div>
                                    <div class='item'>
                                        <img src='{{asset('assets/web/images/shop/single-products/product-5.jpg')}}' alt=''
                                            data-zoom-image="{{asset('assets/web/images/shop/single-products/product-5.jpg')}}" />
                                    </div>
                                    <div class='item'>
                                        <img src='{{asset('assets/web/images/shop/single-products/product-6.jpg')}}' alt=''
                                            data-zoom-image="{{asset('assets/web/images/shop/single-products/product-6.jpg')}}" />
                                    </div>

                                </div>

                                <!-- sag sol -->
                                <a class='left carousel-control' href='#carousel-custom' data-slide='prev'>
                                    <i class="tf-ion-ios-arrow-left"></i>
                                </a>
                                <a class='right carousel-control' href='#carousel-custom' data-slide='next'>
                                    <i class="tf-ion-ios-arrow-right"></i>
                                </a>
                            </div>

                            <!-- thumb -->
                            <ol class='carousel-indicators mCustomScrollbar meartlab'>
                                <li data-target='#carousel-custom' data-slide-to='0' class='active'>
                                    <img src='{{asset('assets/web/images/shop/single-products/product-1.jpg')}}' alt='' />
                                </li>
                                <li data-target='#carousel-custom' data-slide-to='1'>
                                    <img src='{{asset('assets/web/images/shop/single-products/product-2.jpg')}}' alt='' />
                                </li>
                                <li data-target='#carousel-custom' data-slide-to='2'>
                                    <img src='{{asset('assets/web/images/shop/single-products/product-3.jpg')}}' alt='' />
                                </li>
                                <li data-target='#carousel-custom' data-slide-to='3'>
                                    <img src='{{asset('assets/web/images/shop/single-products/product-4.jpg')}}' alt='' />
                                </li>
                                <li data-target='#carousel-custom' data-slide-to='4'>
                                    <img src='{{asset('assets/web/images/shop/single-products/product-5.jpg')}}' alt='' />
                                </li>
                                <li data-target='#carousel-custom' data-slide-to='5'>
                                    <img src='{{asset('assets/web/images/shop/single-products/product-6.jpg')}}' alt='' />
                                </li>
                                <li data-target='#carousel-custom' data-slide-to='6'>
                                    <img src='{{asset('assets/web/images/shop/single-products/product-6.jpg')}}' alt='' />
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="single-product-details">
                        <h2>Eclipse Crossbody</h2>
                        <p class="product-price">$300</p>

                        <p class="product-description mt-20">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laborum ipsum dicta quod, quia
                            doloremque aut deserunt commodi quis. Totam a consequatur beatae nostrum, earum consequuntur?
                            Eveniet consequatur ipsum dicta recusandae.
                        </p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt, velit, sunt temporibus, nulla
                            accusamus similique sapiente tempora, at atque cumque assumenda minus asperiores est esse sequi
                            dolore magnam. Debitis, explicabo.</p>
                        <div class="color-swatches">
                            <span>color:</span>
                            <ul>
                                <li>
                                    <a href="#!" class="swatch-violet"></a>
                                </li>
                                <li>
                                    <a href="#!" class="swatch-black"></a>
                                </li>
                                <li>
                                    <a href="#!" class="swatch-cream"></a>
                                </li>
                            </ul>
                        </div>
                        <div class="product-size">
                            <span>Size:</span>
                            <select class="form-control">
                                <option>S</option>
                                <option>M</option>
                                <option>L</option>
                                <option>XL</option>
                            </select>
                        </div>
                        <div class="product-quantity">
                            <span>Quantity:</span>
                            <div class="product-quantity-slider">
                                <input id="product-quantity" type="text" value="0" name="product-quantity">
                            </div>
                        </div>
                        <div class="product-category">
                            <span>Categories:</span>
                            <ul>
                                <li><a href="product-single.html">Products</a></li>
                                <li><a href="product-single.html">Soap</a></li>
                            </ul>
                        </div>
                        <a href="cart.html" class="btn btn-main mt-20">Add To Cart</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="tabCommon mt-20">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#details" aria-expanded="true">Details</a></li>
                            <li class=""><a data-toggle="tab" href="#reviews" aria-expanded="false">Reviews (3)</a></li>
                        </ul>
                        <div class="tab-content patternbg">
                            <div id="details" class="tab-pane fade active in">
                                <h4>Product Description</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                    exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                                    dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                    Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                    mollit anim id est laborum. Sed ut per spici</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis delectus quidem
                                    repudiandae veniam distinctio repellendus magni pariatur molestiae asperiores animi, eos
                                    quod iusto hic doloremque iste a, nisi iure at unde molestias enim fugit, nulla
                                    voluptatibus. Deserunt voluptate tempora aut illum harum, deleniti laborum animi neque,
                                    praesentium explicabo, debitis ipsa?</p>
                            </div>
                            <div id="reviews" class="tab-pane fade">
                                <div class="post-comments">
                                    <ul class="media-list comments-list m-bot-50 clearlist">
                                        <!-- Comment Item start-->
                                        <li class="media">

                                            <a class="pull-left" href="#!">
                                                <img class="media-object comment-avatar"
                                                    src="{{ asset('assets/web/images/blog/avater-1.jpg') }}" alt=""
                                                    width="50" height="50" />
                                            </a>

                                            <div class="media-body">
                                                <div class="comment-info">
                                                    <h4 class="comment-author">
                                                        <a href="#!">Jonathon Andrew</a>

                                                    </h4>
                                                    <time datetime="2013-04-06T13:53">July 02, 2015, at 11:34</time>
                                                    <a class="comment-button" href="#!"><i
                                                            class="tf-ion-chatbubbles"></i>Reply</a>
                                                </div>

                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque at
                                                    magna ut ante eleifend eleifend.Lorem ipsum dolor sit amet, consectetur
                                                    adipisicing elit. Quod laborum minima, reprehenderit laboriosam officiis
                                                    praesentium? Impedit minus provident assumenda quae.
                                                </p>
                                            </div>

                                        </li>
                                        <!-- End Comment Item -->

                                        <!-- Comment Item start-->
                                        <li class="media">

                                            <a class="pull-left" href="#!">
                                                <img class="media-object comment-avatar"
                                                    src="{{asset('assets/web/images/blog/avater-4.jpg')}}" alt="" width="50"
                                                    height="50" />
                                            </a>

                                            <div class="media-body">

                                                <div class="comment-info">
                                                    <div class="comment-author">
                                                        <a href="#!">Jonathon Andrew</a>
                                                    </div>
                                                    <time datetime="2013-04-06T13:53">July 02, 2015, at 11:34</time>
                                                    <a class="comment-button" href="#!"><i
                                                            class="tf-ion-chatbubbles"></i>Reply</a>
                                                </div>

                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque at
                                                    magna ut ante eleifend eleifend. Lorem ipsum dolor sit amet, consectetur
                                                    adipisicing elit. Magni natus, nostrum iste non delectus atque ab a
                                                    accusantium optio, dolor!
                                                </p>

                                            </div>

                                        </li>
                                        <!-- End Comment Item -->

                                        <!-- Comment Item start-->
                                        <li class="media">

                                            <a class="pull-left" href="#!">
                                                <img class="media-object comment-avatar"
                                                    src="{{asset('assets/web/images/blog/avater-1.jpg')}}" alt="" width="50"
                                                    height="50">
                                            </a>

                                            <div class="media-body">

                                                <div class="comment-info">
                                                    <div class="comment-author">
                                                        <a href="#!">Jonathon Andrew</a>
                                                    </div>
                                                    <time datetime="2013-04-06T13:53">July 02, 2015, at 11:34</time>
                                                    <a class="comment-button" href="#!"><i
                                                            class="tf-ion-chatbubbles"></i>Reply</a>
                                                </div>

                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque at
                                                    magna ut ante eleifend eleifend.
                                                </p>

                                            </div>

                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="products related-products section">
        <div class="container">
            <div class="row">
                <div class="title text-center">
                    <h2>Related Products</h2>
                </div>
            </div>
            <div class="row">
                @for ($item = 1; $item <= 3; $item++)
                    <div class="col-md-3">
                        <div class="product-item">

                            <div class="product-thumb">
                                <span class="bage">Sale</span>
                                <a href="{{ route('web.product.show') }}">
                                    <img class="img-responsive"
                                        src="{{ asset('assets/web/images/shop/products/product-' . $item . '.jpg') }}"
                                        alt="product-img" />
                                </a>
                                <div class="preview-meta">
                                    <ul>
                                        <li>
                                            <span class="icon-search" data-toggle="modal" data-target="#product-modal">
                                                <i class="tf-ion-ios-search-strong"></i>
                                            </span>
                                        </li>
                                        <li>
                                            <span class="icon-heart">
                                                <i class="tf-ion-ios-heart"></i>
                                            </span>
                                        </li>
                                        <li>
                                            <span class="icon-cart">
                                                <i class="tf-ion-android-cart"></i>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="product-content">
                                <h4 class="mb-1">Rainbow Shoes</h4>
                                <p class="price">$200</p>
                            </div>
                        </div>
                    </div>

                @endfor

            </div>
        </div>
    </section>



    <!-- Modal -->
    <div class="modal product-modal fade" id="product-modal">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="tf-ion-close"></i>
        </button>
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="modal-image">
                                <img class="img-responsive"
                                    src="{{ asset('assets/web/images/shop/products/modal-product.jpg') }}" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="product-short-details">
                                <h2 class="product-title">GM Pendant, Basalt Grey</h2>
                                <p class="product-price">$200</p>
                                <p class="product-short-description">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem iusto nihil cum. Illo
                                    laborum numquam rem aut officia dicta cumque.
                                </p>
                                <a href="#!" class="btn btn-main">Add To Cart</a>
                                <a href="#!" class="btn btn-transparent">View Product Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
