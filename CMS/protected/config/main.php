<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

include("custom.php");

Yii::setPathOfAlias('bootstrap', dirname(__FILE__) . '/../extensions/bootstrap');

$systemConf = array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'RzWebSys6',
    'sourceLanguage' => 'en',
    'language' => 'ru',

    // preloading
    'preload' => array('log', /*'bootstrap', 'ajax_manager'*/),

    // autoloading model and component classes
    'import' => array(
        //'editable.*',
        'application.models.*',
        'application.components.*',
        'application.components.search.*',
        'application.extensions.imgresizer.*',
        'application.extensions.redactorjs.*',
        'application.extensions.remove_files.*',
        'application.modules.main.models.*',
        'application.modules.main.components.*',
        'application.modules.iblocks.models.*',
        'application.modules.iblocks.models.iblocks.*',
        'application.modules.iblocks.components.*'
    ),

    'modules' => array(
        // uncomment the following to enable the Gii tool
        'main' => array('modules' => array('admin')),
        'iblocks' => array('modules' => array('admin')),
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'xh48u56',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1'),
            'preload' => array('bootstrap'), // Подключаем bootstrap к gii
            'components' => array(
                'bootstrap' => array(
                    'class' => 'ext.bootstrap.components.Bootstrap',
                )
            ),
            'generatorPaths' => array(
                'bootstrap.gii',
                'application.components.gii'
            ),
        ),

    ),

    // application components
    'components' => array(

        'userconfig'=>array(

            'class'=>'ConfigAccess',
            'modelClass'=>'Config'

        ),

        'mailer'=>array(

            "class"=>"SendMailer",
            "fromText"=>"Сообщение с сайта",
            "fromMail"=>"info@rznc.ru",


        ),

        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
            'loginUrl' => array('login'),
            'class' => 'WebUser',
        ),

        // uncomment the following to enable URLs in path-format

        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,


            'rules' => array(

                // Правило для админки

                array(
                    'class' => 'application.components.AdminUrlRule',
                    'connectionID' => 'db',
                ),


                // Правило для категорий

                   array(
                      'class' => 'application.components.SectionsUrlRule',
                      'connectionID' => 'db',
                   ),

                // Правило для элементов инфоблоков

                   array(
                      'class' => 'application.components.ElementsUrlRule',
                      'connectionID' => 'db',
                   ),

                // Стандартный роутинг

                /*'rules'=>array(
                    '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<module>/<controller>/<action>',
                    '<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
                    '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                    '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                    '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                ),*/
        ),

        ),

        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning, profile',
                ),

                // uncomment the following to show log messages on web pages

                /*array(
                      'class'=>'CWebLogRoute',
                                      'levels'=>'profile',
                                      'showInFireBug'=>true,
                 ),*/

            ),

        ),

        'cache' => array(
            'class' => 'system.caching.CFileCache',
        ),

        'bootstrap' => array(
            'class' => 'ext.bootstrap.components.Bootstrap', // assuming you extracted bootstrap under extensions
        ),
        'ajax_manager' => array(
            'class' => 'ext.ajax_manager.AjaxManager', // менеджер асинхронных запросов
            'debug' => false
        ),
        'authManager' => array(
            'class' => 'PhpAuthManager',
            'defaultRoles' => array('guest'),
        ),

        'widgetFactory' => array(
            'widgets' => array(
                /*'CLinkPager' => array(
                    'cssFile' => '/css/system/pager.css',
                    'header' => ''
                ),*/
                'CJuiDatePicker' => array(
                    'language' => 'ru',
                ),
                /*'CGridView' => array(
                    'cssFile' => '/css/system/grid.css',
                ),*/
            ),
        ),

    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        'adminEmail' => 'webadmin87@gmail.com',
        'savePathAlias' => 'webroot.userfiles', // Папка для сохранения пользовательских файлов
        'savePathRedactorAlias' => 'webroot.userfiles.redactor', // Папка для сохранения пользовательских файлов загруженных через редактор
        'cacheThumbAlias' => 'webroot.cache.thumb', // Папка для сохранения кэша резайзенных изображений
        'maxImgWidth' => '800', // Максимальная ширина загружаемого изображения
        'maxImgHeight' => '800', // Максимальная высота загружаемого изображения
        'maxFileSize' => 3, // Максимальный размер загружаемого файла в мегабайтах
        'verifyCode' => 515943155, // Код проверки
    ),
);

return CMap::mergeArray($systemConf, $customConf);
