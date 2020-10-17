<?php


	namespace App\Http\Controllers\Partners;


    use DOMDocument;
    use DOMXPath;
    use Illuminate\Support\Facades\Http;
    use RuntimeException;


	class ZKillboard {

        /**
         * Gets a fit from zKillboard
         * @param string $zkillLink
         *
         * @return string
         * @throws \Exception
         */
        public static function getZKillboardFit(string $zkillLink): string {
            libxml_use_internal_errors(true);
            $DOM = new DOMDocument();
            $source = Http::get($zkillLink);
            if ($source->failed() || !$source->successful()) {
                throw new RuntimeException("Could not get link " . $zkillLink);
            }
            $DOM->loadHTML($source->body());
            $xpath = new DOMXPath($DOM);
            $eft = $xpath->query('//textarea[@id="eft"]')
                         ->item(0)->nodeValue;
            libxml_use_internal_errors(false);

            return $eft;
        }
	}
