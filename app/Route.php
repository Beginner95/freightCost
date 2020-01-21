<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    public function weights()
    {
        return $this->belongsToMany(Weight::class)->withPivot('price')->withTimestamps();
    }

    public function cityOrigin()
    {
        return $this->hasOne(City::class, 'id', 'origin_id');
    }

    public function cityDestination()
    {
        return $this->hasOne(City::class, 'id', 'destination_id');
    }
}
