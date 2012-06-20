<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'book-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'global_id'); ?>
		<?php echo $form->textField($model,'global_id'); ?>
		<?php echo $form->error($model,'global_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_type'); ?>
		<?php echo $form->textField($model,'id_type',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'id_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>512)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'author'); ?>
		<?php echo $form->textField($model,'author',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'author'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'edition'); ?>
		<?php echo $form->textField($model,'edition',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'edition'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_complete'); ?>
		<?php echo $form->checkBox($model,'is_complete'); ?>
		<?php echo $form->error($model,'is_complete'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_viewable'); ?>
		<?php echo $form->checkBox($model,'is_viewable'); ?>
		<?php echo $form->error($model,'is_viewable'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->