<?php


Yii::app()->clientScript->registerScriptFile(
    Yii::app()->assetManager->publish(
        __DIR__ . '/../assets/redactor.js'
    ),
    CClientScript::POS_END
);

Yii::app()->clientScript->registerScriptFile(
    Yii::app()->assetManager->publish(
        __DIR__ . '/../assets/ru.js'
    ),
    CClientScript::POS_END
);

Yii::app()->clientScript->registerCssFile(
    Yii::app()->assetManager->publish(
        __DIR__ . '/../assets/redactor.css'
    )
);

Yii::app()->clientScript->registerScript("redactor_loader_" . $htmlOptions["id"], "
 
			$('#" . $htmlOptions["id"] . "').redactor({autoresize: false, lang: 'ru', imageUpload: '/admin/adminservice/upload', fileUpload: '/admin/adminservice/upload'});
		");


echo CHtml::activeLabelEx($model, $name);

echo CHtml::activeTextArea($model, $name, $htmlOptions);

?>
