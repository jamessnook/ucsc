<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'request-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'term_id'); ?>
		<?php echo $form->textField($model,'term_id',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'term_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'class_id'); ?>
		<?php echo $form->textField($model,'class_id',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'class_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'department'); ?>
		<?php echo $form->textField($model,'department',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'department'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'course'); ?>
		<?php echo $form->textField($model,'course',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'course'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'section'); ?>
		<?php echo $form->textField($model,'section',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'section'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'instructor_id'); ?>
		<?php echo $form->textField($model,'instructor_id',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'instructor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type_id'); ?>
		<?php echo $form->textField($model,'type_id'); ?>
		<?php echo $form->error($model,'type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'course_name'); ?>
		<?php echo $form->textField($model,'course_name',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'course_name'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->