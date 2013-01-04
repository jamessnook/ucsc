<?php
/**
 * The base view component for displaying and editing a user model.
 * Can be included in a composite view 
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.user
 */
?>

<div class="form">

	<?php  
	// build up the side bar menu
    $this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>'<h3>Word Filter</h3>',
		'contentCssClass'=>'nav-header',
	));
	?>

	<fieldset>
        <div class="control-group">
			<?php echo $form->labelEx($model,'word'); ?>
            <div class="controls">
            
				<?php echo $form->textField($model,'word',array('class'=>"input-xlarge",'maxlength'=>63)); // also? id="input01", type="text" ?>
				<?php echo $form->error($model,'word'); ?>
              
            </div>
        </div>
        <div class="control-group">
			<?php echo $form->labelEx($model, 'subjectId', array('class'=>"control-label")); ?>
            <div class="controls">
				
		        <?php 	$options = CHtml::listData(Subject::model()->findAll(), 'id', 'name');
	        		echo $form->dropDownList($model,'subjectId', $options, array('class'=>"input-xlarge"));
	        	?>
				<?php echo $form->error($model,'subjectId'); ?>

            </div>
        </div>
        <div class="control-group">
			<?php echo $form->labelEx($model, 'grade', array('class'=>"control-label")); ?>
            <div class="controls">
				
		        <?php 	$options = CHtml::listData(Grade::model()->findAll(), 'id', 'name');
	        		echo $form->dropDownList($model,'grade', $options, array('class'=>"input-xlarge"));
	        	?>
				<?php echo $form->error($model,'grade'); ?>

            </div>
        </div>
        <div class="control-group">
			<?php echo $form->labelEx($model, 'concrete', array('class'=>"control-label")); ?>
            <div class="controls">
				
		        <?php 	$options = CHtml::listData(Concrete::model()->findAll(array('distinct'=>true,)), 'id', 'name');
	        		echo $form->dropDownList($model,'concrete', $options, array('class'=>"input-xlarge"));
	        	?>
				<?php echo $form->error($model,'concrete'); ?>

            </div>
        </div>
         <div class="control-group">
			<?php echo $form->labelEx($model, 'polysemyCnt', array('class'=>"control-label")); ?>
            <div class="controls">
				
		        <?php 	$options = CHtml::listData(Polysemy::model()->findAll(), 'id', 'name');
	        		echo $form->dropDownList($model,'polysemyCnt', $options, array('class'=>"input-xlarge"));
	        	?>
				<?php echo $form->error($model,'polysemyCnt'); ?>

            </div>
        </div>
         <div class="control-group">
			<?php echo $form->labelEx($model, 'pos', array('class'=>"control-label")); ?>
            <div class="controls">
				
		        <?php 	$options = CHtml::listData(PosMap::model()->findAll(array('select'=>'t.pos, t.name','distinct'=>true,)), 'pos', 'name');
	        		echo $form->dropDownList($model,'pos', $options, array('class'=>"input-xlarge"));
	        	?>
				<?php echo $form->error($model,'pos'); ?>

            </div>
        </div>
         <div class="control-group">
			<?php echo $form->labelEx($model, 'maxFrequency', array('class'=>"control-label")); ?>
            <div class="controls">
				
		        <?php 	$options = CHtml::listData(Frequency::model()->findAll(), 'id', 'name');
	        		echo $form->dropDownList($model,'maxFrequency', $options, array('class'=>"input-xlarge"));
	        	?>
				<?php echo $form->error($model,'maxFrequency'); ?>

            </div>
        </div>
         <div class="control-group">
			<?php echo $form->labelEx($model, 'minFrequency', array('class'=>"control-label")); ?>
            <div class="controls">
				
		        <?php 	$options = CHtml::listData(Frequency::model()->findAll(), 'id', 'name');
	        		echo $form->dropDownList($model,'minFrequency', $options, array('class'=>"input-xlarge"));
	        	?>
				<?php echo $form->error($model,'minFrequency'); ?>

            </div>
        </div>
         <div class="control-group">
			<?php echo $form->labelEx($model, 'topicId', array('class'=>"control-label")); ?>
            <div class="controls">
				
		        <?php 	$options = CHtml::listData(Topics::model()->findAll(array('condition'=>'typeId=3 OR typeId=-1', 'distinct'=>true, 'order'=>'typeId, topic')), 'id', 'topic');
	        		echo $form->dropDownList($model,'topicId', $options, array('class'=>"input-xlarge"));
	        	?>
				<?php echo $form->error($model,'topicId'); ?>
 
             </div>
        </div>

          <div class="form-actions">
          
			<?php 
			echo CHtml::submitButton('Create List', array( 'class'=>"btn btn-primary" )); 
			//echo CHtml::submitButton('Add To List', array( 'class'=>"btn btn-primary", 'params'=>array('add'=>1) )); 
			echo CHtml::submitButton('Add To List', array( 'class'=>"btn btn-success pull-right", 'name' => 'Words[addToList]', )); 
            ?>
          </div>
        </fieldset>

	<?php 
		$this->endWidget(); 
	?>

</div><!-- form -->
        
