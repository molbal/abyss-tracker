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

    Route::get("/",'AbyssController@home')->name("home");
    Route::get("/stats_mine/",'AbyssController@home_mine')->name("home_mine");


    Route::post("/new", 'AbyssController@store')->name("store");
    Route::get("/new", 'AbyssController@form_new')->name("new");

    Route::get("/run/{id}", 'AbyssController@get_single')->name("view_single");
    Route::get("/runs/{order_by?}/{order_type?}", 'AbyssController@get_all')->name("runs");
    Route::get("/runs_mine/{order_by?}/{order_type?}", 'AbyssController@get_mine')->name("runs_mine");
    Route::get("/runs/{charID}/{order_by?}/{order_type?}", 'AbyssController@get_char')->name("runs_char");


    /**
     *
     */
    Route::get("/api/chart/home/types", 'GraphHelper@homeType')->name("chart.home.type");
    Route::get("/api/chart/home/tiers", 'GraphHelper@homeTier')->name("chart.home.tier");
    Route::get("/api/chart/home/loot_levels", 'GraphHelper@homeLootLevels')->name("chart.home.loot_levels");
    Route::get("/api/chart/home/survival", 'GraphHelper@homeSurvival')->name("chart.home.survival");
    Route::get("/api/chart/home/tiers/averages", 'GraphHelper@tierAverages')->name("chart.home.tier_averages");

    Route::get("/api/chart/personal/loot", 'GraphHelper@personalLoot')->name("chart.personal.loot");
    Route::get("/api/chart/personal/isk_per_hour", 'GraphHelper@personalIsk')->name("chart.personal.ihp");

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


    /**
     * Runs database migrations
     */
    Route::get("/maintenance/test-login/{login_id}/{secret}", function ($login_id, $secret) {
        if ($secret != env("MAINTENANCE_TOKEN")) {
            abort(403, "Invalid maintenance token.");
        }
        session()->put("login_id", $login_id);
        session()->put("login_name", "TEST LOGIN $login_id");
        return redirect(\route("home_mine"));
    });
