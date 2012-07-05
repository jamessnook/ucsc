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
		<?php echo $form->label($model,'request_id'); ?>
		<?php echo $form->textField($model,'request_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model->request,'username'); ?>
		<?php echo $form->textField($model->request,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model->request,'term_id'); ?>
		<?php echo $form->textField($model->request,'term_id'); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model->request,'subject'); ?>
		<?php echo $form->textField($model->request,'subject'); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model->request,'course_name'); ?>
		<?php echo $form->textField($model->request,'course_name'); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model->request,'accommodation_type'); ?>
		<?php echo $form->textField($model->request,'accommodation_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'global_id'); ?>
		<?php echo $form->textField($model,'global_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_type'); ?>
		<?php echo $form->textField($model,'id_type',array('size'=>32,'maxlength'=>32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>512)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'author'); ?>
		<?php echo $form->textField($model,'author',array('size'=>60,'maxlength'=>128)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_complete'); ?>
		<?php echo $form->checkBox($model,'is_complete'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'has_zip_file'); ?>
		<?php echo $form->checkBox($model,'has_zip_file'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->