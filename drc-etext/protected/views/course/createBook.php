<?php

	$options = array(
		'contentView' => '../book/_create',
		'contentModel' => $contentModel,
		'action'=>Yii::app()->createUrl("course/saveBook", array('termCode'=>$model->term_code, 'classNum'=>$model->class_num)),
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
		 
?>


