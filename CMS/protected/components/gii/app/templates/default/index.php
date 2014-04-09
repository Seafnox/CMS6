<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$label = $this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	Yii::t('app', '$label')=>array('index'),
	Yii::t('app', 'Manage'),
);\n";
?>

$this->menu=array(
array('label'=>Yii::t('app', 'Manage'),'url'=>array('index')),
array('label'=>Yii::t('app', 'Create'),'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
var data = $(this).serialize();
if(window.history.pushState)
    window.history.pushState({}, '', '?'+data);
$.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid', {
data: data
});
return false;
});
");

Yii::app()->clientScript->registerScript('group-delete', "


$('.to-delete').on('click', function(e){


bootbox.confirm('".Yii::t('app', 'A you shure?')."', function(conf){


if(conf) {

var qs = $('#<?php echo $this->class2id($this->modelClass); ?>-form').serialize();

var url = '".Yii::app()->createUrl($this->uniqueId."/groupdelete")."';

$.post(url, qs, function(response) {
$.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid');
});

}

})



e.preventDefault();


});



");



?>

<h1><?php echo "<?php echo Yii::t('app', 'Manage'); ?>"?> <?php echo "<?php echo Yii::t('app', '".$this->pluralize($this->class2name($this->modelClass))."'); ?>"; ?></h1>

    <p>
        Вы можете использовать следующие операторы (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
        or <b>=</b>) в начале поискового запроса для уточнения вашего запроса.
    </p>

<?php echo "<?php echo CHtml::link(Yii::t('app', 'Advanced Search'),'#',array('class'=>'search-button btn')); ?>"; ?>

<div class="search-form" style="display:none">
	<?php echo "<?php \$this->renderPartial('_search',array(
	'model'=>\$model,
)); ?>\n"; ?>
</div><!-- search-form -->

<form id="<?php echo $this->class2id($this->modelClass); ?>-form">

<?php echo "<?php \$this->renderPartial('_grid', array('model'=>\$model)); ?>"; ?>

<div class="form-actions form-inline">
    <a class="btn btn-danger to-delete" href="#">Удалить</a>
</div>

</form>