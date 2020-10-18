<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\VideoTutorial
 *
 * @property int $id
 * @property string $youtube_id
 * @property string $name
 * @property int $content_creator_id
 * @property array $video_bookmarks
 * @property string|null $tier
 * @property string|null $type
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\ContentCreator $content_creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\VideoTutorialFit[] $fits
 * @property-read int|null $fits_count
 * @method static \Illuminate\Database\Eloquent\Builder|VideoTutorial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VideoTutorial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VideoTutorial query()
 * @method static \Illuminate\Database\Eloquent\Builder|VideoTutorial whereContentCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoTutorial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoTutorial whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoTutorial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoTutorial whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoTutorial whereTier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoTutorial whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoTutorial whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoTutorial whereVideoBookmarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoTutorial whereYoutubeId($value)
 * @mixin \Eloquent
 */
class VideoTutorial extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'video_tutorials';

    function fits() {
        return $this->hasMany("App\VideoTutorialFit");
    }

    function content_creator() {
        return $this->belongsTo('App\ContentCreator');
    }

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'video_bookmarks' => 'array',
    ];
}
