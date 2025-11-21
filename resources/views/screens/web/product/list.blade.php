<div id="showing-results" class="text-muted" style="display:none;">
    Showing <span class="fw-semibold">{{ $products->firstItem() }}</span>
    to <span class="fw-semibold">{{ $products->lastItem() }}</span>
    of <span class="fw-semibold">{{ $products->total() }}</span> results
</div>
@forelse ($products as $key => $product)
    <div class="col-md-4">
        <div class="product-item" style="cursor:pointer;">
            <div class="product-thumb">
                <span class="bage">Sale</span>
                <a href="{{ route('web.product.show') }}" class="product-a">
                    <img class="img-responsive"
                        src="{{ asset('assets/web/images/shop/products/product-' . $key + 1 . '.jpg') }}"
                        alt="product-img" />
                </a>
                <div class="preview-meta">
                    <ul>
                        <li>
                            <span data-toggle="modal" data-target="#product-modal">
                                <i class="tf-ion-ios-search-strong"></i>
                            </span>
                        </li>
                        <li>
                            <span><i class="tf-ion-ios-heart"></i></span>
                        </li>
                        <li>
                            <span><i class="tf-ion-android-cart"></i></span>
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
@empty
@endforelse