<?php

	$options = array(
		'contentView' => '../book/_list',
		'titleNavRight' => '<a href="' . $this->createUrl('course/createBook', array('termCode'=> $model->term_code, 'classNum'=>$model->class_num)) . '"><i class="icon-plus"></i> New Book </a>',
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	
?>


