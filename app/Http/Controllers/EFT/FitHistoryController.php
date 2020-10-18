<?php

namespace App\Http\Controllers\EFT;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Models\FitHistoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FitHistoryController extends Controller
{
    public static function getFitHistory(int $fitId) {
        try {
            $fitRootId = DB::table("fits")->where("ID", $fitId)->value("ROOT_ID");

            if (!$fitRootId) {
                throw new \RuntimeException("Can't find the ROOT ID for the firts version of this fit.");
            }

//            DB::table("fit_logs")->where("fit_root_id", $fitRootId)->orderBy("created_at", "asc")->select(['id','fit_it','event','created_at'])->get();
//            FitHistoryItem::where("");

        }
        catch (\Exception $e) {
            throw new $e;
        }
    }
}
