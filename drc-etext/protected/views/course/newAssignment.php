<?php

	$options = array(
		'contentView' => '../assignment/_new',
		'contentModel' => $contentModel,
		'titleNavRight' => '<a href="' . $this->createUrl('assignment/create') . '"><i class="icon-plus"></i> Add Request</a>',
		'action'=>Yii::app()->createUrl("course/saveAssignment", array('termCode'=>$model->term_code, 'classNum'=>$model->class_num)),
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
		 
?>


