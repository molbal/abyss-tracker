<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function discord() {
        return redirect(config('tracker.discord'));
    }
}
