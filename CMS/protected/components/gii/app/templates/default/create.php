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
	Yii::t('app', 'Create'),
);\n";
?>

$this->menu=array(
array('label'=>Yii::t('app', 'Manage'),'url'=>array('index')),
);
?>

<h1><?php echo "<?php echo Yii::t('app', 'Create'); ?>"?> <?php echo  "<?php echo Yii::t('app', '".$this->modelClass."'); ?>"; ?></h1>

<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>
