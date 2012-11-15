<?php
	// User Frame

	$options['menuView'] = '../layouts/_termMenu';
	$options['title'] = "($model->username) $model->first_name $model->last_name";

	echo $this->renderPartial('../layouts/_allUsers',  array('options'=>$options, 'model' => $model,)); 
	 
?>


