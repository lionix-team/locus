<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Review
 *
 * @property int $id
 * @property string $email
 * @property string $text
 * @property int $star
 * @property int $place_id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review query()
 * @mixin \Eloquent
 * @property-read \App\Models\Place $place
 */
class Review extends Model
{
    protected $table = "reviews";
    protected $fillable = ["email", "text", "star"];

    //Review statuses
    const STATUS_PENDING = 0;
    const STATUS_DECLINED = 1;
    const STATUS_APPROVED = 2;

    /**
     * Relationship for get review place
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id', 'id');
    }
}
