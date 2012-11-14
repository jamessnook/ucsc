<?php
	$layoutOptions = array(
		'model' => $model,
		'title' => 'Update Book',
		'createNew'=>false,
		'action'=>Yii::app()->createUrl("book/update", array("id" => $model->id)),
	);	

	echo $this->renderPartial('_edit', $layoutOptions); 
	 
?>

