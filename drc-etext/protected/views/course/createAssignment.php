<?php

	$options = array(
		'contentView' => '../assignment/_create',
		'contentModel' => $contentModel,
		'action'=>Yii::app()->createUrl("course/saveAssignment", array('term_code'=>$model->term_code, 'class_num'=>$model->class_num)),
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
		 
?>


