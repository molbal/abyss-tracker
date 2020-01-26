<?php

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */

    use Illuminate\Support\Facades\Artisan;
    use Illuminate\Support\Facades\Route;

    Route::get('/', function () {
        return view('welcome');
    })->name("home");

    Route::get("/stats_mine/",'AbyssController@home_mine')->name("home_mine");


    Route::post("/new", 'AbyssController@store')->name("store");
    Route::get("/new", 'AbyssController@form_new')->name("new");

    Route::get("/run/{id}", 'AbyssController@get_single')->name("view_single");
    Route::get("/runs/{order_by?}/{order_type?}", 'AbyssController@get_all')->name("runs");
    Route::get("/runs_mine/{order_by?}/{order_type?}", 'AbyssController@get_mine')->name("runs_mine");
    Route::get("/runs/{charID}/{order_by?}/{order_type?}", 'AbyssController@get_char')->name("runs_char");

    /**
     * EVE Authentication routes
     */
    Route::get("/eve/auth/start", 'Auth\AuthController@redirectToProvider')->name("auth-start");
    Route::get("/logout", 'Auth\AuthController@logout')->name("logout");
    Route::get("/eve/auth/callback", 'Auth\AuthController@handleProviderCallback');


    /**
     * Runs database migrations
     */
    Route::get("/maintenance/db/{secret}", function ($secret) {
        if ($secret != env("MAINTENANCE_TOKEN")) {
            abort(403, "Invalid maintenance token.");
        }
        echo "DB maintenance starts <br>";
        echo Artisan::call('migrate', ['--force' => true]);
        echo "DB maintenance Over";
    });
