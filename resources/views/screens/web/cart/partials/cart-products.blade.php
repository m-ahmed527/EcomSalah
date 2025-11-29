<table class="table">
    <thead>
        <tr>
            <th class="">Item Name</th>
            <th class="">Variant</th>
            <th class="">Item Quantity</th>
            <th class="">Item Price</th>
            <th class="">Actions</th>
        </tr>
    </thead>
    <tbody>
        {{-- @dd(session('cart', [])) --}}
        @forelse (session('cart.items', []) as $key => $item)

            <tr class="">
                <td class="">
                    <div class="product-info">
                        <img width="80" src="{{$item['product']['featured_image']}}" alt="" />
                        <a href="{{route('web.product.show', $item['product']['slug'])}}">{{ $item['product']['name'] }}</a>
                    </div>
                </td>
                <td class="">{{ $item['variant']['variant_name'] ?? 'Simple Product' }}</td>
                <td class="">

                    <input type="number" value="{{ $item['quantity'] }}" min="1" name="quantity" data-id="{{$key}}" style="width: 50%;">


                </td>
                <td class="">PKR {{ number_format($item['total_price'],2) }}</td>
                <td class="">

                    <a class="product-remove remove-from-cart" data-id="{{$key}}" href="javascript:void(0);"
                        id="remove-from-cart-{{$key}}">Remove</a>
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
    <span class="total-price">{{ session('cart.total_items', 0) }}</span>

</div>
<div class="cart-summary mt-2">
    <span>Total Amount</span>
    <span class="total-price">PKR {{ number_format(session('cart.total_amount', 0),2) }}</span>

</div>
<hr>