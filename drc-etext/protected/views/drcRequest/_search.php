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
		<?php echo $form->label($model,'term_code'); ?>
		<?php echo $form->textField($model,'term_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'class_number'); ?>
		<?php echo $form->textField($model,'class_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'emplId'); ?>
		<?php echo $form->textField($model,'emplId',array('size'=>32,'maxlength'=>32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'accommodation_type'); ?>
		<?php echo $form->textField($model,'accommodation_type',array('size'=>32,'maxlength'=>32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'effective_date'); ?>
		<?php echo $form->textField($model,'effective_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->