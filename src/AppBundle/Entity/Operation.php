<?php

namespace AppBundle\Entity;

/**
 * Operation
 *
 */
class Operation
{
    /**
     * @var integer
     *
     */
    private $id;

    /**
     * @var string
     *
     */
    private $result;

    /**
     * @var string
     *
     */
    private $type;

    /**
     * @var integer
     *
     */
    private $paramW;

    /**
     * @var string
     *
     */
    private $log;


    /**
     * Constructor
     */
    public function __construct($id=0)
    {
        $this->id = $id;
        $this->result = '';
        $this->type = '';
        $this->log = '';
        $this->paramW = NULL;
    }

    /**
     * Set id
     *
     * @param integer $value
     * @return Operation
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
     * Set result
     *
     * @param string $value
     * @return Operation
     */
    public function setResult($value)
    {
        $this->result = $value;
        return $this;
    }

    /**
     * Get result
     *
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set type
     *
     * @param string $value
     * @return Operation
     */
    public function setType($value)
    {
        $this->type = $value;
        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }


    /**
     * Set paramW
     *
     * @param integer $value
     * @return Operation
     */
    public function setParamW($value)
    {
        $this->paramW = $value;
        return $this;
    }

    /**
     * Get paramW
     *
     * @return integer
     */
    public function getParamW()
    {
        return $this->paramW;
    }

    /**
     * Set log
     *
     * @param string $value
     * @return Operation
     */
    public function setLog($value){
        $this->log = $value;
    }

    /**
     * Get log
     *
     * @return string
     */
    public function getLog(){
        return $this->log;
    }

    public function updateValues($type, $params){
        $this->type = $type;
        if($type == 'U'){
            extract(Cube::extractUpdateParams($params));
            $this->paramW = $w;
            $this->result = '';
            $this->createLog($params);
        }
    }

    public function queryValues($type, $params1, $params2, $result){
        $this->type = $type;
        if($type == 'Q'){
            $this->result = $result;
            $this->createLog($params1,$params2);
        }
    }

    public function createLog($params1,$params2 = ''){
        if($this->type == 'U')
            $this->log = 'UPDATE '.$params1;
        else if($this->type == 'Q')
            $this->log = 'QUERY '.$params1.' '.$params2;
    }


}
