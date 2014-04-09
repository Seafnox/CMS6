<?
    $url = Yii::app()->createUrl("fronted/elements", array("section_url"=>$sectionUrl, "element_code"=>$data->code, "iblock_code"=>"news"));
?>
<h3><?=$data->title?></h3>
<p><?=$data->annotation?></p>
<p><?= $data->date?></p>
<p><a href="<?=$url?>">подробнее &rarr;</a></p>
<hr />