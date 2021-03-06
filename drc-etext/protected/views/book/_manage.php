<?php
/**
 * The base view component file for managing a  book.
 * Includes a sub-form for listing students and updating their purchase status
 * and a file upload widget.
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

			          <?php 
			            // file upload section
		          		echo $this->renderPartial('../book/_listStudents', array('model'=>$model)); 
		          		echo $this->renderPartial('../file/_listFiles', array('model'=>$model)); 
		          		echo $this->renderPartial('../book/_uploadFiles', array('model'=>$model)); 
					  ?>
					  <?php echo $form->hiddenField($model,'id'); ?>

			          <div class="form-actions">
			          
						<?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array( 'class'=>"btn btn-primary" )); ?>
						<?php //echo CHtml::button('Cancel', array( 'class'=>"btn", 'onclick'=> "history.back()" )); ?>
			            
			          </div>
			        </fieldset>
			      </form>
		
            </div><!--/span-->
        </div><!--/row-->

<?php $this->endWidget(); ?>

</div><!-- form -->
        
