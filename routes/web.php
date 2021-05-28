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

    use App\Http\Controllers\FitsController;
    use App\Http\Controllers\GraphHelper;
    use App\Http\Controllers\ItemController;
    use App\Http\Controllers\Misc\QrController;
    use App\Http\Controllers\Profile\ActivityChartController;
    use App\Http\Controllers\PVP\PVPController;
    use App\Http\Controllers\StreamToolsController;
    use Illuminate\Support\Facades\Route;

    Route::get("/", 'AbyssController@home')->name("home");
    Route::get("/stats_mine/", 'AbyssController@home_mine')->name("home_mine")->middleware("sso");
    Route::get("/stats_mine/year/{year}", [ActivityChartController::class, 'redirectToYear'])->name("home.year-redirect")->middleware("sso");


    Route::post("/new", 'AbyssController@store')->name("store")->middleware("sso");
    Route::get("/new", 'AbyssController@form_new')->name("new")->middleware("sso");
    Route::post("/api/loot_estimate", 'Loot\AjaxLootController@getSum')->name("estimate_loot")->middleware("sso");

    Route::get("/runs/{order_by?}/{order_type?}", 'AbyssController@get_all')->name("runs");
    Route::get("/runs_mine/{order_by?}/{order_type?}", 'AbyssController@get_mine')->name("runs_mine")->middleware("sso");
    Route::get("/runs/{charID}/{order_by?}/{order_type?}", 'AbyssController@get_char')->name("runs_char");
    Route::get("/filter/{type}/{tier}", 'FilteredController@get_list')->name("filtered_list");


    /**
     * Runs
     */
    Route::get("/run/{id}", 'AbyssController@get_single')->name("view_single");
    Route::any("/run/qr/{id}/{color?}", [QrController::class, 'runQr'])->name("run.qr");
    Route::get("/run/{id}/privacy/{privacy}", 'AbyssController@change_privacy')->name("run.change_privacy")->middleware("sso");
    Route::get("/run/delete/{id}", 'AbyssController@delete')->name("run_delete")->middleware("sso");
    Route::post("/run/flag", 'AbyssController@flag')->name("run_flag")->middleware("sso");

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
    Route::get('/settings', 'Profile\SettingController@index')->name('settings.index')->middleware("sso");
    Route::post('/settings/update', 'Profile\SettingController@save')->name('settings.save')->middleware("sso");
    Route::post('/settings/remove-esi', 'Profile\SettingController@removeEsi')->name('settings.remove-esi')->middleware("sso");
    Route::post('/settings/save-cargo', 'Profile\SettingController@saveCargo')->name('settings.save-cargo')->middleware("sso");

    /**
     * Stopwatch
     */
    Route::post("/stopwatch/start/{charId}", 'StopwatchController@addChecks')->name("stopwatch_start")->middleware("sso");
    Route::get("/stopwatch/get/{charId}", 'StopwatchController@getAbyssState')->name("stopwatch_get")->middleware("sso");

    /**
     * Ships and fits routes
     */
    Route::get("/ships/", 'ShipsController@get_all')->name("ships_all");
    Route::get("/ship/{id}", 'ShipsController@get_single')->name("ship_single");
    Route::get("/fits/new-or-update/{id?}", [FitsController::class, 'new'])->name("fit_new")->middleware("sso");
    Route::any("/fits/new-do/submit", [FitsController::class, 'new_store'])->name("fit_new_store")->middleware("sso");
    Route::get("/fit/{id}/delete", [FitsController::class, 'delete'])->name('fit.delete')->middleware("sso");
    Route::get("/fit/{id}/change-privacy/{privacySetting}", 'FitsController@changePrivacy')->name('fit.change_privacy')->middleware("sso");
    Route::get("/fit/{id}", [FitsController::class, 'get'])->name('fit_single');
    Route::get("/fits", 'FitSearchController@index')->name("fit.index");
    Route::get("/fits/mine", 'FitSearchController@mine')->name("fit.mine")->middleware("sso");
    Route::any("/fits/search", 'FitSearchController@search')->name("fit.search");
    Route::post("/fits/search/ajax", 'FitSearchController@searchAjax')->name("fit.search.ajax");
    Route::post("/fits/update/description", [FitsController::class, 'updateDescription'])->name("fit.update.description")->middleware("sso");
    Route::post("/fits/update/video", [FitsController::class, 'updateVideo'])->name("fit.update.video")->middleware("sso");
    Route::get("/fits/update/last_patch/{id}/{status}", [FitsController::class, 'updateLastPatch'])->name("fit.update.last-patch")->middleware("sso");
    Route::get("/fits/search/select/{shipId}/{nameOrId?}", 'FitSearchController@getFitsForNewRunDropdown')->name("fit.search.select");
    Route::get("/fits/newrun/select", 'FitSearchController@getIntegratedTypeList')->name("fit.newrun.select")->middleware("sso");

    /**
     * Fit questions and answers
     */
    Route::post('/fit/questions/new', 'FitQuestionsController@postQuestion')->name('fit.questions.new')->middleware('sso');
    Route::post('/fit/questions/answer', 'FitQuestionsController@postAnswer')->name('fit.questions.answer')->middleware('sso');

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
    Route::prefix('/api/chart')->group(function () {
        Route::get("/home/types/tier/{tier}", [GraphHelper::class, 'typeTier'])->name("chart.home.type.tier");
        Route::get("/home/fits/popular/hull", [GraphHelper::class, 'popularHulls'])->name("chart.home.popular-hulls");
        Route::get("/home/fits/popular/class", [GraphHelper::class, 'popularClasses'])->name("chart.home.popular-classes");
        Route::get("/home/loot_levels", [GraphHelper::class, 'homeLootLevels'])->name("chart.home.loot_levels");
        Route::get("/home/survival/tier/{tier}", [GraphHelper::class, 'homeSurvivalTier'])->name("chart.home.survival.tier");
        Route::get("/home/tiers/averages", [GraphHelper::class, 'tierAverages'])->name("chart.home.tier_averages");
        Route::get("/personal/loot", [GraphHelper::class, 'personalLoot'])->name("chart.personal.loot");
        Route::get('/personal/activity/{year}', [ActivityChartController::class, 'loadChart'])->name('chart.activity');
        Route::get('/personal/timeline/{charId}', [ActivityChartController::class, 'loadTimelineChart'])->name('chart.timeline');
        Route::get("/personal/isk_per_hour", [GraphHelper::class, 'personalIsk'])->name("chart.personal.ihp");
        Route::get("/run/distribution/{tier}/{isCruiser}/{thisRun}", [GraphHelper::class, 'getRunBellGraphs'])->name("chart.run.averages");
        Route::get("/run/distribution/cruisers", [GraphHelper::class, 'getHomeRunBellGraphsCruisers'])->name("chart.home.distribution.cruisers");
        Route::get("/run/distribution/frigates", [GraphHelper::class, 'getHomeRunBellGraphsFrigates'])->name("chart.home.distribution.frigates");
        Route::get("/fit/popularity/{ids}/{name}", [GraphHelper::class, 'getFitPopularityChart'])->name("chart.fit.popularity");
        Route::get("/fit/loot-strategy/{ids}", [GraphHelper::class, 'getFitLootStrategyChart'])->name("chart.fit.loot-strategy");
        Route::get("/item/history/market/{id}", [ItemController::class, 'itemMarketHistory'])->name("chart.item.market-history");
        Route::get("/item/history/drops/{id}", [ItemController::class, 'itemDroppedVolume'])->name("chart.item.volume-history");
    });

    /**
     * Search routes
     */
    Route::get("/search", 'SearchController@index')->name("search.index");
    Route::any("/search/execute", 'SearchController@search')->name("search.do");
    Route::any("/search/saved/{uuid}", 'SearchController@savedSearch')->name("search.saved");

    /**
     * Donor routes
     */
    Route::get("/donors", 'Misc\DonorController@index')->name("donors.index");

    /**
     * Tutorials
     */
    Route::get("/tutorials", 'VideoTutorials\VideoTutorialsController@index')->name("tutorials.index");
    Route::get("/tutorial/{id}/{slug}", 'VideoTutorials\VideoTutorialsController@get')->name("tutorials.get");
    Route::get("/tutorial/vote/{id}/{vote}", 'VideoTutorials\VideoTutorialsController@vote')->name("tutorials.vote");
    Route::get("/tutorial/creator/{id}/{slug}", 'VideoTutorials\VideoTutorialsController@creatorIndex')->name("tutorials.creator");

    /**
     * EVE Authentication routes
     */
    Route::get("/eve/auth/start/{addAltCharacter?}", 'Auth\AuthController@redirectToProvider')->name("auth-start");
    Route::get("/eve/auth/callback", 'Auth\AuthController@handleProviderCallback');
    Route::get("/eve/scoped/auth/start", 'Auth\AuthController@redirectToScopedProvider')->name("auth-scoped-start");
    Route::get("/eve/scoped/auth/callback", 'Auth\AuthController@handleScopedProviderCallback');
    Route::get("/eve/mail-scoped/auth/start", 'Auth\AuthController@redirectToMailProvider')->name("auth-mail-start");
    Route::get("/eve/mail-scoped/auth/callback", 'Auth\AuthController@handleMailProviderCallback');
    Route::get("/logout", 'Auth\AuthController@logout')->name("logout");

    /**
     * Theme routes
     */
    Route::get("/customize/dark-theme/{isDark}", 'ThemeController@setTheme')->name("customize_set_dark");

    /**
     * Aggregator routes
     */
    Route::get('/info-page/tier/{tier}', 'InfopageController@tier')->name("infopage.tier");
    Route::get('/info-page/tier/{tier}/weather/{type}', 'InfopageController@tierType')->name("infopage.tier-type");
    Route::get('/info-page/weather/chart/{tier}/{type}/{hullSize}', 'DS\HistoricLootController@getChartData')->name('infopage.weather.chart');

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
    Route::get("/maintenance/mediantest", 'Maintenance\MaintenanceController@medianTests');

    /**
     * Community Controller
     */
    Route::get("/discord", 'CommunityController@discord')->name("community.discord");

    /**
     * Helpers
     */
    Route::any("/guard/must-log-in", 'HelperController@showLoginNotice')->name("helper.message.login");

    /**
     * Alt switcher routes
     */
    Route::get('/character-relationships', 'Profile\AltRelationController@index')->name('alts.index')->middleware('sso');
    Route::get('/character-relationships/list/ajax', 'Profile\AltRelationController@filterAjax')->name('alts.ajax')->middleware('sso');
    Route::get('/character-relationships/switch/{altId}', 'Auth\AuthController@switch')->name('alts.switch')->middleware('sso');
    Route::get('/character-relationships/remove/{mainId}/{altId}', 'Profile\AltRelationController@delete')->name('alts.delete')->middleware('sso');
    Route::post('/character-relationships/add/main', 'Profile\AltRelationController@setMain')->name('alts.add.alt')->middleware('sso');

    /**
     * Stream tools
     */
    Route::prefix('/stream-tools')->group(function () {
        Route::view('/controls', 'stream.settings')->middleware('sso')->name('stream-tools.control');

        Route::post('/view/daily/make', [StreamToolsController::class, 'createDailyLink'])->name('stream-tools.daily.make')->middleware('sso');
        Route::get ('/view/daily/redirect/{token}', [StreamToolsController::class, 'redirectToDailyView'])->name('stream-tools.daily.redirect');
        Route::get ('/view/daily', [StreamToolsController::class, 'viewDaily'])->name('stream-tools.daily.view');

        Route::post('/view/run/make', [StreamToolsController::class, 'createNewFullScreenModalLink'])->name('stream-tools.run.make')->middleware('sso');
        Route::get ('/view/run/{token}/{id?}', [StreamToolsController::class, 'viewRun'])->name('stream-tools.run.view');
    });

    /** Proving grounds tools */
    Route::prefix('/event')->group(function () {
        Route::get('/current', [PVPController::class, 'index'])->name('pvp.index');
        Route::get('/{slug}', [PVPController::class, 'getEvent'])->name('pvp.get');

        Route::get('/kill/{id}', [PVPController::class, 'getKill'])->name('pvp.kill');

        Route::get('/{slug}/kills', [PVPController::class, 'listKills'])->name('pvp.kills');
        Route::get("/{slug}/top-kills", [PVPController::class, 'listTopKills'])->name('pvp.top-kills');
        Route::get('/{slug}/item/{id}', [PVPController::class, 'viewItem'])->name('pvp.item');
        Route::get('/{slug}/ship/{id}', [PVPController::class, 'viewItem'])->name('pvp.ship');
        Route::get('/{slug}/character/{id}', [PVPController::class, 'viewCharacter'])->name('pvp.character');
        Route::get('/{slug}/corporation/{id}', [PVPController::class, 'viewCorporation'])->name('pvp.corporation');
        Route::get('/{slug}/alliance/{id}', [PVPController::class, 'viewAlliance'])->name('pvp.alliance');

        Route::get('/widget/top-kills/{id}', [PVPController::class, 'renderToplist'])->name('pvp.widget.top-kills');

    });



