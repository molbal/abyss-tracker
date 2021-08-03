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


    /**
     * Conduit v1 routes
     * @authenticated
     */
    Route::prefix("conduit/v1/")->middleware('auth:sanctum')->group(function() {

        /**
         * @group Fits
         *
         * List use rfits
         *
         * Lists all fits selectable by the authenticated user: public fits, incognito fits, and users' private fits.
         */
        Route::get("fits/list", [ConduitController::class, 'fitsRead']);
    });
