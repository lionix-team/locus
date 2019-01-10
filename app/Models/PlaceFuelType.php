<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaceFuelType extends Model
{
    protected $table = 'place_fuel_type';
    protected $fillable = ['place_id', 'fuel_type_id', 'price'];
}
