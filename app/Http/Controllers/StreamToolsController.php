<?php

namespace App\Http\Controllers;


use App\Char;
use App\Events\RunSaved;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Misc\ErrorHelper;
use App\Http\Requests\NewStreamToolDailyLinkRequest;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class StreamToolsController extends Controller
{
    public function createDailyLink(NewStreamToolDailyLinkRequest $request) {
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
           'message' => "You may use the link below as a browsersource in OBS, or other stream applications. You can save this link as it contains your authentication and settings.",
           'selectable' => route('stream-tools.daily.redirect', ['token' => $token])
        ]);
    }

    public function redirectToDailyView(string $token) {

        try {
            $settings = Crypt::decrypt($token);


            session()->forget(["login_id", "login_name"]);
            session()->put("login_id", $settings['charId']);
            session()->put("login_name", DB::table('chars')->where('CHAR_ID', $settings['charId'])->first('NAME')->NAME);
            \auth()->login(AuthController::charIdToFrameworkUser($settings['charId']));

            session()->flash('daily', $settings);
            return redirect(route('stream-tools.daily.view'));
        } catch (DecryptException $e) {
            return ErrorHelper::errorPage("Please generate a new link - this is impossible to decode. You probably made a copy/paste mistake somewhere?", "Invalid token");
        }
    }

    public function viewDaily() {
        if (\auth()->guest() || !session()->has('daily')) {
            return ErrorHelper::errorPage("Please use your generated link, not this URL directly.");
        }

        $data = session()->get('daily');
        $event = RunSaved::createEventForUser($data['charId']);
        $data["runsCount"] = $event->runsCount;
        $data["sumIsk"] = $event->sumIsk;
        $data["avgIsk"] = $event->avgIsk;
        $data["charName"] = Char::where("CHAR_ID", $event->charId)->first()->NAME;
        return view('stream.daily', $data);

    }
}
