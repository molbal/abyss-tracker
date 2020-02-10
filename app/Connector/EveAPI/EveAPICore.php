<?php


	namespace App\Connector\EveAPI;


	use App\Connector\ESITokenController;
	use Illuminate\Support\Facades\DB;

	abstract class EveAPICore
	{

		/** @var string */
		protected $apiRoot;

		/** @var string $this */
		protected $userAgent;

		/**
		 * EveAPICore constructor.
		 */
		public function __construct()
		{
			$this->apiRoot = env("ESI_ROOT", "https://esi.evetech.net/latest/");
			$this->userAgent = env("ESI_USERAGENT", "Eve Co-Pilot (https://co-pilot.eve-nt.uk; molbal@outlook.com)");
		}

		/**
		 * Creates a get CURL request with ESI authentication
		 *
		 * @param int $charId Character ID
		 *
		 * @return false|resource
		 * @throws \Exception
		 */
		protected function createGet(int $charId = null)
		{
			$curl = curl_init();

			if ($charId) {
				$tokenController = new ESITokenController($charId);
				$accessToken = $tokenController->getAccessToken();
			}
			curl_setopt_array($curl, [CURLOPT_RETURNTRANSFER => 1, CURLOPT_USERAGENT => $this->userAgent, CURLOPT_HTTPHEADER => [isset($accessToken) ? 'authorization: Bearer ' . $accessToken : 'X-a: b', 'accept: application/json'],

									  CURLOPT_VERBOSE => true, CURLOPT_STDERR => fopen('./curl.log', 'a+'),

			]);

			return $curl;
		}

		/**
		 * Makes a GET call to ESI with authentication
		 *
		 * @param int    $charId
		 * @param string $fullPath
		 *
		 * @return mixed
		 * @throws \Exception
		 */
		protected function simpleGet(?int $charId, string $fullPath)
		{

			$curl = curl_init();

			if ($charId) {
				$tokenController = new ESITokenController($charId);
				$accessToken = $tokenController->getAccessToken();
			}
			curl_setopt_array($curl, [
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_USERAGENT => $this->userAgent,
				CURLOPT_URL => $this->apiRoot . $fullPath,
				CURLOPT_HTTPHEADER => [isset($accessToken) ? 'authorization: Bearer ' . $accessToken : 'X-a: b', 'accept: application/json'],

									  CURLOPT_VERBOSE => true, CURLOPT_STDERR => fopen('./curl.log', 'a+'),

			]);
			$ret = curl_exec($curl);
			curl_close($curl);

			return json_decode($ret);
		}


		/**
		 * Makes a POST call to ESI with authentication
		 *
		 * @param int    $charId
		 * @param string $fullPath
		 * @param string $requestBody
		 * @param bool   $jsonReply Set to true if the expected response is JSON
		 *
		 * @return mixed
		 * @throws \Exception
		 */
		protected function simplePost(?int $charId, string $fullPath, string $requestBody, bool $jsonReply = true)
		{

			$curl = curl_init();

			if ($charId) {
				$tokenController = new ESITokenController($charId);
				$accessToken = $tokenController->getAccessToken();
			}
			curl_setopt_array($curl, [CURLOPT_RETURNTRANSFER => 1, CURLOPT_POST => true, CURLOPT_USERAGENT => $this->userAgent, CURLOPT_URL => $this->apiRoot . $fullPath, CURLOPT_HTTPHEADER => [isset($accessToken) ? 'authorization: Bearer ' . $accessToken : 'X-a: b', 'accept: application/json', "Content-type: application/json"], CURLOPT_POSTFIELDS => $requestBody, CURLOPT_VERBOSE => true, CURLOPT_STDERR => fopen('./curl.log', 'a+'),

			]);
			$ret = curl_exec($curl);
			curl_close($curl);

			if ($jsonReply) {
				return json_decode($ret);
			} else {
				return $ret;
			}
		}

		/**
		 * Creates a post CURL request with ESI authentication
		 *
		 * @param int|null $charId
		 *
		 * @return false|resource
		 * @throws \Exception
		 */
		protected function createPost(?int $charId = null)
		{
			$curl = curl_init();

			if ($charId) {
				$tokenController = new ESITokenController($charId);
				$accessToken = $tokenController->getAccessToken();
			}
			curl_setopt_array($curl, [CURLOPT_RETURNTRANSFER => 1, CURLOPT_USERAGENT => $this->userAgent, CURLOPT_POST => true, CURLOPT_HTTPHEADER => [isset($accessToken) ? 'authorization: Bearer ' . $accessToken : 'X-a: b', 'accept: application/json'],

									  CURLOPT_VERBOSE => true, CURLOPT_STDERR => fopen('./curl.log', 'a+'),

			]);

			return $curl;

		}


		/**
		 * @param int    $stationId
		 * @param string $stationName
		 */
		protected function forevercachePut(int $stationId, string $stationName) : void
		{
			DB::table("forevercache")->insert(["ID" => $stationId, "Name" => $stationName]);
		}

		/**
		 * @param int $itemId
		 *
		 * @return bool
		 */
		protected function forevercacheHas(int $itemId) : bool
		{
			return DB::table("forevercache")->where("ID", "=", $itemId)->exists();
		}

		/**
		 * @param int $itemId
		 *
		 * @return mixed
		 */
		protected function forevercacheGet(int $itemId) : string
		{
			$results = DB::table("forevercache")->select("Name")->where("ID", "=", $itemId)->get();

			return $results->get(0)->Name;
		}

		/**
		 * Helper function to determine whether a string is valid json
		 *
		 * @param $string
		 *
		 * @return bool
		 */
		protected function isJson(string $string) : bool
		{
			try {

				$decoded = json_decode($string);
				if (!is_object($decoded) && !is_array($decoded)) {
					return false;
				}

				return (json_last_error() == JSON_ERROR_NONE);
			} catch (\Exception $ignored) {
				return false;
			}

		}

	}