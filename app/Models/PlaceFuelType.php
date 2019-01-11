<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PlaceFuelType
 *
 * @property int $id
 * @property int $place_id
 * @property int $fuel_type_id
 * @property float $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PlaceFuelType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlaceFuelType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlaceFuelType query()
 * @mixin \Eloquent
 */
class PlaceFuelType extends Model
{
    protected $table = 'place_fuel_type';
    protected $fillable = ['place_id', 'fuel_type_id', 'price'];
    protected $with = ['fuelType'];

    public function fuelType()
    {
        return $this->belongsTo(FuelType::class, 'fuel_type_id', 'id');
    }
}
