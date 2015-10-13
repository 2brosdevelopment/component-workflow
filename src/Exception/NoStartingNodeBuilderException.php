<?php

    namespace TwoBros\ComponentWorkflow\Exception;

    class NoStartingNodeBuilderException extends \LogicException
    {

        public function __construct()
        {

            return parent::__construct( 'No starting node in current workflow' );
        }
    }
