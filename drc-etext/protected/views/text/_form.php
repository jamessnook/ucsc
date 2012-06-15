<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'text-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

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
		<?php echo $form->labelEx($model,'publisher'); ?>
		<?php echo $form->textField($model,'publisher',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'publisher'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'year_published'); ?>
		<?php echo $form->textField($model,'year_published'); ?>
		<?php echo $form->error($model,'year_published'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'edition'); ?>
		<?php echo $form->textField($model,'edition',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'edition'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'isbn'); ?>
		<?php echo $form->textField($model,'isbn',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'isbn'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'format_id'); ?>
        <?php 	$options = CHtml::listData(Format::model()->findAll(), 'id', 'name');
        		echo $form->dropDownList($model,'format_id', $selected, $options);
        ?>
		<?php echo $form->error($model,'format_id'); ?>
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

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>512)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->