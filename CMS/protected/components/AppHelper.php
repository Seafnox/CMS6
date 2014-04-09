<?php

class AppHelper {
  
    /**
     * Форматирование цены
     * @param string $price
     * @return string 
     */
    
    public static function formatPrice($price, $sep=".") {
        
        $arr = str_split($price);
       
        $arr = array_reverse($arr);
               
        $new_arr = array();
        
        for($i=0; $i<count($arr); $i++) {
            
            $new_arr[] = $arr[$i];
            
            if(fmod($i+1, 3) == 0 AND isset($arr[$i+1])) {
             
                $new_arr[] = $sep;
                
            }
            
        }
        
        $new_arr = array_reverse($new_arr);
        
        return implode("", $new_arr);
        
    }
    
    
    /**
     * Склонение слов по числам
     * @param integer $number число
     * @param string $word1 первая словоформа, пример: рубль
     * @param string $word2 вторая словоформа, пример: рубля
     * @param string $word3 третья словоформа, пример: рублей
     * @return string форма слова 
     */
    public static function declOfNum($number, $word1, $word2, $word3) {

        $number = (int) round($number);

        $len = strlen($number);

        if ($len == 1) { // Число от 0 до 9
            if ($number == 1) {
                $word = $word1;
            } elseif ($number > 1 AND $number < 5) {
                $word = $word2;
            } else {
                $word = $word3;
            }
        } else { // Число от 10 и более
          
            $last2 = (int) substr($number, -2); // Последние 2 цифры

            if ($last2 < 21 AND $last2 > 9) {

                $word = $word3;
        
            } else {

                $last1 = (int) substr($number, -1); // Последняя цифра

                if ($last1 == 1) {

                    $word = $word1;
                    
                } elseif ($last1 > 1 AND $last1 < 5) {

                    $word = $word2;
                    
                } else {

                    $word = $word3;
                }
            }
        }

        return $word;
    }
   
    
}

?>
