<?php

/**
 * Базовый контроллер разделов котрыми может управлять только суперпользователь
 */
class RootController extends AdminController {

      

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
  
    public function accessRules() {
        return array(
            array('allow',
                'roles' => array(Yii::app()->authManager->getRootRole()),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

}