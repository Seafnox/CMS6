<?php
/**
 * Class ConfigController контроллер пользовательских настроек
 */

class ConfigController extends RootController {


    public function actionIndex() {

        $models = Config::model()->getAllModels();

        if(isset($_POST["Config"])) {

            $saved = true;

            foreach($_POST["Config"] AS $attrs) {

                $id = $attrs["id"];

                $model = $models[$id];

                $model->attributes = $attrs;

                $saved = $model->save() && $saved;

            }

            if($saved)
                $this->redirect(Yii::app()->createUrl("/main/admin/config/"));

        }


        $this->render("index", array("models"=>$models));


    }


}