<?php

    namespace TwoBros\ComponentWorkflow;

    class NodeMap
    {

        /**
         * @var array
         */
        private $items;

        public function __construct()
        {

            $this->items = [ ];
        }

        /**
         * Gets a node by name.
         *
         * @param string $name
         *
         * @return Node
         */
        public function get( $name )
        {

            $name = (string) $name;

            if ($this->doesNodeExistAlready( $name )) {
                $this->items[ $name ] = new Node( $name );
            }

            return $this->items[ $name ];
        }

        /**
         * Checks if a node exists.
         *
         * @param string $name
         *
         * @return bool
         */
        public function has( $name )
        {

            $name = (string) $name;

            return isset( $this->items[ $name ] );
        }

        /**
         * doesNodeExistAlready
         *
         * @param $name
         *
         * @return bool
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        protected function doesNodeExistAlready( $name )
        {

            return !isset( $this->items[ $name ] );
        }
    }
