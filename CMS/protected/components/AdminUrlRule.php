<?php

/**
 * Класс url правил для админки  
 */

class AdminUrlRule extends AppUrlRule
{
    public $connectionID = 'db';
    
     
    public function createUrl($manager,$route,$params,$ampersand)
    {

        if(substr_count($route, '/admin') == 0) return false; // не обрабатываем данный запрос.
        
        $arr = explode("/", $route);

        $module = array_shift($arr);

        $admin = array_shift($arr);

        $url = $admin."/".$module."/".implode("/", $arr);
        
        // Добавлйем параметры
        
        if(!empty($params)) {
            
            $url .= "?".http_build_query($params);
            
        }
        
        return $url;

    }
 
    public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
    {
          
        if(substr_count($pathInfo, 'admin') == 0) return false; // не обрабатываем данный запрос.
     
        $arr = explode("/", $pathInfo);
       
        $admin = array_shift($arr);
            
        $module = count($arr)?array_shift($arr):"main";
       
        $route = $module."/".$admin."/".implode("/", $arr);
        
        //die($route);
        
        return $route;
       
    }
}
?>
