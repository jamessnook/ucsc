<?php

	$options = array(
		'contentView' => '../book/_edit',
		'contentModel' => $contentModel,
		'contentTitle' => 'Create Book',
		'createNew'=>true,
		'action'=>Yii::app()->createUrl("course/saveBook", array('term_code'=>$model->term_code, 'class_num'=>$model->class_num)),
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
		 
?>


