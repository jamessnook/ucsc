<?php
	$layoutOptions = array(
		'model' => $model,
		'title' => 'Create Book',
		'createNew'=>true,
		//'action'=>Yii::app()->createUrl("course/createBook", array('term_code'=>$_REQUEST['term_code'], 'class_num'=>$_REQUEST['class_num'])),
		'action'=>$options['action'],
	);	

	echo $this->renderPartial('../book/_edit', $layoutOptions); 
	 
?>

