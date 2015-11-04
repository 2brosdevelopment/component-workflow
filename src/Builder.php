<?php

    namespace TwoBros\ComponentWorkflow;

    use Symfony\Component\EventDispatcher\EventDispatcher;
    use Symfony\Component\EventDispatcher\EventDispatcherInterface;

    class Builder
    {

        /**
         * @var EventDispatcherInterface
         */
        private $eventDispatcher;

        /**
         * @var NodeMap
         */
        private $nodes;

        /**
         * @var Node
         */
        private $start;

        public function __construct( EventDispatcherInterface $eventDispatcher = null )
        {

            $this->eventDispatcher = $eventDispatcher ?: new EventDispatcher();
            $this->nodes           = new NodeMap();
            $this->start           = null;
        }

        /**
         * Opens a workflow.
         *
         * @param string                 $sourceNode
         * @param SpecificationInterface $specification
         *
         * @return Builder
         */
        public function open( $sourceNode, SpecificationInterface $specification )
        {

            $this->start = $this->nodes->get( uniqid() );
            $this->start->addTransition( $this->nodes->get( $sourceNode ), $specification );

            return $this;
        }

        /**
         * Adds a link to the workflow.
         *
         * @param string                 $sourceNode
         * @param string                 $destinationNode
         * @param SpecificationInterface $specification
         *
         * @return Builder
         *
         * @throws Exception\NoStartingNodeBuilderException
         */
        public function link( $sourceNode, $destinationNode, SpecificationInterface $specification )
        {

            if ($this->isThereAStartingNode()) {
                throw new Exception\NoStartingNodeBuilderException();
            };

            $this->nodes->get( $sourceNode )
                        ->addTransition( $this->nodes->get( $destinationNode ), $specification );

            return $this;
        }

        /**
         * Returns the workflow being built.
         *
         * @return Workflow
         *
         * @throws Exception\NoStartingNodeBuilderException
         */
        public function getWorkflow()
        {

            if ($this->isThereAStartingNode()) {
                throw new Exception\NoStartingNodeBuilderException();
            };

            return new Workflow( $this->start, $this->nodes, $this->eventDispatcher );
        }

        /**
         * isThereAStartingNode
         *
         * @return bool
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        protected function isThereAStartingNode()
        {

            return null === $this->start;
        }
    }
