<?php
	$layoutOptions = array(
		'model' => $model,
		'title' => 'Create Assignment',
		'createNew'=>true,
		'action'=>Yii::app()->createUrl("assignment/create", array("term_code" => $model->term_code, "class_num" => $model->class_num, )),
	);	

	echo $this->renderPartial('_edit', $layoutOptions); 
	 
?>

