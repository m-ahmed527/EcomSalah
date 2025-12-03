@extends('layouts.web.app')

@section('title', 'Wishlist Salah Wears')
@section('page', 'Wishlist')

@section('content')

    <div class="page-wrapper">
        <div class="cart shopping">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="block">
                            <div class="product-list">
                                <a class="product-remove remove-from-wishlist" href="javascript:void(0);"
                                    title="Remove From Wishlist">Clear All</a>
                                <div class="wishlist-product-list">
                                    @include('screens.web.wishlist.partials.wishlist-products')
                                </div>
                                <ul class="text-center wishlist-buttons">
                                    <li> <a href="{{ route('web.product.index') }}" class="btn btn-main pull-left">Countinue
                                            Shopping</a></li>

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
    @include('includes.web.common.wishlist.remove-wishlist-script')
@endpush
