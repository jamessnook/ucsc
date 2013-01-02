<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'assignment-form',
	'enableAjaxValidation'=>false,
	'action'=> $action,
)); ?>

		<div class="row-fluid">
            <div class="span12">
				<h2><?php echo $contentTitle; ?></h2>
				<br />
				
            	<form class="" action="request-edit.html">
            	
					<fieldset>
			          <div class="control-group">
						<?php echo $form->labelEx($model, 'subject', array('class'=>"control-label")); ?>
			            <div class="controls">
			            
							<?php echo $form->textField($model,'subject',array('class'=>"input-xxlarge",'maxlength'=>127)); // also? id="input01", type="text" ?>
							<?php echo $form->error($model,'subject'); ?>
			              
			            </div>
			          </div>

			          <div class="control-group">
						<?php echo $form->labelEx($model, 'type', array('class'=>"control-label")); ?>
			            <div class="controls">
							
					        <?php 	$options = CHtml::listData(EmailType::model()->findAll(), 'name', 'name');
					        		echo $form->dropDownList($model,'type', $options, array('class'=>"input-xxlarge"));
					        ?>
							<?php echo $form->error($model,'type'); ?>

			            </div>
			          </div>

					  <div class="control-group">
						<?php echo $form->labelEx($model,'message'); ?>
			            <div class="controls">
			            
							<?php echo CHtml::activeTextArea($model,'message',array('rows'=>3, 'class'=>"input-xxlarge")); ?>
							<?php echo $form->error($model,'message'); ?>
			              
			            </div>
			          </div>
			          
					  <?php echo $form->hiddenField($model,'id'); ?>

			          <div class="form-actions">
			          
						<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array( 'class'=>"btn btn-primary" )); ?>
						<?php echo CHtml::button('Cancel', array( 'class'=>"btn", 'onclick'=> "history.back()" )); ?>
			            
			          </div>
			        </fieldset>
			      </form>
		
            </div><!--/span-->
        </div><!--/row-->

<?php $this->endWidget(); ?>

</div><!-- form -->
        
