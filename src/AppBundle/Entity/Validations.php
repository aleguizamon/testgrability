<?php

namespace AppBundle\Entity;

/**
 * Validations
 *
 */
class Validations
{

    public static function validateT($value = 0, $limits = array()){
        if( !isset($limits['lower_limit_t']) || !is_numeric($limits['lower_limit_t']))
            return 'El límite inferior para T es incorrecto.';
        if( !isset($limits['upper_limit_t']) || !is_numeric($limits['upper_limit_t']))
            return 'El límite superior para T es incorrecto.';
        if(!is_numeric($value))
            return 'El valor de T debe ser un entero.';
        if($value < $limits['lower_limit_t'] || $value > $limits['upper_limit_t'])
            return 'El valor T no esta dentro de los límites permitidos.';

        return '';
    }

    public static function validateN($value = 0, $limits = array()){
        if( !isset($limits['lower_limit_n']) || !is_numeric($limits['lower_limit_n']))
            return 'El límite inferior para N es incorrecto.';
        if( !isset($limits['upper_limit_n']) || !is_numeric($limits['upper_limit_n']))
            return 'El límite superior para N es incorrecto.';
        if(!is_numeric($value))
            return 'El valor de N debe ser un entero.';
        if($value < $limits['lower_limit_n'] || $value > $limits['upper_limit_n'])
            return 'El valor N no esta dentro de los límites permitidos.';

        return '';
    }

    public static function validateM($value = 0, $limits = array()){
        if( !isset($limits['lower_limit_m']) || !is_numeric($limits['lower_limit_m']))
            return 'El límite inferior para M es incorrecto.';
        if( !isset($limits['upper_limit_m']) || !is_numeric($limits['upper_limit_m']))
            return 'El límite superior para M es incorrecto.';
        if(!is_numeric($value))
            return 'El valor de M debe ser un entero.';
        if($value < $limits['lower_limit_m'] || $value > $limits['upper_limit_m'])
            return 'El valor M no esta dentro de los límites permitidos.';

        return '';
    }

    public static function validateW($value = 0, $limits = array()){
        if( !isset($limits['lower_limit_w']) || !is_numeric($limits['lower_limit_w']))
            return 'El límite inferior para W es incorrecto.';
        if( !isset($limits['upper_limit_w']) || !is_numeric($limits['upper_limit_w']))
            return 'El límite superior para W es incorrecto.';
        if(!is_numeric($value))
            return 'El valor de W debe ser un entero.';
        if($value < $limits['lower_limit_w'] || $value > $limits['upper_limit_w'])
            return 'El valor W no esta dentro de los límites permitidos.';

        return '';
    }

    public static function validateStringUpdate($params, $n, $limits){
        $data = explode(' ',$params);
        if(count($data) != 4) return 'El comando UPDATE debe tener cuatro parámetros separados por un espacio en blanco';

        if(!is_numeric($data[0])) return 'La coordenada X debe ser un valor numérico';
        if($data[0] < 1 || $data[0] > $n) return 'La coordenada X debe estar entre 1 y '.$n;

        if(!is_numeric($data[1])) return 'La coordenada Y debe ser un valor numérico';
        if($data[1] < 1 || $data[1] > $n) return 'La coordenada Y debe estar entre 1 y '.$n;

        if(!is_numeric($data[2])) return 'La coordenada Z debe ser un valor numérico';
        if($data[2] < 1 || $data[2] > $n) return 'La coordenada Z debe estar entre 1 y '.$n;

        if( ($resp=Validations::validateW($data[3],$limits)) != "") return $resp;

        return "";
    }

    public static function validateStringQuery($params1,$params2, $n){
        $data1 = explode(' ',$params1);
        if(count($data1) != 3) return 'La coordenada 1 del comando QUERY debe tener tres parámetros separados por un espacio en blanco';
        if(!is_numeric($data1[0])) return 'La coordenada X1 debe ser un valor numérico';
        if(!is_numeric($data1[1])) return 'La coordenada Y1 debe ser un valor numérico';
        if(!is_numeric($data1[2])) return 'La coordenada Z1 debe ser un valor numérico';

        $data2 = explode(' ',$params2);
        if(count($data2) != 3) return 'La coordenada 2 del comando QUERY debe tener tres parámetros separados por un espacio en blanco';
        if(!is_numeric($data2[0])) return 'La coordenada X2 debe ser un valor numérico';
        if(!is_numeric($data2[1])) return 'La coordenada Y2 debe ser un valor numérico';
        if(!is_numeric($data2[2])) return 'La coordenada Z2 debe ser un valor numérico';

        if($data1[0] < 1 || $data1[0] > $data2[0]) return "La coordenada X1 debe estar entre 1 y X2";
        if($data1[1] < 1 || $data1[1] > $data2[1]) return "La coordenada Y1 debe estar entre 1 y Y2";
        if($data1[2] < 1 || $data1[2] > $data2[2]) return "La coordenada Z1 debe estar entre 1 y Z2";

        if($data2[0] < $data1[0] || $data2[0] > $n) return "La coordenada X2 debe estar entre X1 y N";
        if($data2[1] < $data1[1] || $data2[1] > $n) return "La coordenada Y2 debe estar entre Y1 y N";
        if($data2[2] < $data1[2] || $data2[2] > $n) return "La coordenada Z2 debe estar entre Z1 y N";

        return "";
    }


}
