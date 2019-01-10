<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FuelType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FuelType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FuelType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FuelType query()
 * @mixin \Eloquent
 */
class FuelType extends Model
{
    protected $table = 'fuel_types';
    protected $fillable = ['name'];
}
