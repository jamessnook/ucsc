<?php

	$options = array(
		'contentView' => '../assignment/_list',
		'titleNavRight' => '<a href="' . $this->createUrl('course', array('view'=> 'createAssignment', 'content'=> 'assignment', 'term_code'=> $model->term_code, 'class_num'=>$model->class_num)) . '"><i class="icon-plus"></i> Add Request</a>',
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	 
?>


