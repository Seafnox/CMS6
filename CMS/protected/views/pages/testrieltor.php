<h1>Сертифицированные агенты и брокеры</h1>

<h2>Компании входящие в состав РПН</h2>

<?php

$section =  Yii::app()->params["request_object"];

$sort_org_conf =  array('route'=>'fronted/sections', 'params'=>array("id"=>$section->id), 'defaultOrder'=>'title asc');

$sort_r_conf =  array('route'=>'fronted/sections', 'params'=>array("id"=>$section->id), 'defaultOrder'=>'fio asc');

$route_conf =  array('route'=>'fronted/sections', 'params'=>array("id"=>$section->id));


$dataProviderOrg = $model_o->search();

$dataProviderOrg->sort = $sort_org_conf;

$dataProviderOrg->pagination = $route_conf;


$dataProviderRealtor = $model_r->search();

$dataProviderRealtor->sort = $sort_r_conf;

$dataProviderRealtor->pagination = $route_conf;


$this->widget('zii.widgets.grid.CGridView',array(
	'id'=>'type-orgs-grid',
       // 'ajaxUpdate'=>false,
    	'dataProvider'=>$dataProviderOrg,
        //'enableHistory'=>true,
        'afterAjaxUpdate'=>'function() { $("body").trigger("content-updated"); }',
       	'filter'=>$model_o,
	'columns'=>array(
            array(
                 'name'=>'image',
                 'type'=>'raw',
                 'filter'=>false,
                'sortable'=>false,
                 'value'=>'!empty($data->image)?"<div class=\"img-bl\"><a href=\"".$data->getFirstFileRelPath()."\"><img src=\"".ImageResizer::ri($data->getFirstFilePath(), array(96, 0), array(0, 96), 1)."\" /></a></div>":"<img src=\"/images/rpn/nofoto.jpg\" />"'
           ), 
           'title',
           'sert',
           'srok',
           'address',
       	),
        
)); ?>

<h2>Аттестованные риэлторы</h2>

<?php

$this->widget('zii.widgets.grid.CGridView',array(
	'id'=>'type-realtors-grid',
       // 'ajaxUpdate'=>false,
    	'dataProvider'=>$dataProviderRealtor,
        //'enableHistory'=>true,
        'afterAjaxUpdate'=>'function() { $("body").trigger("content-updated"); }',
       	'filter'=>$model_r,
	'columns'=>array(
           array(
                 'name'=>'image',
                 'type'=>'raw',
                 'filter'=>false,
               'sortable'=>false,
                 'value'=>'!empty($data->image)?"<a href=\"".$data->getFirstFileRelPath()."\"><img src=\"".ImageResizer::r($data->getFirstFilePath(), 100)."\" /></a>":"<img src=\"/images/rpn/nofoto2.jpg\" />"'
           ),
           'fio',
           array(
                    'name'=>'org_id',
                    'filter' => CHtml::listData(TypeOrgs::model()->findAll(), 'id', 'title'),
                    'value'=>'$data->org->title',
            ),
           'post',
           'attestat',
           'valid_to', 
           array(
               'type'=>'html',
               'filter'=>false,
               'value'=>'"<img src=\"/images/rpn/znaki/logo1.jpg\" align=\"left\" /><img src=\"/images/rpn/znaki/logo2.jpg\" align=\"left\" /><img src=\"/images/rpn/znaki/logo3.jpg\" align=\"left\" />"'
               
           ), 
       ),
   
    
)); 
  
?>
