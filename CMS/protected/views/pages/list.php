<h1><?=$section->title?></h1>

<ul class="items_list">
<?php


$section_url = Yii::app()->createUrl("fronted/sections", array("id"=>$section->id));    

foreach($models As $model):

$link = $section_url.$model->code."/";

?>

    <li>
       
        <h2><a href="<?=$link?>"><?=$model->title?></a></h2>
      
    </li>

<?php
    
endforeach;
?>
       
</ul>

<?php $this->widget('CLinkPager', array(
    'pages' => $pages,
    'header' => '',
    'cssFile' => Yii::app()->baseUrl.'/css/rpn/pager.css'
)) ?>
