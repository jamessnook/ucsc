<?php
/**
 * The base view component for editing a book model.
 * Can be included in a composite view 
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.book
 */
?>

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
						<?php echo $form->labelEx($model, 'title', array('class'=>"control-label")); ?>
			            <div class="controls">
			            
							<?php echo $form->textField($model,'title',array('class'=>"input-xxlarge",'maxlength'=>127)); // also? id="input01", type="text" ?>
							<?php echo $form->error($model,'title'); ?>
			              
			            </div>
			          </div>

			          <div class="control-group">
						<?php echo $form->labelEx($model, 'author', array('class'=>"control-label")); ?>
			            <div class="controls">
			            
							<?php echo $form->textField($model,'author',array('class'=>"input-xxlarge",'maxlength'=>127)); // also? id="input01", type="text" ?>
							<?php echo $form->error($model,'author'); ?>
			              
			            </div>
			          </div>

			          <div class="control-group">
						<?php echo $form->labelEx($model, 'publisher', array('class'=>"control-label")); ?>
			            <div class="controls">
			            
							<?php echo $form->textField($model,'publisher',array('class'=>"input-xxlarge",'maxlength'=>127)); // also? id="input01", type="text" ?>
							<?php echo $form->error($model,'publisher'); ?>
			              
			            </div>
			          </div>

			          <div class="control-group">
						<?php echo $form->labelEx($model, 'year', array('class'=>"control-label")); ?>
			            <div class="controls">
			            
							<?php echo $form->textField($model,'year',array('class'=>"input-xxlarge",'maxlength'=>15)); // also? id="input01", type="text" ?>
							<?php echo $form->error($model,'year'); ?>
			              
			            </div>
			          </div>

			          <div class="control-group">
						<?php echo $form->labelEx($model, 'edition', array('class'=>"control-label")); ?>
			            <div class="controls">
			            
							<?php echo $form->textField($model,'edition',array('class'=>"input-xxlarge",'maxlength'=>63)); // also? id="input01", type="text" ?>
							<?php echo $form->error($model,'edition'); ?>
			              
			            </div>
			          </div>

			          <div class="control-group">
						<?php echo $form->labelEx($model, 'id_type', array('class'=>"control-label")); ?>
			            <div class="controls">
							
					        <?php 	$options = CHtml::listData(IdType::model()->findAll(), 'name', 'name');
					        		echo $form->dropDownList($model,'id_type', $options, array('class'=>"input-xxlarge"));
					        ?>
							<?php echo $form->error($model,'id_type'); ?>

			            </div>
			          </div>

			          <div class="control-group">
						<?php echo $form->labelEx($model, 'global_id', array('class'=>"control-label")); ?>
			            <div class="controls">
			            
							<?php echo $form->textField($model,'global_id',array('class'=>"input-xxlarge",'maxlength'=>32)); // also? id="input01", type="text" ?>
							<?php echo $form->error($model,'global_id'); ?>
			              
			            </div>
			          </div>

			          <div class="form-actions">
			          
						<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array( 'class'=>"btn btn-primary" )); ?>
						<?php echo CHtml::button('Cancel', array( 'class'=>"btn", 'onclick'=> "history.back()" )); ?>
			            
			          </div>
			          <hr/>
			          <?php 
			            // file upload section
			          	if ($createNew){
							echo $this->renderPartial('base.views.file._uploadAlert', array('model'=>$model)); 
			          	} else {
				          	echo $this->renderPartial('base.views.file._listFiles', array('model'=>$model)); 
			          		echo $this->renderPartial('../book/_uploadFiles', array('model'=>$model)); 
				            // student purchase section
			          		echo $this->renderPartial('../book/_listStudents', array('model'=>$model)); 
			          	}
		          		?>
					  <?php echo $form->hiddenField($model,'id'); ?>
			          
			        </fieldset>
			      </form>
		
            </div><!--/span-->
        </div><!--/row-->

<?php $this->endWidget(); ?>

</div><!-- form -->
        
