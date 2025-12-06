@forelse ($products as $product)
    <div class="col-lg-4 col-md-6 item">
        <!-- single product start-->
        <div class="single-product">
            <div class="product-img">
                <div class="product-label red">
                    <div class="new">New</div>
                </div>
                <div class="single-prodcut-img  product-overlay pos-rltv">
                    <a href="single-product.html"> <img alt=""
                            src="{{$product->featured_image ?? asset('assets/web/images/product/01.jpg')}}"
                            class="primary-image">
                        <img alt="" src="{{$product->featured_image ?? asset('assets/web/images/product/02.jpg')}}"
                            class="secondary-image">
                    </a>
                </div>
                <div class="product-icon socile-icon-tooltip text-center">
                    <ul>

                        <li><a href="#" data-tooltip="Wishlist" class="w-list"><i class="fa fa-heart-o"></i></a></li>
                        <li><a href="javascript:void(0)" data-tooltip="Quick View"
                                data-url="{{ route('web.product.details', $product->slug) }}" class="q-view modalProductShow"
                                ><i class="fa fa-eye"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="product-text">
                <div class="prodcut-name"> <a href="single-product.html">{{ $product->name }}</a> </div>
                <div class="prodcut-ratting-price">
                    <div class="prodcut-price">
                        <div class="new-price"> PKR {{ $product->priceRange() }} </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- single product end-->
    </div>
@empty

@endforelse