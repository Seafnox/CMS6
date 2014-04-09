<?php
class ToolsController extends RootController
{


    public function actionIndex()
    {

        $this->render("index");

    }

    /**
     * Установка ролей
     */


    public function actionInstallRoles()
    {

        $auth = Yii::app()->authManager;

        //сбрасываем все существующие правила

        $auth->clearAll();

        // Административные операции

        $auth->createOperation('rootOperation', 'операции суперпользователя');

        $auth->createOperation('useFileManager', 'использование файлового менеджера');

        //Операции работы с моделями

        $auth->createOperation('createModel', 'создание');
        $auth->createOperation('listModels', 'просмотр списка');
        $auth->createOperation('readModel', 'чтение');
        $auth->createOperation('updateModel', 'изменение');
        $auth->createOperation('deleteModel', 'удаление');


        // Задачи работы с моделями

        $bizRule = 'return is_object($params["model"]->getPermission()) AND $params["model"]->getPermission()->createModel();';
        $task = $auth->createTask('createModelTask', 'создание', $bizRule);
        $task->addChild('createModel');

        $bizRule = 'return is_object($params["model"]->getPermission()) AND $params["model"]->getPermission()->listModels();';
        $task = $auth->createTask('listModelsTask', 'просмотр списка', $bizRule);
        $task->addChild('listModels');

        $bizRule = 'return is_object($params["model"]->getPermission()) AND $params["model"]->getPermission()->readModel($params["model"]);';
        $task = $auth->createTask('readModelTask', 'чтение', $bizRule);
        $task->addChild('readModel');

        $bizRule = 'return is_object($params["model"]->getPermission()) AND $params["model"]->getPermission()->updateModel($params["model"]);';
        $task = $auth->createTask('updateModelTask', 'изменение', $bizRule);
        $task->addChild('updateModel');

        $bizRule = 'return is_object($params["model"]->getPermission()) AND $params["model"]->getPermission()->deleteModel($params["model"]);';
        $task = $auth->createTask('deleteModelTask', 'удаление', $bizRule);
        $task->addChild('deleteModel');


        //Дополнительные операции управления пользователями.

        $auth->createOperation('changeRole', 'изменение роли пользователя');


        // Создание ролей и присвоение операций

        $role = $auth->createRole('user');
        $role->addChild('createModelTask');
        $role->addChild('listModelsTask');
        $role->addChild('readModelTask');
        $role->addChild('updateModelTask');
        $role->addChild('deleteModelTask');

        $role = $auth->createRole('admin');
        $role->addChild('user');
        $role->addChild('useFileManager');

        $role = $auth->createRole('root');
        $role->addChild('createModel');
        $role->addChild('readModel');
        $role->addChild('listModels');
        $role->addChild('updateModel');
        $role->addChild('deleteModel');
        $role->addChild('changeRole');
        $role->addChild('rootOperation');
        $role->addChild('useFileManager');

        //сохраняем роли и операции

        $auth->save();

        echo json_encode(array("page"=>1, "pagesNum"=>1));

        Yii::app()->end();

    }


}

?>