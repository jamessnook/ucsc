<?php

	$options = array(
		'contentView' => '_adminList',
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
		 
?>


