<?php
/**
 * The base view component for editing an assignment model.
 * Can be included in a composite view 
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.assignment
 */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'assignment-form',
	'enableAjaxValidation'=>false,
	'action'=> $action,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

		<div class="row-fluid">
            <div class="span12">
				<h2><?php echo $contentTitle; ?></h2>
				<br />
				
            	<form class="" action="request-edit.html">
            	
					<fieldset>
			          <div class="control-group">
						<?php echo $form->labelEx($model,'title'); ?>
			            <div class="controls">
			            
							<?php echo $form->textField($model,'title',array('class'=>"input-xxlarge",'maxlength'=>127)); // also? id="input01", type="text" ?>
							<?php echo $form->error($model,'title'); ?>
			              
			            </div>
			          </div>
			          <div class="control-group">
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
						<?php echo $form->labelEx($model,'due_date'); ?>
			            <div class="controls">
			            
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
			          
			          <?php 
			          	if ($createNew){
							echo $this->renderPartial('../file/_uploadAlert', array('model'=>$model)); 
			          	} else {
			          		echo $this->renderPartial('../file/_listFiles', array('model'=>$model)); 
			          		echo $this->renderPartial('../assignment/_uploadFiles', array('model'=>$model)); 
			          	}
					  ?>
					  <?php echo $form->hiddenField($model,'term_code'); ?>
					  <?php echo $form->hiddenField($model,'class_num'); ?>
					  <?php echo $form->hiddenField($model,'id'); ?>

			          <div class="form-actions">
			          
						<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array( 'class'=>"btn btn-primary" )); ?>
						<?php echo CHtml::button('Cancel', array( 'class'=>"btn", 'onclick'=> "history.back()" )); ?>
						<?php 
							if (!$createNew)
								echo CHtml::submitButton('Request Completed', array( 'class'=>"btn btn-success pull-right", 'name' => 'Completed', )); 
						?>
			            
			          </div>
			        </fieldset>
			      </form>
		
            </div><!--/span-->
        </div><!--/row-->

<?php $this->endWidget(); ?>

</div><!-- form -->
        