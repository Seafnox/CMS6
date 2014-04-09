<?php

/**
 * Поведение сортировки 
 */

class SortBehavior extends CActiveRecordBehavior
{

    public function up($condition = null, $params=array() )
    {
        
          $class = get_class($this->owner);
             
          $cur_sort = $this->owner->sort;
          
          $q_condition = 'sort > :sort';
          
          $q_params = array(':sort'=>$cur_sort);
          
          if(!empty($condition)) {
              
              
              $q_condition = $q_condition." AND ".$condition;
              
              $q_params = array_merge($q_params, $params);
              
                          
          }
          
        
          $criteria=new CDbCriteria;
          $criteria->condition=$q_condition;
          $criteria->params=$q_params;
          $criteria->order = "sort asc";
          
          $up_item = $class::model()->find($criteria);
          
          
                   
          if(!empty($up_item)) {    
          
          $up_sort = $up_item->sort;    
              
          $up_item->sort = $cur_sort;
          
          $up_item->save();
          
           $this->owner->sort = $up_sort;
          
          $this->owner->save();
          
          }
          
                
    }
    
    
    public function down($condition = null, $params=array())
    {
    
          $class = get_class($this->owner);
            
          $cur_sort = $this->owner->sort;
          
          $q_condition = 'sort < :sort';
          
          $q_params = array(':sort'=>$cur_sort);
          
          if(!empty($condition)) {
              
              
              $q_condition = $q_condition." AND ".$condition;
              
              $q_params = array_merge($q_params, $params);
              
          }
          
        
          $criteria=new CDbCriteria;
          $criteria->condition=$q_condition;
          $criteria->params=$q_params;
          $criteria->order = "sort desc";
          
          $down_item = $class::model()->find($criteria);
          
         
          
          if(!empty($down_item)) {
           
           $down_sort = $down_item->sort;
           
          $down_item->sort = $cur_sort;
          
          $down_item->save();
          
           $this->owner->sort = $down_sort;
          
          $this->owner->save();
                
                
         }
    
    }
    
    public function afterSave($event) {
        
        if($this->owner->isNewRecord) {
        
        $class = get_class($this->owner);
       
        $class::model()->updateByPk($this->owner->id, array("sort" => $this->owner->id)); 
        
        
        }
        
        return parent::afterSave($event);
    
        
    }
    

}



?>
