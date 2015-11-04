<?php

    namespace TwoBros\ComponentWorkflow;

    use Symfony\Component\EventDispatcher\EventDispatcherInterface;

    class Workflow
    {

        /**
         * @var Node
         */
        private $startNode;

        /**
         * @var NodeMap
         */
        private $nodes;

        /**
         * @var EventDispatcherInterface
         */
        private $eventDispatcher;

        /**
         * @var Node
         */
        private $current;

        public function __construct( Node $startNode, NodeMap $nodes, EventDispatcherInterface $eventDispatcher )
        {

            $this->startNode       = $startNode;
            $this->nodes           = $nodes;
            $this->eventDispatcher = $eventDispatcher;
            $this->current         = null;
        }

        /**
         * Initializes the workflow with a given token.
         *
         * @param string $token
         *
         * @return Workflow
         *
         * @throws Exception\InvalidTokenException
         */
        public function initialize( $token = null )
        {

            if ($this->isStartOfWorkflow( $token )) {
                $this->current = $this->startNode;
            } elseif ($this->nodes->has( $token )) {
                $this->current = $this->nodes->get( $token );
            } else {
                throw new Exception\InvalidTokenException();
            }

            return $this;
        }

        /**
         * Moves the current token to the next node of the workflow.
         *
         * @param ContextInterface $context
         *
         * @return Workflow
         *
         * @throws Exception\NotInitializedWorkflowException
         * @throws Exception\NoOpenTransitionException
         * @throws Exception\MoreThanOneOpenTransitionException
         */
        public function next( ContextInterface $context )
        {

            if ($this->isWorkflowInitialized()) {
                throw new Exception\NotInitializedWorkflowException();
            }

            $transitions = $this->current->getOpenTransitions( $context );

            if ($this->areThereNoOpenTransitions( $transitions )) {
                throw new Exception\NoOpenTransitionException();
            } elseif ($this->isThereMoreThanOneOpenTransition( $transitions )) {
                throw new Exception\MoreThanOneOpenTransitionException();
            }

            $transition = array_pop( $transitions );
            $token      = $transition->getDestination()
                                     ->getName();

            $this->initialize( $token );
            $this->eventDispatcher->dispatch( $token, new Event( $context, $token ) );

            return $this;
        }

        /**
         * isStartOfWorkflow
         *
         * @param $token
         *
         * @return bool
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        protected function isStartOfWorkflow( $token )
        {

            return null === $token;
        }

        /**
         * isWorkflowInitialized
         *
         * @return bool
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        protected function isWorkflowInitialized()
        {

            return null === $this->current;
        }

        /**
         * areThereNoOpenTransitions
         *
         * @param $transitions
         *
         * @return bool
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        protected function areThereNoOpenTransitions( $transitions )
        {

            return 0 === count( $transitions );
        }

        /**
         * isThereMoreThanOneOpenTransition
         *
         * @param $transitions
         *
         * @return bool
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        protected function isThereMoreThanOneOpenTransition( $transitions )
        {

            return 1 < count( $transitions );
        }
    }
