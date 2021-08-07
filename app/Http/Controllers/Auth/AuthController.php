<?php

    namespace App\Http\Controllers\Auth;

    use App\Exceptions\SecurityViolationException;
    use App\Http\Controllers\Controller;
    use App\Http\Controllers\Misc\NotificationController;
    use App\Http\Controllers\Profile\AltRelationController;
    use Illuminate\Routing\Redirector;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Laravel\Socialite\Facades\Socialite;
    use Laravel\Socialite\Two\User;

    class AuthController extends Controller {

        public const ALT_SESSION_VAR = 'flag_add_alt_character';

        /**
         * Gets whether a user is logged in
         * @return bool
         */
        public static function isLoggedIn() : bool {
            return session()->has('login_id') && session()->has('login_name');
        }

        /**
         * Gets the logged in user's EVE ID, null, if not logged in
         * @return int|null
         */
        public static function getLoginId(): ?int {
            try {
                return session('login_id', request()->user()->CHAR_ID ?? null);
            }
            catch (\Exception $e) {
                return null;
            }
        }

        /**
         * Gets if the current user is the logged in
         * @param int $id
         *
         * @return bool
         */
        public static function isItMe(int $id) : bool {
            try {
                return self::getLoginId() == $id;
            }
            catch (\Exception $e) {
                return false;
            }
        }

        /**
         * Gets the logged in user's EVE Name, null, if not logged in
         * @return string
         */
		 public static function getCharName():string {
            return session('login_name', null);
		 }

        public function switch(int $charId) {

            try {
                $all = AltRelationController::getAllMyAvailableCharacters(false);
            } catch (SecurityViolationException $e) {
                return view('error', [
                    'title' => "Not allowed ",
                    'message' => $e->getMessage()
                ]);
            }
            $alt = $all->where('id', strval($charId))->first();
            if ($alt) {
                session()->regenerate(true);


                \auth()->login(self::charIdToFrameworkUser(intval($alt->id)));
                session()->put([
                    'login_id' => intval($alt->id),
                    'login_name' => $alt->name,
                ]);
            }
            else {

                return view('error', [
                    'title' => "Not allowed ",
                    'message' => "You cannot switch to that character, because it is not your alt."
                ]);
            }

//            NotificationController::flashInfoLine("Switched active character to ".htmlentities($alt->name), 'info');
            NotificationController::flashToast("Switched active character to ".htmlentities($alt->name));
            return redirect(url()->previous(route('home')));
		 }

        /**
         * Redirect the user to the Eve Online authentication page.
         *
         * @return mixed
         */
        public function redirectToProvider($addAltCharacter = false) {
            if ($addAltCharacter) {
                session()->put(self::ALT_SESSION_VAR, true);
            }
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
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|Redirector|\Illuminate\View\View
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

                if(session()->has(self::ALT_SESSION_VAR)) {
                    session()->forget(self::ALT_SESSION_VAR);
                    AltRelationController::addRelation(AuthController::getLoginId(), $id);
                    NotificationController::flashInfoLine($name." was added as your alt.", 'success');
                    return redirect(route('alts.index'));
                }
                else {
                    session()->put([
                        'login_id' => intval($id),
                        'login_name' => $name,
                    ]);

                    \auth()->login(self::charIdToFrameworkUser(intval($id)));
                    return redirect(route("home_mine"));
                }
            }
            catch (\Exception $e) {
                return view('error', ["error" => "The EVE API had an error: " . ($e->getMessage() ?? 'No error message provided by ESI') . " - if you try logging in again it will probably work."]);
            }
        }


        /**
         * Obtain the user information from Eve Online.
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|Redirector|\Illuminate\View\View
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
                session()->put([
                    'login_id' => intval($id),
                    'login_name' => $name,
                ]);

                // Hack. Dirty
                \auth()->login(self::charIdToFrameworkUser(intval($id)));

                return redirect(route("new"));
            }
            catch (\Exception $e) {
                return view('error', ["error" => "The EVE API had an error: " . ($e->getMessage() ?? 'No error message provided by ESI') . " - if you try logging in again it will probably work."]);
            }
        }


        /**
         * Obtain the user information from Eve Online.
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|Redirector|\Illuminate\View\View
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


            }
            catch (\Exception $e) {
                return view('error', ["error" => "The EVE API had an error: " . ($e->getMessage() ?? 'No error message provided by ESI') . " - if you try logging in again it will probably work."]);
            }
        }

        /**
         * @param int $charId
         *
         * @return \App\User
         */
        public static function charIdToFrameworkUser(int $charId): \App\User {
            if (\App\User::whereId($charId)->exists()) {
                return \App\User::whereId($charId)->firstOrFail();
            }

            $user = \App\User::create([
                'id' => $charId,
                'name' => $charId,
                'email' => $charId.'@abyss.eve-nt.uk',
                'password' => 'a',
            ]);
            $user->save();

            return  $user;
        }

        public function logout() {
            auth()->logout();
            \session()->forget("login_id");
            \session()->forget("login_name");
            return redirect(route("home"));

        }

    }
