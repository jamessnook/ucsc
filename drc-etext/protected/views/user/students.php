<?php
	$options = array(
		'contentView' => '../user/_students',
		'titleNavRight' => '<a href="' . $this->createUrl('user/create') . '"><i class="icon-plus"></i> Add User </a>',
		//'action'=>Yii::app()->createUrl("course/saveBook", array('termCode'=>$model->term_code, 'classNum'=>$model->class_num)),
		'menuView' => '../layouts/_termMenu',
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	
?>
	