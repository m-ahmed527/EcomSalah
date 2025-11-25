
@forelse ($products as $key => $product)
    <div class="col-md-4">
        <div class="product-item" style="cursor:pointer;">
            <div class="product-thumb">
                <span class="bage">Sale</span>
                <a href="{{ route('web.product.show', $product->slug) }}" class="product-a">
                    <img class="img-responsive"
                        src="{{ $product->featured_image ?? asset('assets/web/images/no-image.png') }}" alt="product-img" />
                </a>
                <div class="preview-meta">
                    <ul>
                        <li>
                            <span class="modalProductShow" data-url="{{ route('web.product.details', $product->slug) }}">
                                <i class="tf-ion-ios-eye" style="font-size:22px;"></i>
                            </span>
                        </li>
                        <li>
                            <span><i class="tf-ion-ios-heart"></i></span>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="product-content">
                <h4 class="mb-1">{{ $product->name }}</h4>
                <p class="price">PKR {{ $product->priceRange() }}</p>
            </div>
        </div>
    </div>
@empty
    <div class="col-12">
        <h5 class="text-center text-muted">No products found.</h5>
    </div>
@endforelse
@push('scripts')
    <script>
        $('.pagination-div').html(`<div class="col-6 ">
                                        <nav aria-label="Page navigation example">
                                            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                                        </nav>
                                    </div>`);



    </script>
@endpush
