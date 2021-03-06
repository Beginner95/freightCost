<?php

namespace App\Http\Controllers\Admin;

use App\Weight;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $weight = Weight::get();
        return view('admin.car.index', ['weights' => $weight]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.car.create');
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
        if (empty($name)) return back();

        $weight = new Weight();
        $weight->name = $name;
        $weight->cubic_meter = $cubic_meter;
        $weight->save();
        return redirect('/admin/car');
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
        return view('admin.car.edit', ['weight' => $weight]);
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

        if (empty($name) || empty($cubic_meter)) return back();
        Weight::where('id', $id)->update(['name' => $name, 'cubic_meter' => $cubic_meter]);
        return redirect('admin/car');
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
