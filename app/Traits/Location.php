<?php

namespace App\Traits;

trait Location
{
    public function getLocation($city)
    {
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $city . '&key=' . env('YOUR_API_KEY');
        $data = json_decode(file_get_contents($url), true);
        return json_encode($data['results'][0]['geometry']['location']);
    }

    public function isJson($string)
    {
        json_decode($string);
        return (json_last_error() === JSON_ERROR_NONE);
    }
}