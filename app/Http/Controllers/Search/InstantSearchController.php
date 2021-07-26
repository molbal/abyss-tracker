<?php


	namespace App\Http\Controllers\Search;


	use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Cache;
    use MeiliSearch\Client;

    class InstantSearchController extends Controller {

        /**
         * @return string
         */
        public static function getMeiliSearchPublicKey():string {
            return Cache::remember('meili.keys.public', now()->addMinutes(15), function () {

                $meili = new Client(config('tracker.meili.endpoint'), config('tracker.meili.masterKey'), new \GuzzleHttp\Client([
                    'timeout' => 2,
                    'headers' => ['Accept-Encoding' => 'gzip']
                ]));

                return $meili->getKeys()['public'];
            });
	    }
	}
