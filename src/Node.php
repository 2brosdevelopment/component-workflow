<?php

    namespace TwoBros\ComponentWorkflow;

    class Node
    {

        /**
         * @var string
         */
        private $name;

        /**
         * @var array
         */
        private $transitions;

        public function __construct( $name )
        {

            $this->name        = (string) $name;
            $this->transitions = [ ];
        }

        /**
         * Returns the current node's name.
         *
         * @return string
         */
        public function getName()
        {

            return $this->name;
        }

        /**
         * Adds a transition.
         *
         * @param Node                   $dst
         * @param SpecificationInterface $spec
         *
         * @return Node
         */
        public function addTransition( Node $dst, SpecificationInterface $spec )
        {

            $this->transitions[] = new Transition( $this, $dst, $spec );
        }

        /**
         * Returns the opened transitions.
         *
         * @param ContextInterface $context
         *
         * @return array
         */
        public function getOpenTransitions( ContextInterface $context )
        {

            $transitions = [ ];

            foreach ($this->transitions as $transition) {
                /** @var $transition Transition */
                if ($transition->isOpen( $context )) {
                    $transitions[] = $transition;
                }
            }

            return $transitions;
        }
    }
