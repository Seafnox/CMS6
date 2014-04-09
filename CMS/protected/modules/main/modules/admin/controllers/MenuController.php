<?php

/**
 * Class MenuController контроллер управления меню
 */

class MenuController extends AdminController
{


	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        $model=$this->loadModel($id);

        if(!Yii::app()->user->checkAccess('readModel', array("model"=>$model)))
            throw new CHttpException(403, 'Forbidden');

        $parent_id = 0;

        $parentModel = $model->parent();

        if(is_object($parentModel))
            $parent_id = $parentModel->id;

		$this->render('view',array(
			'model'=>$model,
            'parent_id' => $parent_id

		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($parent_id = 0)
	{
		$model=new Menu;

        if(!Yii::app()->user->checkAccess('createModel', array("model"=>$model)))
            throw new CHttpException(403, 'Forbidden');

        $model->active = 1;

        if($parent_id != 0) {

            $parentModel = Menu::model()->findByPk($parent_id);

            $model->code = $parentModel->code;

        }

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Menu']))
		{

			$model->attributes=$_POST['Menu'];

            if($parent_id == 0) {

                $res = $model->saveNode();

            } else {

                $res = $model->appendTo($parentModel);

            }

            if($res) {
                if(empty($_POST["apply"]))
                    $this->redirect($_POST["returnUrl"]);
                else
                    $this->redirect(array('update', 'id' => $model->id, 'returnUrl' => $_POST["returnUrl"]));
            }

        }

		$this->render('create',array(
			'model'=>$model,
            'parent_id'=>$parent_id
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

        if(!Yii::app()->user->checkAccess('updateModel', array("model"=>$model)))
            throw new CHttpException(403, 'Forbidden');

        $parent_id = 0;

        $parentModel = $model->parent();

        if(is_object($parentModel))
            $parent_id = $parentModel->id;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Menu']))
		{
			$model->attributes=$_POST['Menu'];

			if($model->saveNode() AND empty($_POST["apply"]))
				$this->redirect($_POST["returnUrl"]);
		}

		$this->render('update',array(
			'model'=>$model,
            'parent_id' => $parent_id
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
            $model = $this->loadModel($id);

            if(!Yii::app()->user->checkAccess('deleteModel', array("model"=>$model)))
                throw new CHttpException(403, 'Forbidden');

            $model->deleteNode();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex($parent_id = 0)
	{

        $request = Yii::app()->request;

		if($parent_id == 0) {

            $model=Menu::model()->roots();

        } else {

            $parentModel = Menu::model()->findByPk($parent_id);

            $model = $parentModel->children();

        }


        if(!Yii::app()->user->checkAccess('listModels', array("model"=>$model)))
            throw new CHttpException(403, 'Forbidden');

        $permission = $model->getPermission();

        if(is_object($permission))
            $permission->applyConstraint($model);


        $model->setScenario("search");

		$model->unsetAttributes();  // clear any default values

        if(isset($_GET['Menu']))
			$model->attributes=$_GET['Menu'];


        $params = array(
            'model'=>$model,
            'parent_id'=>$parent_id
        );

        if($request->isAjaxRequest)
            $this->renderPartial("_grid", $params);
        else
		    $this->render('index',$params);
	}

    /**
     * Перемещение вверх
     * @param $id идентификатор модели
     * @throws CHttpException
     */

    public function actionUp($id) {

        if(empty($id))
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');

        $model = $this->loadModel($id);

        if(!Yii::app()->user->checkAccess('updateModel', array("model"=>$model)))
            throw new CHttpException(403, 'Forbidden');

        $prevModel = $model->prev()->find();

        if($prevModel)
            $model->moveBefore($prevModel);

    }

    /**
     * Перемещение вниз
     * @param $id идентификатор модели
     * @throws CHttpException
     */

    public function actionDown($id) {

        if(empty($id))
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');

        $model = $this->loadModel($id);

        if(!Yii::app()->user->checkAccess('updateModel', array("model"=>$model)))
            throw new CHttpException(403, 'Forbidden');

        $nextModel = $model->next()->find();

        if($nextModel)
            $model->moveAfter($nextModel);

    }

    /**
     * Асинхронное редактирование свойств
     */


    public function actionEdit() {

        $request = Yii::app()->request;

        if($request->isPostRequest) {

            $model=$this->loadModel($request->getPost("pk"));

            if(!Yii::app()->user->checkAccess('updateModel', array("model"=>$model)))
                throw new CHttpException(403, 'Forbidden');

            $model->{$request->getPost("name")} = $request->getPost("value");

            $model->saveNode();

        }


    }


    /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Menu::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='menu-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
