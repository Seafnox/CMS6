<?php

Yii::import('gii.generators.crud.CrudGenerator');

/**
 *## Class AppGenerator
 *
 */

class AppGenerator extends CrudGenerator
{
	public $codeModel = 'application.components.gii.app.AppCode';
}