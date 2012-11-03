<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'assignment-form',
	'enableAjaxValidation'=>false,
)); ?>

		<div class="row-fluid">
            <div class="span12">
				<h2>Create Assignment</h2>
				<br />
				
            	<form class="" action="request-edit.html">
            	
					<fieldset>
			          <div class="control-group">
			            <label class="control-label" for="input01">Title</label>
			            <div class="controls">
			            
							<?php echo $form->textField($model,'title',array('class'=>"input-xxlarge",'maxlength'=>127)); // also? id="input01", type="text" ?>
							<?php echo $form->error($model,'title'); ?>
			              
			            </div>
			          </div>
			          <div class="control-group">
			            <label class="control-label" for="textarea">Book</label>
						<?php echo $form->labelEx($model,'book_id'); ?>
			            <div class="controls">
							
					        <?php 	$options = CHtml::listData(Book::model()->findAll(), 'id', 'title');
					        		echo $form->dropDownList($model,'book_id', $options, array('class'=>"input-xxlarge"));
					        ?>
							<?php echo $form->error($model,'book_id'); ?>

			            </div>
			          </div>
					  <div class="control-group">
						<?php echo $form->labelEx($model,'description'); ?>
			            <div class="controls">
			            
							<?php echo CHtml::activeTextArea($model,'description',array('rows'=>3, 'class'=>"input-xxlarge")); ?>
							<?php echo $form->error($model,'description'); ?>
			              
			            </div>
			          </div>
					  <div class="control-group">
			            <label class="control-label" for="input01">Due Date</label>
						<?php echo $form->labelEx($model,'description'); ?>
			            <div class="controls">
			            
							<?php echo $form->labelEx($model,'due_date'); ?>
							<?php 
							$this->widget('zii.widgets.jui.CJuiDatePicker', array(
								'model'=>$model,
								'attribute'=>'due_date',	    
							    'options'=>array( 'showAnim'=>'fold',  ),
							    'htmlOptions'=>array( 'style'=>'height:20px;', 'class'=>"input-xxlarge" ),
							));
							?>
							<?php echo $form->error($model,'due_date'); ?>

			            </div>
			          </div>
					  
				
					  <div class="alert alert-info">
					  
					        <button type="button" class="close" data-dismiss="alert">×</button>
							<strong>Looking to attach files?</strong> Please fill out and save the new request form first.
					</div>
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
        
