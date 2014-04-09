<?php

/**
 * Класс url правил приложения.  
 */
abstract class AppUrlRule extends CBaseUrlRule {

    
    /**
     * Формирует строку параметров из массива
     * @param array $params
     * @return string 
     */
    
    public function getParamsStr($params) {


        $p_arr = array();

        foreach ($params AS $k => $v) {

            $p_arr[] = $k . "=" . $v;
        }
        

        $p_str = implode("&", $p_arr);

        $p_str = !empty($p_str) ? "?" . $p_str : null;
    
        return $p_str;
        
    }

}

?>
