<?php


	namespace App\Http\Controllers\Search;


	class SearchCriteria {

        private $name;
        private $table;
        private $field;
	    private $relation;
	    private $value;

        /**
         * SearchCriteria constructor.
         *
         * @param $name
         * @param $table
         * @param $field
         * @param $relation
         * @param $value
         */
        public function __construct($name, $table, $field, $relation, $value) {
            $this->name = $name;
            $this->table = $table;
            $this->field = $field;
            $this->relation = $relation;
            $this->value = $value;
        }

        /**
         * @return mixed
         */
        public function getName() {
            return $this->name;
        }

        /**
         * @param mixed $name
         *
         * @return SearchCriteria
         */
        public function setName($name) {
            $this->name = $name;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTable() {
            return $this->table;
        }

        /**
         * @param mixed $table
         *
         * @return SearchCriteria
         */
        public function setTable($table) {
            $this->table = $table;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getField() {
            return $this->field;
        }

        /**
         * @param mixed $field
         *
         * @return SearchCriteria
         */
        public function setField($field) {
            $this->field = $field;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getRelation() {
            return $this->relation;
        }

        /**
         * @param mixed $relation
         *
         * @return SearchCriteria
         */
        public function setRelation($relation) {
            $this->relation = $relation;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getValue() {
            return $this->value;
        }

        /**
         * @param mixed $value
         *
         * @return SearchCriteria
         */
        public function setValue($value) {
            $this->value = $value;

            return $this;
        }



    }
