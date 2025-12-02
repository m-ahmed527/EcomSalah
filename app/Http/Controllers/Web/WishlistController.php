<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class WishlistController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            'Home' => route('web.index'),
            'Cart' => route('web.wishlist.index'),
        ];
        $wishlistProducts = auth()->user()->wishlist;
        return view('screens.web.wishlist.index', get_defined_vars());
    }

    public function store(Request $request, Product $product)
    {
        try {
            if (auth()->check()) {
                DB::beginTransaction();
                if (auth()->user()->hasWishlisted($product->id)) {
                    auth()->user()->wishlist()->detach($product->id);
                    $userWishlistCount = auth()->user()->wishlistCount();
                    DB::commit();
                    return successResponse("Removed From wishlist", ['wishlist_count' => $userWishlistCount]);
                } else {
                    auth()->user()->wishlist()->attach($product->id);
                    $userWishlistCount = auth()->user()->wishlistCount();
                    DB::commit();
                    return successResponse("Added to wishlist", ['wishlist_count' => $userWishlistCount]);
                }
            } else {
                return errorResponse('You must be logged in to add to wishlist', 200);
            }
        } catch (Throwable $e) {
            create_error_log("Wishilist Product", $e);
            return errorResponse('Something went wrong', 400);
        }

    }

    public function destroy(Request $request)
    {
        dd($request->all());
    }
}
