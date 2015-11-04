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
         * @param Node                   $destinationNode
         * @param SpecificationInterface $specification
         *
         * @return Node
         */
        public function addTransition( Node $destinationNode, SpecificationInterface $specification )
        {

            $this->transitions[] = new Transition( $this, $destinationNode, $specification );
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
