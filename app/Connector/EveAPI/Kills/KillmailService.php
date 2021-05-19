<?php


    namespace App\Connector\EveAPI\Kills;

    use App\Connector\EveAPI\EveAPICore;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class KillmailService extends EveAPICore {

        /**
         * @param int    $id
         * @param string $hash
         *
         * @return mixed
         * @throws \Exception
         */
        public function getKillmail(int $id, string $hash) {
            return $this->simpleGet(null, sprintf("killmails/%d/%s/", $id, $hash));


        }
    }
