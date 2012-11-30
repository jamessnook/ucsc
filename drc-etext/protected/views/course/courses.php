<?php

	$options = array(
		'contentView' => '../course/_list',
		'menuView' => '../layouts/_termMenu',
		'title' => 'All Courses',
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	
?>


