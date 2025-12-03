<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartService
{
    // public function add($quantity, $variantId)
    // {
    //     $variant = ProductVariant::with(['product', 'values.attribute'])->findOrFail($variantId);
    //     $product = $variant->product;

    //     $cart = session()->get('cart', []);

    //     $variantId = $variant->id;
    //     $productId = $product->id;
    //     $productPrice = ((float) ($variant->price) + (float) ($product->base_price)) * $quantity;
    //     // Unique key by variant (as you want variant-wise entries)
    //     $key = $variantId;

    //     $attributes = $variant->values->pluck('value')->toArray();

    //     if (isset($cart['items'][$key])) {
    //         $cart['items'][$key]['quantity'] = $quantity;
    //         $cart['items'][$key]['total_price'] = $productPrice;
    //         $this->recalculateCart($cart);
    //     } else {
    //         $cart['items'][$key] = [
    //             'product_id' => $productId,
    //             'variant_id' => $variantId,
    //             'quantity' => $quantity,
    //             'total_price' => $productPrice,
    //             'product' => $product, // Optional: Reduce payload
    //             'variant' => [
    //                 'price' => (float) $variant->price,
    //                 'sku' => $variant->sku,
    //                 'variant_name' => $variant->variant_name,
    //                 'attributes' => $attributes
    //             ]
    //         ];
    //         $this->recalculateCart($cart);
    //     }
    //     // $this->recalculateCart($cart);
    //     $cartItem = [];
    //     $cartItem['item'] = session()->get('cart')['items'][$key];
    //     $cartItem['total_amount'] = session()->get('cart')['total_amount'];
    //     $cartItem['total_items'] = session()->get('cart')['total_items'];

    //     return $cartItem;
    // }
    public function add($quantity, $variantId)
    {
        // -----------------------------
        // SIMPLE PRODUCT CASE (NO VARIANT)
        // -----------------------------
        if (!$variantId) {
            $product = Product::findOrFail(request()->product_id);

            $cart = session()->get('cart', []);

            $key = 'product_' . $product->id; // unique key for simple product
            $productPrice = (float) $product->base_price * $quantity;

            if (isset($cart['items'][$key])) {
                // update quantity + price
                $cart['items'][$key]['quantity'] = $quantity;
                $cart['items'][$key]['total_price'] = $productPrice;
            } else {
                // add as new simple product item
                $cart['items'][$key] = [
                    'product_id' => $product->id,
                    'variant_id' => null,
                    'quantity' => $quantity,
                    'total_price' => $productPrice,
                    'product' => $product,
                    'variant' => null
                ];
            }

            $this->recalculateCart($cart);

            return [
                'item' => session()->get('cart')['items'][$key],
                'total_amount' => session()->get('cart')['total_amount'],
                'total_items' => session()->get('cart')['total_items'],
            ];
        }

        // -----------------------------
        // VARIANT PRODUCT CASE
        // -----------------------------
        $variant = ProductVariant::with(['product', 'values.attribute'])->findOrFail($variantId);
        $product = $variant->product;

        $cart = session()->get('cart', []);

        $key = 'variant_' . $variantId;

        $productPrice = ((float) $variant->price + (float) $product->base_price) * $quantity;
        $attributes = $variant->values->pluck('value')->toArray();

        if (isset($cart['items'][$key])) {
            $cart['items'][$key]['quantity'] = $quantity;
            $cart['items'][$key]['total_price'] = $productPrice;
        } else {
            $cart['items'][$key] = [
                'product_id' => $product->id,
                'variant_id' => $variantId,
                'quantity' => $quantity,
                'total_price' => $productPrice,
                'product' => $product,
                'variant' => [
                    'price' => (float) $variant->price,
                    'sku' => $variant->sku,
                    'variant_name' => $variant->variant_name,
                    'attributes' => $attributes
                ]
            ];
        }

        $this->recalculateCart($cart);

        return [
            'item' => session()->get('cart')['items'][$key],
            'total_amount' => session()->get('cart')['total_amount'],
            'total_items' => session()->get('cart')['total_items'],
        ];
    }
    public function quantityUpdate($quantity, $key)
    {
        $cart = session()->get('cart', []);
        $cart['items'][$key]['quantity'] = $quantity;
        $cart['items'][$key]['total_price'] = ((float) $cart['items'][$key]['variant']['price'] + (float) $cart['items'][$key]['product']['base_price']) * $quantity;
        $this->recalculateCart($cart);
    }
    public function removeFromCart($key)
    {

        $cart = session()->get('cart', []);

        if (isset($cart['items'][$key])) {
            unset($cart['items'][$key]); // remove item
            $this->recalculateCart($cart);
        }

    }
    public function emptyCart()
    {
        session()->forget('cart');
    }
    public function isCartEmpty()
    {
        $cart = session()->get('cart', []);
        if (count($cart['items']) == 0) {
            return true;
        }
        return false;
    }




    private function recalculateCart($cart)
    {


        $cart['total_amount'] = array_sum(array_column($cart['items'], 'total_price')) ?? 0;
        $cart['total_items'] = array_sum(array_column($cart['items'], 'quantity')) ?? 0;

        session()->put('cart', $cart);
    }
}
