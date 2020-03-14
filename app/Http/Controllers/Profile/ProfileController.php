<?php


	namespace App\Http\Controllers\Profile;


	use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\DB;

    class ProfileController extends Controller {



        public function index(int $id) {

            if (!DB::table("chars")->where("CHAR_ID", $id)->exists()) {
                return view("error", ["error" => "No such user found"]);
            }

            $name = DB::table("chars")->where("CHAR_ID", $id)->value("NAME");

            $runs = DB::table("V_runall")
                ->where("CHAR_ID", $id)
                ->where("PUBLIC", 1)
                ->orderBy("CREATED_AT", "DESC")
                ->paginate(15);

            $my_avg_loot = DB::table("runs")->where("CHAR_ID", $id)->avg('LOOT_ISK');
            $my_sum_loot = DB::table("runs")->where("CHAR_ID", $id)->sum('LOOT_ISK');
            $my_runs_count = DB::table("runs")->where("CHAR_ID", session()->get("login_id"))->count();
            $my_survival_ratio = (DB::table("runs")->where("CHAR_ID", session()->get("login_id"))->where("SURVIVED", '=', true)->count()) / max(1, $my_runs_count) * 100;

            return view('profile', [
                'id' => $id,
                'name' =>$name,
                'last_runs' => $runs,
                'my_avg_loot' => $my_avg_loot,
                'my_sum_loot' => $my_sum_loot,
                'my_runs_count' => $my_runs_count,
                'my_survival_ratio' => $my_survival_ratio,
            ]);
        }
	}
