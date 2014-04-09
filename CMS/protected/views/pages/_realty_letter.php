<ul>
<?php

$sdelki = array('arenda', 'pokupka', 'prodazha', 'obmen');

$attrs = $model->getAttributes();

$selected_sdelki = array();

foreach($sdelki AS $s) {
 
   if(!empty($attrs[$s]))
    $selected_sdelki[] = mb_strtolower ( $model->getAttributeLabel($s), 'utf-8' );
}


?>
<h1>Пользователь хочет: <?=implode(', ', $selected_sdelki)?></h1>
<?
foreach($attrs AS $key => $value) {

    if(empty($value) OR in_array($key, $sdelki)) continue;
    
    if($key == 'region_id') {
        
        $m = TypeRegion::model()->findByPk($value);
        
        $value = $m->title;
        
    }
    
     if($key == 'area_id') {
        
        $m = TypeArea::model()->findByPk($value);
        
        $value = $m->title;
        
    }
    
      if($key == 'section') {
        
        $m = Section::model()->findByPk($value);
        
        $value = $m->title;
        
    }
    
       if($key == 'sub_section') {
        
        $m = Section::model()->findByPk($value);
        
        $value = $m->title;
        
    }
    
    if($value == 1) $value = "Да";
    
    $label = $model->getAttributeLabel($key);
    
    
 ?>
    
<li><?=$label?>: <?=$value?></li>


<?
    
}
?>

</ul>
