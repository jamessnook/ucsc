    
					          
  
<div class="page-header">
   <h2>Upload Books for this Course</h2>
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

