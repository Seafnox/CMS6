<?php

class UsersController extends AdminController
{

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */

    public function actionView($id)
    {

        $model = User::model()->findByPk($id);

        if(!Yii::app()->user->checkAccess('readModel', array("model"=>$model)))
            throw new CHttpException(403, 'Forbidden');

        $this->render('view', array(
            'model' => $model,
        ));

    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */

    public function actionCreate()
    {

        $model = new User;

        if(!Yii::app()->user->checkAccess('createModel', array("model"=>$model)))
            throw new CHttpException(403, 'Forbidden');

        $model->role = $model->defaultRole;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];

            if ($model->save()) {

                if(empty($_POST["apply"]))
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

        //проверяем, можно ли пользователю изменять роль

        if (isset($_POST['Users']['role']) && !Yii::app()->user->checkAccess('changeRole', array("model"=>$model)))
            throw new CHttpException(403, 'Forbidden');


        if(!Yii::app()->user->checkAccess('updateModel', array("model"=>$model)))
            throw new CHttpException(403, 'Forbidden');

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {

            $model->attributes = $_POST['User'];

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

        $model = $this->loadModel($id);

        if(!Yii::app()->user->checkAccess('deleteModel', array("model"=>$model)))
            throw new CHttpException(403, 'Forbidden');


        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $model->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }


    /**
     * Manages all models.
     */
    public function actionIndex()
    {

       $model = new User('search');

        if(!Yii::app()->user->checkAccess('listModels', array("model"=>$model)))
            throw new CHttpException(403, 'Forbidden');

        $permission = $model->getPermission();

        if(is_object($permission))
            $permission->applyConstraint($model);

        $model->unsetAttributes(); // clear any default values

        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];


        $params = array(
            'model' => $model,
        );

        if(Yii::app()->request->isAjaxRequest) {

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
        $model = User::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
