<?php

	namespace App\Http\Controllers\Search;

	use Illuminate\Support\Collection;

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

    }
