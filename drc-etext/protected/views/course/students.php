<?php
	$options = array(
		'contentView' => '../user/_list',
		'dataProvider' => $model->students(),
		'contentTitle' => 'Course Students',
		//'menuView' => '../layouts/_termMenu',
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	
?>
	