<?php



    namespace App\Http\Controllers\Partners;


	use DOMDocument;
    use DOMXPath;
    use Illuminate\Support\Facades\Http;
    use RuntimeException;

    class EveWorkbench {

        /**
         * Gets the EVE Workbench URL
         * @param string $name
         *
         * @return string
         */
        public static function getProfileUrl(string $name): string {
            $name = preg_replace('/[^a-zA-Z0-9\' ]/', '', $name);
            $name = str_replace("'", '', $name);
            return "https://www.eveworkbench.com/u/".strtolower(str_replace(" ", "-", $name));
	    }


        /**
         * Gets the FIT EFT from EVE Workbench
         * @param string $ewbLink
         *
         * @return string
         * @throws RuntimeException
         */
        public static function getEveWorkbenchFit(string $ewbLink) : string {
            libxml_use_internal_errors(true);
            $DOM = new DOMDocument();
            $source = Http::get($ewbLink);
            if ($source->failed() || !$source->successful()) {
                throw new RuntimeException("Could not get link " . $ewbLink);
            }
            $DOM->loadHTML($source->body());
            $xpath = new DOMXPath($DOM);
            $eft = $xpath->query('//textarea[@id="eftFitting"]')
                         ->item(0)->nodeValue;
            libxml_use_internal_errors(false);

            return $eft;
        }
	}
