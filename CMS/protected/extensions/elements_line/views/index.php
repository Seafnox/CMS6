<?

$attrs = null;

foreach ($htmlOptions AS $k => $v)
    $attrs .= ' '.$k . '="' . $v . '"';

?>

<ul<?=$attrs?>>

    <?foreach($models AS $model):

        $url = Yii::app()->createUrl("fronted/elements", array("section_url"=>$sectionUrl, "element_code"=>$model->code, "iblock_code"=>$model->getIblock()->code));

        ?>

        <li><a href="<?=$url?>"><?=$model->title?></a></li>

    <?endforeach;?>

</ul>