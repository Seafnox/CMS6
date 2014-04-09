<?php

/**
 * Контроллер информационных блоков 
 */
class IblocksController extends RootController {

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Iblocks;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Iblocks'])) {
            $model->attributes = $_POST['Iblocks'];

            if ($model->save()) {

                // Генерим код модели

                $dir = Yiibase::getPathOfAlias('iblocks.models.iblocks');

                $classname = $model::getModelName($model->code);

                $tpl = "<?php\r\n\r\n".$this->renderPartial("_model-tpl",array(

                    "classname"=>$classname,
                    "tablename"=>$model::getTableName($model->code),
                    "iblock_id"=>$model->id

                ), true)."\r\n\r\n?>";

                file_put_contents($dir.DIRECTORY_SEPARATOR.$classname.".php", $tpl);

                if (empty($_POST["apply"]))
                    $this->redirect($_POST["returnUrl"]);
                else
                    $this->redirect(array('update', 'id' => $model->id, 'returnUrl' => $_POST["returnUrl"]));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Iblocks'])) {
            $model->attributes = $_POST['Iblocks'];

            if ($model->save()  AND empty($_POST["apply"]))
                $this->redirect($_POST["returnUrl"]);
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {

        if (Yii::app()->request->isPostRequest) {

            $model = $this->loadModel($id);

            $dir = Yiibase::getPathOfAlias('iblocks.models.iblocks');

            $classname = $model::getModelName($model->code);

            $filePath = $dir.DIRECTORY_SEPARATOR.$classname.".php";

            if(file_exists($filePath))
                unlink($filePath);

            $model->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }



    /**
     * Manages all models.
     */
    public function actionIndex() {
        $request = Yii::app()->request;
        $model = new Iblocks('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Iblocks']))
            $model->attributes = $_GET['Iblocks'];

        $params = array('model' => $model);

        if($request->isAjaxRequest)
            $this->renderPartial('_grid', $params);
        else
            $this->render('index', $params);
                
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Iblocks::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'iblocks-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
