<?php

namespace App\Http\Controllers\Admin;

use App\Weight;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $weight = Weight::get();
        return view('admin.index', ['weights' => $weight]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request['name'];
        $cubic_meter = $request['cubic-meter'];
        $price = $request['price'];
        if (empty($name) || empty($price)) return back();

        $weight = new Weight();
        $weight->name = $name;
        $weight->cubic_meter = $cubic_meter;
        $weight->price = $price;
        $weight->save();
        return redirect('/admin/index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $weight = Weight::where('id', $id)->first();
        return view('admin.edit', ['weight' => $weight]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $name = $request['name'];
        $cubic_meter= $request['cubic-meter'];
        $price = $request['price'];

        if (empty($name) || empty($cubic_meter)) return back();
        Weight::where('id', $id)->update(['name' => $name, 'cubic_meter' => $cubic_meter, 'price' => $price]);
        return redirect('admin/index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $weight = Weight::where('id', $id)->first();
        $weight->delete();
        return back();
    }
}
