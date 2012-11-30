<?php
	// Course Frame
	if (!isset($options['menuView'])) 
		$options['menuView'] = '../layouts/_courseMenu';  // default
	if (!isset($options['title'])) 
		$options['title'] = $model->title .' (' .$model->idString().')';
	
	echo $this->renderPartial('../layouts/_main',  array('options'=>$options, 'model' => $model,)); 
	
?>


