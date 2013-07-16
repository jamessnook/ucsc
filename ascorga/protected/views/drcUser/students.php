<?php
	$options = array(
		'contentView' => '../drcUser/_list',
		'dataProvider' => $model->students(),
		'contentTitle' => 'DRC Students',
		'titleNavRight' => '<a href="' . $this->createUrl('drcUser/create') . '"><i class="icon-plus"></i> Add User </a>',
		'menuView' => '../layouts/_termMenu',
		'menuRoute' => 'drcUser/students',
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	
?>
	