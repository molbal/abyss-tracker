<?php


    namespace App\Http\Controllers\Auth;

    use App\Exceptions\BusinessLogicException;
    use App\Exceptions\SecurityViolationException;
    use App\Helpers\ConversationCache;
    use App\Http\Controllers\Controller;
    use App\Http\Controllers\Profile\AltRelationController;
    use http\Client\Request;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Laravel\Socialite\Facades\Socialite;
    use Laravel\Socialite\Two\User;

    class AuthController extends Controller {



        /**
         * Gets whether a user is logged in
         * @return bool
         */
        public static function isLoggedIn() {
            return session()->has('login_id') && session()->has('login_name');
        }

        /**
         * Gets the logged in user's EVE ID, null, if not logged in
         * @return int|null
         */
        public static function getLoginId(): ?int {
            return session()->get('login_id', null);
        }

        /**
         * Gets if the current user is the logged in
         * @param int $id
         *
         * @return bool
         */
        public static function isItMe(int $id) {
            return self::getLoginId() == $id;
        }

        /**
         * Gets the logged in user's EVE Name, null, if not logged in
         * @return string
         */
		 public static function getCharName():string {
            return session()->get('login_name', null);
		 }

        public function switch(int $charId) {
            $all = AltRelationController::getAllMyAvailableCharacters(false);
            if ($all->has('id', $charId)) {
                session()->regenerate(true);

                session()->put("login_id", $charId);
                session()->put("login_name", $all->where('id', $charId)->name);
            }
            else {

                return view('error', [
                    'title' => "Not allowed ",
                    'message' => "You cannot switch to that character, because it is not your alt."
                ]);
            }

            return redirect()->route('home_mine');
		 }

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
                'client_id'     => config("tracker.scoped.client_id"),
                'client_secret' => config("tracker.scoped.client_secret"),
                'redirect'      => config("tracker.scoped.redirect"),
            ]]);

            return Socialite::driver('eveonline')
                            ->setScopes(explode(' ', config("tracker.scoped.client_scopes")))
                            ->redirect();
        }

        public function redirectToMailProvider() {
            config(['services.eveonline' => [
                'client_id'     => config("tracker.mail-scope.client_id"),
                'client_secret' => config("tracker.mail-scope.client_secret"),
                'redirect'      => config("tracker.mail-scope.redirect"),
            ]]);

            return Socialite::driver('eveonline')
                            ->setScopes(explode(' ', config("tracker.mail-scope.client_scopes")))
                            ->redirect();
        }

        /**
         * Obtain the user information from Eve Online.
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
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
            catch (\Exception $e) {
                return view('error', ["error" => "The EVE API had an error: " . ($e->getMessage() ?? 'No error message provided by ESI') . " - if you try logging in again it will probably work."]);
            }
        }


        /**
         * Obtain the user information from Eve Online.
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
         */
        public function handleScopedProviderCallback() {
            try {

                config(['services.eveonline' => [
                    'client_id'     => config("tracker.scoped.client_id"),
                    'client_secret' => config("tracker.scoped.client_secret"),
                    'redirect'      => config("tracker.scoped.redirect"),
                ]]);


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


        /**
         * Obtain the user information from Eve Online.
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
         */
        public function handleMailProviderCallback() {
            try {

                config(['services.eveonline' => [
                    'client_id'     => config("tracker.mail-scope.client_id"),
                    'client_secret' => config("tracker.mail-scope.client_secret"),
                    'redirect'      => config("tracker.mail-scope.redirect"),
                ]]);

                /** @var User $user */
                $user = Socialite::driver('eveonline')->user();

                dd($user);

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
