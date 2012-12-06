<?php
	$options = array(
		'contentView' => '../user/_list',
		'dataProvider' => $model->students(),
		'contentTitle' => 'DRC Students',
		'titleNavRight' => '<a href="' . $this->createUrl('user/create') . '"><i class="icon-plus"></i> Add User </a>',
		'menuView' => '../layouts/_termMenu',
		'menuRoute' => 'user/students',
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	
?>
	