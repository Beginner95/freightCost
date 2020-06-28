<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Traits\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    use Location;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::paginate(20);
        return view('admin.city.index', ['cities' => $cities]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.city.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $regionId = $request['region-id'];
        $cityName = $request['city'];
        if (empty($regionId) || empty($cityName)) return back();

        $city = new City();
        $city->name = $cityName;
        $city->region_id = $regionId;
        $location = $this->getLocation($cityName);

        if ($this->isJson($location)) $city->location = $location;

        $city->save();
        return redirect('/admin/city');
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
        $city = City::where('id', $id)->first();
        return view('admin.city.edit', ['city' => $city]);
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
        $cityName = $request['city'];
        $regionId = $request['region-id'];
        if (empty($cityName) || empty($regionId)) return back();
        $location = $this->getLocation($cityName);

        City::where('id', $id)->update([
            'region_id' => $regionId,
            'name' => $cityName,
            'location' => ($this->isJson($location)) ? $location : null
        ]);
        return redirect('admin/city');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::where('id', $id)->first();
        $city->delete();
        return back();
    }
}
