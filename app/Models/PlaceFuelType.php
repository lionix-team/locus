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
 * @property-read \App\Models\FuelType $fuelType
 * @property-read \App\Models\FuelType $fuel_type
 * @property-read \App\Models\Place $gas_station
 */
class PlaceFuelType extends Model
{
    protected $table = 'place_fuel_type';
    protected $fillable = ['place_id', 'fuel_type_id', 'price'];
    protected $with = ['fuel_type'];

    /**
     * Relationship for get place fuel type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fuel_type()
    {
        return $this->belongsTo(FuelType::class, 'fuel_type_id', 'id');
    }

    /**
     * Relationship for get fuel type station
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function gas_station()
    {
        return $this->hasOne(Place::class, 'id', 'place_id');
    }
}
