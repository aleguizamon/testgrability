<?php

namespace AppBundle\Entity;


/**
 * TestCase
 *
 */
class TestCase
{
    /**
     * @var integer
     *
     */
    private $id;

    /**
     * @var Cube
     *
     */
    private $cube;

    /**
     * @var integer
     *
     */
    private $paramN;

    /**
     * @var integer
     *
     */
    private $paramM;

    /**
     * @var OperationList
     *
     */
    private $operationList;


    /**
     * Constructor
     */
    public function __construct($id=0)
    {
        $this->id = $id;
    }

    /**
     * Set id
     *
     * @param integer $value
     * @return TestCase
     */
    public function setId($value)
    {
        $this->id = $value;
        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set paramN
     *
     * @param integer $value
     * @return TestCase
     */
    public function setParamN($value)
    {
        $this->paramN = $value;
        return $this;
    }

    /**
     * Get paramN
     *
     * @return integer
     */
    public function getParamN()
    {
        return $this->paramN;
    }

    /**
     * Set paramM
     *
     * @param integer $value
     * @return TestCase
     */
    public function setParamM($value)
    {
        $this->paramM = $value;
        return $this;
    }

    /**
     * Get paramM
     *
     * @return integer
     */
    public function getParamM()
    {
        return $this->paramM;
    }

    /**
     * Set operationList
     *
     * @param \AppBundle\Entity\OperationList $value
     * @return TestCase
     */
    public function setOperationList(\AppBundle\Entity\OperationList $value)
    {
        $this->operationList = $value;
        return $this;
    }

    /**
     * Get operationList
     *
     * @return OperationList
     */
    public function getOperationList()
    {
        return $this->operationList;
    }

    /**
     * Get cube
     *
     * @return Cube
     */
    public function getCube()
    {
        return $this->cube;
    }

    public function init($n,$m){
        $this->cube = new Cube($n);
        $this->paramN = $n;
        $this->paramM = $m;
        $this->operationList = new OperationList();
    }

    /**
     * Format output log
     *
     * @return array
     */
    public function formatLog(){
        return array(
            'testCase'  => '#'.$this->getId()." (N={$this->getParamN()}, M={$this->getParamM()})",
            'operation' => '#'.$this->getOperationList()->getCurrent()->getId().' - '.$this->getOperationList()->getCurrent()->getLog(),
            'result'    => $this->getOperationList()->getCurrent()->getResult()
        );

    }

    /**
     * Format output log for all operations
     *
     * @return array
     */
    public function regenerateLog(){
        $logs = array();
        for($i=0;$i<$this->operationList->getCount();$i++)
            $logs[] = array(
                'testCase'  => '#'.$this->getId()." (N={$this->getParamN()}, M={$this->getParamM()})",
                'operation' => '#'.$this->getOperationList()->getOperations($i)->getId().' - '.$this->getOperationList()->getOperations($i)->getLog(),
                'result'    => $this->getOperationList()->getOperations($i)->getResult()
            );
        return $logs;

    }

}
