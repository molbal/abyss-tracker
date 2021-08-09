<?php

    use App\Http\Controllers\ConduitController;
    use App\Http\Controllers\PVP\PVPController;
    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
    */


    Route::post("fit/callback", 'EFT\FitCallbackController@handleFitCallback');
    Route::post('killmail/push', [PVPController::class, 'addKillmail']);



    Route::prefix("conduit/v1/")->middleware('auth:sanctum')->group(function() {


        Route::any("ping", [ConduitController::class, 'ping']);
        Route::get("fits/list", [ConduitController::class, 'fitList']);
        Route::post("fits/ffh/calculate", [ConduitController::class, 'getFlexibleFitHash']);
        Route::get("fits/get/{id}", [ConduitController::class, 'fitGet']);
    });
