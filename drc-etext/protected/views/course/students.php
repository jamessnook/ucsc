<?php
	$options = array(
		'contentView' => '../user/_students',
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	
?>
	