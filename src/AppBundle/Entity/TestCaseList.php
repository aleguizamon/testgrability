<?php

namespace AppBundle\Entity;

/**
 * TestCaseList
 *
 */
class TestCaseList
{

    /**
     * @var array
     *
     */
    private $testCases;

    /**
     * @var integer
     *
     */
    private $count;

    /**
     * @var integer
     *
     */
    private $total;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->testCases = array();
        $this->count = 0;
        $this->total = 0;
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
    public function setCount($newCount) {
        $this->count = $newCount;
    }

    /**
     *
     */
    public function getTotal() {
        return $this->total;
    }

    /**
     *
     */
    public function setTotal($total) {
        $this->total = $total;
    }

    /**
     *
     */
    public function getTestCases($testCaseNumber) {
        if ( (is_numeric($testCaseNumber)) && ($testCaseNumber <= $this->getCount()))
            return $this->testCases[$testCaseNumber];
        else
            return NULL;
    }

    /**
     * Get current testCase
     *
     * @return TestCase
     */
    public function getCurrent() {
        return $this->count>0 ? $this->testCases[$this->count-1] : NULL;
    }

    /**
     *
     */
    public function addTestCases(\AppBundle\Entity\TestCase $testCase) {
        $this->testCases[$this->getCount()] = $testCase;
        $this->setCount($this->getCount() + 1);
        return $this->getCount();
    }

    /**
     *
     */
    public function removeTestCases(\AppBundle\Entity\TestCase $testCase) {
        $counter = 0;
        while (++$counter <= $this->getCount()) {
            if ($testCase->getId() == $this->testCases[$counter]->getId())
            {
                for ($x = $counter; $x < $this->getCount(); $x++) {
                    $this->testCases[$x] = $this->testCases[$x + 1];
                }
                $this->setCount($this->getCount() - 1);
            }
        }
        return $this->getCount();
    }

    public function regenerateLog(){
        $logs = array();
        for($i=0;$i<$this->getCount();$i++)
            $logs = array_merge($logs,$this->getTestCases($i)->regenerateLog());
        return $logs;
    }
}
