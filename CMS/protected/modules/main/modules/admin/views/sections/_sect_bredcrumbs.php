<?php

$route = '/main/admin/sections/';

$sect_breadcrumbs = $model->getBredCrumbsArr($parent_id, $route);

$this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$sect_breadcrumbs,
                        'homeLink'=>CHtml::link(Yii::t('app', 'Root'), Yii::app()->getUrlManager()->createUrl($route)),
    )
);

?>
