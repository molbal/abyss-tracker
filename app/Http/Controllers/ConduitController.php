<?php

    namespace App\Http\Controllers;

    use App\Char;
    use App\Exceptions\BusinessLogicException;
    use App\Fit;
    use App\Http\Controllers\EFT\FitHelper;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use JetBrains\PhpStorm\ArrayShape;
    use Laravel\Sanctum\Sanctum;


    /**
     * Conduit v1 routes
     *
     * @authenticated
     */
    class ConduitController extends Controller {

        /**
         * Ping endpoint
         *
         * Returns a single success=>true endpoint if the auth token is valid.
         *
         * @group         Misc
         * @responseField error string|null null on normal operation, string containing error message on exception
         * @responseField char object contains the authenticated character's ID and name
         * @responseField char.id int|null authenticated character's ID  (might be null on error)
         * @responseField char.name string|null authenticated character's name (might be null on error)
         * @response {"success": true,"char": {"id": 93940047,"name": "Veetor Nara"}}
         *
         */
        #[ArrayShape(['success' => "bool", 'char' => "array", 'error' => "null"])] public function ping(Request $request) : array {
            return ['success' => true, 'char' => ['id' => $request->user()->CHAR_ID, 'name' => $request->user()->NAME], 'error' => null];
        }



        protected function getErrorResponse($e): array {
            return ['success' => false, 'char' => ['id' => \request()->user()->CHAR_ID ?? null, 'name' => \request()->user()->NAME ?? null,], 'item' => null, 'count' => null, 'error' => $e->getMessage()];
        }
    }
