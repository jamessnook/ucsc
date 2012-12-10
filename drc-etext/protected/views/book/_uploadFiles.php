    
					          
  
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

