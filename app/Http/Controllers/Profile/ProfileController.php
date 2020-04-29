<?php


    namespace App\Http\Controllers\Profile;


    use App\Charts\ShipCruiserChart;
    use App\Http\Controllers\Controller;
    use App\Http\Controllers\ThemeController;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Storage;
    use PhpOffice\PhpSpreadsheet\IOFactory;

    class ProfileController extends Controller {


        /**
         * Handles the player profile page
         *
         * @param int $id
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function index(int $id) {

            if (!DB::table("chars")
                   ->where("CHAR_ID", $id)
                   ->exists()) {
                return view("error", ["error" => "No such user found"]);
            }

            $name = DB::table("chars")
                      ->where("CHAR_ID", $id)
                      ->value("NAME");

            $runs = DB::table("v_runall")
                      ->where("CHAR_ID", $id)
                      ->where("PUBLIC", 1)
                      ->orderBy("CREATED_AT", "DESC")
                      ->paginate(15);

            $my_avg_loot = DB::table("runs")
                             ->where("CHAR_ID", $id)
                             ->where("PUBLIC", 1)
                             ->avg('LOOT_ISK');
            $my_sum_loot = DB::table("runs")
                             ->where("CHAR_ID", $id)
                             ->where("PUBLIC", 1)
                             ->sum('LOOT_ISK');
            $my_runs_count = DB::table("runs")
                               ->where("CHAR_ID", $id)
                               ->where("PUBLIC", 1)
                               ->count();
            $my_survival_ratio = (DB::table("runs")
                                    ->where("CHAR_ID", $id)
                                    ->where("PUBLIC", 1)
                                    ->where("SURVIVED", '=', true)
                                    ->count()) / max(1, $my_runs_count) * 100;

            [$query_ships, $favoriteShipsChart] = $this->getProfileShipsChart($id);

            $access = $this->getAllRights($id);

            $loot = DB::select("
SELECT ip.ITEM_ID,
       SUM(dl.COUNT) as COUNT,
       MAX(ip.PRICE_BUY) as PRICE_BUY,
       MAX(ip.PRICE_SELL) as PRICE_SELL,
       MAX(ip.GROUP_ID) as GROUP_ID,
       MAX(ip.GROUP_NAME) as GROUP_NAME,
       MAX(ip.NAME) as NAME
FROM detailed_loot dl
INNER JOIN item_prices ip ON dl.ITEM_ID = ip.ITEM_ID
WHERE dl.RUN_ID IN
    (SELECT runs.ID
     FROM runs
     WHERE CHAR_ID=?
       AND RUN_DATE>=NOW() - INTERVAL 7 DAY)
GROUP BY ip.ITEM_ID ORDER BY 2 DESC;", [$id]);

            return view('profile', ['id' => $id, 'name' => $name, 'last_runs' => $runs, 'my_avg_loot' => $my_avg_loot, 'my_sum_loot' => $my_sum_loot, 'my_runs_count' => $my_runs_count, 'my_survival_ratio' => $my_survival_ratio, 'query_ships' => $query_ships, 'favoriteShipsChart' => $favoriteShipsChart, 'access' => $access, 'loot' => $loot]);
        }

        public function downloadLoot(int $id, string $from = "", string $to = "") {

            if (!DB::table("chars")
                   ->where("CHAR_ID", $id)
                   ->exists()) {
                return view("error", ["error" => "No such user found"]);
            }

            if (!$this->getRight($id, 'LOOT')) {
                return view("error", ["error" => "Access denied!"]);
            }


            [$from, $to] = $this->normalizeFromAndTo($from, $to);
            $loot = DB::select("select
       r.ID as RUN_ID,
       r.RUN_DATE as RUN_DATE,
        ip.NAME as NAME,
       ip.GROUP_NAME as GROUP_NAME,
       ip.PRICE_SELL as PRICE_SELL,
       ip.PRICE_BUY as PRICE_BUY,
       dl.COUNT as COUNT
from runs r
    join detailed_loot dl on r.ID = dl.RUN_ID
    join item_prices ip on dl.ITEM_ID = ip.ITEM_ID
where
    r.CHAR_ID=? and RUN_DATE>=? and RUN_DATE<=?
    ORDER BY r.ID DESC LIMIT 10000;", [$id, $from, $to]);

            if (count($loot) == 0) {
                return view('sp_message', [
                    'title' => 'Nothing to export',
                    'message' => 'Please select a date range that contains literally anything and I will create the Excel file for you'
                ]);
            }

            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadSheet = null;
            $workSheet = null;
            try {
                $spreadSheet = $reader->load(Storage::disk("public")
                                                    ->path("loot_export_template.xlsx"));
            } catch (\Exception $e) {
                return view("error", ["error" => "Failed to load template excel file " . $e->getMessage()]);
            }
            try {
                $workSheet = $spreadSheet->getActiveSheet();
            } catch (\Exception $e) {
                return view("error", ["error" => "Failed to switch to the active worksheet " . $e->getMessage()]);
            }
            Log::info("Exporting " . count($loot));
            try {
                $r = 2; // Current row
                $prid = 0; // Current run id
                $tr = 2; // Current top row
                foreach ($loot as $item) {
                    $r++;
                    if ($item->RUN_ID != $prid) {
                        // New run's row

                        $workSheet->getStyle("A" . $r . ":K" . $r)
                                  ->applyFromArray(['borders' => ['top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,],]]);

                        if ($tr != 2) {
                            $workSheet->setCellValue('J' . $tr, '=SUM(H' . $tr . ':H' . ($r - 1) . ')');
                            $workSheet->setCellValue('K' . $tr, '=SUM(I' . $tr . ':I' . ($r - 1) . ')');

                            $workSheet->mergeCells('J' . $tr . ':J' . ($r - 1));
                            $workSheet->mergeCells('K' . $tr . ':K' . ($r - 1));
                            $workSheet->getStyle('J' . $tr . ':K' . ($r - 1))
                                      ->applyFromArray(['alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,]]);
                        }
                        $tr = $r;
                        $prid = $item->RUN_ID;
                    }

                    $workSheet->setCellValue("A$r", $item->RUN_ID);
                    $workSheet->setCellValue("B$r", $item->RUN_DATE);
                    $workSheet->setCellValue("C$r", $item->NAME);
                    $workSheet->setCellValue("D$r", $item->GROUP_NAME);
                    $workSheet->setCellValue("E$r", $item->COUNT);
                    $workSheet->setCellValue("F$r", $item->PRICE_SELL);
                    $workSheet->setCellValue("G$r", $item->PRICE_BUY);
                    $workSheet->setCellValue("H$r", "=E$r*F$r");
                    $workSheet->setCellValue("I$r", "=E$r*G$r");


                }
                $r++;
                // New run's row

                $workSheet->getStyle("A" . $r . ":K" . $r)
                          ->applyFromArray(['borders' => ['top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,],]]);

                $workSheet->setCellValue('J' . $tr, '=SUM(H' . $tr . ':H' . ($r - 1) . ')');
                $workSheet->setCellValue('K' . $tr, '=SUM(I' . $tr . ':I' . ($r - 1) . ')');

                $workSheet->mergeCells('J' . $tr . ':J' . ($r - 1));
                $workSheet->mergeCells('K' . $tr . ':K' . ($r - 1));
                $workSheet->getStyle('J' . $tr . ':K' . ($r - 1))
                          ->applyFromArray(['alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,]]);
                $tr = $r;
                $prid = $item->RUN_ID;

                $workSheet->setCellValue("A$r", 'Exported with ❤ from the Abyss Tracker');
                $workSheet->mergeCells("A$r:I$r");
                $workSheet->getStyle("A$r:I$r")->applyFromArray([
                    'font' => [
                        'italic' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'borders' => [
                        'top' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                        ],
                    ],
                ]);

                $workSheet->setCellValue("J$r", '=SUM(J2:J'.($r-1).')');
                $workSheet->setCellValue("K$r", '=SUM(K2:K'.($r-1).')');
                $workSheet->getStyle("J$r:K$r")->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'borders' => [
                        'top' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                        ],
                    ],
                ]);

            } catch (\Exception $e) {
                return view("error", ["error" => "Failed to write the excel file " . $e->getMessage()]);
            }

            try {
                // Rename worksheet
                $spreadSheet->getActiveSheet()
                            ->setTitle('Abyss Loot Export');

                // Set active sheet index to the first sheet, so Excel opens this as the first sheet
                $spreadSheet->setActiveSheetIndex(0);

                $spreadSheet->getProperties()
                            ->setCreator('Abyss Tracker')
                            ->setLastModifiedBy('Abyss Tracker')
                            ->setTitle("Abyss Tracker loot export from $from to $to")
                            ->setSubject("Abyss Tracker loot export from $from to $to")
                            ->setDescription("Abyss Tracker loot export from $from to $to")
                            ->setKeywords('eve online abyss loot tracker')
                            ->setCategory('report');

                // Redirect output to a client’s web browser (Xlsx)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Abyss_Tracker_loot_export_' . $from . '_' . $to . '.xlsx"');
                header('Cache-Control: max-age=0');
                // If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

                // If you're serving to IE over SSL, then the following may be needed
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
                header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header('Pragma: public'); // HTTP/1.0

                $writer = IOFactory::createWriter($spreadSheet, 'Xlsx');
                $writer->setPreCalculateFormulas(false);

                $writer->save('php://output');
            } catch (\Exception $e) {
                return view("error", ["error" => "Failed to switch to the active worksheet " . $e->getMessage()]);
            }

            return null;
        }


        /**
         * @param int    $id
         * @param string $from
         * @param string $to
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function loot(int $id, string $from = "", string $to = "") {

            [$from, $to] = $this->normalizeFromAndTo($from, $to);

            if (!DB::table("chars")
                   ->where("CHAR_ID", $id)
                   ->exists()) {
                return view("error", ["error" => "No such user found"]);
            }

            $loot = DB::select("
SELECT ip.ITEM_ID,
       SUM(dl.COUNT) as COUNT,
       MAX(ip.PRICE_BUY) as PRICE_BUY,
       MAX(ip.PRICE_SELL) as PRICE_SELL,
       MAX(ip.GROUP_ID) as GROUP_ID,
       MAX(ip.GROUP_NAME) as GROUP_NAME,
       MAX(ip.NAME) as NAME
FROM detailed_loot dl
INNER JOIN item_prices ip ON dl.ITEM_ID = ip.ITEM_ID
WHERE dl.RUN_ID IN
    (SELECT runs.ID
     FROM runs
     WHERE CHAR_ID=?
       AND RUN_DATE>=? AND RUN_DATE <=?)
GROUP BY ip.ITEM_ID ORDER BY 2 DESC;", [$id, $from, $to]);

            $access = $this->getAllRights($id);
            $name = DB::table("chars")
                      ->where("CHAR_ID", $id)
                      ->value("NAME");

            return view('inventory', ['id' => $id, 'name' => $name, 'from' => $from, 'to' => $to, 'access' => $access, 'loot' => $loot]);
        }


        /**
         * Gets default display levels
         *
         * @param string $panel
         *
         * @return bool
         */
        private function getDefaultVisibility(string $panel) {
            switch ($panel) {
                case 'LAST_RUNS':
                case 'TOTAL_LOOT':
                case 'TOTAL_RUNS':
                    return true;
                case 'SHIPS':
                case 'LOOT':
                case 'SURVIVAL':
                default:
                    return false;
            }
        }

        public function getAllRights(int $userId) : array {
            $rights = ["LAST_RUNS", "TOTAL_LOOT", "TOTAL_RUNS", "LOOT", "SHIPS", "SURVIVAL"];
            $ar = [];
            foreach ($rights as $right) {
                $ar[$right] = $this->getRight($userId, $right);
            }

            return $ar;
        }

        /**
         * Persists a DB setting
         *
         * @param int    $userId
         * @param string $panel
         * @param int    $visible
         */
        public function persistRight(int $userId, string $panel, int $visible) : void {
            DB::beginTransaction();
            if (DB::table("privacy")
                  ->where("CHAR_ID", $userId)
                  ->where("PANEL", $panel)
                  ->exists()) {
                DB::table("privacy")
                  ->where("CHAR_ID", $userId)
                  ->where("PANEL", $panel)
                  ->update(["DISPLAY" => $visible ? "public" : "private"]);
            } else {
                DB::table("privacy")
                  ->insert(["CHAR_ID" => $userId, "PANEL" => $panel, "DISPLAY" => $visible ? "public" : "private"]);
            }
        }

        /**
         * Gets if a panel should be visible
         *
         * @param int    $userId
         * @param string $panel
         *
         * @return bool
         */
        private function getRight(int $userId, string $panel) : bool {

            if (session()->has("login_id") && $userId == session()->get("login_id")) {
                return true;
            }

            if (DB::table("privacy")
                  ->where("CHAR_ID", $userId)
                  ->where("PANEL", $panel)
                  ->exists()) {
                return DB::table("privacy")
                         ->where("CHAR_ID", $userId)
                         ->where("PANEL", $panel)
                         ->value("DISPLAY") == 'public';
            } else {
                return $this->getDefaultVisibility($panel);
            }
        }

        /**
         * @return array
         */
        public function getProfileShipsChart(int $id) : array {
            $query_cruiser = Cache::remember("ships.profile.$id", 20, function () use ($id) {
                return DB::select("select count(r.ID) as RUNS, l.Name as NAME, l.ID as SHIP_ID
                    from runs r inner join ship_lookup l on r.SHIP_ID=l.ID
                    where r.CHAR_ID=" . $id . " and r.PUBLIC=1
                    group by r.SHIP_ID, l.NAME, l.ID
                    order by 1 desc
                    limit 15");
            });

            $dataset = [];
            $values = [];
            $i = 7;
            foreach ($query_cruiser as $type) {
                if ($i-- == 0) break;
                $dataset[] = $type->NAME;
                $values[] = $type->RUNS;
            }

            $shipCruiserChart = new ShipCruiserChart();
            $shipCruiserChart->export(true, "Download");
            $shipCruiserChart->displayAxes(false);
            $shipCruiserChart->height(400);
            $shipCruiserChart->theme(ThemeController::getChartTheme());
            $shipCruiserChart->labels($dataset);
            $shipCruiserChart->dataset("Favorite ships", "pie", $values)
                             ->options(["radius" => [30, 120], "roseType" => "radius"]);
            $shipCruiserChart->displayLegend(false);

            return [$query_cruiser, $shipCruiserChart];
        }

        /**
         * @param string $from
         * @param string $to
         *
         * @return array
         */
        public function normalizeFromAndTo(string $from, string $to) : array {
            if (trim($from) == "" || !strtotime($from)) {
                $from = date("Y-m-d");
            } else {
                $from = date("Y-m-d", strtotime($from));
            }
            if (trim($to) == "" || !strtotime($to)) {
                $to = date("Y-m-d");
            } else {
                $to = date("Y-m-d", strtotime($to));
            }

            return [$from, $to];
        }
    }
