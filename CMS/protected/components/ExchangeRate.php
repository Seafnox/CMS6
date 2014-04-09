<?php

/**
 * Возвращает курсы валют 
 */

class ExchangeRate extends CComponent {

    public $url =  'http://www.cbr.ru/scripts/XML_daily.asp?date_req=';
      
    public $cache_time = 3600;
    
    public $cache_pref = "er_";
    
    protected $xml;
    
    /**
     *Загрузка xml с информацией о курсах валют 
     */
    
    protected function loadXml() {

        $date = date("d/m/Y");
        
        if ($curl = curl_init()) {

            curl_setopt($curl, CURLOPT_URL, $this->url . $date);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($curl, CURLOPT_TIMEOUT, 3);

            $this->xml = curl_exec($curl);

            curl_close($curl);
        }
    }
    
    /**
     * Получение курса по символьному коду
     * @param string $code символьный код (USD - доллар США, EUR - евро)
     * @return string 
     */
    
    public function getER($code) {
        
        $id = $this->cache_pref.$code;
        
        $value=Yii::app()->cache->get($id); // Попытка получения из кэша
        
        if(!$value) {
            
            if(empty($this->xml)) $this->loadXml();
            
            if(empty($this->xml)) return false; // Получить xml не удалось
            
            // Разбор xml
            
            $dom = simplexml_load_string($this->xml); 
            
            foreach($dom->Valute AS $Valute) {
                
                if($Valute->CharCode == $code) {
                    
                    $value = (string) $Valute->Value;
                    
                    break;
                                                       
                }
                
            }
            
            if($value) Yii::app()->cache->set($id, $value, $this->cache_time); // Запись в кэш
            
        }
        
        return $value;
        
    }
    
    /**
     * Получение курса по символьному коду
     * @param string $code символьный код (USD - доллар США, EUR - евро)
     * @return double 
     */
    
    public function getNumEr($code) {
        
        $er = $this->getER($code);
        
        return (double) str_replace(",", ".", $er);
        
    }
   

}

?>
