<?php
	// Course Frame

	$options['menuView'] = '../layouts/_courseMenu';
	$options['title'] = $model->title .' (' .$model->idString().')';

	echo $this->renderPartial('../layouts/_allUsers',  array('options'=>$options, 'model' => $model,)); 
	
?>


