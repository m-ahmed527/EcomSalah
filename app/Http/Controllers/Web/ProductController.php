<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $breadcrumbs = [
            'Home' => route('web.index'),
            'Products' => route('web.product.index'),
        ];
        $products = Product::paginate(3);
        return view('screens.web.product.index',get_defined_vars());
    }

    public function show()
    {
        $breadcrumbs = [
            'Home' => route('web.index'),
            'Products' => route('web.product.index'),
            'Product Details' => '#',
        ];
        return view('screens.web.product.show',get_defined_vars());
    }

}
