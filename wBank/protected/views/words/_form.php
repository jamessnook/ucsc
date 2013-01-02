<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'words-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'word'); ?>
		<?php echo $form->textField($model,'word',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'word'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pos'); ?>
		<?php echo $form->textField($model,'pos',array('size'=>16,'maxlength'=>16)); ?>
		<?php echo $form->error($model,'pos'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'isPubWord'); ?>
		<?php echo $form->textField($model,'isPubWord'); ?>
		<?php echo $form->error($model,'isPubWord'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lemmaId'); ?>
		<?php echo $form->textField($model,'lemmaId'); ?>
		<?php echo $form->error($model,'lemmaId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'head'); ?>
		<?php echo $form->textField($model,'head',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'head'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'headCnt'); ?>
		<?php echo $form->textField($model,'headCnt'); ?>
		<?php echo $form->error($model,'headCnt'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'polysemyCnt'); ?>
		<?php echo $form->textField($model,'polysemyCnt'); ?>
		<?php echo $form->error($model,'polysemyCnt'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'concrete'); ?>
		<?php echo $form->textField($model,'concrete'); ?>
		<?php echo $form->error($model,'concrete'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'senseNum'); ?>
		<?php echo $form->textField($model,'senseNum'); ?>
		<?php echo $form->error($model,'senseNum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'senseText'); ?>
		<?php echo $form->textField($model,'senseText',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'senseText'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'definition'); ?>
		<?php echo $form->textField($model,'definition',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'definition'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'synsetId'); ?>
		<?php echo $form->textField($model,'synsetId'); ?>
		<?php echo $form->error($model,'synsetId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'posHeadCnt'); ?>
		<?php echo $form->textField($model,'posHeadCnt'); ?>
		<?php echo $form->error($model,'posHeadCnt'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'wordNetId'); ?>
		<?php echo $form->textField($model,'wordNetId'); ?>
		<?php echo $form->error($model,'wordNetId'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->