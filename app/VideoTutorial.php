<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    function video_tutorial() {
        return $this->belongsTo('App\VideoTutorial');
    }
}
