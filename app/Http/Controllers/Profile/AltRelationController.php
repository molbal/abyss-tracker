<?php

namespace App\Http\Controllers\Profile;

use App\Exceptions\BusinessLogicException;
use App\Exceptions\SecurityViolationException;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Misc\Enums\CharacterType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AltRelationController extends Controller
{
    public function index() {
        $type = self::getCharacterType(AuthController::getLoginId());

        $allChars = self::getAllMyAvailableCharacters();

        $main = self::getMyMain();
        $alts = self::getMyAlts();

//        dd($allChars);
        return view('alts', [
            'type' => $type,
            'main' => $main,
            'alts' => $alts,
        ]);
    }


    public static function getAllMyAvailableCharacters(bool $excludeCurrentCharacter = true) {

        if (!AuthController::isLoggedIn()) {
            throw new SecurityViolationException('User must be logged in to access '.__FUNCTION__.' in '.__FILE__);
        }

        $main = self::getMyMain();
        if ($main) {
            $alts = self::getAlts($main->id);
            $alts->add($main);
        }
        else {
            $alts = self::getMyAlts();
            $alts->add(json_decode(json_encode([
                'id' => AuthController::getLoginId(),
                'name' => AuthController::getCharName()
            ]))); // PHP bullshit
        }

        if ($excludeCurrentCharacter) {
            $alts = $alts->reject(function ($item) {
                return intval($item->id) == intval(AuthController::getLoginId());
            });
        }

        return $alts->sortBy('name');
    }

    /**
     * Determines if the given character is an alt, main, or single.
     * @param int $charId
     *
     * @return string
     */
    public static function getCharacterType(int $charId): string {
        $main = self::getMain($charId);
        if ($main != null) {
            return CharacterType::ALT;
        }

        $alts = self::getAlts($charId);
        if ($alts->count() > 0) {
            return CharacterType::MAIN;
        }
        return CharacterType::SINGLE;
    }

    /**
     * Gets the alt character IDs of the given char EVE ID.
     * @param int $mainId
     *
     * @return Collection
     */
    public static function getAlts(int $mainId): Collection {
        return DB::table('char_relationships')->join('chars', 'chars.CHAR_ID', '=', 'char_relationships.alt')->where('main', $mainId)->select(['char_relationships.alt as id', 'chars.NAME as name'])->get();
    }

    /**
     * Gets the alt character IDs of the currently logged in account.
     *
     * @return Collection
     * @throws SecurityViolationException Thrown if a guest account tries to call this.
     */
    public static function getMyAlts(): Collection {

        if (!AuthController::isLoggedIn()) {
            throw new SecurityViolationException('User must be logged in to access '.__FUNCTION__.' in '.__FILE__);
        }

        return self::getAlts(AuthController::getLoginId());
    }

    /**
     * Gets the main character for the given char EVE ID.
     * @param int $altId
     *
     * @return mixed|null
     */
    public static function getMain(int $altId) {
        $main = DB::table('char_relationships')->join('chars', 'chars.CHAR_ID', '=', 'char_relationships.main')->where('alt', $altId)->select(['char_relationships.main as id', 'chars.NAME as name'])->limit(1)->get();

        if ($main->isEmpty()) {
            return null;
        }

        return $main->first();
    }

    /**
     * Gets the main character for the the currently logged in account.
     *
     * @return mixed|null
     * @throws SecurityViolationException Thrown if a guest account tries to call this.
     */
    public static function getMyMain() {

        if (!AuthController::isLoggedIn()) {
            throw new SecurityViolationException('User must be logged in to access '.__FUNCTION__.' in '.__FILE__);
        }

        return self::getMain(AuthController::getLoginId());

    }

    /**
     * Adds a relation
     * @param int $mainId
     * @param int $altId
     *
     * @return bool
     */
    public static function addRelation(int $mainId, int $altId) : bool {
        $now = Carbon::now();
        return DB::table('char_relationships')->insert([
            'main' => $mainId,
            'alt' => $altId,
            'crated_at' => $now,
            'updated_at' => $now,
        ]);
    }

    /**
     * Deletes a relation
     * @param int $mainId
     * @param int $altId
     *
     * @return bool
     */
    public static function deleteRelation(int $mainId, int $altId): bool {
        return DB::table('char_relationships')->where('main', $mainId)->where('alt', $altId)->delete() == 1;
    }


    /**
     * @param int $mainId
     * @param int $altId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function delete(int $mainId, int $altId) {

        try {

            if (!AuthController::isLoggedIn()) {
                throw new SecurityViolationException('User must be logged in to access '.__FUNCTION__.' in '.__FILE__);
            }

            if (!in_array(AuthController::getLoginId(), [$altId, $mainId])) {
                throw new SecurityViolationException(sprintf("Logged in user must be %s or %s", $mainId, $altId));
            }

            self::deleteRelation($mainId, $altId);

            return view('autoredirect', [
                'redirect' => route('alts.index'),
                'title' => "Connection removed",
                'message' => "The connection between the characters is removed!"
            ]);
        }
        catch (SecurityViolationException $e) {
            DB::rollBack();
            return view('error', [
                'title' => "Not allowed",
                'message' => $e->getMessage()
            ]);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return view('error', [
                'title' => "Failed",
                'message' => $e->getMessage()
            ]);
        }

    }

    /**
     * Sets thet main character
     * @param int $mainId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     */
    public function setMain(int $mainId) {

        try {

            if (!AuthController::isLoggedIn()) {
                throw new SecurityViolationException('User must be logged in to access '.__FUNCTION__.' in '.__FILE__);
            }
            DB::beginTransaction();
            $myMain = AltRelationController::getMyMain();
            if ($myMain != null) {
                throw new BusinessLogicException('You can only have one main character: Please remove '.$myMain->name.' as your main, before adding the new one.');
            }


            if (!DB::table('char_relationships')->where('main', $mainId)->where('alt', AuthController::getLoginId())->exists()) {
                AltRelationController::addRelation($mainId, AuthController::getLoginId());
            }
            DB::commit();

            return view('autoredirect', [
                'redirect' => route('alts.index'),
                'title' => "Saved",
                'message' => "Your main character is now set!"
            ]);

        }
        catch (SecurityViolationException $e) {
            DB::rollBack();
            return view('error', [
                'title' => "Not allowed ",
                'message' => $e->getMessage()
            ]);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return view('error', [
                'title' => "Failed",
                'message' => $e->getMessage()
            ]);
        }
    }

}
