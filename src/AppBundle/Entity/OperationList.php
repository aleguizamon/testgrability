<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * OperationList
 *
 */
class OperationList
{

    /**
     * @var array
     *
     */
    private $operations;

    /**
     * @var integer
     *
     */
    private $count;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->operations = array();
        $this->count = 0;
    }

    /**
     *
     */
    public function getCount() {
        return $this->count;
    }

    /**
     *
     */
    private function setCount($newCount) {
        $this->count = $newCount;
    }

    /**
     *
     */
    public function getOperations($operationNumber) {
        if ( (is_numeric($operationNumber)) && ($operationNumber <= $this->getCount()))
            return $this->operations[$operationNumber];
        else
            return NULL;
    }

    /**
     * Get current operation
     *
     * @return Operation
     */
    public function getCurrent() {
        return $this->count > 0 ? $this->operations[$this->count-1] : NULL;
    }

    /**
     *
     */
    public function addOperations(\AppBundle\Entity\Operation $operation) {
        $this->operations[$this->getCount()] = $operation;
        $this->setCount($this->getCount() + 1);
        return $this->getCount();
    }

    /**
     *
     */
    public function removeOperations(\AppBundle\Entity\Operation $operation) {
        $counter = 0;
        while (++$counter <= $this->getCount()) {
            if ($operation->getId() == $this->operations[$counter]->getId())
            {
                for ($x = $counter; $x < $this->getCount(); $x++) {
                    $this->operations[$x] = $this->operations[$x + 1];
                }
                $this->setCount($this->getCount() - 1);
            }
        }
        return $this->getCount();
    }
}
