<?php

	namespace App\Runs;

	use App\Models\Run;
    use Illuminate\Support\Facades\DB;
    use Laravel\Sanctum\PersonalAccessToken;

    class DeleteHelper {

        /**
         * Returns whether a user is allowed to delete a run
         * @param int                      $id Run ID
         * @param PersonalAccessToken|null $token If null, the char ID is taken from session, if set, the char ID is taken from the token
         *
         * @return bool
         */
        public static function canDeleteRun(int $id, PersonalAccessToken $token = null) : bool {
            $char_id = $token ? $token->tokenable_id : session('login_id', null);
            if (!$char_id) return false;
            return Run::where('ID', $id)->where('CHAR_ID', $char_id)->exists();
        }

        /**
         * @param int $id
         * @param int $userId
         *
         * @return bool
         * @throws \Throwable
         */
        public static function deleteRun(int $id) {

            DB::beginTransaction();
            try {
                $run = DB::table("runs")->where("ID", $id)->first();
                $lootItems = DB::table("detailed_loot")->where("RUN_ID", $id)->get();
                foreach ($lootItems as $lootItem) {
                    DB::table("delete_cleanup")->insert([
                        "ITEM_ID" => $lootItem->ITEM_ID,
                        "TYPE" => $run->TYPE,
                        "TIER" => $run->TIER,
                        "DELETES_SUM" => $lootItem->COUNT
                    ]);
                }


                DB::table("detailed_loot")->where("RUN_ID", $id)->delete();
                DB::table("lost_items")->where("RUN_ID", $id)->delete();
                DB::table("runs")->where("ID", $id)->delete();
                DB::commit();
            }
            catch (\Exception $w) {
                DB::rollBack();
                throw $w;
            }

            return  true;
        }
	}
