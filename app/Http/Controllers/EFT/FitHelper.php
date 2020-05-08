<?php


	namespace App\Http\Controllers\EFT;


	use Illuminate\Support\Facades\DB;

    class FitHelper {

        public function getFitFFH(string $eft) {

            $lines = explode("\n", $eft);

            // Let's get before the comma: strip ammo
            $ammo = trim(explode(',', $line, 2)[1] ?? "");
            $ammo_id = DB::table("item_prices")->where("NAME", $ammo)->value("ITEM_ID");
            $line = explode(',', $line, 2)[0];

            if (preg_match('/^.+x\d{0,4}$/m', $line)) {
                $words = explode(' ', $line);
                $count = intval(str_replace("x", "",array_pop($words)));
                $line = implode(" ",$words);
            }

        }

        /**
         * Quick parses the EFT fit.
         * @param string $eft
         *
         * @return array
         */
        public function quickParseEft(string $eft) {

            $lows = [];
            $mids = [];
            $highs = [];
            $rigs = [];
            $other = [];

            $current = "start";
            $lines = explode("\n", $eft);
            array_shift($lines);
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line == "") {
                    switch ($current) {
                        case 'lows':
                            $current = "mids";
                            break;
                        case 'mids':
                            $current = "highs";
                            break;
                        case 'highs':
                            $current = "rigs";
                            break;
                        case 'rigs':
                            $current = "other";
                            break;
                        case 'other':
                            $current = "other";
                            break;
                        case 'start':
                        default:
                            $current = "lows";
                    }
                }
                else {
                    // Let's get before the comma: strip ammo
                    $ammo = trim(explode(',', $line, 2)[1] ?? "");
                    $ammo_id = DB::table("item_prices")->where("NAME", $ammo)->value("ITEM_ID");
                    $line = explode(',', $line, 2)[0];

                    if (preg_match('/^.+x\d{0,4}$/m', $line)) {
                        $words = explode(' ', $line);
                        $count = intval(str_replace("x", "",array_pop($words)));
                        $line = implode(" ",$words);
                    }
                    ${$current}[] = [
                        'name' => $line,
                        'id' => DB::table("item_prices")->where("NAME", $line)->value("ITEM_ID") ?? null,
                        'ammo' => $ammo,
                        'count' => $count ?? 1,
                        'price' => (DB::table("item_prices")->where("NAME", $line)->value("PRICE_BUY")+ DB::table("item_prices")->where("NAME", $line)->value("PRICE_SELL"))/2,
                        'ammo_id' => $ammo_id ?? null
                    ];
                }
            }

            return [
                'low' => $lows,
                'mid' => $mids,
                'high' => $highs,
                'rig' => $rigs,
                'other' => $other
            ];

        }
	}
