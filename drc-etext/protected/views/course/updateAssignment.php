<?php

	$options = array(
		'contentView' => $contentView,
		'contentModel' => $contentModel,
		'titleNavRight' => '<a href="' . $this->createUrl('assignment/create') . '"><i class="icon-plus"></i> Add Request</a>',
		'titleNavRight' => '<a href="' . $this->createUrl('course/newAssignment', array('term_code'=> $model->term_code, 'class_num'=>$model->class_num)) . '"><i class="icon-plus"></i> Add Request</a>',
		'action'=>Yii::app()->createUrl("course/saveAssignment", array('term_code'=>$model->term_code, 'class_num'=>$model->class_num, 'id'=>$contentModel->id)),
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	
?>


