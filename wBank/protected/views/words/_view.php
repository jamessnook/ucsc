<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('word')); ?>:</b>
	<?php echo CHtml::encode($data->word); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pos')); ?>:</b>
	<?php echo CHtml::encode($data->pos); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('isPubWord')); ?>:</b>
	<?php echo CHtml::encode($data->isPubWord); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lemmaId')); ?>:</b>
	<?php echo CHtml::encode($data->lemmaId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('head')); ?>:</b>
	<?php echo CHtml::encode($data->head); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('headCnt')); ?>:</b>
	<?php echo CHtml::encode($data->headCnt); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('polysemyCnt')); ?>:</b>
	<?php echo CHtml::encode($data->polysemyCnt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('concrete')); ?>:</b>
	<?php echo CHtml::encode($data->concrete); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('senseNum')); ?>:</b>
	<?php echo CHtml::encode($data->senseNum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('senseText')); ?>:</b>
	<?php echo CHtml::encode($data->senseText); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('definition')); ?>:</b>
	<?php echo CHtml::encode($data->definition); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('synsetId')); ?>:</b>
	<?php echo CHtml::encode($data->synsetId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('posHeadCnt')); ?>:</b>
	<?php echo CHtml::encode($data->posHeadCnt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('wordNetId')); ?>:</b>
	<?php echo CHtml::encode($data->wordNetId); ?>
	<br />

	*/ ?>

</div>