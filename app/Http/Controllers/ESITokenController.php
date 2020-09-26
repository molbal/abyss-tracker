<?php


    namespace App\Http\Controllers;


    use App\Exceptions\ESIAuthException;
    use Exception;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class ESITokenController {

        /** @var int EVE Character ID */
        protected $charId;

        /**
         * ESITokenController constructor.
         *
         * @param int $charId
         */
        public function __construct(int $charId) {
            $this->charId = $charId;
        }


        /**
         * Gets a usable, not expired access token
         * @return string Access token
         * @throws Exception
         */
        public function getAccessToken():string {
            if (Cache::has("AccessToken-".$this->charId)) {

                $token = Cache::get("AccessToken-".$this->charId);
            }
            else {
                $token = $this->getAndCacheNewAccessToken();
            }
            return $token;
        }

        /**
         * Gets a new, refreshed access token and places it in the cache + returns it.
         * @throws Exception
         */
        public function getAndCacheNewAccessToken(): ?string {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL,"https://login.eveonline.com/oauth/token");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                'grant_type' => "refresh_token",
                'refresh_token' => $this->getRefreshToken()
            ]));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Type:application/json",
                "Authorization:Basic ".base64_encode(config('tracker.scoped.client_id').":".config('tracker.scoped.client_secret'))
            ]);

            curl_setopt($ch,CURLOPT_VERBOSE ,true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $esiResponse = curl_exec($ch);
            /**
             {
                "access_token":"MXP...tg2",
                "token_type":"Bearer",
                "expires_in":1200,
                "refresh_token":"gEy...fM0"
            }
            */
            curl_close($ch);

            if (!$esiResponse) {
                Log::error("Could not get access token!");
                return null;
            }

            /** @var array $esiResponseDecoded */
            $esiResponseDecoded = @json_decode($esiResponse, true);
            /** @var int $expiresInMinutes */
            $expiresInMinutes = max(floor(($esiResponseDecoded["expires_in"] ?? 0)/60)-1, 1);
            /** @var string $newAccessToken */
            $newAccessToken = $esiResponseDecoded["access_token"] ?? null;

            if (!$newAccessToken) {
                throw new ESIAuthException("Could not get auth token for char ID ".$this->charId);
            }
            Cache::forget("AccessToken-".$this->charId);
            Cache::put("AccessToken-".$this->charId, $newAccessToken, now()->addMinutes($expiresInMinutes));
            return $newAccessToken;
        }


        /**
         * Gets the stored refresh token from the database
         * @return string Refresh token
         * @throws Exception Throws exception if the character ID has no refresh token stored
         */
        public function getRefreshToken() {

            $refreshToken = DB::table('chars')
                ->select('REFRESH_TOKEN')
                ->where('CHAR_ID', '=', $this->charId);
            if (!$refreshToken->exists()) {
                throw new Exception("The user ID " . $this->charId. " has no refresh token stored");
            }
            else {
                $refreshToken = $refreshToken->first()->REFRESH_TOKEN;
            }

            return $refreshToken;
        }

    }
