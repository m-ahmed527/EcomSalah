@extends('layouts.web.app')
@section('content')


    <!--breadcumb area start -->
    <div class="breadcumb-area overlay pos-rltv">
        <div class="bread-main">
            <div class="bred-hading text-center">
                <h5>Prodcut Details</h5>
            </div>
            <ol class="breadcrumb">
                <li class="home"><a title="Go to Home Page" href="index.html">Home</a></li>
                <li class="active">product-details</li>
            </ol>
        </div>
    </div>
    <!--breadcumb area end -->
    {{-- @dd($product) --}}
    <!--single-protfolio-area are start-->
    <div class="single-protfolio-area ptb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="portfolio-thumbnil-area">
                        <div class="product-more-views">
                            <div class="tab_thumbnail" data-tabs="tabs">
                                <div class="thumbnail-carousel">
                                    <ul class="nav">
                                        <li class="">
                                            <a class="active" href="#view11" class="shadow-box" aria-controls="view11"
                                                data-bs-toggle="tab"><img
                                                    src="{{ $product->featured_image ?? asset('assets/web/images/product/no-image.png') }}"
                                                    alt="" /></a>
                                        </li>
                                        @foreach ($product->images as $image)
                                            <li class="">
                                                <a href="#view{{ $loop->iteration + 1 . $loop->iteration + 1  }}"
                                                    class="shadow-box"
                                                    aria-controls="view{{ $loop->iteration + 1 . $loop->iteration + 1}}"
                                                    data-bs-toggle="tab"><img src="{{ $image->image }}" alt="" /></a>
                                            </li>
                                        @endforeach


                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content active-portfolio-area pos-rltv">
                            <div class="social-tag">
                                {{-- <a href="#"><i class="zmdi zmdi-share"></i></a> --}}
                            </div>
                            <div role="tabpanel" class="tab-pane active" id="view11">
                                <div class="product-img product-show-img">
                                    <a class="fancybox" data-fancybox-group="group"
                                        href="{{ $product->featured_image ?? asset('assets/web/images/product/no-image.png') }}"><img
                                            src="{{ $product->featured_image ?? asset('assets/web/images/product/no-image.png') }}"
                                            alt="Single portfolio" /></a>
                                </div>
                            </div>
                            @foreach ($product->images as $image)
                                <div role="tabpanel" class="tab-pane "
                                    id="view{{ $loop->iteration + 1 . $loop->iteration + 1  }}">
                                    <div class="product-img product-show-img">
                                        <a class="fancybox" data-fancybox-group="group" href="{{ $image->image }}"><img
                                                src="{{ $image->image }}" alt="Single portfolio" /></a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="single-product-description">
                        <div class="sp-top-des">
                            <h3>{{ $product->name }} <span>()</span></h3>
                            <div class="prodcut-ratting-price">
                                <div class="prodcut-ratting">
                                    <a href="#" tabindex="0"><i class="fa fa-star-o"></i></a>
                                    <a href="#" tabindex="0"><i class="fa fa-star-o"></i></a>
                                    <a href="#" tabindex="0"><i class="fa fa-star-o"></i></a>
                                    <a href="#" tabindex="0"><i class="fa fa-star-o"></i></a>
                                    <a href="#" tabindex="0"><i class="fa fa-star-o"></i></a>
                                </div>
                                <div class="prodcut-price">
                                    <div class="new-price "> PKR {{ $product->base_price }} </div>
                                    {{-- <div class="old-price"> <del>$250</del> </div> --}}
                                </div>
                            </div>
                        </div>

                        <div class="sp-des">
                            <p>{!! $product->short_description !!}</p>
                        </div>
                        <div class="sp-bottom-des">

                            <div class="row" id="variant-selectors">
                            @foreach ($attributes as $attribute)

                                <div class="mb-3">
                                    <label class="">{{ $attribute->name }}:</label>
                                    <div style="display: flex; gap:10px;">
                                        @foreach ($attribute->values as $value)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input variant-radio" type="radio"
                                                    name="attribute_{{ $attribute->id }}" data-attribute-id="{{ $attribute->id }}"
                                                    value="{{ $value->id }}" id="{{ $value->value }}">
                                                <label class="" for="{{ $value->value }}">{{ $value->value }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    {{-- Reset Button --}}
                                    <button type="button" class="btn btn-sm btn-outline-secondary reset-attribute"
                                        data-attribute-id="{{ $attribute->id }}">
                                        <i class="fa fa-refresh"></i> {{ $attribute->name }}
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            <h5 style="display:{{ $product->has_variants ? 'block' : 'none' }}">Additional price: <span
                                    id="variant-price">-</span>
                            </h5>
                            <h2 id="variant-stock">
                                @if ($product->stock > 0)
                                    <span class="label label-success label-lg">In Stock</span>
                                @else
                                    <span class="label label-danger label-lg">Out of Stock</span>
                                @endif
                            </h2>
                            <input type="hidden" id="stock" value="{{ $product->has_variants ? '' : $product->stock }}">
                        </div>
                        <form id="cart-form" action="{{ route('web.cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="{{ $product->has_variants ? 'variant_id' : 'product_id' }}"
                                id="selected-variant-id" value="{{ $product->has_variants ? '' : $product->id }}">
                            <div class="quantity-area">
                                <label>Qty :</label>
                                <div class="cart-quantity">

                                        <div class="product-qty">
                                            <div class="cart-quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="dec qtybutton">-</div>
                                                    <input type="text" value="1" name="product-quantity"
                                                        class="cart-plus-minus-box" id="quantity">
                                                    <div class="inc qtybutton">+</div>
                                                </div>
                                            </div>
                                        </div>

                                </div>
                            </div>
                            <div class="social-icon socile-icon-style-1">
                                <ul>
                                    <li><a href="javascript:void(0)"  data-tooltip="Add To Cart" class="add-cart add-cart-text"
                                            data-placement="left" tabindex="0" id="add-to-cart" {{ $product->has_variants ? 'disabled' : '' }}
                                title="{{ $product->has_variants ? 'Please select a valid variant' : '' }}">Add To Cart<i
                                                class="fa fa-cart-plus"></i></a></li>
                                    <li><a href="javascript:void(0)" data-tooltip="Wishlist" class="w-list add-to-wishlist" id="add-to-wishlist" data-slug="{{ $product->slug }}"
                                data-url="{{ route('web.wishlist.store', $product->slug) }}" tabindex="0">
                                <i class="fa {{ auth()?->user()?->hasWishlisted($product->id) ? 'fa-heart' : 'fa-heart-o' }}"></i></a></li>

                                </ul>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--single-protfolio-area are start-->

    <!--descripton-area start -->
    <div class="descripton-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-area tab-cars-style">
                        <div class="title-tab-product-category row">
                            <div class="col-lg-12 text-center">
                                <ul class="nav mb-40 heading-style-2" role="tablist">
                                    <li role="presentation"><a class="active" href="#description-tab"
                                            aria-controls="description-tab" role="tab" data-bs-toggle="tab">Description</a>
                                    </li>
                                    {{-- <li role="presentation"><a class="active" href="#review-tab"
                                            aria-controls="review-tab" role="tab" data-bs-toggle="tab">Review</a></li>
                                    <li role="presentation"><a href="#tags-tab" aria-controls="tags-tab" role="tab"
                                            data-bs-toggle="tab">Tags</a></li> --}}
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-12">
                            <div class="content-tab-product-category">
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fix fade show active" id="description-tab">
                                        <div class="review-wraper">
                                            <p>{!! $product->long_description !!}</p>
                                        </div>
                                    </div>
                                    {{-- <div role="tabpanel" class="tab-pane fix fade show active" id="review-tab">
                                        <div class="review-wraper">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim <br>
                                                veniam, quis nostrud exercitation.</p>
                                            <h5>SIZE & FIT</h5>
                                            <ul>
                                                <li>Model wears: Style Photoliya U2980</li>
                                                <li>Model's height: 185”66</li>
                                            </ul>
                                            <h5>ABOUT ME</h5>
                                            <p>It is a long established fact that a reader will be distracted by the
                                                readable content of a page when looking at its layout. The point of using
                                                Lorem Ipsum is that it has a more-or-less normal distribution of letters, as
                                                opposed to using 'Content here, content here', making it look like readable
                                                English.It is a long established fact that a reader will be distracted by
                                                the readable content of a page when looking at its layout. The point of
                                                using Lorem Ipsum is that it has a more-or-less normal distribution of
                                                letters, as opposed to using 'Content here, content here', making it look
                                                like readable English</p>
                                            <h5>Overview</h5>
                                            <p>There are many variations of passages of Lorem Ipsum available, but the
                                                majority have suffered alteration in some form, by injected humour, or
                                                randomised words which don't look even slightly believable.There are many
                                                variations of passages of Lorem Ipsum available, but the majority have
                                                suffered alteration in some form.</p>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fix fade in" id="tags-tab">
                                        <ul class="tag-filter">
                                            <li><a href="#">Fashion</a></li>
                                            <li><a href="#">Women</a></li>
                                            <li><a href="#">Winter</a></li>
                                            <li><a href="#">Street Style</a></li>
                                            <li><a href="#">Style</a></li>
                                            <li><a href="#">Shop</a></li>
                                            <li><a href="#">Collection</a></li>
                                            <li><a href="#">Spring 2022</a></li>
                                            <li><a href="#">Street Style</a></li>
                                            <li><a href="#">Style</a></li>
                                            <li><a href="#">Shop</a></li>
                                        </ul>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--descripton-area end-->

    <!--new arrival area start-->
    <div class="new-arrival-area ptb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="heading-title heading-style pos-rltv mb-50 text-center">
                        <h5 class="uppercase">Related Product</h5>
                    </div>
                    <div class="total-new-arrival new-arrival-slider-active carsoule-btn">
                        @forelse ($relatedProducts as $rel )
                        <div class="product-item">
                            <!-- single product start-->
                            <div class="single-product">
                                <div class="product-img">
                                    <div class="product-label red">
                                        <div class="new">New</div>
                                    </div>
                                    <div class="single-prodcut-img product-list-img  product-overlay pos-rltv">
                                        <a href="{{ route('web.product.show', $rel->slug) }}"> <img alt=""
                                                src="{{$rel->featured_image ?? asset('assets/web/images/product/no-image.png')}}"
                                                class="primary-image">
                                            <img alt=""
                                                src="{{$rel->featured_image ?? asset('assets/web/images/product/no-image.png')}}"
                                                class="secondary-image">
                                        </a>
                                    </div>
                                    <div class="product-icon socile-icon-tooltip text-center">
                                        <ul>

                                            <li><a href="#" data-tooltip="Wishlist" class="w-list"><i
                                                        class="fa fa-heart-o"></i></a></li>
                                            <li><a href="javascript:void(0)"
                                                    data-url="{{ route('web.product.details', $rel->slug) }}"
                                                    class="modalProductShow"><i class="fa fa-eye"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-text">
                                    <div class="prodcut-name"> <a
                                            href="{{ route('web.product.show', $rel->slug) }}">{{ $rel->name }}</a>
                                    </div>
                                    <div class="prodcut-ratting-price">
                                        <div class="prodcut-price">
                                            <div class="new-price"> PKR {{ $rel->priceRange() }} </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- single product end-->
                        </div>
                        @empty

                        @endforelse


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--new arrival area end-->
    @include('screens.web.product.partials.modal')
@endsection
@push('scripts')
 @include('includes.web.common.modal-script')
  @include('includes.web.common.variant-script')
    @include('includes.web.common.cart.add-to-cart-script')
@endpush
