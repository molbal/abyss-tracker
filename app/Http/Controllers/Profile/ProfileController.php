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
                ->limit(10);



            return view('profile', [
                'id' => $id,
                'name' =>$name,
                'last_runs' => $runs
            ]);
        }
	}
