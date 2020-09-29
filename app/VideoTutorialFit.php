<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoTutorialFit extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'video_tutorial_fits';


    function video_tutorial() {
        return $this->belongsTo('App\VideoTutorial');
    }
}
