<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CartMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */


    public function handle(Request $request, Closure $next)
    {
        // session()->flush();
        // dd(session('cart'));
        if (session('cart') == null || count(session('cart.items')) == 0) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your Cart is empty.'
                ], 200);
            }
            return redirect()->route('web.index')->with('error', 'Your Cart is empty.');
        }

        return $next($request);
    }
    // public function handle(Request $request, Closure $next): Response
    // {
    //     try {
    //         $cart = session()->get('cart', []);

    //         // Cart empty → Return JSON (stop here)
    //         if (empty($cart) && $request->ajax()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Your cart is empty. Please add items first.'
    //             ], 200);
    //         }

    //         if (empty($cart)) {
    //             return redirect()->route('web.product.index');
    //         }
    //         // Cart has items → Allow request to continue to controller
    //         $response = $next($request);

    //         // Controller response ke sath middleware ka JSON wrap mat karo,
    //         // Isliye bas return karo
    //         return $response;

    //     } catch (Throwable $e) {
    //         create_error_log('Cart Middleware', $e);
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Something went wrong.'
    //         ], 500);
    //     }
    // }

}
