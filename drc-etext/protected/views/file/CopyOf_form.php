<div class="form">

<?php 

	echo CHtml::form(array('file/create'),'post',array('enctype'=>'multipart/form-data')); 

	$this->widget('CMultiFileUpload', array(
                'name' => 'files',
                'accept' => 'jpeg|jpg|gif|png', // useful for verifying files
                'duplicate' => 'Duplicate file!', // useful, i think
                'denied' => 'Invalid file type', // useful, i think
            ));
?>        
            
<div class="row buttons">
<?php 
	//echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); 
	echo CHtml::submitButton('Upload'); 
?>
</div>
            
</div><!-- form -->