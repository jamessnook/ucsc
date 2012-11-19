<?php

	$options = array(
		'contentView' => '../course/_list',
		'menuView' => '../layouts/_termMenu',
		//'titleNavRight' => '<a href="' . $this->createUrl('course/newBook', array('termCode'=> $model->term_code, 'classNum'=>$model->class_num)) . '"><i class="icon-plus"></i> New Book </a>',
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	
?>


