<?php

	$options = array(
		'contentView' => '../book/_list',
		'titleNavRight' => '<a href="' . $this->createUrl('course', array('view'=> 'createBook', 'content'=> 'book', 'term_code'=> $model->term_code, 'class_num'=>$model->class_num)) . '"><i class="icon-plus"></i> New Book </a>',
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	
?>


