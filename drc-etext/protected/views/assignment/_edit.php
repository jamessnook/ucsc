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
								<?php echo $form->textField($model,'title',array('maxlength'=>127, 'class'=>'input-xxlarge')); // also? id="input01", type="text" ?>
								<?php echo $form->error($model,'title'); ?>
			            </div>
			          </div>
			          <div class="control-group">
						<?php echo $form->labelEx($model,'due_date'); ?>
			            <div class="controls">
							<?php
							$this->widget('zii.widgets.jui.CJuiDatePicker', array(
								'model'=>$model,
								'attribute'=>'due_date',	    
							    'options'=>array( 'showAnim'=>'fold',  "dateFormat"=>"yy-mm-dd" ),
							    'htmlOptions'=>array( 'class'=>"input-xxlarge" ), //'style'=>'height:20px;', 
							));
							?>
							<?php echo $form->error($model,'due_date'); ?>
			            </div>
			          </div>
			          <div class="control-group">
						<?php echo $form->labelEx($model,'book_id'); ?>
			            <div class="controls input-xxlarge">
							<?php
							$this->widget('base.extensions.select2.ESelect2', array(
								'model'=>$model,
  								'attribute'=>'book_id',								
 							    'data'=>CHtml::listData(Book::model()->findAll(), 'id', 'title'),
							    'htmlOptions'=>array( 'class'=>"input-xxlarge", ),  //, 'class'=>"input-xxlarge", 'style'=>'height:20px;', 
								'options'=>array(
								    'placeholder'=>'No Book Selected',
								    'allowClear'=>true,
							),							
							));
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
			          
			          <?php 
			          	if ($createNew){
							echo $this->renderPartial('base.views.file._uploadAlert', array('model'=>$model)); 
			          	} else {
			          		echo $this->renderPartial('base.views.file._listFiles', array('model'=>$model)); 
				            // student file type section
			          		echo $this->renderPartial('../assignment/_listFileTypes', array('model'=>$model)); 
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
							if (!$createNew){
								if ($model->is_complete){
									echo CHtml::submitButton('Mark Assignment As Not Completed', array( 'class'=>"btn btn-success pull-right", 'name' => 'NotCompleted', )); 
								}else{
									echo CHtml::submitButton('Mark Assignment As Completed', array( 'class'=>"btn btn-success pull-right", 'name' => 'Completed', )); 
								}
							}
							?>
			            
			          </div>
			        </fieldset>
			      </form>
		
            </div><!--/span-->
        </div><!--/row-->

<?php $this->endWidget(); ?>

</div><!-- form -->
        
