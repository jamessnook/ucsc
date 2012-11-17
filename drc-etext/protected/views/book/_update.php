<?php
	$layoutOptions = array(
		'model' => $model,
		'title' => 'Update Book',
		'createNew'=>false,
		//'action'=>Yii::app()->createUrl("book/update", array("id" => $model->id)),
		'action'=>$options['action'],
	);	

	echo $this->renderPartial('../book/_edit', $layoutOptions); 
	 
?>

