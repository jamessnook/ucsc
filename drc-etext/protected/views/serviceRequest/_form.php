<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'service-request-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'term_id'); ?>
        <?php 	$options = CHtml::listData(Term::model()->findAll(), 'id', 'name');
        		echo $form->dropDownList($model,'term_id', $options);
        ?>
		<?php echo $form->error($model,'term_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'class_number'); ?>
		<?php echo $form->textField($model,'class_number'); ?>
		<?php echo $form->error($model,'class_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'class_section'); ?>
		<?php echo $form->textField($model,'class_section',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'class_section'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'session_code'); ?>
		<?php echo $form->textField($model,'session_code',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'session_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'course_offer_number'); ?>
		<?php echo $form->textField($model,'course_offer_number'); ?>
		<?php echo $form->error($model,'course_offer_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'course_id'); ?>
		<?php echo $form->textField($model,'course_id',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'course_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'course_name'); ?>
		<?php echo $form->textField($model,'course_name',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'course_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subject'); ?>
		<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'subject'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'catalog_nbr'); ?>
		<?php echo $form->textField($model,'catalog_nbr',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'catalog_nbr'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'instructor_id'); ?>
		<?php echo $form->textField($model,'instructor_id',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'instructor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'instructor_cruzid'); ?>
		<?php echo $form->textField($model,'instructor_cruzid',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'instructor_cruzid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'student_id'); ?>
		<?php echo $form->textField($model,'student_id',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'student_id'); ?>
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
		<?php echo $form->labelEx($model,'type_name'); ?>
		<?php echo $form->textField($model,'type_name',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'type_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'effective_date'); ?>
		<?php 
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model'=>$model,
			'attribute'=>'effective_date',	    
			//'name'=>'publishDate',
	    	// additional javascript options for the date picker plugin
		    'options'=>array(
		        'showAnim'=>'fold',
		    ),
		    'htmlOptions'=>array(
		        'style'=>'height:20px;'
		    ),
		));
		?>
		<?php echo $form->error($model,'effective_date'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->