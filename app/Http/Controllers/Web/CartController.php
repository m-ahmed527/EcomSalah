<?php

namespace App\Http\Controllers\Web;

use App\Facades\Cart;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\AddToCartRequest;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Throwable;

class CartController extends Controller
{

    public function index()
    {
        $breadcrumbs = [
            'Home' => route('web.index'),
            'Cart' => route('web.cart.index'),
        ];
        return view('screens.web.cart.index', get_defined_vars());
    }

    public function addOrUpdate(AddToCartRequest $request)
    {

        try {
            $quantity = intval($request->input('product-quantity'));
            $variantId = $request->has('variant_id') ? $request->variant_id : null;
            $cart = Cart::add($quantity, $variantId);

            return successResponse('Product added to cart successfully.', $cart);
        } catch (Throwable $e) {
            create_error_log('Cart Add', $e);
            return errorResponse('Something went wrong.');
        }

    }

    public function removeCart(Request $request)
    {
        try {
            $variantId = $request->id;
            // dd($variantId);
            Cart::removeFromCart($variantId);
            $cartIsEmpty = Cart::isCartEmpty();
            $html = view('screens.web.cart.partials.cart-products', get_defined_vars())->render();
            return successResponse('Product removed from cart successfully.', [
                'html' => $html,
                'cartIsEmpty' => $cartIsEmpty
            ]);
        } catch (Throwable $e) {
            create_error_log('Cart Remove', $e);
            return errorResponse('Something went wrong.');
        }
    }

    public function updateQuantity(Request $request)
    {
        try {
            $variantId = $request->id;
            $quantity = $request->quantity;
            Cart::quantityUpdate($quantity, $variantId);

            $html = view('screens.web.cart.partials.cart-products', get_defined_vars())->render();
            return successResponse('Product quantity updated successfully.', [
                'html' => $html,
            ]);
        } catch (Throwable $e) {
            dd($e->getMessage());
            create_error_log('Cart Update', $e);
            return errorResponse('Something went wrong.');
        }
    }

}
