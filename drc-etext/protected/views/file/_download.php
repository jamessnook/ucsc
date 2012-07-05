<?php 
	if (isset($model->parent_id) && $model->parent_id > 0){
		$files = File::model()->findAllByAttributes(array('parent_id'=>$model->parent_id), array('order'=>'type_id,name'));
		$bookTitle = BookRequest::model()->findByAttributes(array('id'=>$model->parent_id))->title;
		echo "<h2>Files for $bookTitle</h2>";
	} else {
		$files = File::model()->findAll();
	}
    foreach ($files as $model) {
    	echo CHtml::link("$model->name, ", array('file/download', 'name'=>$model->name, 'path'=>$model->path),
	      array('class'=>'donwload_link')
	   );
	   echo '<br/>';
    }
 ?>

