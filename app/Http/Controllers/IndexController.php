<?php

namespace App\Http\Controllers;

use App\City;
use App\Route;
use App\Traits\TraitCity;
use App\Weight;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    use TraitCity;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $weights = Weight::get();
        return view('index', ['weights' => $weights]);
    }

    public function weights(Request $request)
    {
        $origin = explode(',', $request['start_address'])[0];
        $destination = explode(',', $request['end_address'])[0];

        $origin_id = $this->getCityId($origin);
        $destination_id = $this->getCityId($destination);
        if (empty($origin_id) || empty($destination_id)) response()->json(['route' => null]);
        $route = $this->getRoute($origin_id, $destination_id);
        if (empty($route)) return response()->json(['route' => null]);

        $data = [];
        foreach ($route->weights as $weight) {
            $data[] = [
                'name' => $weight->name,
                'cubic_meter' => $weight->cubic_meter,
                'price' => $weight->pivot->price
            ];
        }
        return response()->json($data);
    }

    public function getCitiesFrom()
    {
        $weights = Route::get();
        $data = [];
        foreach ($weights as $weight) {
            $data[] = $weight->cityOrigin->toArray();
        }
        return response()->json($data);
    }

    private function getRoute($origin_id, $destination_id)
    {
        return Route::where('origin_id', $origin_id)->where('destination_id', $destination_id)->first();
    }

    private function getCityId($city)
    {
        $city = City::select('id')->where('name', $city)->first();
        if (empty($city)) return null;
        return $city->id;
    }

    public function getCitiesTo(Request $request)
    {
        $city_id = $request->id ?? $this->getCityId($request->n3);
        $routes = Route::where('origin_id', $city_id)->get();
        $cites = [];

        foreach ($routes as $route) {
            $cites[] = [
                'id' => $route->id,
                'active1' => true,
                'status' => 1,
                'name' => $route->cityDestination->name,
                'lat' => json_decode($route->cityDestination->location, true)['lat'],
                'len1' => intval($route->weights->toArray()[0]['pivot']['distance']),
                'price_nal' => intval($route->weights->toArray()[0]['pivot']['price']),
                'lon' => json_decode($route->cityDestination->location, true)['lng'],
            ];
        }
        return response()->json($cites);
    }

    public function InfoWinLineData(Request $request)
    {
        $cityFrom = $request->ns1;
        $cityTo = $request->ns2;

        $cityFromId = $this->getCityId($cityFrom);
        $cityToId = $this->getCityId($cityTo);

        $route = Route::where([
            ['origin_id', $cityFromId],
            ['destination_id', $cityToId]
        ])->first();

        if ($route === null) return response()->json('Empty city');

        $weights['weights'] =  $route->weights;

        return response()->json($weights);
    }
}
