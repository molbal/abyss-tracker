<?php

namespace App\Http\Controllers\EFT;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Models\FitHistoryItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FitHistoryController extends Controller
{

    /**
     * @param int $fitId
     *
     * @return FitHistoryItem[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    public static function getFitHistory(int $fitId) {
        try {
            $fitRootId = DB::table("fits")->where("ID", $fitId)->value("ROOT_ID");

            if (!$fitRootId) {
                throw new \RuntimeException("Can't find the ROOT ID for the firts version of this fit.");
            }

            return FitHistoryItem::whereFitRootId($fitRootId)->orderBy("created_at")->get();
        }
        catch (\Exception $e) {
            throw new $e;
        }
    }
}
