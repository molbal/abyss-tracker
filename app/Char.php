<?php

namespace App;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Char
 *
 * @property int $CHAR_ID
 * @property string $NAME
 * @property string $REFRESH_TOKEN Eve OAuth2 Refresh Token
 * @method static \Illuminate\Database\Eloquent\Builder|Char newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Char newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Char query()
 * @method static \Illuminate\Database\Eloquent\Builder|Char whereCHARID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Char whereNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Char whereREFRESHTOKEN($value)
 * @mixin \Eloquent
 */
class Char extends Model
{
    use HasApiTokens;
    protected $primaryKey = 'CHAR_ID';

    public static function loadName(int $id):string {
        return Cache::remember('char-id.'.$id, now()->addMinutes(10), function () use ($id) {
            return Char::where('CHAR_ID',$id)->firstOrFail()->NAME;
        });
    }

    public function publicRuns() {
        return $this->hasMany('App\Run', 'CHAR_ID', 'CHAR_ID')->where('PUBLIC', '=', '1');
    }

    public static function current(): Char {
        if (!AuthController::isLoggedIn()) {
            throw new \RuntimeException("Not logged in");
        }

        return Char::where('CHAR_ID', AuthController::getLoginId())->firstOrFail();
    }


    public function addToken(string $name) {
        $newAccessToken = $this->createToken($name);
        return $newAccessToken->plainTextToken;
    }

    public function getTokens() {
        return $this->tokens();
    }

    public function getAuthIdentifier() {
        return $this->CHAR_ID;
    }
}
