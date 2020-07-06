<?php

namespace App\Traits;
use App\City;

trait TraitCity
{
    use Location;
    public function getCityId($city)
    {
        $cityName = explode(',', $city)[0];

        $city = City::select('id', 'location')
            ->where('name', $cityName)
            ->first();

        if (empty($city)) {
            $city = new City();
            $city->name = $cityName;
            $city->region_id = 0;
            $city->location = $this->getLocation($cityName);
            $city->save();
            return $city->id;
        }

        if ($city->location === null) {
            $location = $this->getLocation($cityName);
            City::where('name', $cityName)->update(['location' => $location]);
        }

        return $city->id;
    }
}