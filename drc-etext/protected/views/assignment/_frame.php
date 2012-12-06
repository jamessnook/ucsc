<?php
	// Assignment Frame

	$options['menuView'] = '../layouts/_termMenu';
	$options['title'] = $model->title;
	if (!$model->title || $model->title =='') {
		$options['title'] = "Assignments";
	}
	if (!isset($options['activeTab'])){
		$options['activeTab'] = "assignment";
	}
	$this->viewOptions = $options;
	$this->model = $model;
	//$this->contentModel = $contentModel;
	$options['model'] = $model;
	echo $this->renderPartial('../layouts/_main', $options); 
		
?>


