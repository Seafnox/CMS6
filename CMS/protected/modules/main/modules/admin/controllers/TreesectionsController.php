<?php

class TreesectionsController extends AdminController {
    
    public function actionTree()
    {
        // рендерим файлик отображения tree.php
        $this->render('tree');
    }

    public function actionAjaxFillTree()
    {
        // если пробуют получить прямой доступ к экшину (не через ajax)
        // тогда обрубаем "крылья")) т.е. возвращаем белую страницу
        if (!Yii::app()->request->isAjaxRequest) {
            exit();
        }


        if(!isset($_GET['root']))
            exit();


        $parent_id = (int) $_GET['root'];

        if($parent_id == 0)
            $models=Section::model()->roots()->findAll();
        else
            $models=Section::model()->findByPk($parent_id)->children()->findAll();



        $children = array();


        foreach($models AS $model) {

            if(!Yii::app()->user->checkAccess('readModel', array("model"=>$model)))
                continue;

            $count = $model->children()->count();

            $children[] = array(
                "id" => $model->id,
                "text" => "<a href=\"".Yii::app()->getUrlManager()->createUrl('/main/admin/sections', array("parent_id"=>$model->id))."\">".$model->title."</a>",
                "hasChildren" => $count>0?true:false
            );

        }
        
        
        // возвращаем данные
/*
        echo str_replace(
            '"hasChildren":"0"',
            '"hasChildren":false',
            CTreeView::saveDataAsJson($children)
        );*/

        echo CTreeView::saveDataAsJson($children);
        exit();
    }
    
    
    
}
?>
