<div class="modal-header">
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <div class="modal-product">
        <div class="product-images">
            <!--modal tab start-->
            <div class="portfolio-thumbnil-area-2">
                <div class="tab-content active-portfolio-area-2">
                    <div role="tabpanel" class="tab-pane active" id="view1">
                        <div class="product-img product-list-img">

                            <a href="#"><img src="{{$product->featured_image ?? asset('assets/web/images/product/no-image.png')}}" alt="Single portfolio" /></a>
                        </div>
                    </div>
                    @foreach ($product->images as $image)
                        <div role="tabpanel" class="tab-pane" id="view{{ $loop->iteration + 1 }}">
                            <div class="product-img">

                                <a href="#"><img src="{{$image->image }}" alt="Single portfolio" /></a>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="product-more-views-2">
                    <ul class="thumbnail-carousel-modal-2 nav" data-tabs="tabs">
                        <li class="nav-item" role="presentation" style="width: 76px; height: 97px; overflow: hidden;">
                            <a class="nav-link active" id="view1" data-bs-toggle="tab" href="#view1" role="tab"
                                aria-controls="view1" aria-selected="true">

                                <img src="{{$product->featured_image ?? asset('assets/web/images/product/no-image.png')}}" alt="" style="width: 100%; height: 100%; object-fit: cover;" />
                            </a>
                        </li>
                        @foreach ($product->images as $image)
                            <li class="nav-item" role="presentation" style="width: 76px; height: 97px; overflow: hidden;">
                                <a class="nav-link" id="view{{ $loop->iteration + 1 }}" data-bs-toggle="tab"
                                    href="#view{{ $loop->iteration + 1 }}" role="tab"
                                    aria-controls="view{{ $loop->iteration + 1 }}" aria-selected="true">

                                    <img src="{{$image->image}}" alt="" style="width: 100%; height: 100%; object-fit: cover;" />
                                </a>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
        <!--modal tab end-->
        <!-- .product-images -->
        <div class="product-info">
            <h1>{{ $product->name }}</h1>
            <div class="price-box-3">
                <div class="s-price-box"> <span class="new-price">PKR {{ $product->priceRange() }}</span> <span
                        class="old-price"></span> </div>
            </div> <a href="{{ route('web.product.show', $product->slug) }}" class="see-all">See all features</a>
            
            <div class="quick-desc"> {!! $product->short_description !!}</div>
            <div class="social-sharing-modal">
                <div class="widget widget_socialsharing_widget">
                    <h3 class="widget-title-modal">See this product</h3>
                    <ul class="social-icons-modal">
                        <li><a title="Facebook" href="#" class="facebook m-single-icon"><i
                                    class="fa fa-facebook"></i></a>
                        </li>
                        <li><a title="Twitter" href="#" class="twitter m-single-icon"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li><a title="Pinterest" href="#" class="pinterest m-single-icon"><i
                                    class="fa fa-pinterest"></i></a>
                        </li>
                        <li><a title="Google +" href="#" class="gplus m-single-icon"><i
                                    class="fa fa-google-plus"></i></a>
                        </li>
                        <li><a title="LinkedIn" href="#" class="linkedin m-single-icon"><i
                                    class="fa fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- .product-info -->
    </div>
    <!-- .modal-product -->
</div>
