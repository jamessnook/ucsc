<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'word'); ?>
		<?php echo $form->textField($model,'word',array('size'=>60,'maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pos'); ?>
		<?php echo $form->textField($model,'pos',array('size'=>16,'maxlength'=>16)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'isPubWord'); ?>
		<?php echo $form->textField($model,'isPubWord'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lemmaId'); ?>
		<?php echo $form->textField($model,'lemmaId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'head'); ?>
		<?php echo $form->textField($model,'head',array('size'=>60,'maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'headCnt'); ?>
		<?php echo $form->textField($model,'headCnt'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'polysemyCnt'); ?>
		<?php echo $form->textField($model,'polysemyCnt'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'concrete'); ?>
		<?php echo $form->textField($model,'concrete'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'senseNum'); ?>
		<?php echo $form->textField($model,'senseNum'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'senseText'); ?>
		<?php echo $form->textField($model,'senseText',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'definition'); ?>
		<?php echo $form->textField($model,'definition',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'synsetId'); ?>
		<?php echo $form->textField($model,'synsetId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'posHeadCnt'); ?>
		<?php echo $form->textField($model,'posHeadCnt'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'wordNetId'); ?>
		<?php echo $form->textField($model,'wordNetId'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->