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
                         ->leftJoin("detailed_loot", "runs.ID", "=", "detailed_loot.RUN_ID")
                         ->leftJoin("ship_lookup", "runs.SHIP_ID", "=", "ship_lookup.ID");

            /** @var SearchCriteria $condition */
            foreach ($this->conditions as $condition) {
                $builder->where(sprintf("%s.%s", $condition->getTable(), $condition->getField()), $condition->getRelation(), $condition->getValue());
            }

            return $builder;
        }



    }
