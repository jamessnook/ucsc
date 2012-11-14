<?php
	$layoutOptions = array(
		'model' => $model,
		'title' => 'Create Book',
		'createNew'=>true,
		'action'=>Yii::app()->createUrl("book/create", array("term_code" => $model->term_code, "class_num" => $model->class_num, )),
	);	

	echo $this->renderPartial('_edit', $layoutOptions); 
	 
?>

