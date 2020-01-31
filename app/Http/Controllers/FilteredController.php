<?php


    namespace App\Http\Controllers;

    use Illuminate\Support\Facades\DB;

    class FilteredController extends Controller {

        public function get_list($type, $tier) {


            $builder = DB::table("v_runall")
                ->where("TYPE", $type)
                ->where("TIER", $tier)
                ->orderBy("RUN_DATE", "DESC");

            $items = $builder->paginate(25);
            return view("filtered", [
                "items" => $items,
                "type" => $type,
                "tier" => $tier]);

        }

    }
