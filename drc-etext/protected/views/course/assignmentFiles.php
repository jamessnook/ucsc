<?php

	$options = array(
		'contentView' => '../assignment/_listFiles',
		'contentModel' => $contentModel,
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	
?>


