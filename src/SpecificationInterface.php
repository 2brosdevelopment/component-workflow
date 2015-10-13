<?php

    namespace TwoBros\ComponentWorkflow;

    interface SpecificationInterface
    {

        /**
         * Tests if the given context satisfies the specification.
         *
         * @param ContextInterface $context
         *
         * @return bool
         */
        public function isSatisfiedBy( ContextInterface $context );
    }
