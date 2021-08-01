<?php

namespace App\Http\Controllers\Misc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public static function flashInfoLine(string $text, string $borderClass = "info") {
        session()->flash('infoline_text', $text);
        session()->flash('infoline_style', $borderClass);
    }

    public static function renderInfoline() {
        if (session()->has('infoline_text')) {
            return '<div class="row mt-3">
                        <div class="col-sm-12"><div class="alert mb-3 border-'.session('infoline_style').' shadow-sm">
                            <div class="d-flex w-100 justify-content-start align-items-center ">
                                <span class="tinyicon"><img src="https://img.icons8.com/small/24/ffffff/info.png" class="tinyicon mr-2"></span><span class="text-justify">'.session('infoline_text').'</span>
                            </div>
                    </div>
    </div>';
        }
        return  '';
    }

    public static function flashToast(string $text) {
        session()->flash('toast_text', $text);
    }

    public static function renderToast() {
        if (session()->has('toast_text')) {
            return "
            Toastify({
                text: '".str_ireplace('\'',"\\", session('toast_text'))."',
                duration: 3000,
                close: true,
                gravity: 'top',
                position: 'center',
            }).showToast();
            ";
        }

        return  '';
    }
}
