<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('iblock_id')); ?>:</b>
	<?php echo CHtml::encode($data->iblock_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('field')); ?>:</b>
	<?php echo CHtml::encode($data->field); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('data_code')); ?>:</b>
	<?php echo CHtml::encode($data->data_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('list_code')); ?>:</b>
	<?php echo CHtml::encode($data->list_code); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('show_in_list')); ?>:</b>
	<?php echo CHtml::encode($data->show_in_list); ?>
	<br />

	*/ ?>

</div>