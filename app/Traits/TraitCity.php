<?php

namespace App\Traits;
use App\City;

trait TraitCity
{
    use Location;
    public function getCityId($city)
    {
        if (is_array($city)) {
            $cityName = explode(',', $city)[0];
        } else {
            $cityName = $city;
        }

        $city = City::select('id', 'location')
            ->where('name', $cityName)
            ->first();

        if ($city->location === null) {
            $location = $this->getLocation($cityName);
            City::where('name', $cityName)->update(['location' => $location]);
        }

        if (empty($city)) {
            $city = new City();
            $city->name = $cityName;
            $city->region_id = 0;
            $location = $this->getLocation($cityName);
            if ($this->isJson($location)) $city->location = $location;
            $city->save();
            return $city->id;
        }
        return $city->id;
    }
}