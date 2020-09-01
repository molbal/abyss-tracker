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
