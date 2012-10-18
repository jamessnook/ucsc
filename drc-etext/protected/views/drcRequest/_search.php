<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'term_code'); ?>
		<?php echo $form->textField($model,'term_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'class_num'); ?>
		<?php echo $form->textField($model,'class_num'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'emplid'); ?>
		<?php echo $form->textField($model,'emplid',array('size'=>32,'maxlength'=>32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'type'); ?>
		<?php echo $form->textField($model,'type',array('size'=>32,'maxlength'=>32)); ?>
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