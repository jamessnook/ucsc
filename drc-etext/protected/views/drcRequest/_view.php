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

	<b><?php echo CHtml::encode($data->getAttributeLabel('emplId')); ?>:</b>
	<?php echo CHtml::encode($data->emplId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
	<?php echo CHtml::encode($data->username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('accommodation_type')); ?>:</b>
	<?php echo CHtml::encode($data->accommodation_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('effective_date')); ?>:</b>
	<?php echo CHtml::encode($data->effective_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode($data->created); ?>
	<br />

	*/ ?>

</div>