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
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Route;

    Route::get("/",'AbyssController@home')->name("home");
    Route::get("/stats_mine/",'AbyssController@home_mine')->name("home_mine");


    Route::post("/new", 'AbyssController@store')->name("store");
    Route::get("/new", 'AbyssController@form_new')->name("new");
    Route::post("/api/loot_estimate", 'Loot\AjaxLootController@getSum')->name("estimate_loot");

    Route::get("/run/{id}", 'AbyssController@get_single')->name("view_single");
    Route::get("/runs/{order_by?}/{order_type?}", 'AbyssController@get_all')->name("runs");
    Route::get("/runs_mine/{order_by?}/{order_type?}", 'AbyssController@get_mine')->name("runs_mine");
    Route::get("/runs/{charID}/{order_by?}/{order_type?}", 'AbyssController@get_char')->name("runs_char");
    Route::get("/filter/{type}/{tier}", 'FilteredController@get_list')->name("filtered_list");

    /**
     * Runs
     */
    Route::get("/run/{id}", 'AbyssController@get_single')->name("view_single");
    Route::get("/run/delete/{id}", 'AbyssController@delete')->name("run_delete");
    Route::post("/run/flag", 'AbyssController@flag')->name("run_flag");

    /**
     * Stopwatch
     */
    Route::post("/stopwatch/start/{charId}", 'StopwatchController@addChecks')->name("stopwatch_start");
    Route::get("/stopwatch/get/{charId}", 'StopwatchController@getAbyssState')->name("stopwatch_get");

    /**
     * Most used ships
     */
    Route::get("/ships/", 'ShipsController@get_all')->name("ships_all");
    Route::get("/ship/{id}", 'ShipsController@get_single')->name("ship_single");

    /**
     * Item check
     */
    Route::get("/loot/item/{item_id}/", 'ItemController@get_single')->name("item_single");
    Route::get("/loot/group/{group_id}/", 'ItemController@get_group')->name("item_group");
    Route::view("/changelog", "changelog")->name("changelog");
    Route::get("/loot/all", 'ItemController@get_all')->name("item_all");
    Route::get("/api/search/items", 'ItemController@search_items')->name("search_items");

    /**
     * Chart APIs
     */
    Route::get("/api/chart/home/types", 'GraphHelper@homeType')->name("chart.home.type");
    Route::get("/api/chart/home/tiers", 'GraphHelper@homeTier')->name("chart.home.tier");
    Route::get("/api/chart/home/loot_levels", 'GraphHelper@homeLootLevels')->name("chart.home.loot_levels");
    Route::get("/api/chart/home/survival", 'GraphHelper@homeSurvival')->name("chart.home.survival");
    Route::get("/api/chart/home/tiers/averages", 'GraphHelper@tierAverages')->name("chart.home.tier_averages");

    Route::get("/api/chart/personal/loot", 'GraphHelper@personalLoot')->name("chart.personal.loot");
    Route::get("/api/chart/personal/isk_per_hour", 'GraphHelper@personalIsk')->name("chart.personal.ihp");

    /**
     * Search routes
     */
    Route::get("/search", 'SearchController@index')->name("search.index");
    Route::post("/search", 'SearchController@search')->name("search.do");

    /**
     * EVE Authentication routes
     */
    Route::get("/eve/auth/start", 'Auth\AuthController@redirectToProvider')->name("auth-start");
    Route::get("/eve/auth/callback", 'Auth\AuthController@handleProviderCallback');

    Route::get("/eve/scoped/auth/start", 'Auth\AuthController@redirectToScopedProvider')->name("auth-scoped-start");
    Route::get("/eve/scoped/auth/callback", 'Auth\AuthController@handleScopedProviderCallback');

    Route::get("/logout", 'Auth\AuthController@logout')->name("logout");


    Route::get("/maintenance/flagged/{secret}", function($secret) {
        if ($secret != env("MAINTENANCE_TOKEN")) {
            abort(403, "Invalid maintenance token.");
        }
        $flags = DB::table("run_report")->where("PROCESSED", false)->orderBy("CREATED_AT", "DESC")->get();

        return view("sp_message", ["title" => "Flagged runs", "message" => print_r($flags, true)]);
    });

    Route::get("/maintenance/flagged/delete/{id}/{secret}", function($id, $secret) {
        if ($secret != env("MAINTENANCE_TOKEN")) {
            abort(403, "Invalid maintenance token.");
        }

        DB::table("runs")->where("ID", $id)->delete();
        DB::table("detailed_loot")->where("RUN_ID", $id)->delete();
        DB::table("lost_items")->where("RUN_ID", $id)->delete();
        DB::table("run_report")->where("RUN_ID", $id)->update(["PROCESSED" => true]);


        return view("sp_message", ["title" => "Flagged runs", "message" => "Run #$id destroyed"]);
    });

    /**
     * Dark theme
     */
    Route::get("/customize/dark-theme/{isDark}",'ThemeController@setTheme')->name("customize_set_dark");

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
