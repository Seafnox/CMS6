<h1><?=$section->title?></h1>

<?php

$sectionUrl = Yii::app()->createUrl('fronted/sections', array("id"=>$section->id));


$this->widget('bootstrap.widgets.TbListView', array(
    'dataProvider'=>$dataProvider,
    'ajaxUpdate' => false,
    'itemView'=>'_view',
    'viewData'=>array("sectionUrl"=>$sectionUrl)
));

?>
