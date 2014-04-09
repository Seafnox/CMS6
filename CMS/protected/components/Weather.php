<?php

/**
 * Класс для получения прогноза погоды от gismeteo.ru
 */

class Weather extends CComponent {
  
    public $url =  'http://informer.gismeteo.ru/xml/27731_1.xml';
        
    public $cache_time = 3600;
    
    public $cache_pref = "weather_";
   
    protected $xml;
    
    /**
     * Загрузка данных в xml 
     */
    
    protected function loadXml() {
       
        if ($curl = curl_init()) {

            curl_setopt($curl, CURLOPT_URL, $this->url);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($curl, CURLOPT_TIMEOUT, 3);

            $this->xml = curl_exec($curl);

            curl_close($curl);
        }
          
    }
    
    /**
     * Получение информации о погоде за дату
     * @param string $date дата ф формате Y-m-d
     * @return array 
     */
    
    public function getInfo($date) {
        
        $id = $this->cache_pref.$date;
        
        $value=Yii::app()->cache->get($id); // Попытка получения из кэша
        
        if(!$value) {
        
            if(empty($this->xml)) $this->loadXml();
            
            if(empty($this->xml)) return false; // Получить xml не удалось
            
            // Разбор xml
            
            $dom = simplexml_load_string($this->xml); 
            
            $result = $dom->xpath('/MMWEATHER/REPORT/TOWN/FORECAST');
            
            $i = 0;
            
            $cur_time = strtotime(date("Y-m-d H:i:s")); // Текущее время
            
            $dif = array(); // Массив хранящий разницы между временем прогноза и текущем временем
            
            foreach($result AS $item) {
                
                $attrs = $item->attributes();
                
                $year = $attrs["year"];
                $month = $attrs["month"];
                $day = $attrs["day"];
                $hour = $attrs["hour"];
                
                $item_date  = $year."-".$month."-".$day;
                
                if($item_date == $date ) {
             
                    $date_str = $item_date.$hour.":00:00";
                    $time = strtotime($date_str);
                    $dif[$i] = $time-$cur_time;
                    $dif[$i] = abs($dif[$i]);
                    
                }
                
                $i++;
                
            }
            
            if(empty($dif)) return false; // Прогнозов за $date не найдено
             
            // Находим ближайший по времени прогноз
            
            $min = min($dif);

            $key = array_search($min, $dif);    
            
            $prognoz = $result[$key];
            
            $value = $this->getWeatherArr($prognoz);
            
            Yii::app()->cache->set($id, $value, $this->cache_time); // Сохраняем в кеш
            
        }
        
        return $value;
        
    }

    /**
     * Формирует массив с прогнозом погоды
     * @param SimpleXMLElement $prognoz
     * @return array массив с данными о погоде( элементы - temperature, cloudiness, precipitation )
     */
    
    protected function getWeatherArr($prognoz) {
        
        $arr = array();
        
        $t = $prognoz->TEMPERATURE;
        
        $attrs = $t->attributes();
        
        $arr["temperature"] = ( (int) $attrs["min"] + (int) $attrs["max"])/2;
        
        $ph = $prognoz->PHENOMENA;
        
        $attrs = $ph->attributes();
        
        $arr["cloudiness"] = (int) $attrs["cloudiness"];
        
        $arr["precipitation"] = (int) $attrs["precipitation"];
        
        return $arr;
        
    }
    
    
}

?>
