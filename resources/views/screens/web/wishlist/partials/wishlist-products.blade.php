<table class="table">
    <thead>
        <tr>
            <th class="">Item Name</th>
            <th class="">Item Price</th>
            <th class="">Actions</th>
        </tr>
    </thead>
    <tbody>
        {{-- @dd(session('cart', [])) --}}
        @forelse ($wishlistProducts as $key => $item)

            <tr class="">
                <td class="">
                    <div class="product-info">
                        <img width="80" src="{{$item->featured_image}}" alt="" />
                        <a href="{{route('web.product.show', $item->slug)}}">{{ $item->name }}</a>
                    </div>
                </td>

                <td class="">PKR {{ $item->priceRange() }}</td>
                <td class="">

                    <a class="product-remove remove-from-wishlist" data-id="{{$item->id}}" href="javascript:void(0);"
                        id="remove-from-wishlist-{{$item->id}}" title="Remove From Wishlist"><i
                            class="fa-solid fa-xmark"></i></a>
                    <a href="{{ route('web.product.show', $item->slug) }}" title="View Product Details"><i
                            class="fa-solid fa-eye"></i></a>
                </td>
            </tr>
        @empty

            <tr>
                <td colspan="5" class="text-center">Cart is empty</td>
            </tr>

        @endforelse

    </tbody>
</table>
<hr>
<div class="cart-summary mt-2">
    <span>Total Items</span>
    <span class="total-price">{{ $wishlistProducts->count() }}</span>

</div>

<hr>