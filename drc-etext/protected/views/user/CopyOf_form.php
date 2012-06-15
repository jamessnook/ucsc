<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
        <?php 	echo CHtml::label('Role', 'roleName'); ?>
        <?php 	$username = $model->username;
        		$userRoles = Yii::app()->authManager->getRoles($username);
        		$selected = key($userRoles);
        		$options = array();
        		$roles = array_keys (Yii::app()->authManager->getRoles());
        		foreach ($roles as $role){
        			$options[$role]=$role;
        		}
        		echo CHtml::dropDownList('roleName', $selected, $options);
        ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->