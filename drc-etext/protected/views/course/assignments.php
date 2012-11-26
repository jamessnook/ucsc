<?php

	$options = array(
		'contentView' => '../assignment/_list',
		'titleNavRight' => '<a href="' . $this->createUrl('course/createAssignment', array('termCode'=> $model->term_code, 'classNum'=>$model->class_num)) . '"><i class="icon-plus"></i> Add Request</a>',
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	 
?>


