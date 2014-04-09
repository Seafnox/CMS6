<?php

class SectionsController extends AdminController
{

    /**
     * Массив моделей типов данных
     * @var type
     */

    public $iblocksList;


    public function beforeAction($action)
    {

        $this->iblocksList = Iblocks::model()->findAll("active=1");

        return parent::beforeAction($action);

    }


    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {

        $model = $this->loadModel($id);

        if(!Yii::app()->user->checkAccess('readModel', array("model"=>$model)))
            throw new CHttpException(403, 'Forbidden');

        $model->parent_id = 0;

        $parentModel = $model->parent();

        if(is_object($parentModel))
            $model->parent_id = $parentModel->id;

        $this->render('view', array(
            'model' => $model,
            'parent_id' => $model->parent_id
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($parent_id = 0)
    {

        $model = new Section;

        if(!Yii::app()->user->checkAccess('createModel', array("model"=>$model)))
            throw new CHttpException(403, 'Forbidden');

        $model->parent_id = $parent_id;

        if(!empty($_POST['parent_id']))
            $model->parent_id = $_POST['parent_id'];

        $model->active = 1;

        if($model->parent_id != 0) {

            $parentModel = Section::model()->findByPk($model->parent_id);

            $model->controller = $parentModel->controller;

            $model->action = $parentModel->action;

        }


        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);


        if(isset($_POST['Section']))
        {

            $model->attributes=$_POST['Section'];

            if($model->parent_id == 0) {

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

        $this->render('create', array(
            'model' => $model,
            'parent_id' =>$model->parent_id,
           ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public
    function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if(!Yii::app()->user->checkAccess('updateModel', array("model"=>$model)))
            throw new CHttpException(403, 'Forbidden');

        $parentModel = $model->parent()->find();

        $model->parent_id = is_object($parentModel)?$parentModel->id:0;


        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Section'])) {

                $model->attributes = $_POST['Section'];


                if(empty($_POST["parent_id"]) AND $model->parent_id != 0) {
                    $res = $model->moveAsRoot();
                }
                elseif($model->parent_id != $_POST["parent_id"]) {

                    $newParent = Section::model()->findByPk($_POST["parent_id"]);

                    $res = $model->moveAsFirst($newParent);

                } else {

                    $res = $model->saveNode();

                }

                $model->parent_id = $_POST["parent_id"];


                if(empty($_POST["apply"]) AND $res)
                    $this->redirect($_POST['returnUrl']);


        }

        $this->render('update', array(
            'model' => $model,
            'parent_id' =>$model->parent_id,
         ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public
    function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {

            $model = $this->loadModel($id);

            if(!Yii::app()->user->checkAccess('deleteModel', array("model"=>$model)))
                throw new CHttpException(403, 'Forbidden');

            $model->deleteNode();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }



    /**
     * Manages all models.
     */
    public
    function actionIndex($parent_id = 0)
    {

        if($parent_id == 0)
            $model=Section::model()->roots();
        else
            $model=Section::model()->findByPk($parent_id)->children();


        if(!Yii::app()->user->checkAccess('listModels', array("model"=>$model)))
            throw new CHttpException(403, 'Forbidden');

        $permission = $model->getPermission();

        if(is_object($permission))
            $permission->applyConstraint($model);


        $model->setScenario('search');

        $model->unsetAttributes(); // clear any default values

        if (isset($_GET['Section']))
            $model->attributes = $_GET['Section'];


        $params = array(
            'model' => $model,
            'parent_id' => $parent_id,
            'dataProvider' => $model->search()
        );

        if(Yii::app()->request->isAjaxRequest)
            $this->renderPartial('_grid', $params);
        else
            $this->render('index', $params);

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
     * Групповое удаление категорий
     * @throws CHttpException
     */

    public function actionGroupDelete()
    {

        $request = Yii::app()->request;


        if( $request->isPostRequest AND !empty($_POST["items"]))
        {

            $model = new Section('search');

            $model->id = $_POST["items"];

            $dataProvider = $model->search();

            $iterator = new CDataProviderIterator($dataProvider, 50);

            foreach ($iterator as $m) {

                if(Yii::app()->user->checkAccess('deleteModel', array("model"=>$m)))
                    $m->deleteNode();

            }

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if( !$request->isAjaxRequest )
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }


    /**
     * Перемещение категорий по дереву
     * @param int $section_id идентификатор категории в которую осуществляется перенос
     * @param array $items массив идентификаторов категорий которые необходимо переместить
     */

    public function actionReplace($section_id = 0, array $items) {

        if(!empty($items)) {

            $criteria = new CDbCriteria();

            $criteria->compare("id", $items);

            $models = Section::model()->findAll($criteria);

            // Переносим в корень

            if($section_id == 0) {

                foreach($models AS $model) {

                    if(!$model->isRoot() AND Yii::app()->user->checkAccess('updateModel', array("model"=>$model))) {
                        $model->moveAsRoot();
                    }
                }

            } else {


                $newParentModel = Section::model()->findByPk($section_id);

                if($newParentModel)
                    $models = array_reverse($models);
                    foreach($models AS $model) {
                        if(Yii::app()->user->checkAccess('updateModel', array("model"=>$model)))
                            $model->moveAsFirst($newParentModel);
                    }

            }


        }

    }

    /**
     * Возвращает html код для формирования выпадающего списка категорий
     * @param array $items массив id моделей которые необходимо исключить из списка
     */

    public function actionSectionsListHtml(array $items) {


        $list = Section::getListData(0, $items);

        echo CHtml::tag('option', array("value"=>0), Yii::t('app', 'Root'));

        foreach($list AS $k => $v)
            echo CHtml::tag('option', array("value"=>$k), $v);


        Yii::app()->end();

    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public
    function loadModel($id)
    {
        $model = Section::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected
    function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'section-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
