<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoTutorial extends Model
{
    protected $casts = [
        'timestamps' => 'collection',
    ];
}
