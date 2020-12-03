<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ContentCreator
 *
 * @property int $id
 * @property string $NAME
 * @property int|null $CHAR_ID
 * @property string|null $DISCORD
 * @property string|null $YOUTUBE
 * @property string|null $TWITTER
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\VideoTutorial[] $video_tutorials
 * @property-read int|null $video_tutorials_count
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCreator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCreator newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCreator query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCreator whereCHARID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCreator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCreator whereDISCORD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCreator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCreator whereNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCreator whereTWITTER($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCreator whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCreator whereYOUTUBE($value)
 * @mixin \Eloquent
 */
class ContentCreator extends Model
{
    public function video_tutorials() {
        return $this->hasMany("App\VideoTutorial");
    }
}
