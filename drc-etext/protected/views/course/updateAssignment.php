<?php

	$options = array(
		'contentView' => '../assignment/_update',
		'contentModel' => $contentModel,
		'titleNavRight' => '<a href="' . $this->createUrl('course/createAssignment', array('content'=> 'assignment', 'term_code'=> $model->term_code, 'class_num'=>$model->class_num)) . '"><i class="icon-plus"></i> Add Request</a>',
		'action'=>Yii::app()->createUrl("course/saveAssignment", array('term_code'=>$model->term_code, 'class_num'=>$model->class_num, 'id'=>$contentModel->id)),
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model'=>$model,)); 
	
?>


