<?php

    use App\Http\Controllers\ConduitController;
    use App\Http\Controllers\ConduitImpl\FitConduitController;
    use App\Http\Controllers\ConduitImpl\ItemConduitControllers;
    use App\Http\Controllers\PVP\PVPController;
    use App\Http\Middleware\LogConduitRequests;
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



    Route::prefix("conduit/v1/")->middleware(['auth:sanctum', LogConduitRequests::class])->group(function() {

        // Ping endpoint
        Route::any("ping", [ConduitController::class, 'ping']);

        // Fit endpoints
        Route::get ("fits/list", [FitConduitController::class, 'fitList']);
        Route::post("fits/ffh/calculate", [FitConduitController::class, 'getFlexibleFitHash']);
        Route::get ("fits/get/{id}", [FitConduitController::class, 'fitGet']);

        // Item endpoints
        Route::get('/drop-table/list', [ItemConduitControllers::class, 'getDroppedItems']);
        Route::get('/drop-table/get/{id}', [ItemConduitControllers::class, 'getItem']);
    });
