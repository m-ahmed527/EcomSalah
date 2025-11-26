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
            $variantId = $request->variant_id;
            $cart = Cart::add($quantity, $variantId);
            return successResponse('Product added to cart successfully.', $cart);
        } catch (Throwable $e) {
            create_error_log('Cart Add', $e);
            return errorResponse('Something went wrong.');
        }

    }

}
