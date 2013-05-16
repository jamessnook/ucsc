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

  
<div class="section-header">
   <h3>Upload Files for this Book</h3>
</div>
          
   <?php
	$this->widget('base.extensions.xupload.XUpload', array(
	                    'url' => Yii::app()->createUrl("book/uploadFile", array("id"=>$model->id)),
	                    'model' => $model,
	                    'attribute' => 'file',
	                    'multiple' => true, 
						//'formView' => 'application.views.somemodel._form',
						'formView' => 'base.views.file._xupload',
						'htmlOptions' => array('id'=>'assignment-form'),
	));
	?>      

