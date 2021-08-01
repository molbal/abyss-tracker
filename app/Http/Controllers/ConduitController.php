<?php

namespace App\Http\Controllers;

use App\Char;
use App\Fit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\Sanctum;



class ConduitController extends Controller
{
    public function fitsRead(Request $request) {$charId = $request->user()->CHAR_ID;
        $collection = Cache::remember('api.fits.list.'.$request, now()->addMinute(), function () use ($charId) {
            return Fit::getForApi($charId);
        });

        return [$collection];
    }
}
