<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('author')); ?>:</b>
	<?php echo CHtml::encode($data->author); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('publisher')); ?>:</b>
	<?php echo CHtml::encode($data->publisher); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('year_published')); ?>:</b>
	<?php echo CHtml::encode($data->year_published); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('edition')); ?>:</b>
	<?php echo CHtml::encode($data->edition); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('isbn')); ?>:</b>
	<?php echo CHtml::encode($data->isbn); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('poster_id')); ?>:</b>
	<?php echo CHtml::encode($data->poster_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('post_date')); ?>:</b>
	<?php echo CHtml::encode($data->post_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('format_id')); ?>:</b>
	<?php echo CHtml::encode($data->format_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_complete')); ?>:</b>
	<?php echo CHtml::encode($data->is_complete); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_viewable')); ?>:</b>
	<?php echo CHtml::encode($data->is_viewable); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	*/ ?>

</div>