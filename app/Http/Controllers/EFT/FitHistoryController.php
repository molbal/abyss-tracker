<?php

namespace App\Http\Controllers\EFT;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Models\FitHistoryItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
            $fitRootId = self::getFitRootId($fitId);

            return FitHistoryItem::whereFitRootId($fitRootId)->orderBy("created_at")->get();
        }
        catch (\Exception $e) {
            throw new $e;
        }
    }

    public static function addEntry(int $fitId, string $text) {
        if (Str::of($text)->length() >= 255) {
            throw new \RuntimeException("Event text must be less than 255 characters long.");
        }

        $fitRootId = self::getFitRootId($fitId);

        $fhi = new FitHistoryItem();
        $fhi->fit_it = $fitId;
        $fhi->fit_root_id = $fitRootId;
        $fhi->event = $text;
        $fhi->save();
    }

    /**
     * @param int $fitId
     *
     */
    public static function getFitRootId(int $fitId): int {
        $fitRootId = (int)DB::table("fits")
                       ->where("ID", $fitId)
                       ->value("ROOT_ID");

        if (!$fitRootId) {
            $fitRootId = $fitId;
        }

        return $fitRootId;
}
}
