<?php

	$options = array(
		'contentView' => '../user/_view',
		'menuView' => '../layouts/_userMenu',
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	
?>


