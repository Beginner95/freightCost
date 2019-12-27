<?php

namespace App\Http\Controllers;

use App\Weight;

class IndexController extends Controller
{
    public function index()
    {
        $weights = Weight::get();
        return view('index', ['weights' => $weights]);
    }
}
