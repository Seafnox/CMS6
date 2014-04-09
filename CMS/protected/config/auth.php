<?php
return array (
  'rootOperation' => 
  array (
    'type' => 0,
    'description' => 'операции суперпользователя',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'useFileManager' => 
  array (
    'type' => 0,
    'description' => 'использование файлового менеджера',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'createModel' => 
  array (
    'type' => 0,
    'description' => 'создание',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'listModels' => 
  array (
    'type' => 0,
    'description' => 'просмотр списка',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'readModel' => 
  array (
    'type' => 0,
    'description' => 'чтение',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updateModel' => 
  array (
    'type' => 0,
    'description' => 'изменение',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'deleteModel' => 
  array (
    'type' => 0,
    'description' => 'удаление',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'createModelTask' => 
  array (
    'type' => 1,
    'description' => 'создание',
    'bizRule' => 'return is_object($params["model"]->getPermission()) AND $params["model"]->getPermission()->createModel();',
    'data' => NULL,
    'children' => 
    array (
      0 => 'createModel',
    ),
  ),
  'listModelsTask' => 
  array (
    'type' => 1,
    'description' => 'просмотр списка',
    'bizRule' => 'return is_object($params["model"]->getPermission()) AND $params["model"]->getPermission()->listModels();',
    'data' => NULL,
    'children' => 
    array (
      0 => 'listModels',
    ),
  ),
  'readModelTask' => 
  array (
    'type' => 1,
    'description' => 'чтение',
    'bizRule' => 'return is_object($params["model"]->getPermission()) AND $params["model"]->getPermission()->readModel($params["model"]);',
    'data' => NULL,
    'children' => 
    array (
      0 => 'readModel',
    ),
  ),
  'updateModelTask' => 
  array (
    'type' => 1,
    'description' => 'изменение',
    'bizRule' => 'return is_object($params["model"]->getPermission()) AND $params["model"]->getPermission()->updateModel($params["model"]);',
    'data' => NULL,
    'children' => 
    array (
      0 => 'updateModel',
    ),
  ),
  'deleteModelTask' => 
  array (
    'type' => 1,
    'description' => 'удаление',
    'bizRule' => 'return is_object($params["model"]->getPermission()) AND $params["model"]->getPermission()->deleteModel($params["model"]);',
    'data' => NULL,
    'children' => 
    array (
      0 => 'deleteModel',
    ),
  ),
  'changeRole' => 
  array (
    'type' => 0,
    'description' => 'изменение роли пользователя',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'user' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'createModelTask',
      1 => 'listModelsTask',
      2 => 'readModelTask',
      3 => 'updateModelTask',
      4 => 'deleteModelTask',
    ),
  ),
  'admin' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'user',
      1 => 'useFileManager',
    ),
  ),
  'root' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'createModel',
      1 => 'readModel',
      2 => 'listModels',
      3 => 'updateModel',
      4 => 'deleteModel',
      5 => 'changeRole',
      6 => 'rootOperation',
      7 => 'useFileManager',
    ),
  ),
);
