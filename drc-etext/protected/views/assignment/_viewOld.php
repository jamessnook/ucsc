<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('term_code')); ?>:</b>
	<?php echo CHtml::encode($data->term_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('class_number')); ?>:</b>
	<?php echo CHtml::encode($data->class_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('book_id')); ?>:</b>
	<?php echo CHtml::encode($data->book_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode($data->created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified')); ?>:</b>
	<?php echo CHtml::encode($data->modified); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_by')); ?>:</b>
	<?php echo CHtml::encode($data->modified_by); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('notes')); ?>:</b>
	<?php echo CHtml::encode($data->notes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_complete')); ?>:</b>
	<?php echo CHtml::encode($data->is_complete); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('has_zip_file')); ?>:</b>
	<?php echo CHtml::encode($data->has_zip_file); ?>
	<br />

	*/ ?>

</div>