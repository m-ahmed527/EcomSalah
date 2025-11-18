<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    public function index()
    {
         $breadcrumbs = [
            'Home' => route('web.index'),
            'Contact' => route('web.contact.index'),
        ];
        return view('screens.web.contact.index',get_defined_vars());
    }


}
