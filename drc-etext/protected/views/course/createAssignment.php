<?php

	$options = array(
		'contentView' => '../assignment/_create',
		'contentModel' => $contentModel,
		'action'=>Yii::app()->createUrl("course/saveAssignment", array('termCode'=>$model->term_code, 'classNum'=>$model->class_num)),
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
		 
?>


