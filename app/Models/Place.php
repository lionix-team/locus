<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Place
 *
 * @property int $id
 * @property string $name
 * @property string $place_id
 * @property int $type
 * @property float $latitude
 * @property float $longitude
 * @property string $street
 * @property float|null $price
 * @property string|null $photo
 * @property string|null $open_at
 * @property string|null $close_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Place newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Place newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Place query()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PlaceFuelType[] $fuelTypes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PlaceFuelType[] $fuel_types
 */
class Place extends Model
{
    protected $table = 'places';
    protected $fillable = ['name', 'place_id', 'type', 'latitude', 'longitude', 'street', 'price', 'photo', 'open_at', 'close_at'];
    protected $with = ['fuel_types'];

    //Place types
    const TYPE_GAS_STATION = 'gas_station';

    /**
     * Places types
     *
     * @return array
     */
    public static function getTypes()
    {
        return [
            'gas_station' => 1
        ];
    }

    /**
     * Relationship for get place all fuel types
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fuel_types()
    {
        return $this->hasMany(PlaceFuelType::class, 'place_id', 'id')->orderBy('price','desc');
    }
}
