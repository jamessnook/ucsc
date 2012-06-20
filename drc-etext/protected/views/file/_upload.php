<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'file-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'path'); ?>
		<?php echo $form->textField($model,'path',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'path'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'notes'); ?>
		<?php echo $form->textField($model,'notes',array('size'=>60,'maxlength'=>1000)); ?>
		<?php echo $form->error($model,'notes'); ?>
	</div>

	<?php 
		$allowedTypes = implode('|', CHtml::listData(FileType::model()->findAll(), 'id', 'name'));
		$this->widget('CMultiFileUpload', array(
	                'name' => 'files',
	                'accept' => $allowedTypes, // useful for verifying files
	                //'accept' => 'jpeg|jpg|gif|png|doc|docx|pdf|txt', // useful for verifying files
					//'duplicate' => 'Duplicate file!', // useful, i think
	                'denied' => 'Invalid file type', // useful, i think
	            ));
	?>        
            
	<div class="row buttons">
		<?php echo CHtml::submitButton('Upload Selected Files'); ?>
	</div>


<?php $this->endWidget(); ?>

            
</div><!-- form -->

