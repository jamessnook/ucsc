<?php
	// Course Frame
	if (!isset($options['menuView'])) $options['menuView'] = '../layouts/_courseMenu';  // default
	$options['title'] = $model->title .' (' .$model->idString().')';
	if (!$model->title || $model->title ==''){
		$options['title'] = "All Courses";
	}
	
	echo $this->renderPartial('../layouts/_allUsers',  array('options'=>$options, 'model' => $model,)); 
	
?>


