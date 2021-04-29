<?php


	namespace App\Http\Controllers\Misc;


	class ErrorHelper {

        /**
         * @param        $message
         * @param string $title
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
         */
        public static function errorPage($message, $title = "Error") : \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
            return view('error', [
                'title' => $title,
                'message' => $message,
            ]);
	    }

	}
