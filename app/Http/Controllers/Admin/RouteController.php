<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Route;
use App\Weight;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routes = Route::paginate(20);
        return view('admin.route.index', ['routes' => $routes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $weights = $this->getWeights();
        return view('admin.route.create', ['weights' => $weights]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $origin_id = $this->getCityId($request['origin']);
        $destination_id = $this->getCityId($request['destination']);
        $weights = $request['weight'];
        $prices = $request['price'];

        if (empty($origin_id) || empty($destination_id)) return back();

        $sync_data = $this->getSyncData($weights, $prices);
        $id = $this->saveRoute($origin_id, $destination_id);

        $route = Route::where('id', $id)->first();
        $route->weights()->attach($sync_data);
        $route->save();
        return redirect('admin/route');
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
        $route = Route::where('id', $id)->first();
        $weights = Weight::get();
        return view('admin.route.edit', [
            'route' => $route,
            'weights' => $weights
        ]);
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
        $this->destroy($id);
        $origin_id = $this->getCityId($request['origin']);
        $destination_id = $this->getCityId($request['destination']);
        $weights = $request['weight'];
        $prices = $request['price'];

        if (empty($origin_id) || empty($destination_id)) return back();

        $sync_data = $this->getSyncData($weights, $prices);
        $id = $this->saveRoute($origin_id, $destination_id);

        $route = Route::where('id', $id)->first();
        $route->weights()->attach($sync_data);
        $route->save();
        return redirect('admin/route');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $route = Route::where('id', $id)->first();
        $route->weights()->detach();
        $route->delete();
        return back();
    }

    private function saveRoute($origin_id, $destination_id)
    {
        $route = new Route();
        $route->origin_id = $origin_id;
        $route->destination_id = $destination_id;
        $route->save();
        return $route->id;
    }

    private function getSyncData($weights, $prices)
    {
        $i = 0;
        $sync_data = [];
        foreach ($weights as $weight) {
            $sync_data[] = [
                'weight_id' => $weight,
                'price' => $prices[$i],
            ];
            $i++;
        }
        return $sync_data;
    }

    public function autocomplete(Request $request)
    {
        $data = City::select('name')->where('name','LIKE',"%{$request->input('query')}%")->get();

        return response()->json($data);
    }

    private function getWeights()
    {
        return Weight::get();
    }

    private function getCityId($city)
    {
        $cityName = explode(',', $city)[0];
        $city = City::select('id')->where('name', $cityName)->first();
        if (empty($city)) {
            $city = new City();
            $city->name = $cityName;
            $city->region_id = 0;
            $city->save();
            return $city->id;
        }
        return $city->id;
    }
}
