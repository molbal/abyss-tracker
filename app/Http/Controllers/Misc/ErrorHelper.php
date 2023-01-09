<?php


	namespace App\Http\Controllers\Misc;


	class ErrorHelper {


        public static function errorPage($message, $title = "Error") : \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
            return view('error', [
                'title' => $title,
                'message' => $message,
            ]);
	    }

	}
