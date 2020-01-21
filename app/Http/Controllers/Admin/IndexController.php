<?php
/**
 * Created by PhpStorm.
 * User: Vaharsolta
 * Date: 21.01.2020
 * Time: 15:01
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Route;

class IndexController extends Controller
{
    public function index()
    {
        $routes = Route::paginate(20);
        return view('admin.index', ['routes' => $routes]);
    }
}