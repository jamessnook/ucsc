<?php
	// User Frame, set up defaults
	if (!isset($options['title'])){
		$options['title'] = "($model->username) $model->first_name $model->last_name";
		if (!$model->username || $model->username ==''){
			$options['title'] = "Users";
			if ($model->term_code){
				$term=Term::model()->findByPk($model->term_code);
				$options['title'] = $term->description;
			}
		}
	}
	if (!isset($options['activeTab'])){
		$options['activeTab'] = "students";
		if ($model->username){
			if(Yii::app()->authManager->checkAccess('staff', $model->username))
				$options['activeTab'] = "staff";
			if (Yii::app()->authManager->checkAccess('admin', $model->username)) 
				$options['activeTab'] = "staff";
			if (Yii::app()->authManager->checkAccess('faculty', $model->username)) 
				$options['activeTab'] = "faculty";
		}
	}
	
	$this->viewOptions = $options;
	$this->model = $model;
	$options['model'] = $model;
	echo $this->renderPartial('../layouts/_main', $options); 
	 
?>


