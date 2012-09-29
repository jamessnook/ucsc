<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'drc-request-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'term_code'); ?>
		<?php echo $form->textField($model,'term_code'); ?>
		<?php echo $form->error($model,'term_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'class_number'); ?>
		<?php echo $form->textField($model,'class_number'); ?>
		<?php echo $form->error($model,'class_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'emplId'); ?>
		<?php echo $form->textField($model,'emplId',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'emplId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'accommodation_type'); ?>
		<?php echo $form->textField($model,'accommodation_type',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'accommodation_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'effective_date'); ?>
		<?php echo $form->textField($model,'effective_date'); ?>
		<?php echo $form->error($model,'effective_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
		<?php echo $form->error($model,'created'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->