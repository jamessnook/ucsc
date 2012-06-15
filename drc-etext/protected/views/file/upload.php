<?php
$this->breadcrumbs=array(
	'File'=>array('/file'),
	'Upload',
);?>

<h1>Upload File</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'file-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'text_id'); ?>
        <?php 	$options = CHtml::listData(Text::model()->findAll(), 'id', 'title');
        		echo $form->dropDownList($model,'text_id', $options);
        ?>
		<?php echo $form->error($model,'text_id'); ?>

 	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'format_id'); ?>
        <?php 	$options = CHtml::listData(Format::model()->findAll(), 'id', 'name');
        		echo $form->dropDownList($model,'format_id', $options);
        ?>
		<?php echo $form->error($model,'format_id'); ?>
	</div>


	<?php 
	
		$this->widget('CMultiFileUpload', array(
	                'name' => 'files',
	                'accept' => 'jpeg|jpg|gif|png|doc|docx|pdf|txt', // useful for verifying files
	                //'duplicate' => 'Duplicate file!', // useful, i think
	                'denied' => 'Invalid file type', // useful, i think
	            ));
	?>        
            
	<div class="row buttons">
		<?php echo CHtml::submitButton('Upload Selected Files'); ?>
	</div>


<?php $this->endWidget(); ?>

            
</div><!-- form -->