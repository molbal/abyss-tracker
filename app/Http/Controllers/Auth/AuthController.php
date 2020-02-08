<?php


    namespace App\Http\Controllers\Auth;

    use App\Helpers\ConversationCache;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Session;
    use Laravel\Socialite\Facades\Socialite;
    use Laravel\Socialite\Two\User;
    use PHPUnit\Exception;

    class AuthController extends Controller {


        /**
         * Redirect the user to the Eve Online authentication page.
         *
         * @return mixed
         */
        public function redirectToProvider() {
            return Socialite::driver('eveonline')
                ->redirect();
        }

        /**
         * Obtain the user information from Eve Online.
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function handleProviderCallback() {
            try {

            /** @var User $user */
            $user = Socialite::driver('eveonline')->user();

            $id = $user->getId();
            $name = $user->getName();
            DB::table("chars")->insertOrIgnore([
                "CHAR_ID" => $id,
                "NAME" => $name
            ]);
            \session()->put("login_id", $id);
            \session()->put("login_name", $name);
            return redirect(route("home_mine"));
            }
            catch (Exception $e) {
                return view('error', ["error" => "The EVE API had an error: ".($e->getMessage() ?? 'No error message provided by ESI')." - if you try logging in again it will probably work."]);
            }
        }

        public function logout() {
            \session()->forget("login_id");
            \session()->forget("login_name");
            return redirect(route("home"));

        }

    }
