<?php


	namespace App\Http\Controllers\Misc;


	use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\View\View;
    use Illuminate\Support\Facades\Log;

    class ErrorHelper {

        /**
         * @param        $message
         * @param string $title
         *
         * @return Factory|View|Application
         */
        public static function errorPage($message, $title = "Error") : Factory|View|Application {
            Log::warning(sprintf("Generating error page: %s: .%s", $title, $message));
            return view('error', [
                'title' => $title,
                'message' => $message,
            ]);
	    }

	}
