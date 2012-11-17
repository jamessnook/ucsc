<?php

	$options = array(
		'contentView' => '../assignment/_update',
		'contentModel' => $contentModel,
		'titleNavRight' => '<a href="' . $this->createUrl('assignment/create') . '"><i class="icon-plus"></i> Add Request</a>',
		'action'=>Yii::app()->createUrl("course/saveAssignment", array('termCode'=>$model->term_code, 'classNum'=>$model->class_num, 'id'=>$contentModel->id)),
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	
?>


