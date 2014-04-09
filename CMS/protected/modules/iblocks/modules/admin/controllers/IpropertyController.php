<?php

class IpropertyController extends RootController {

    public function init() {

        return parent::init();
    }

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
    public function actionCreate($iblock_id) {
        $model = new Iproperty;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        $model->iblock_id = $iblock_id;

        if (isset($_POST['Iproperty'])) {
            $model->attributes = $_POST['Iproperty'];

            if ($model->save()) {

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

        if (isset($_POST['Iproperty'])) {
            $model->attributes = $_POST['Iproperty'];
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
            // we only allow deletion via POST request
            $model = $this->loadModel($id);

            $iblock_id = $model->iblock_id;

            $model->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin', 'iblock_id' => $iblock_id));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }



    /**
     * Manages all models.
     */
    public function actionIndex($iblock_id) {
        $request = Yii::app()->request;
        $model = new Iproperty('search');
        $model->unsetAttributes();  // clear any default values

        $model->iblock_id = $iblock_id;

        $iblock_title = Iblocks::model()->findByPk($iblock_id)->title;

        if (isset($_GET['Iproperty']))
            $model->attributes = $_GET['Iproperty'];

        $params =  array(
            'model' => $model,
            'iblock_id' => $iblock_id,
            'iblock_title' => $iblock_title
        );

        if($request->isAjaxRequest)
            $this->renderPartial('_grid', $params);
        else
            $this->render('index', $params);
        
    }


    public function actionUp($id, $iblock_id) {


        $model = $this->loadModel($id);

        $model->up("iblock_id = :iblock_id", array(":iblock_id"=>$iblock_id));


    }

    public function actionDown($id, $iblock_id) {


        $model = $this->loadModel($id);

        $model->down("iblock_id = :iblock_id", array(":iblock_id"=>$iblock_id));

    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Iproperty::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'iproperty-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
