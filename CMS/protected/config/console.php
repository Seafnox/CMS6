<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.

include("custom.php");

$systemConf = array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),
    
        'import'=>array(
		'application.models.*',
		'application.components.*',
                'application.components.search.*',
         ),

	// application components
	'components'=>array(
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),

    'params' => array(
        'adminEmail' => 'webadmin87@gmail.com',
        'savePathAlias' => 'webroot.userfiles', // Папка для сохранения пользовательских файлов
        'savePathRedactorAlias' => 'webroot.userfiles.redactor', // Папка для сохранения пользовательских файлов загруженных через редактор
        'cacheThumbAlias' => 'webroot.cache.thumb', // Папка для сохранения кэша резайзенных изображений
        'maxImgWidth' => '800', // Максимальная ширина загружаемого изображения
        'maxImgHeight' => '800', // Максимальная высота загружаемого изображения
        'maxFileSize' => 3, // Максимальный размер загружаемого файла в мегабайтах
        'verifyCode' => 515943155, // Код проверки
        'sendmailer' => array( // Настройки отправки писем
            'from_text' => 'Сообщение с сайта',
            'from_mail' => 'info@rznc.ru',
        ),
    ),
    
);

return  CMap::mergeArray($systemConf, $customConf);