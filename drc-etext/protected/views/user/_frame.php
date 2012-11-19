<?php
	// User Frame

	//$options['menuView'] = '../layouts/_termMenu';
	$options['title'] = "($model->username) $model->first_name $model->last_name";
	if (!$model->username || $model->username ==''){
		$options['title'] = "Users";
		if ($model->term_code){
			$term=Term::model()->findByPk($model->term_code);
			$options['title'] = $term->description;
		}
	}

	echo $this->renderPartial('../layouts/_allUsers',  array('options'=>$options, 'model' => $model,)); 
	 
?>


