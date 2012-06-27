<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('term_id')); ?>:</b>
	<?php echo CHtml::encode($data->term_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('class_id')); ?>:</b>
	<?php echo CHtml::encode($data->class_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('course')); ?>:</b>
	<?php echo CHtml::encode($data->course); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('section')); ?>:</b>
	<?php echo CHtml::encode($data->section); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('course_id')); ?>:</b>
	<?php echo CHtml::encode($data->course_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('session_code')); ?>:</b>
	<?php echo CHtml::encode($data->session_code); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('course_name')); ?>:</b>
	<?php echo CHtml::encode($data->course_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subject')); ?>:</b>
	<?php echo CHtml::encode($data->subject); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('catalog_nbr')); ?>:</b>
	<?php echo CHtml::encode($data->catalog_nbr); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instructor_id')); ?>:</b>
	<?php echo CHtml::encode($data->instructor_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('student_id')); ?>:</b>
	<?php echo CHtml::encode($data->student_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
	<?php echo CHtml::encode($data->username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type_name')); ?>:</b>
	<?php echo CHtml::encode($data->type_name); ?>
	<br />

	*/ ?>

</div>