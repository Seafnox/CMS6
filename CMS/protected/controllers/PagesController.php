<?php

/**
 * Контроллер текстовых страниц. 
 */
class PagesController extends FrontedController {

    /**
     * Дефолтный экшен для категории
     */
    public function actionIndex() {

        $section = Yii::app()->params["request_object"];

        $this->render('view', array("model" => $section));
    }

    /**
     * Дефолтный экшен для материала 
     */
    public function actionIndexType() {

        throw new AppException("Действие не задано");
    }


}

?>
