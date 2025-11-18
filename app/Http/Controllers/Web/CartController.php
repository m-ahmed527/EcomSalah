<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index()
    {
         $breadcrumbs = [
            'Home' => route('web.index'),
            'Cart' => route('web.cart.index'),
        ];
        return view('screens.web.cart.index',get_defined_vars());
    }

}
