<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function index()
    {
         $breadcrumbs = [
            'Home' => route('web.index'),
            'Blogs' => route('web.blog.index'),
        ];
        return view('screens.web.blog.index',get_defined_vars());
    }


}
