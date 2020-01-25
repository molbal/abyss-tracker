<?php


    namespace App\Http\Controllers;


    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Validator;

    class AbyssController extends Controller {

        public function store(Request $request) {
            Validator::make($request->all(), [
                'TYPE' => 'required',
                'TIER' => 'required',
                'SURVIVED' => 'required',
                'PUBLIC' => 'required',
                'LOOT_ISK' => 'required|numeric',
                'RUN_DATE' => 'required|date',
            ])->validate();


            Log::info("Here!");
            $id = DB::table("runs")->insertGetId([
                'CHAR_ID' => session()->get("login_id"),
                'PUBLIC' => $request->get("PUBLIC"),
                'TIER' => $request->get("TIER"),
                'TYPE' => $request->get("TYPE"),
                'LOOT_ISK' => $request->get("SURVIVED") ? $request->get("LOOT_ISK") : 0,
                'SURVIVED' => $request->get("SURVIVED"),
                'RUN_DATE' => $request->get("RUN_DATE"),
            ]);

            return redirect(route("view_single", ["id" => $id]));
        }

        public function form_new() {
            if (session()->has("login_id")) {
                return view("new");
            } else {
                return view("error", ["error" => "Please log in to add a new run"]);
            }
        }

        public function get_single($id) {
            return view("run", ["id" => $id]);
        }

        public function get_all($order_by = "", $order_type = "") {
            $builder = DB::table("v_runall");
            list($order_by, $order_by_text, $order_type_text, $order_type) = $this->getSort($order_by, $order_type);

            $items = $builder->orderBy($order_by, $order_type)->paginate(25);
            return view("runs", ["order_type" => $order_type_text, "order_by" => $order_by_text, "items" => $items]);
        }

        public function get_mine($order_by = "", $order_type = "") {
            if (!session()->has("login_id")) {
                return view("error", ["error" => "Please log in to list your runs"]);
            }
            $builder = DB::table("v_runall")->where("CHAR_ID", session()->get('login_id'));
            list($order_by, $order_by_text, $order_type_text, $order_type) = $this->getSort($order_by, $order_type);

            $items = $builder->orderBy($order_by, $order_type)->paginate(25);
            return view("my_runs", ["order_type" => $order_type_text, "order_by" => $order_by_text, "items" => $items]);
        }

        /**
         * @param $order_by
         * @param $order_type
         * @return array
         */
        private function getSort($order_by, $order_type): array {
            switch (strtoupper($order_by)) {
                case 'CHAR_ID':
                    $order_by = "NAME";
                    $order_by_text = "character name";
                    break;
                case 'TIER':
                    $order_by = "TIER";
                    $order_by_text = "Abyss tier";
                    break;
                case 'TYPE':
                    $order_by = "TYPE";
                    $order_by_text = "Abyss type";
                    break;
                case 'LOOT_ISK':
                    $order_by = "LOOT_ISK";
                    $order_by_text = "éoot value";
                    break;
                case 'SURVIVED':
                    $order_by = "SURVIVED";
                    $order_by_text = "survival";
                    break;
                default:
                case 'RUN_DATE':
                    $order_by = "RUN_DATE";
                    $order_by_text = "date of run";
                    break;
            }

            switch (strtoupper($order_type)) {
                case 'DESC':
                default:
                    $order_type_text = "in descending order";
                    $order_type = "DESC";
                    break;
                case 'ASC':
                    $order_type = "ASC";
                    $order_type_text = "in ascending order";
            }
            return [$order_by, $order_by_text, $order_type_text, $order_type];
        }
    }
