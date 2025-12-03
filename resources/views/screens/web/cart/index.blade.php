@extends('layouts.web.app')

@section('title', 'Cart Salah Wears')
@section('page', 'Cart')

@section('content')

    <div class="page-wrapper">
        <div class="cart shopping">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="block">
                            <div class="product-list">
                                <a class="product-remove remove-from-cart" style="cursor: pointer;">Empty Cart</a>
                                <div class="cart-product-list">
                                    @include('screens.web.cart.partials.cart-products')
                                </div>
                                <ul class="text-center cart-buttons">
                                    <li> <a href="{{ route('web.product.index') }}" class="btn btn-main pull-left">Countinue
                                            Shopping</a></li>
                                    <li> <a href="{{ route('web.checkout.index') }}"
                                            class="btn btn-main pull-right">Checkout</a></li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @include('includes.web.common.cart.update-cart')


@endpush
