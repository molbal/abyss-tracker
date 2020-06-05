<?php


	namespace App\Connector\EveAPI\Journal;


	use App\Connector\EveAPI\EveAPICore;
    use App\Exceptions\ESIAuthException;
    use App\Http\Controllers\ESITokenController;
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

            $esiResponse = curl_exec($ch);
            curl_close($ch);

            if (!$esiResponse) {
//                Log::error("Could not get access token!");
                return null;
            }

            /** @var array $esiResponseDecoded */
            $esiResponseDecoded = @json_decode($esiResponse, true);
            /** @var int $expiresInMinutes */
//            $expiresInMinutes = floor($esiResponseDecoded["expires_in"] ?? 0/60);
            /** @var string $newAccessToken */
            $accessToken = $esiResponseDecoded["access_token"] ?? null;

            Log::error($esiResponse);
            if (!$accessToken) {
                throw new \Exception("Unable to get Access token");
            }

            $url = sprintf("https://esi.evetech.net/latest/characters/%d/wallet/journal/?datasource=tranquility&page=1", $charId);

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_USERAGENT => $this->userAgent,
                CURLOPT_URL => $url,
                CURLOPT_HTTPHEADER => [isset($accessToken) ? 'authorization: Bearer ' . $accessToken : 'X-a: b', 'accept: application/json']
            ]);
            $ret = curl_exec($curl);
            curl_close($curl);

            $list = json_decode($ret, 1);
            $donators = collect([]);
            foreach ($list as $item) {
                if ($item["ref_type"] == "player_donation" && $item["amount"] > 0) {
                    $donators->add($item);
                }
            }

            return $donators;
        }
	}
