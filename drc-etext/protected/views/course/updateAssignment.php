<?php

	$options = array(
		'contentView' => $contentView,
		'contentModel' => $contentModel,
		'titleNavRight' => '<a href="' . $this->createUrl('assignment/create') . '"><i class="icon-plus"></i> Add Request</a>',
		'titleNavRight' => '<a href="' . $this->createUrl('course/newAssignment', array('termCode'=> $model->term_code, 'classNum'=>$model->class_num)) . '"><i class="icon-plus"></i> Add Request</a>',
		'action'=>Yii::app()->createUrl("course/saveAssignment", array('termCode'=>$model->term_code, 'classNum'=>$model->class_num, 'id'=>$contentModel->id)),
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	
?>


