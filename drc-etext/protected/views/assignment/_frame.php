<?php
	// Assignment Frame

	$options['menuView'] = '../layouts/_termMenu';
	$options['title'] = $model->title;
	if (!$model->title || $model->title =='') {
		$options['title'] = "Assignments";
	}
	
	echo $this->renderPartial('../layouts/_main',  array('options'=>$options, 'model' => $model,)); 
	
?>


