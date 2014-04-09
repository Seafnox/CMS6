<?php

/**
 * Поведение для добавленияи удаление элементов в индекс Zend Lucene
 */

class SearchBehavior extends CActiveRecordBehavior
{

        
    public function afterSave($event) {
        
        $s_c  = new SearchLucene();

        $cst = new RpnTitleConstructor(); // Конструктор имен для каталога
        
        $sid = SearchLucene::getSid($this->owner);
        
        $id = $this->owner->id;
        
        $cls = get_class($this->owner);
        
        $model = $cls::model()->findByPk($id);
        
        $title =  $cst->constr($model); // Конструктор названий
        
        $link = "/catalog/data-catalog/" . $model->code;
        
        $text = $model->text;
        
        if($this->owner->isNewRecord) { // Добавляем в индекс
            
            $s_c->add($sid, $id, $title, $link, $text, array('address'=>$model->address));
        
        }
        else { // Обновляем индекс
            

            $s_c->delete($sid);
            
             $s_c->add($sid, $id, $title, $link, $text, array('address'=>$model->address));

        }
        
        return parent::afterSave($event);
    
        
    }
    
    public function beforeDelete($event) {
        
        $s_c  = new SearchLucene();
        
        $sid = SearchLucene::getSid($this->owner);
        
         $s_c->delete($sid); // Удаляем из индеса
        
        return parent::beforeDelete($event);
    }
    

}



?>
