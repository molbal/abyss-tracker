<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentCreator extends Model
{
    public function video_tutorials() {
        return $this->hasMany("App\VideoTutorial");
    }
}
