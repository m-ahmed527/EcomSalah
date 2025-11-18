<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{

    public function index()
    {
        $breadcrumbs = [
            'Home' => route('web.index'),
            'About Us' => route('web.about.index'),
        ];
        return view('screens.web.about.index', get_defined_vars());
    }


}
