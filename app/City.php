<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string name
 * @property integer region_id
 * @property string location
 */
class City extends Model
{
    protected $fillable = ['region_id', 'name', 'location'];
}
