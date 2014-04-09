<?php

/**
 * Контроллер новостей.
 */

class NewsController extends FrontedController {
   
   
      
   /**
    * Дефолтный экшен для категории
    */    
    
    public function actionIndex() {
         
        $section =  Yii::app()->params["request_object"];

        $model = IblockNews::model();

        $dataProvider = $model->search();

        $pager = $dataProvider->getPagination();

        $pager->pageSize=1;

        $pager->route = 'fronted/sections'; // Задаем маршрут

        $pager->params = array("id"=>$section->id); // Передаем параметры маршруту

        $params =  array("dataProvider"=>$dataProvider, "section"=>$section );

        if(Yii::app()->request->isAjaxRequest)
            $this->renderPartial('list', $params);
        else
            $this->render('list', $params);
        
    }
    
    /**
     * Дефолтный экшен для материала 
     */
    
     public function actionIndexData() {
        
         $model =  Yii::app()->params["request_object"];
         
         $this->render('one', array("model"=>$model ));
         
    }
    
}

?>
