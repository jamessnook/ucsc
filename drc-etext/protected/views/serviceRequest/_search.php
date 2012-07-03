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
		<?php echo $form->label($model,'term_id'); ?>
		<?php echo $form->textField($model,'term_id',array('size'=>32,'maxlength'=>32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'class_number'); ?>
		<?php echo $form->textField($model,'class_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'class_section'); ?>
		<?php echo $form->textField($model,'class_section',array('size'=>32,'maxlength'=>32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'session_code'); ?>
		<?php echo $form->textField($model,'session_code',array('size'=>32,'maxlength'=>32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'course_offer_number'); ?>
		<?php echo $form->textField($model,'course_offer_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'course_id'); ?>
		<?php echo $form->textField($model,'course_id',array('size'=>32,'maxlength'=>32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'course_name'); ?>
		<?php echo $form->textField($model,'course_name',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'subject'); ?>
		<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'catalog_nbr'); ?>
		<?php echo $form->textField($model,'catalog_nbr',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'instructor_id'); ?>
		<?php echo $form->textField($model,'instructor_id',array('size'=>32,'maxlength'=>32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'instructor_cruzid'); ?>
		<?php echo $form->textField($model,'instructor_cruzid',array('size'=>32,'maxlength'=>32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'student_id'); ?>
		<?php echo $form->textField($model,'student_id',array('size'=>60,'maxlength'=>64)); ?>
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
		<?php echo $form->label($model,'type_name'); ?>
		<?php echo $form->textField($model,'type_name',array('size'=>32,'maxlength'=>32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'effective_date'); ?>
		<?php echo $form->textField($model,'effective_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'last_changed'); ?>
		<?php echo $form->textField($model,'last_changed'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'last_changed_by'); ?>
		<?php echo $form->textField($model,'last_changed_by',array('size'=>32,'maxlength'=>32)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->