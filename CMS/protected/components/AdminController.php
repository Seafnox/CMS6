<?php

/**
 * Базовый контроллер админки
 */
class AdminController extends CController
{

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/admin';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    /**
     * Меню доступных типов данных
     * @var array
     */

    public $iblocks_menu = array();


    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'roles' => array('root', 'admin'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }


    public function init()
    {


        if (Yii::app()->request->isAjaxRequest) {

            $this->layout = '//layouts/clear';

        }

        $this->loadIblocksMenu();

        return parent::init();
    }

    protected function loadIblocksMenu()
    {

        /*$iblocks = Iblocks::model()->findAll("active = :active", array(":active" => 1));

        foreach ($iblocks AS $iblock) {

            $model_class=Iblocks::getModelName($iblock->code);

            $model = new $model_class;

            if(!Yii::app()->user->checkAccess('listModels', array("model"=>$model)))
                continue;

            if (!empty($iblock->backend_controller)) {

                $this->iblocks_menu[] = array("label" => $iblock->title, 'icon' => 'folder-open', 'url' => array(strtolower($iblock->backend_controller)));

            } else {

                $this->iblocks_menu[] = array("label" => $iblock->title, 'icon' => 'folder-open', 'url' => array('/iblocks/admin/ielements', 'model' => $model_class));


            }

        }*/


        $itypes = Itypes::model()->findAll(array("order"=>"t.title asc", "with"=>"iblocks"));


        foreach($itypes AS $itype) {


            $arr = array("title"=>$itype->title, "items"=>array(), "opend"=>false);

            $iblocks = $itype->iblocks;


            foreach($iblocks AS $iblock) {

                $model_class=Iblocks::getModelName($iblock->code);

                $model = new $model_class;

                if(!Yii::app()->user->checkAccess('listModels', array("model"=>$model)))
                    continue;

                if(!$arr["opend"] AND $model_class == Yii::app()->request->getParam("model"))
                    $arr["opend"] = true;

                $arr["classes"][] = $model_class;

                if (!empty($iblock->backend_controller)) {

                    $arr["items"][] = array("label" => $iblock->title, 'icon' => 'folder-open', 'url' => array(strtolower($iblock->backend_controller)));

                } else {

                    $arr["items"][] = array("label" => $iblock->title, 'icon' => 'folder-open', 'url' => array('/iblocks/admin/ielements', 'model' => $model_class));


                }



            }

            $this->iblocks_menu[] = $arr;

        }


    }


    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     *Обрабатываем выходной поток
     * @param string $output
     * @return boolen
     */

    public function processOutput($output)
    {

        if (YII_DEBUG == false AND Yii::app()->getRequest()->isAjaxRequest) {

            // Вырезаем переводы строк, символы табуляции, лишние пробелы

            $output = str_replace("\t", "", $output);
            $output = str_replace("\r", "", $output);
            $output = str_replace("\n", "", $output);
            $output = preg_replace("/\s{2,}/i", " ", $output);

        }

        return parent::processOutput($output);

    }

    /**
     * Возвращает массив для формирования левого меню системы управления
     * @return array
     */

    public function getLeftMenuArray()
    {

        $items = array();

        $items[] = array('label' => Yii::t('app', 'Menu'), 'icon' => 'list', 'url' => array('/main/admin/menu/'));
        $items[] = array('label' => Yii::t('app', 'Sections'), 'icon' => 'folder-open', 'url' => array('/main/admin/sections/'));
        $items[] = array('label' => Yii::t('app', 'Users'), 'icon' => 'user', 'url' => array('/main/admin/users/'));
        $items[] = array('label' => Yii::t('app', 'Include Areas'), 'icon' => 'list', 'url' => array('/main/admin/includeareas/'));

        if (Yii::app()->user->checkAccess('rootOperation')) {
            $items[] = array('label' => Yii::t('app', 'Permissions'), 'icon' => 'hand-right', 'url' => array('/main/admin/permission/'));
            $items[] = array('label' => Yii::t('app', 'Iblock types'), 'icon' => 'tag', 'url' => array('/iblocks/admin/itypes/'));
            $items[] = array('label' => Yii::t('app', 'Iblocks'), 'icon' => 'list', 'url' => array('/iblocks/admin/iblocks/'));
            $items[] = array('label' => Yii::t('app', 'Templates'), 'icon' => 'th-list', 'url' => array('/main/admin/templates/'));
            $items[] = array('label' => Yii::t('app', 'Tools'), 'icon' => 'wrench', 'url' => array('/main/admin/tools/'));
            $items[] = array('label' => Yii::t('app', 'Config'), 'icon' => 'cog', 'url' => array('/main/admin/config/'));
        }

        if(Yii::app()->user->checkAccess('useFileManager'))
            $items[] = array('label' => Yii::t('app', 'File manager'), 'icon' => 'file', 'url' => array('/main/admin/elfinder/'));

        return $items;

    }


}