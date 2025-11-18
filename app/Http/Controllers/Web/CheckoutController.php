<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    public function index()
    {
        $breadcrumbs = [
            'Home' => route('web.index'),
            'Checkout' => route('web.checkout.index'),
        ];
        return view('screens.web.checkout.index',get_defined_vars());
    }

}
