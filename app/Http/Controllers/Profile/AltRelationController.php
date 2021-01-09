<?php

namespace App\Http\Controllers\Profile;

use App\Exceptions\SecurityViolationException;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AltRelationController extends Controller
{

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

}
