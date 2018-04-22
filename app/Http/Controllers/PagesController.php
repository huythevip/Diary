<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function gate()
    {
        return view('pages.gate');
    }
}
