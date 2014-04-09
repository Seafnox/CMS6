<?php

$route = '/main/admin/menu/';

$breadcrumbs = $model->getBredCrumbsArr($parent_id, $route);

$this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$breadcrumbs,
            'homeLink'=>CHtml::link(Yii::t('app', 'Root'), Yii::app()->getUrlManager()->createUrl($route)),
    )
);

?>
