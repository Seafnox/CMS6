<?php

/**
 * Контроллер элементов инфоблоков 
 */

class IelementsController extends AdminController
{
    
	
    /**
     * Имя класса модели
     * @var string 
     */
    
    public $model_class;
   

    
    public $properties = array();
    
    
        public function init() {

            $model_class = Yii::app()->request->getParam("model");
            
            if( empty($model_class) ) {
                
                throw new AppException( Yii::t('app', 'Missing parametrs') );
                
            }
            
            $this->model_class = $model_class;

            return parent::init();
            
        }
    

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{

        $model_class = $this->model_class;

		$model=new $model_class;

        if(!Yii::app()->user->checkAccess('createModel', array("model"=>$model)))
            throw new CHttpException(403, 'Forbidden');

        $model->active = 1;

		// AJAX валидация
		$this->performAjaxValidation($model);

		if(isset($_POST[$model_class]))
		{
			$model->attributes=$_POST[$model_class];

            if ( $model->save() ) {

                if(empty($_POST["apply"]))
                    $this->redirect($_POST["returnUrl"]);
                else
                    $this->redirect(array('update', 'id' => $model->id, 'model'=>$model_class, 'returnUrl' => $_POST["returnUrl"]));

            }

        } elseif(isset($_GET[$model_class])) { // Устанавливаем значения по умолчанию при создании модели

            $model->attributes=$_GET[$model_class];

        }

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{

        $model_class = $this->model_class;

		$model=$this->loadModel($id);

        if(!Yii::app()->user->checkAccess('updateModel', array("model"=>$model)))
            throw new CHttpException(403, 'Forbidden');

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST[$model_class]))
		{
			$model->attributes=$_POST[$model_class];

            $save = $model->save();

            if($save AND empty($_POST["apply"]))
				$this->redirect($_POST["returnUrl"]);
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
        $request = Yii::app()->request;

		if( $request->isPostRequest )
		{

            $model = $this->loadModel($id);

            if(!Yii::app()->user->checkAccess('deleteModel', array("model"=>$model)))
                throw new CHttpException(403, 'Forbidden');

            $model->delete();

            $model_class = $this->model_class;

			if( !$request->isAjaxRequest )
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index', 'model'=>$model_class));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

    /**
     * Возвращает атрибуты модели переданные в запросе для фильтрации элементов над котрыми нужно выполнить действие
     * @return array
     */

    protected function getAttrsFromRequest() {


        $model_class = $this->model_class;

        $attrs = array();

        if(empty($_POST["all-selected"]) AND !empty($_POST["items"])) // Только отмеченные записи
            $attrs["id"] = $_POST["items"];
        elseif(!empty($_POST["all-selected"]) AND !empty($_POST[$model_class])) // Все отфильтрованные записи
            $attrs = $_POST[$model_class];

        return $attrs;

    }


    /**
     * Групповое удаление элементов
     * @throws CHttpException
     */

    public function actionGroupDelete()
    {

        $request = Yii::app()->request;

        $model_class = $this->model_class;

        if( $request->isPostRequest AND !empty($_POST[$model_class]))
        {

            $model = new $model_class('search');

            $attrs = $this->getAttrsFromRequest();

            if(!empty($attrs)) {

                $model->attributes = $attrs;

                $model->deleteAllRecords();

            }

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if( !$request->isAjaxRequest )
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Привязка моделей к категории
     * @throws CHttpException
     */

    public function actionLinkSection($id) {

        $request = Yii::app()->request;

        $model_class = $this->model_class;

        if( $request->isPostRequest AND !empty($_POST[$model_class]))
        {

            $model = new $model_class('search');

            $attrs = $this->getAttrsFromRequest();

            if(!empty($attrs)) {

                $attrs["id"] = $_POST["items"];

                $model->attributes = $attrs;

                $model->linkSection($id);

            }

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if( !$request->isAjaxRequest )
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');

    }

    /**
     * Перенос моделей в категорию
     * @throws CHttpException
     */

    public function actionReplaceSection($id) {

        $request = Yii::app()->request;

        $model_class = $this->model_class;

        if( $request->isPostRequest AND !empty($_POST[$model_class]))
        {

            $model = new $model_class('search');

            $attrs = $this->getAttrsFromRequest();

            if(!empty($attrs)) {

                $attrs["id"] = $_POST["items"];

                $model->attributes = $attrs;

                $model->replaceSection($id);

            }

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if( !$request->isAjaxRequest )
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');

    }


	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
        $model_class = $this->model_class;

		$model=new $model_class('search');

        if(!Yii::app()->user->checkAccess('listModels', array("model"=>$model)))
            throw new CHttpException(403, 'Forbidden');

        $permission = $model->getPermission();

        if(is_object($permission))
            $permission->applyConstraint($model);

        $model->unsetAttributes();  // clear any default values

        if(isset($_GET[$model_class]))
			$model->attributes=$_GET[$model_class];

        $params = array(
            'model'=>$model,
            'dataProvider'=>$model->search()
        );

        if(Yii::app()->request->isAjaxRequest)
            $this->renderPartial('_grid', $params);
        else
            $this->render('index', $params);

    }

    /**
     * Асинхронное редактирование свойств
     */


    public function actionEdit() {

        $request = Yii::app()->request;

        if($request->isPostRequest) {

            Yii::import('bootstrap.widgets.TbEditableSaver');

            $model_class = $this->model_class;

            $es = new TbEditableSaver($model_class);

            $es->attachEventHandler('onBeforeUpdate', function($event) {

                $model = $event->sender->model;

                if(!Yii::app()->user->checkAccess('updateModel', array("model"=>$model)))
                    throw new CHttpException(403, 'Forbidden');


            });

            $es->update();

        }


    }


    /**
     * Формирует массив параметров для передачи действиям контроллера
     * @return array
     */

    public function buildActionUrlParams() {

        $model_class =  $this->model_class;

        $request = Yii::app()->request;

        $extend = $request->getQuery('extend'); // массив ключей наследуемых параметров

        $modelParams = $request->getQuery($model_class);

        $arr["model"] =  $model_class;

        if(is_array($modelParams) AND is_array($extend)) {

            $arr['extend'] = $extend;

            foreach($modelParams AS $k => $v) {

                if(in_array($k, $extend))
                    $arr[$model_class][$k] = $v;


            }


        }

        return $arr;

    }


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
        $model_class =  $this->model_class;
                
		$model= $model_class::model()->findByPk($id);
                
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='iblock-element-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
