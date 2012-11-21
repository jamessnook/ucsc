<?php
	// Course Frame

	$options['menuView'] = '../layouts/_termMenu';
	$options['title'] = $model->title;
	if (!$model->title || $model->title =='') {
		$options['title'] = "Assignments";
	}
	
	echo $this->renderPartial('../layouts/_allUsers',  array('options'=>$options, 'model' => $model,)); 
	
?>


