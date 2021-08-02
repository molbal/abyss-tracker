<?php


	namespace App\Exceptions;


	class ConduitSecurityViolationException extends \Exception {

        /**
         * Render the exception into an HTTP response.
         *
         * @param  \Illuminate\Http\Request  $request
         *
         * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
         */
        public function render($request)
        {
            return response()->json([
                'success' => false,
                'error' => $this->getMessage()
            ]);
        }
	}
