@forelse ($products as $product)
    <div class="col-lg-4 col-md-6 item">
        <!-- single product start-->
        <div class="single-product">
            <div class="product-img">
                <div class="product-label red">
                    <div class="new">New</div>
                </div>
                <div class="single-prodcut-img product-list-img  product-overlay pos-rltv">
                    <a href="single-product.html"> <img alt=""
                            src="{{$product->featured_image ?? asset('assets/web/images/product/no-image.png')}}"
                            class="primary-image">
                        <img alt="" src="{{$product->featured_image ?? asset('assets/web/images/product/no-image.png')}}"
                            class="secondary-image">
                    </a>
                </div>
                <div class="product-icon socile-icon-tooltip text-center">
                    <ul>

                        <li><a href="#" data-tooltip="Wishlist" class="w-list"><i class="fa fa-heart-o"></i></a></li>
                        <li><a href="javascript:void(0)" data-url="{{ route('web.product.details', $product->slug) }}"
                                class="modalProductShow"><i class="fa fa-eye"></i></a></li>
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