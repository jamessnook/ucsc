<?php
	$options = array(
		'contentView' => '../user/_list',
		'dataProvider' => $model->students(),
		'contentTitle' => 'Course Students',
		//'menuView' => '../layouts/_termMenu',
		//'menuRoute' => 'course/students',
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	
?>
	