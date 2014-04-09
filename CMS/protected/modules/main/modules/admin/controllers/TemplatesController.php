<?php

/**
 *Контроллер управления шаблонами 
 */

class TemplatesController extends RootController {

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
        $model = new Template;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Template'])) {

            $model->attributes = $_POST['Template'];

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

        if (isset($_POST['Template'])) {
            $model->attributes = $_POST['Template'];
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
            $this->loadModel($id)->delete();

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

        $model = new Template('search');

        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['Template']))
            $model->attributes = $_GET['Template'];

        $params = array(
            'model' => $model,
        );

        if($request->isAjaxRequest)
            $this->renderPartial('_grid', $params);
        else
            $this->render('index', $params);

    }

    /**
     * Вверх
     * @param integer $id 
     */
    public function actionUp($id) {


        $model = $this->loadModel($id);

        $model->up();
    }

    /**
     * Вниз
     * @param integer $id 
     */
    public function actionDown($id) {


        $model = $this->loadModel($id);

        $model->down();

    }

    /**
     * Редактирование файла шаблона
     * @param integer $id идентификатор шаблона 
     */
    public function actionEditFile($id) {

        $model = $this->loadModel($id);

        $layout_path = Yiibase::getPathOfAlias('application.views.layouts.' . $model->code) . ".php";

        if (!is_file($layout_path))
            throw new AppException('Файл шаблона не существует');

        if (isset($_POST['tpl'])) {

            file_put_contents($layout_path, $_POST["tpl"]);

            if (empty($_POST["apply"]))
                $this->redirect($_POST["returnUrl"]);

        }

        $tpl = file_get_contents($layout_path);

        $this->render('editfile', array('tpl' => $tpl, 'model' => $model));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Template::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'template-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
