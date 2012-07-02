<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'book-request-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'request_id'); ?>
        <?php 	// drop down for selection of service request to associate with this book request
			$criteria=new CDbCriteria;
			$criteria->select="id, CONCAT(coure_name, ' ', type) AS name";   
			//$criteria->join='LEFT JOIN units ON units.id=products.id';                          
			$criteria->condition="username='{Yii::app()->user->name}'";                           
			//$criteria->params=array(':productId'=>$productId);                              
        	$options = CHtml::listData(ServiceRequest::model()->findAll($criteria), 'id', 'name');
        	echo $form->dropDownList($model,'request_id', $options);
        ?>
		<?php echo $form->error($model,'format_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'book_id'); ?>
		<?php echo $form->textField($model,'book_id'); ?>
		<?php echo $form->error($model,'book_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'global_id'); ?>
		<?php echo $form->textField($model,'global_id'); ?>
		<?php echo $form->error($model,'global_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_type'); ?>
        <?php 	$options = CHtml::listData(IdType::model()->findAll(), 'name', 'name');
        		echo $form->dropDownList($model,'id_type', $options);
        ?>
		<?php echo $form->error($model,'id_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>512)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'author'); ?>
		<?php echo $form->textField($model,'author',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'author'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'edition'); ?>
		<?php echo $form->textField($model,'edition',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'edition'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'class_name'); ?>
		<?php echo $form->textField($model,'class_name',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'class_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'notes'); ?>
		<?php echo $form->textField($model,'notes',array('size'=>60,'maxlength'=>1024)); ?>
		<?php echo $form->error($model,'notes'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->