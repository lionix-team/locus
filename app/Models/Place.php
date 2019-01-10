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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Place newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Place newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Place query()
 * @mixin \Eloquent
 */
class Place extends Model
{
    protected $table = 'places';

    protected $fillable = ['name', 'place_id', 'type', 'latitude', 'longitude','street'];

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
}
