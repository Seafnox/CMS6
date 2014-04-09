<?php

class ItypesController extends RootController
{

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Itypes;

        $this->performAjaxValidation($model);

        if (isset($_POST['Itypes'])) {
            $model->attributes = $_POST['Itypes'];

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
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        $this->performAjaxValidation($model);

        if (isset($_POST['Itypes'])) {
            $model->attributes = $_POST['Itypes'];

            if ($model->save() AND empty($_POST["apply"])) {
                $this->redirect($_POST['returnUrl']);
            }

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
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $this->loadModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Групповое удаление моделей
     */

    public function actionGroupDelete()
    {

        $request = Yii::app()->request;


        if ($request->isPostRequest AND !empty($_POST["items"])) {

            $criteria = new CDbCriteria;

            $criteria->compare('id', $_POST["items"]);

            $models = Itypes::model()->findAll($criteria);

            foreach ($models AS $model)
                $model->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!$request->isAjaxRequest)
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        $model = new Itypes('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Itypes']))
            $model->attributes = $_GET['Itypes'];

        $params = array(
            'model' => $model,
        );

        if (Yii::app()->request->isAjaxRequest) {

            $this->renderPartial("_grid", $params);

        } else {

            $this->render('index', $params);

        }

    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = Itypes::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'itypes-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
