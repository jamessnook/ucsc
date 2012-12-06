<?php
	// Course Frame
	if (!isset($options['menuView'])) 
		$options['menuView'] = '../layouts/_courseMenu';  // default
	if (!isset($options['title'])) 
		$options['title'] = $model->title .' (' .$model->idString().')';
	if (!isset($options['activeTab']))
		$options['activeTab'] = "courses";
	
		
	$this->viewOptions = $options;
	$this->model = $model;
	$options['model'] = $model;
	echo $this->renderPartial('../layouts/_main', $options); 
	
?>


