<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentCreator extends Model
{
    public function VideoTutorials() {
        return $this->hasMany("App\VideoTutorial");
    }
}
