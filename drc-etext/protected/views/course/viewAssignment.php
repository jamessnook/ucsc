<?php

	$options = array(
		'contentView' => '../assignment/_view',
		'contentModel' => $contentModel,
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	
?>


