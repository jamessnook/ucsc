<?php

	$options = array(
		'contentView' => '../course/_list',
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	 
?>


