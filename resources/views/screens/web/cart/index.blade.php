@extends('layouts.web.app')

@section('title', 'Cart Salah Wears')
@section('page', 'Cart')

@section('content')
    {{-- {{ session()->flush() }} --}}
    {{-- @dd(session()->get('cart')) --}}
    <div class="page-wrapper">
        <div class="cart shopping">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="block">
                            <div class="product-list">
                                <form method="post">
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
                                            @foreach (session('cart.items', []) as $item)
                                                <tr class="">
                                                    <td class="">
                                                        <div class="product-info">
                                                            <img width="80"
                                                                src="{{$item['product']['featured_image']}}"
                                                                alt="" />
                                                            <a href="{{route('web.product.show',$item['product']['slug'])}}">{{ $item['product']['name'] }}</a>
                                                        </div>
                                                    </td>
                                                    <td class="">{{ $item['variant']['variant_name'] ?? 'Default' }}</td>
                                                    <td class="">{{ $item['quantity'] }}</td>
                                                    <td class="">PKR {{ $item['total_price'] }}</td>
                                                    <td class="">
                                                        <a class="product-remove" href="#!">Remove</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                    <hr>
                                    <div class="cart-summary mt-2">
                                        <span>Total Items</span>
                                        <span class="total-price">{{ session('cart.total_items', 0) }}</span>

                                    </div>
                                    <div class="cart-summary mt-2">
                                        <span>Total Amount</span>
                                        <span class="total-price">PKR {{ session('cart.total_amount', 0) }}</span>

                                    </div>
                                    <hr>
                                    <a href="{{ route('web.checkout.index') }}" class="btn btn-main pull-right mt-10">Checkout</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection