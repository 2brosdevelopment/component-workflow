<?php

    namespace TwoBros\ComponentWorkflow\Exception;

    class NoOpenTransitionException extends \LogicException
    {

        public function __construct()
        {

            return parent::__construct( 'No open transition with current context' );
        }
    }
