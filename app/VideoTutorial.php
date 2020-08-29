<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoTutorial extends Model
{

    function creator() {
        return $this->belongsTo('App\ContentCreator');
    }
}
