<?php
	$layoutOptions = array(
		'model' => $model,
		'title' => 'Create Book',
		'createNew'=>true,
		//'action'=>Yii::app()->createUrl("course/createBook", array('termCode'=>$_REQUEST['termCode'], 'classNum'=>$_REQUEST['classNum'])),
		'action'=>$options['action'],
	);	

	echo $this->renderPartial('../book/_edit', $layoutOptions); 
	 
?>

