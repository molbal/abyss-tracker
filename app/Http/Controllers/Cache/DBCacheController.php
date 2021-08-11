<?php


	namespace App\Http\Controllers\Cache;


	use Closure;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Psr\Log\LogLevel;

    class DBCacheController {


        /**
         * @param string|array     $table
         * @param string|int|array $id
         * @param Closure          $callback
         *
         * @return mixed
         */
        public static function remember(string|array $table, string|int|array $id, Closure $callback) : mixed {
            $tableName = is_string($table) ? $table : array_key_first($table);
            $valueColumn = is_array($table) ? $table[$tableName] : "VALUE";
            $idColumn = is_array($id) ? array_key_first($id) : 'ID';
            $idValue = is_array($id) ? $id[$idColumn] : $id;

            try {
                $value = DB::table($tableName)->where($idColumn, $idValue)->value($valueColumn) ?? null;
            }
            catch (\Exception $e) {
                $value = null;
            }

            if (! is_null($value)) {
                return $value;
            }
            $value = $callback();
            $affectedRows = DB::table($tableName)->insertOrIgnore([$idColumn => $idValue, $valueColumn => $value]);
            clock()->log(LogLevel::DEBUG, 'Inserted '.$affectedRows.' row to '.$tableName.' ('.$idColumn.'='.$idValue.')');
            return $value;
        }
	}
