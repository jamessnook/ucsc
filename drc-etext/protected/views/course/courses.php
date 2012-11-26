<?php

	$options = array(
		'contentView' => '../course/_list',
		'menuView' => '../layouts/_termMenu',
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	
?>


