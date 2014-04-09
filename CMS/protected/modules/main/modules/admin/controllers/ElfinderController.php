<?
class ElfinderController extends AdminController
{

    public function init() {

        if(!Yii::app()->user->checkAccess('useFileManager'))
            throw new CHttpException(403, 'Forbidden');

        parent::init();

    }


    public function actions()
    {
        return array(
            'connector' => array(
                'class' => 'ext.elfinder.ElFinderConnectorAction',
                'settings' => array(
                    'root' => Yii::getPathOfAlias('webroot') . '/userfiles/',
                    'URL' => Yii::app()->baseUrl . '/userfiles/',
                    'rootAlias' => 'Home',
                    'mimeDetect' => 'none'
                )
            ),
        );
    }


    public function actionIndex() {

        $this->render("index");

    }

}

?>