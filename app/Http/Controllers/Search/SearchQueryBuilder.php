<?php

	namespace App\Http\Controllers\Search;

	use Illuminate\Database\Query\Builder;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\DB;

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
                    'ship_lookup.IS_CRUISER as IS_CRUISER'
                ])->leftJoin("ship_lookup", "runs.SHIP_ID", "=", "ship_lookup.ID");
            /** @var SearchCriteria $condition */
            foreach ($this->conditions as $condition) {
                $builder->where(sprintf("%s.%s", $condition->getTable(), $condition->getField()), $condition->getRelation(), $condition->getValue());
            }

            return $builder;
        }



    }
