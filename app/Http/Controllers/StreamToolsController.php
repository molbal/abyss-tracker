<?php

namespace App\Http\Controllers;


use App\Events\RunSaved;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Misc\ErrorHelper;
use App\Http\Requests\NewStreamToolDailyLinkRequest;
use App\Http\Requests\NewStreamToolFullScreenModalRequest;
use App\Models\Char;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use function auth;

class StreamToolsController extends Controller
{
    /**
     * Creates
     * @param NewStreamToolDailyLinkRequest $request
     *
     * @return Factory|View|Application
     */
    public function createDailyLink(NewStreamToolDailyLinkRequest $request) : Factory|View|Application {
        $id = AuthController::getLoginId();
        $token = Crypt::encrypt([
            'charId' => $id,
            'width' => $request->get('width', '320px'),
            'height' => $request->get('width', '320px'),
            'align' => $request->get('align', "left"),
            'fontSize' => $request->get('fontSize', '36px'),
            'fontColor' => $request->get('fontColor', '#e3342f'),
        ]);

        return view('sp_message', [
            'title' => "Your stream link is ready",
            'message' => "You may use the link below as a browser source in OBS, or other stream applications. You can save this link as it contains your authentication and settings. Never give this link to anyone else.",
            'selectable' => route('stream-tools.daily.redirect', ['token' => $token])
        ]);
    }

    /**
     * Creates
     * @param NewStreamToolDailyLinkRequest $request
     *
     * @return Factory|View|Application
     */
    public function createNewFullScreenModalLink(NewStreamToolFullScreenModalRequest $request) : Factory|View|Application {
        $id = AuthController::getLoginId();
        $token = Crypt::encrypt([
            'charId' => $id,
            'fontColor' => $request->get('fontColor', '#e3342f'),
            'qr' => $request->get('qr', true),
            'charVisible' => $request->get('charVisible', true),
            'duration' => $request->get('duration', 10_000),
        ]);

        return view('sp_message', [
            'title' => "Your stream link is ready",
            'message' => "You may use the link below as a browser source in OBS, or other stream applications. You can save this link as it contains your authentication and settings. Never give this link to anyone else.",
            'selectable' => route('stream-tools.run.view', ['token' => $token])
        ]);
    }

    /**
     * @param string   $token
     * @param int|null $id
     *
     * @return Factory|View|Redirector|Application|RedirectResponse
     */
    public function viewRun(string $token, ?int $id = null) : Factory|View|Redirector|Application|RedirectResponse {
        try {
            $settings = Crypt::decrypt($token);


            session()->forget(["login_id", "login_name"]);
            session()->put("login_id", $settings['charId']);
            session()->put("login_name", DB::table('chars')->where('CHAR_ID', $settings['charId'])->first('NAME')->NAME);

            auth()->login(AuthController::charIdToFrameworkUser($settings['charId']));


            if (auth()->guest()) {
                abort(403);
            }

            $run = DB::table('v_runall')->where('ID', $id)->first();

            if ($id) {
            $all_data = DB::table("runs")->where("ID", $id)->first();
            $loot = DB::table("v_loot_details")->where("RUN_ID", $id)->get();
            $lost = DB::select("select `dl`.`ITEM_ID`                   AS `ITEM_ID`,
       `dl`.`RUN_ID`                    AS `RUN_ID`,
       `dl`.`COUNT`                     AS `COUNT`,
       `ip`.`NAME`                      AS `NAME`,
       `ip`.`DESCRIPTION`               AS `DESCRIPTION`,
       `ip`.`GROUP_NAME`                AS `GROUP_NAME`,
       `ip`.`PRICE_BUY`                 AS `PRICE_BUY`,
       `ip`.`PRICE_SELL`                AS `PRICE_SELL`,
       `ip`.`PRICE_BUY` * `dl`.`COUNT`  AS `BUY_PRICE_ALL`,
       `ip`.`PRICE_SELL` * `dl`.`COUNT` AS `SELL_PRICE_ALL`
from (`abyss`.`lost_items` `dl`
         join `abyss`.`item_prices` `ip` on (`dl`.`ITEM_ID` = `ip`.`ITEM_ID`)) where dl.`RUN_ID`=?;", [$id]);
            $abyssCo = resolve('App\Http\Controllers\AbyssController');
            $lost = $abyssCo->normalizeLootAndLost($id, $all_data, $lost, $loot);
            }



            return view('stream.run', [
                'token' => $token,
                'charId' => $settings['charId'],
                'fontColor' => $settings['fontColor'],
                'duration' => $settings['duration'],
                'qr' => $settings['qr'],
                'id' => $id,
                'run' => $run,
                'charVisible' =>  $settings['charVisible'],
                'loot' => $loot ?? null,
                'lost' => $lost ?? null,
            ]);
        } catch (DecryptException) {
            return ErrorHelper::errorPage("Please generate a new link - this is impossible to decode. You probably made a copy/paste mistake somewhere?", "Invalid token");
        }
    }




    /**
     * Redirects to daily view after authentication
     * @param string $token
     *
     * @return Factory|View|Redirector|Application|RedirectResponse
     */
    public function redirectToDailyView(string $token) : Factory|View|Redirector|Application|RedirectResponse {
        try {
            $settings = Crypt::decrypt($token);


            session()->forget(["login_id", "login_name"]);
            session()->put("login_id", $settings['charId']);
            session()->put("login_name", DB::table('chars')->where('CHAR_ID', $settings['charId'])->first('NAME')->NAME);
            auth()->login(AuthController::charIdToFrameworkUser($settings['charId']));

            session()->flash('daily', $settings);
            return redirect(route('stream-tools.daily.view'));
        } catch (DecryptException) {
            return ErrorHelper::errorPage("Please generate a new link - this is impossible to decode. You probably made a copy/paste mistake somewhere?", "Invalid token");
        }
    }

    /**
     * Renders the daily display
     * @return Factory|View|Application
     */
    public function viewDaily() : Factory|View|Application {

        if (auth()->guest() || !session()->has('daily')) {
            return ErrorHelper::errorPage("Please use your generated link, not this URL directly.");
        }

        try {
            $data = session()->get('daily');
            $event = RunSaved::createEventForUser($data['charId']);
            $data["runsCount"] = $event->runsCount;
            $data["sumIsk"] = $event->sumIsk;
            $data["avgIsk"] = $event->avgIsk;
            $data["iskHour"] = $event->iskHour;
            $data["charName"] = Char::where("CHAR_ID", $event->charId)->first()->NAME;
            return view('stream.daily', $data);

        }
        catch (\Exception $e) {
            return ErrorHelper::errorPage("Something went wrong while loading this widget.", "Abyss Tracker error");
        }

    }
}
