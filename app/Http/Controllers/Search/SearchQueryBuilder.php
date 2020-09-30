<?php

	namespace App\Http\Controllers\Search;

	use Illuminate\Database\Query\Builder;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Str;

    class SearchQueryBuilder {

	    /** @var Collection */
	    private $conditions;

        /**
         * SearchQueryBuilder constructor.
         */
        public function __construct() {
            $this->conditions = collect([]);
        }

        /**
         * @param SearchCriteria $condition
         *
         * @return $this
         */
        public function addCondition(SearchCriteria $condition) {
            $this->conditions->add($condition);
            return $this;
        }

        /**
         * @return Collection
         */
        public function getConditions() : Collection {
            return $this->conditions;
        }

        /**
         * Gets the query builder query
         * @return Builder
         */
        public function getQuery():Builder {
            $builder = DB::table("runs")
                ->select([
                    'runs.TIER',
                    'runs.TYPE',
                    'runs.ID',
                    'runs.LOOT_ISK',
                    'runs.SURVIVED',
                    'runs.RUN_DATE',
                    'runs.PVP_CONDUIT_SPAWN',
                    'runs.PVP_CONDUIT_USED',
                    'runs.RUNTIME_SECONDS',
                    'runs.PUBLIC',
                    'ship_lookup.NAME as SHIP_NAME',
                    'ship_lookup.ID as SHIP_ID',
                    'ship_lookup.GROUP as SHIP_GROUP',
                    'ship_lookup.HULL_SIZE as HULL_SIZE'
                ])->leftJoin("ship_lookup", "runs.SHIP_ID", "=", "ship_lookup.ID")->orderBy("runs.ID", "DESC");
            /** @var SearchCriteria $condition */
            foreach ($this->conditions as $condition) {
                $builder->where(sprintf("%s.%s", $condition->getTable(), $condition->getField()), $condition->getRelation(), $condition->getValue());
            }

            return $builder;
        }

        protected function serializeConditions(): string {
            $cond = collect([]);
            $this->conditions->each(function (SearchCriteria $item) use ($cond) {
                $cond->add($item->serialize());
            });
            return json_encode($cond);
        }

        /**
         * Saves the string in the database
         * @return string UUID
         */
        public function persistSearch(): string {
            $jsonArray = $this->serializeConditions();
            $id = Str::orderedUuid();
            try {
                DB::table("saved_searches")->insert([

               'id' => $id,
               'criteria' => $jsonArray,
               'expires' => now()->addDays(config('tracker.search.link_save_time_days', 1))
            ]);
            }
            catch (\Exception $e) {
                Log::error("Could not persist search to DB: ".$e->getMessage());
                return "";
            }

            return $id;
        }

        public function unserializeConditions(string $json): SearchQueryBuilder {
            $criterias = json_decode($json, 1);
            foreach ($criterias as $criteria) {
                $new = new SearchCriteria(null, null, null,null, null);
                $new->unserialize($criteria);
                $this->addCondition($new);
            }
//            $this->conditions->dd();
            return $this;
        }



    }
