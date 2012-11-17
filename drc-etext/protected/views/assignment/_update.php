<?php
	$layoutOptions = array(
		'model' => $model,
		'title' => 'Update Assignment',
		'createNew'=>false,
		//'action'=>Yii::app()->createUrl("assignment/update", array("id" => $model->id)),
		'action'=>$options['action'],
	);	

	echo $this->renderPartial('../assignment/_edit', $layoutOptions); 
	 
?>

