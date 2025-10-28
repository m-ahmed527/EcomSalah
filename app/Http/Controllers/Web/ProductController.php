<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        return view('screens.web.product.index');
    }

    public function show()
    {
        return view('screens.web.product.show');
    }

}
