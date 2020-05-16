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

    Route::get("/", 'AbyssController@home')
         ->name("home");
    Route::get("/stats_mine/", 'AbyssController@home_mine')
         ->name("home_mine");


    Route::post("/new", 'AbyssController@store')
         ->name("store");
    Route::get("/new", 'AbyssController@form_new')
         ->name("new");
    Route::post("/api/loot_estimate", 'Loot\AjaxLootController@getSum')
         ->name("estimate_loot");

    Route::get("/runs/{order_by?}/{order_type?}", 'AbyssController@get_all')
         ->name("runs");
    Route::get("/runs_mine/{order_by?}/{order_type?}", 'AbyssController@get_mine')
         ->name("runs_mine");
    Route::get("/runs/{charID}/{order_by?}/{order_type?}", 'AbyssController@get_char')
         ->name("runs_char");
    Route::get("/filter/{type}/{tier}", 'FilteredController@get_list')
         ->name("filtered_list");


    /**
     * Runs
     */
    Route::get("/run/{id}", 'AbyssController@get_single')
         ->name("view_single");
    Route::get("/run/{id}/privacy/{privacy}", 'AbyssController@change_privacy')
         ->name("run.change_privacy");
    Route::get("/run/delete/{id}", 'AbyssController@delete')
         ->name("run_delete");
    Route::post("/run/flag", 'AbyssController@flag')
         ->name("run_flag");

    /**
     * Profile
     */
    Route::get('/char/{id}', 'Profile\ProfileController@index')
         ->name('profile.index');
    Route::get("/char/{id}/loot/{from}/{to}", 'Profile\ProfileController@loot')
         ->name('profile.loot');
    Route::get("/char/{id}/export/{from}/{to}", 'Profile\ProfileController@downloadLoot')
         ->name('profile.export');

    /**
     * Leaderboards
     */
    Route::get('/leaderboard', 'Profile\LeaderboardController@index')
         ->name('leaderboard.index');

    /**
     * Settings
     */
    Route::get('/settings', 'Profile\SettingController@index')
         ->name('settings.index');
    Route::post('/settings/update', 'Profile\SettingController@save')
         ->name('settings.save');
    Route::post('/settings/remove-esi', 'Profile\SettingController@removeEsi')
         ->name('settings.remove-esi');

    /**
     * Stopwatch
     */
    Route::post("/stopwatch/start/{charId}", 'StopwatchController@addChecks')
         ->name("stopwatch_start");
    Route::get("/stopwatch/get/{charId}", 'StopwatchController@getAbyssState')
         ->name("stopwatch_get");

    /**
     * Ships and fits routes
     */
    Route::get("/ships/", 'ShipsController@get_all')
         ->name("ships_all");
    Route::get("/ship/{id}", 'ShipsController@get_single')
         ->name("ship_single");
    Route::get("/fits/new", 'FitsController@new')
         ->name("fit_new");
    Route::post("/fits/new/submit", 'FitsController@new_store')
         ->name("fit_new_store");
    Route::get("/fit/{id}", 'FitsController@get')
         ->name('fit_single');
    Route::get("/fit/{id}/delete", 'FitsController@delete')
         ->name('fit.delete');
    Route::get("/fit/{id}/change-privacy/{privacySetting}", 'FitsController@changePrivacy')
         ->name('fit.change_privacy');
    Route::get("/fits", 'FitSearchController@index')
         ->name("fit.index");
    Route::any("/fits/search", 'FitSearchController@search')
         ->name("fit.search");
    Route::post("/fits/search/ajax", 'FitSearchController@searchAjax')
         ->name("fit.search.ajax");
    Route::get("/fits/search/select/{shipId}", 'FitSearchController@getFitsForNewRunDropdown')
         ->name("fit.search.select");

    /**
     * Item check
     */
    Route::get("/loot/item/{item_id}/", 'ItemController@get_single')
         ->name("item_single");
    Route::get("/loot/group/{group_id}/", 'ItemController@get_group')
         ->name("item_group");
    Route::view("/changelog", "changelog")
         ->name("changelog");
    Route::get("/loot/all", 'ItemController@get_all')
         ->name("item_all");
    Route::get("/api/search/items", 'ItemController@search_items')
         ->name("search_items");

    /**
     * Chart APIs
     */
    Route::get("/api/chart/home/types", 'GraphHelper@homeType')
         ->name("chart.home.type");
    Route::get("/api/chart/home/tiers", 'GraphHelper@homeTier')
         ->name("chart.home.tier");
    Route::get("/api/chart/home/loot_levels", 'GraphHelper@homeLootLevels')
         ->name("chart.home.loot_levels");
    Route::get("/api/chart/home/survival", 'GraphHelper@homeSurvival')
         ->name("chart.home.survival");
    Route::get("/api/chart/home/tiers/averages", 'GraphHelper@tierAverages')
         ->name("chart.home.tier_averages");
    Route::get("/api/chart/personal/loot", 'GraphHelper@personalLoot')
         ->name("chart.personal.loot");
    Route::get("/api/chart/personal/isk_per_hour", 'GraphHelper@personalIsk')
         ->name("chart.personal.ihp");

    /**
     * Search routes
     */
    Route::get("/search", 'SearchController@index')
         ->name("search.index");
    Route::any("/search/execute", 'SearchController@search')
         ->name("search.do");

    /**
     * EVE Authentication routes
     */
    Route::get("/eve/auth/start", 'Auth\AuthController@redirectToProvider')
         ->name("auth-start");
    Route::get("/eve/auth/callback", 'Auth\AuthController@handleProviderCallback');
    Route::get("/eve/scoped/auth/start", 'Auth\AuthController@redirectToScopedProvider')
         ->name("auth-scoped-start");
    Route::get("/eve/scoped/auth/callback", 'Auth\AuthController@handleScopedProviderCallback');
    Route::get("/logout", 'Auth\AuthController@logout')
         ->name("logout");

    /**
     * Theme routes
     */
    Route::get("/customize/dark-theme/{isDark}", 'ThemeController@setTheme')
         ->name("customize_set_dark");

    /**
     * Maintenance routes
     */
    Route::get("/maintenance/flagged/{secret}", function ($secret) {
        if ($secret != env("MAINTENANCE_TOKEN")) {
            abort(403, "Invalid maintenance token.");
        }
        $flags = DB::table("run_report")
                   ->where("PROCESSED", false)
                   ->orderBy("CREATED_AT", "DESC")
                   ->get();

        return view("sp_message", ["title" => "Flagged runs", "message" => print_r($flags, true)]);
    });

    Route::get("/maintenance/flagged/delete/{id}/{secret}", function ($id, $secret) {
        if ($secret != env("MAINTENANCE_TOKEN")) {
            abort(403, "Invalid maintenance token.");
        }

        DB::table("run_report")
          ->where("RUN_ID", $id)
          ->update(["PROCESSED" => true]);
        DB::table("detailed_loot")
          ->where("RUN_ID", $id)
          ->delete();
        DB::table("lost_items")
          ->where("RUN_ID", $id)
          ->delete();
        DB::table("runs")
          ->where("ID", $id)
          ->delete();


        return view("sp_message", ["title" => "Flagged runs", "message" => "Run #$id destroyed"]);
    });

    Route::get("/maintenance/db/{secret}", function ($secret) {
        if ($secret != env("MAINTENANCE_TOKEN")) {
            abort(403, "Invalid maintenance token.");
        }
        echo "DB maintenance starts <br>";
        echo Artisan::call('migrate', ['--force' => true]);
        echo "DB maintenance Over";
    });

    Route::get("/maintenance/test-login/{login_id}/{secret}", function ($login_id, $secret) {
        if ($secret != env("MAINTENANCE_TOKEN")) {
            abort(403, "Invalid maintenance token.");
        }
        session()->put("login_id", $login_id);
        session()->put("login_name", "TEST LOGIN $login_id");

        return redirect(\route("home_mine"));
    });

    Route::get("/maintenance/recalc-fit/{id}/{secret}", function ($id, $secret) {
        if ($secret != env("MAINTENANCE_TOKEN")) {
            abort(403, "Invalid maintenance token.");
        }

        /** @var \App\Http\Controllers\FitsController $fits */
        $fits = resolve('App\Http\Controllers\FitsController');
        $fit = DB::table("fits")->where("ID", $id)->select(["RAW_EFT", "SHIP_ID"])->first();
        $fits->submitSvcFitService($fits->getFitHelper()->pyfaBugWorkaround($fit->RAW_EFT, $fit->SHIP_ID), $id);

        return redirect(\route("fit_single", ["id" => $id]));
    });
