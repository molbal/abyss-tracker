<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatreonDonorDisplay extends Model
{

    protected $casts = [
        'joined' => 'date'
    ];
}