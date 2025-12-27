@forelse ($products as $product)
    <div class="col-lg-4 col-md-6 item">
        <!-- single product start-->
        <div class="single-product">
            <div class="product-img">
                <div class="product-label red">
                    <div class="new">New</div>
                </div>
                <div class="single-prodcut-img product-list-img  product-overlay pos-rltv">
                    <a href="{{ route('web.product.show', $product->slug) }}"> <img alt=""
                            src="{{$product->featured_image ?? asset('assets/web/images/product/no-image.png')}}"
                            class="primary-image">
                        <img alt="" src="{{$product->featured_image ?? asset('assets/web/images/product/no-image.png')}}"
                            class="secondary-image">
                    </a>
                </div>
                <div class="product-icon socile-icon-tooltip text-center">
                    <ul>

                        <li><a href="javascript:void(0)" data-tooltip="Wishlist" class="w-list add-to-wishlist" id="add-to-wishlist" data-slug="{{ $product->slug }}"
                                data-url="{{ route('web.wishlist.store', $product->slug) }}" tabindex="0">
                                <i class="fa {{ auth()?->user()?->hasWishlisted($product->id) ? 'fa-heart' : 'fa-heart-o' }}"></i></a></li>
                        <li><a href="javascript:void(0)" data-url="{{ route('web.product.details', $product->slug) }}"
                                class="modalProductShow"><i class="fa fa-eye"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="product-text">
                <div class="prodcut-name"> <a href="{{ route('web.product.show', $product->slug) }}">{{ $product->name }}</a> </div>
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
    <div class="d-flex justify-content-center align-items-center">
        <h3 class="text-center">No Matching Product Found</h3>
    </div>
@endforelse
