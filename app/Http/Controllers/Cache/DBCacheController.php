<?php


	namespace App\Http\Controllers\Cache;


	use Closure;
    use Illuminate\Support\Facades\DB;

    class DBCacheController {


        public static function remember(string $table, $id, Closure $callback)
        {
            try {
                $value = DB::table($table)->where("ID")->value("VALUE") ?? null;
            }
            catch (\Exception $e) {
                $value = null;
            }

            if (! is_null($value)) {
                return $value;
            }
            $value = $callback();
            DB::table($table)->insertOrIgnore(["ID" => $id, "VALUE" => $value]);

            return $value;
        }
	}
