<?php
/**
 * The base view component file for displaying a file upload widget.
 * Can be included in a composite view 
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.book
 */
?>

  
<div class="page-header">
   <h2>Upload Filess for this Book</h2>
</div>
          
   <?php
	$this->widget('xupload.XUpload', array(
	                    'url' => Yii::app()->createUrl("book/uploadFile", array("id"=>$model->id)),
	                    'model' => $model,
	                    'attribute' => 'file',
	                    'multiple' => true, 
						//'formView' => 'application.views.somemodel._form',
						'formView' => 'application.views.file._xupload',
						'htmlOptions' => array('id'=>'assignment-form'),
	));
	?>      
