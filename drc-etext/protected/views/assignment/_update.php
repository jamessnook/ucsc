<?php
	$layoutOptions = array(
		'model' => $model,
		'title' => 'Update Assignment',
		'createNew'=>false,
		'action'=>Yii::app()->createUrl("assignment/update", array("id" => $model->id)),
	);	

	echo $this->renderPartial('_edit', $layoutOptions); 
	 
?>
