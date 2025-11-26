<?php

namespace App\Services;

use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartService
{
    public function add($quantity, $variantId)
    {
        $variant = ProductVariant::with(['product', 'values.attribute'])->findOrFail($variantId);
        $product = $variant->product;

        $cart = session()->get('cart', []);

        $variantId = $variant->id;
        $productId = $product->id;
        $productPrice = ((float) ($variant->price) + (float) ($product->base_price)) * $quantity;
        // Unique key by variant (as you want variant-wise entries)
        $key = $variantId;

        $attributes = $variant->values->pluck('value')->toArray();

        if (isset($cart['items'][$key])) {
            $cart['items'][$key]['quantity'] = $quantity;
            $cart['items'][$key]['total_price'] = $productPrice;
            $this->recalculateCart($cart);
        } else {
            $cart['items'][$key] = [
                'product_id' => $productId,
                'variant_id' => $variantId,
                'quantity' => $quantity,
                'total_price' => $productPrice,
                'product' => $product, // Optional: Reduce payload
                'variant' => [
                    'price' => (float) $variant->price,
                    'sku' => $variant->sku,
                    'variant_name' => $variant->variant_name,
                    'attributes' => $attributes
                ]
            ];
        }
        $this->recalculateCart($cart);
        return session('cart');
    }

    public function removeFromCart(Request $request)
    {
        $variantId = $request->variant_id; // jis variant ko remove karna hai

        $cart = session()->get('cart', []);

        if (isset($cart['items'][$variantId])) {
            unset($cart['items'][$variantId]); // remove item
            $this->recalculateCart($cart);
        }

        session()->put('cart', $cart);
    }
    private function recalculateCart($cart)
    {


        $cart['total_amount'] = array_sum(array_column($cart['items'], 'total_price')) ?? 0;
        $cart['total_items'] = count($cart['items']) ?? 0;

        session()->put('cart', $cart);
    }
}
