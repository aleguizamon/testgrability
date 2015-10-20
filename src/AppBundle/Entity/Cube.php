<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Cube
 *
 */
class Cube
{

    const INIT_VALUE = 0;
    /**
     * @var array
     *
     */
    private $matrix;


    /**
     * Constructor
     */
    public function __construct($size)
    {
        $this->initMatrix($size);
    }

    /**
     * Get matrix
     *
     * @return array
     */
    public function getMatrix()
    {
        return $this->matrix;
    }


    /**
     * operation update
     *
     */
    public function update($params)
    {
        extract(self::extractUpdateParams($params));
        $this->matrix[$x-1][$y-1][$z-1] = $w;
    }

    public static function extractUpdateParams($params){
        $values = explode(' ',$params);
        return array('x' => $values[0],'y' => $values[1],'z' => $values[2],'w' => $values[3]);
    }

    public static function extractQueryParams($params){
        $values = explode(' ',$params);
        return array('x' => $values[0],'y' => $values[1],'z' => $values[2]);
    }

    /**
     * operation query
     *
     */
    public function query($params1, $params2)
    {
        $c1 = self::extractQueryParams($params1);
        $c2 = self::extractQueryParams($params2);

        $acum = 0;

        for($i=$c1['x'];$i<=$c2['x'];$i++)
            for($j=$c1['y'];$j<=$c2['y'];$j++)
                for($k=$c1['z'];$k<=$c2['z'];$k++)
                    $acum += $this->matrix[$i-1][$j-1][$k-1];

        return $acum;
    }

    private function initMatrix($size){
        $this->matrix = array();
        for($i=0;$i<$size;$i++)
            for($j=0;$j<$size;$j++)
                for($k=0;$k<$size;$k++)
                    $this->matrix[$i][$j][$k] = self::INIT_VALUE;

    }

}
