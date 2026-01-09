@forelse ($products as $product)
    <li>
        <a href="{{ route('web.product.show', $product->slug) }}" class="search-item">
            <div class="search-item-img">
                <img src="{{$product->featured_image ?? asset('assets/web/images/product/no-image.png')}}" alt="Product">
            </div>
            <div class="search-item-content">
                <h4>{{ $product->name }}</h4>
                <p>PKR {{ $product->priceRange() }}</p>
            </div>
        </a>
    </li>
@empty
    <li>
        <div class="search-item-content">
            <h4>No products found</h4>
        </div>
    </li>
@endforelse