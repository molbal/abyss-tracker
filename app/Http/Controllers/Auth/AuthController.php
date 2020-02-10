<?php


    namespace App\Http\Controllers\Auth;

    use App\Helpers\ConversationCache;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
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

        public function redirectToScopedProvider() {

            config(['services.eveonline' => [
                'client_id'     => env('EVEONLINE_SCOPED_CLIENT_ID'),
                'client_secret' => env('EVEONLINE_SCOPED_CLIENT_SECRET'),
                'redirect'      => env('EVEONLINE_SCOPED_REDIRECT'),
            ]]);

            return Socialite::driver('eveonline')
                ->setScopes(explode(' ', env('EVEONLINE_SCOPED_CLIENT_SCOPES')))
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
                    "NAME"    => $name
                ]);
                \session()->put("login_id", $id);
                \session()->put("login_name", $name);
                return redirect(route("home_mine"));
            }
            catch (Exception $e) {
                return view('error', ["error" => "The EVE API had an error: " . ($e->getMessage() ?? 'No error message provided by ESI') . " - if you try logging in again it will probably work."]);
            }
        }


        /**
         * Obtain the user information from Eve Online.
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function handleScopedProviderCallback() {
            try {

                config(['services.eveonline' => [
                    'client_id'     => env('EVEONLINE_SCOPED_CLIENT_ID'),
                    'client_secret' => env('EVEONLINE_SCOPED_CLIENT_SECRET'),
                    'redirect'      => env('EVEONLINE_SCOPED_REDIRECT'),
                ]]);

//                dd(config("services.eveonline"));

                /** @var User $user */
                $user = Socialite::driver('eveonline')->user();

                $id = $user->getId();
                $name = $user->getName();

                DB::beginTransaction();
                try {
                    if (!DB::table("chars")->where("CHAR_ID", $id)->exists()) {
                        DB::table("chars")->insert([
                            "CHAR_ID"       => $id,
                            "NAME"          => $name,
                            "REFRESH_TOKEN" => $user->refreshToken
                        ]);
                    }
                    elseif (!DB::table("chars")->where("CHAR_ID", $id)->get()->get(0)->REFRESH_TOKEN) {
                        DB::table("chars")->where("CHAR_ID", $id)->update(["REFRESH_TOKEN" => $user->refreshToken]);
                    }
                    DB::commit();

                    $expiresInMinutes = floor($user->expiresIn / 60);
                    Cache::put("AccessToken-" . $user->getId(), $user->token, $expiresInMinutes);
                }
                catch (\Exception $e) {
                    Log::error("Database issue on the Abyss Tracker's end: " . $e->getMessage());
                    throw $e;
                }
                \session()->put("login_id", $id);
                \session()->put("login_name", $name);
                return redirect(route("new"));
            }
            catch (\Exception $e) {
                return view('error', ["error" => "The EVE API had an error: " . ($e->getMessage() ?? 'No error message provided by ESI') . " - if you try logging in again it will probably work."]);
            }
        }

        public function logout() {
            \session()->forget("login_id");
            \session()->forget("login_name");
            return redirect(route("home"));

        }

    }
