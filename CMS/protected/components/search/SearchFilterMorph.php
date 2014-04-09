<?php

/**
 * Морфологический фильтр phpmorphy для zend lucene 
 */
class SearchFilterMorph extends Zend_Search_Lucene_Analysis_TokenFilter {

    private $morphy;

    public function __construct() {
        
        //инициализируем объект phpMorphy

        $path = YiiBase::getPathOfAlias('application.vendors'); 
        
        require_once $path . "/phpmorphy/src/common.php";

        $dir = $path . '/phpmorphy/dicts';

              
        $opts = array(
		'storage' => PHPMORPHY_STORAGE_FILE	
        );
   
                
        $this->morphy = new phpMorphy($dir, "ru_RU", $opts);
       
    }

    public function normalize(Zend_Search_Lucene_Analysis_Token $srcToken) {
            
        //извлекаем корень слова
        $pseudo_root = $this->morphy->getPseudoRoot(mb_strtoupper($srcToken->getTermText(), "utf-8"));
        
        if ($pseudo_root === false)
            $newStr = mb_strtoupper($srcToken->getTermText(), "utf-8");
        //если корень извлечь не удалось, тогда используем все слово целиком
        else
            $newStr = $pseudo_root[0];
    
        //если лексема короче 3 символов, то не используем её      
        if (mb_strlen($newStr, "utf-8") < 3)
            return null;

        $newToken = new Zend_Search_Lucene_Analysis_Token(
                        $newStr,
                        $srcToken->getStartOffset(),
                        $srcToken->getEndOffset()
        );

        $newToken->setPositionIncrement($srcToken->getPositionIncrement());

        return $newToken;
    }

}

?>
