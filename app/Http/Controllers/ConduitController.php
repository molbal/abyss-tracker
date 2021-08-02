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
    public function fitsRead(Request $request) {
        try {

        $charId = $request->user()->CHAR_ID;
        $collection = Cache::remember('api.fits.list.'.$request, now()->addMinute(), function () use ($charId) {
            return Fit::getForApi($charId);
        });

        return [
            'success' => true,
            'char' => [
                'id' => $request->user()->CHAR_ID,
                'name' => $request->user()->NAME,
            ],
            'items' => $collection,
            'count' => $collection->count(),
            'error' => null
        ];
        }
        catch (\Exception $e) {
            return [
                'success' => false,
                'char' => [
                    'id' => $request->user()->CHAR_ID ?? null,
                    'name' => $request->user()->NAME ?? null,
                ],
                'items' => null,
                'count' => null,
                'error' => $e->getMessage()
            ];
        }
    }
}
