<?php


	namespace App\Connector\EveAPI\Journal;


	use App\Connector\EveAPI\EveAPICore;
    use App\Exceptions\ESIAuthException;
    use App\Http\Controllers\ESITokenController;
    use App\Http\Controllers\Misc\DTO\IngameDonor;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\Log;

    class JournalService extends EveAPICore {


        /**
         * @param int    $charId
         * @param string $refreshToken
         *
         * @return mixed|null
         * @throws \Exception
         */
        public  function getCharJournal(int $charId, string $refreshToken) {
//            Log::error("1");
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL,"https://login.eveonline.com/oauth/token");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                'grant_type' => "refresh_token",
                'refresh_token' => $refreshToken
            ]));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Type:application/json",
                "Authorization:Basic ".base64_encode(env("EVEONLINE_DONATION_SCOPED_CLIENT_ID").":".env("EVEONLINE_DONATION_SCOPED_CLIENT_SECRET"))
            ]);
//            Log::error("2");
            $esiResponse = curl_exec($ch);
            curl_close($ch);

            if (!$esiResponse) {
                return null;
            }

            /** @var array $esiResponseDecoded */
            $esiResponseDecoded = @json_decode($esiResponse, true);
            /** @var string $newAccessToken */
            $accessToken = $esiResponseDecoded["access_token"] ?? null;

//            Log::error("Esirepsonse1: ".$esiResponse);
            if (!$accessToken) {
                throw new \Exception("Unable to get Access token");
            }
//            Log::error("3");
            $url = sprintf("https://esi.evetech.net/latest/characters/%d/wallet/journal/?datasource=tranquility&page=1", $charId);

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_USERAGENT => $this->userAgent,
                CURLOPT_URL => $url,
                CURLOPT_HTTPHEADER => [isset($accessToken) ? 'authorization: Bearer ' . $accessToken : 'X-a: b', 'accept: application/json']
            ]);
//            Log::error("4");
            $ret = curl_exec($curl);
//            Log::error("Esirepsonse2: ".$ret);
            curl_close($curl);

            $list = json_decode($ret, 1);
            $donators = collect([]);
//            Log::error("5");
            foreach ($list as $item) {
//                Log::error("6x");
                if ($item["ref_type"] == "player_donation" && $item["amount"] > 0) {
//                    Log::error("6a");
                    $donators->add(IngameDonor::fromEsiResponse($item));

                }
            }
//            dd($donators);
            return $donators;
        }
	}
