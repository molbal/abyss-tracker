<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Auth\AuthController;
use App\Http\Requests\NewStreamToolDailyLinkRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class StreamToolsController extends Controller
{
    public function createDailyLink(NewStreamToolDailyLinkRequest $request) {
        $id = AuthController::getLoginId();
        $token = Crypt::encrypt([
            'charId' => $id,
            'width' => $request->get('width', '320px'),
            'height' => $request->get('width', '320px'),
            'align' => $request->get('width', "left"),
            'fontSize' => $request->get('fontSize', '36px'),
            'fontColor' => $request->get('fontColor', '#e3342f'),
        ]);

        return view('sp_message', [
           'title' => "Your stream link is ready",
           'message' => "You may use the link below as a browsersource in OBS, or other stream applications. You can save this link as it contains your authentication and settings.",
           'selectable' => route('stream-tools.daily.view', ['token' => $token])
        ]);
    }

    public function viewDaily(string $token) {

        dd(Crypt::decrypt($token));
    }
}
