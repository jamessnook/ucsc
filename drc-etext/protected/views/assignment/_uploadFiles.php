<?php
/**
 * The base view component file for displaying a file upload widget.
 * Can be included in a composite view 
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.assignment
 */
?>

    
<!-- - 				          
<div class="control-group">
  <label class="control-label" for="input01">Type</label>
-->	            
	<?php 
		/*
		foreach ($model->types() as $type){
			echo '<span class="label">' . $type . '</span>';
		}
		if (count($model->drcRequests)>0){
			echo '<p class="help-block"><small>Based on the students enrolled in this class, that requested Alt media for this class, these file types need to be included with this assignment request.</small></p>';
		} else{
			echo '<p class="help-block"><small>No students have yet requested Alt media types for this class.</small></p>';
		}
		*/
	?>
<!-- - 				          
</div>
-->	            
  
<div class="page-header">
   <h2>Upload Files for this Assignment</h2>
</div>
          
   <?php
	$this->widget('base.extensions.xupload.XUpload', array(
	                    'url' => Yii::app()->createUrl("assignment/uploadFile", array("id"=>$model->id)),
	                    'model' => $model,
	                    'attribute' => 'file',
	                    'multiple' => true, 
						//'formView' => 'application.views.somemodel._form',
						'formView' => 'base.views.file._xupload',
						'htmlOptions' => array('id'=>'assignment-form'),
	));
	?>      

