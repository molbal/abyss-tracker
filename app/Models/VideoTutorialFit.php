<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\VideoTutorialFit
 *
 * @property int                             $id
 * @property int                             $video_tutorial_id
 * @property int                             $fit_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\VideoTutorial  $video_tutorial
 * @method static \Illuminate\Database\Eloquent\Builder|VideoTutorialFit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VideoTutorialFit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VideoTutorialFit query()
 * @method static \Illuminate\Database\Eloquent\Builder|VideoTutorialFit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoTutorialFit whereFitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoTutorialFit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoTutorialFit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VideoTutorialFit whereVideoTutorialId($value)
 * @mixin \Eloquent
 */
class VideoTutorialFit extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'video_tutorial_fits';


    function video_tutorial() {
        return $this->belongsTo('App\Models\VideoTutorial');
    }
}
