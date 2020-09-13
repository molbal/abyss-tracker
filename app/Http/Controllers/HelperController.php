<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelperController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginNotice() {
        return view("error", [
            'message' => "This page is only available for logged in users. Please log in via your Eve Online account.",
            'sso' => true
        ]);
    }
}
