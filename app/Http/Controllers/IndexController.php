<?php

namespace App\Http\Controllers;

use App\City;
use App\Route;
use App\Weight;
use Illuminate\Http\Request;

class IndexController extends Controller
{
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
}
