<?php
$this->pageTitle=Yii::app()->name . ' - Create ITR';
$this->breadcrumbs=array(
	'Create ITR',
);
?>

<p>Please fill out the following form with a description of the problem you would like to create an ITR ticket for:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'itr-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php echo $form->labelEx($model,'message'); ?>
		<?php echo $form->textArea($model,'message', array('rows'=>9, 'class'=>"input-xxlarge")); ?>
		<?php //echo CHtml::activeTextArea($model,'message',array('rows'=>9, 'class'=>"input-xxlarge")); ?>
		<?php echo $form->error($model,'message'); ?>
	</div>
	<?php echo $form->hiddenField($model,'returnUrl'); ?>


	<div class="form-actions">
		<?php echo CHtml::submitButton('Create ITR', array( 'class'=>"btn",)); ?>
		<?php echo CHtml::button('Cancel', array( 'class'=>"btn", 'onclick'=> "history.back()" )); ?>
	</div>

<?php $this->endWidget(); ?>

</div>
