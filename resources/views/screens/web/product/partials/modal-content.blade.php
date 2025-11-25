<div class="modal-body">
    <div class="row">
        <div class="col-md-8 col-sm-6 col-xs-12">
            <div class="modal-image">
                <img class="img-responsive"
                    src="{{$product->featured_image ?? asset('assets/web/images/no-image.png') }}" alt="product-img" />
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="product-short-details">
                <h2 class="product-title">{{ $product->name }}</h2>
                <p class="product-price">PKR {{ $product->priceRange() }}</p>
                <p class="product-short-description">
                    {!! $product->short_description !!}
                </p>
                <a href="{{ route('web.product.show', $product->slug) }}" class="btn btn-main">View Product</a>

            </div>
        </div>
    </div>
</div>
