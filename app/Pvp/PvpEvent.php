<?php

    namespace App\Pvp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\PvpEvent
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PvpEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PvpEvent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PvpEvent query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $is_current
 * @property string $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PvpEvent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpEvent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpEvent whereIsCurrent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpEvent whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpEvent wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpEvent whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpEvent whereUpdatedAt($value)
 */
class PvpEvent extends Model
{
    use HasFactory;

    protected $table = 'pvp_events';

    public static function getCurrentEvent() {

    }
}
