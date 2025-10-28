<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{

    public function index()
    {
        return view('screens.web.about.index');
    }


}
