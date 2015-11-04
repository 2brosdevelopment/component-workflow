<?php

    namespace TwoBros\ComponentWorkflow;

    class Transition
    {

        /**
         * @var Node
         */
        private $source;

        /**
         * @var Node
         */
        private $destination;

        /**
         * @var SpecificationInterface
         */
        private $specification;

        public function __construct( Node $sourceNode, Node $destinationNode, SpecificationInterface $specification )
        {

            $this->source        = $sourceNode;
            $this->destination   = $destinationNode;
            $this->specification = $specification;
        }

        /**
         * Checks if the current transition satisfies the specification on the given context.
         *
         * @param ContextInterface $context
         *
         * @return bool
         */
        public function isOpen( ContextInterface $context )
        {

            return $this->specification->isSatisfiedBy( $context );
        }

        /**
         * Returns the destination of the current transition.
         *
         * @return Node
         */
        public function getDestination()
        {

            return $this->destination;
        }
    }
