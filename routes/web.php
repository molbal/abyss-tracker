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

    use Illuminate\Support\Facades\Route;

    Route::get("/", 'AbyssController@home')->name("home");
    Route::get("/stats_mine/", 'AbyssController@home_mine')->name("home_mine");


    Route::post("/new", 'AbyssController@store')->name("store");
    Route::get("/new", 'AbyssController@form_new')->name("new");
    Route::post("/api/loot_estimate", 'Loot\AjaxLootController@getSum')->name("estimate_loot");

    Route::get("/runs/{order_by?}/{order_type?}", 'AbyssController@get_all')->name("runs");
    Route::get("/runs_mine/{order_by?}/{order_type?}", 'AbyssController@get_mine')->name("runs_mine");
    Route::get("/runs/{charID}/{order_by?}/{order_type?}", 'AbyssController@get_char')->name("runs_char");
    Route::get("/filter/{type}/{tier}", 'FilteredController@get_list')->name("filtered_list");


    /**
     * Runs
     */
    Route::get("/run/{id}", 'AbyssController@get_single')->name("view_single");
    Route::get("/run/{id}/privacy/{privacy}", 'AbyssController@change_privacy')->name("run.change_privacy");
    Route::get("/run/delete/{id}", 'AbyssController@delete')->name("run_delete");
    Route::post("/run/flag", 'AbyssController@flag')->name("run_flag");

    /**
     * Profile
     */
    Route::get('/char/{id}', 'Profile\ProfileController@index')->name('profile.index');
    Route::get("/char/{id}/loot/{from}/{to}", 'Profile\ProfileController@loot')->name('profile.loot');
    Route::get("/char/{id}/export/{from}/{to}", 'Profile\ProfileController@downloadLoot')->name('profile.export');

    /**
     * Leaderboards
     */
    Route::get('/leaderboard', 'Profile\LeaderboardController@index')->name('leaderboard.index');

    /**
     * Settings
     */
    Route::get('/settings', 'Profile\SettingController@index')->name('settings.index');
    Route::post('/settings/update', 'Profile\SettingController@save')->name('settings.save');
    Route::post('/settings/remove-esi', 'Profile\SettingController@removeEsi')->name('settings.remove-esi');

    /**
     * Stopwatch
     */
    Route::post("/stopwatch/start/{charId}", 'StopwatchController@addChecks')->name("stopwatch_start");
    Route::get("/stopwatch/get/{charId}", 'StopwatchController@getAbyssState')->name("stopwatch_get");

    /**
     * Ships and fits routes
     */
    Route::get("/ships/", 'ShipsController@get_all')->name("ships_all");
    Route::get("/ship/{id}", 'ShipsController@get_single')->name("ship_single");
    Route::get("/fits/new", 'FitsController@new')->name("fit_new");
    Route::post("/fits/new/submit", 'FitsController@new_store')->name("fit_new_store");
    Route::get("/fit/{id}/delete", 'FitsController@delete')->name('fit.delete');
    Route::get("/fit/{id}/change-privacy/{privacySetting}", 'FitsController@changePrivacy')->name('fit.change_privacy');
    Route::get("/fit/{id}", 'FitsController@get')->name('fit_single');
    Route::get("/fits", 'FitSearchController@index')->name("fit.index");
    Route::any("/fits/search", 'FitSearchController@search')->name("fit.search");
    Route::post("/fits/search/ajax", 'FitSearchController@searchAjax')->name("fit.search.ajax");
    Route::get("/fits/search/select/{shipId}/{nameOrId?}", 'FitSearchController@getFitsForNewRunDropdown')->name("fit.search.select");

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
    Route::get("/api/chart/home/types/tier/{tier}", 'GraphHelper@typeTier')->name("chart.home.type.tier");
    Route::get("/api/chart/home/tiers", 'GraphHelper@homeTier')->name("chart.home.tier");
    Route::get("/api/chart/home/loot_levels", 'GraphHelper@homeLootLevels')->name("chart.home.loot_levels");
    Route::get("/api/chart/home/survival", 'GraphHelper@homeSurvival')->name("chart.home.survival");
    Route::get("/api/chart/home/survival/tier/{tier}", 'GraphHelper@homeSurvivalTier')->name("chart.home.survival.tier");
    Route::get("/api/chart/home/tiers/averages", 'GraphHelper@tierAverages')->name("chart.home.tier_averages");
    Route::get("/api/chart/personal/loot", 'GraphHelper@personalLoot')->name("chart.personal.loot");
    Route::get("/api/chart/personal/isk_per_hour", 'GraphHelper@personalIsk')->name("chart.personal.ihp");
    Route::get("/api/chart/run/distribution/{tier}/{isCruiser}/{thisRun}", 'GraphHelper@getRunBellGraphs')->name("chart.run.averages");
    Route::get("/api/chart/run/distribution/cruisers", 'GraphHelper@getHomeRunBellGraphsCruisers')->name("chart.home.distribution.cruisers");
    Route::get("/api/chart/run/distribution/frigates", 'GraphHelper@getHomeRunBellGraphsFrigates')->name("chart.home.distribution.frigates");

    /**
     * Search routes
     */
    Route::get("/search", 'SearchController@index')->name("search.index");
    Route::any("/search/execute", 'SearchController@search')->name("search.do");

    /**
     * Donor routes
     */
    Route::get("/donors", 'Misc\DonorController@index')->name("donors.index");

    /**
     * EVE Authentication routes
     */
    Route::get("/eve/auth/start", 'Auth\AuthController@redirectToProvider')->name("auth-start");
    Route::get("/eve/auth/callback", 'Auth\AuthController@handleProviderCallback');
    Route::get("/eve/scoped/auth/start", 'Auth\AuthController@redirectToScopedProvider')->name("auth-scoped-start");
    Route::get("/eve/scoped/auth/callback", 'Auth\AuthController@handleScopedProviderCallback');
    Route::get("/logout", 'Auth\AuthController@logout')->name("logout");

    /**
     * Theme routes
     */
    Route::get("/customize/dark-theme/{isDark}", 'ThemeController@setTheme')->name("customize_set_dark");

    /**
     * Aggregator routes
     */
    Route::get('/info-page/tier/{tier}', 'InfopageController@tier')->name("infopage.tier");

    /**
     * Maintenance routes
     */
    Route::get("/maintenance/flagged/{secret}", 'Maintenance\MaintenanceController@showFlaggedRuns');
    Route::get("/maintenance/convert-eft/{secret}", 'Maintenance\MaintenanceController@convertOldFits');
    Route::get("/maintenance/flagged/delete/{id}/{secret}", 'Maintenance\MaintenanceController@deleteFlaggedRun');
    Route::get("/maintenance/db/{secret}", 'Maintenance\MaintenanceController@runMigrations');
    Route::get("/maintenance/routes/{secret}", 'Maintenance\MaintenanceController@getRoutes');
    Route::get("/maintenance/optimize/{secret}", 'Maintenance\MaintenanceController@resetAndCache');
    Route::get("/maintenance/test-login/{login_id}/{secret}", 'Maintenance\MaintenanceController@debugLogin');
    Route::get("/maintenance/recalc-fit/{id}/{secret}", 'Maintenance\MaintenanceController@recalculateSingleFit');
    Route::get("/maintenance/recalc-fits/{secret}", 'Maintenance\MaintenanceController@recalculateQueuedFits');

    /**
     * Community Controller
     */
    Route::get("/discord", 'CommunityController@discord')->name("community.discord");

