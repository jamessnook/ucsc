<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'file-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'path'); ?>
		<?php echo $form->textField($model,'path',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'path'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'caption'); ?>
		<?php echo $form->textField($model,'caption',array('size'=>60,'maxlength'=>512)); ?>
		<?php echo $form->error($model,'caption'); ?>
	</div>

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

	<div class="row">
		<?php echo $form->labelEx($model,'type_id'); ?>
        <?php 	$options = CHtml::listData(FileType::model()->findAll(), 'id', 'name');
        		echo $form->dropDownList($model,'type_id', $options);
        ?>
		<?php echo $form->error($model,'type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_num'); ?>
		<?php echo $form->textField($model,'order_num'); ?>
		<?php echo $form->error($model,'order_num'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pages'); ?>
		<?php echo $form->textField($model,'pages'); ?>
		<?php echo $form->error($model,'pages'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'voice'); ?>
		<?php echo $form->textField($model,'voice',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'voice'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'speed'); ?>
		<?php echo $form->textField($model,'speed',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'speed'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'source'); ?>
		<?php echo $form->textField($model,'source',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'source'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'notes'); ?>
		<?php echo $form->textField($model,'notes',array('size'=>60,'maxlength'=>1000)); ?>
		<?php echo $form->error($model,'notes'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->