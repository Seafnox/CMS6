<h1><?= $model->title ?></h1>
<?
if (!empty($model->image)):
    $img = $model->getFirstFilePath();
    $img_full = $model->getFirstFileRelPath();
    ?>
    <a href="<?= $img_full ?>"><img src="<?= ImageResizer::r($img, 320) ?>" alt="" class="img-polaroid img-rounded" style="float: left; margin: 0 10px 10px 0" /></a>
<? endif; ?>

<?= $model->text ?>

<p><?= $model->date?></p>

<div class="clear"></div>

 <?php $this->widget('ext.photogallery.PhotogalleryWidget',array(
            'model'=>$model,
            'ri' => true,
            'attr'=>'image',
            'width'=>array(180, 81),
            'height'=>array(120, 120),
            'crop'=>1,
            'skip_first'=>true,
));
        
?>

<p><a href="#" onClick="history.back(-1); return false;">&larr; назад</a></p>