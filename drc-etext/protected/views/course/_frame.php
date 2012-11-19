<?php
	// Course Frame
	if (!isset($options['menuView'])) $options['menuView'] = '../layouts/_courseMenu';  // default
	$options['title'] = $model->title .' (' .$model->idString().')';
	if (!$model->title || $model->title ==''){
		$options['title'] = "Courses";
		//if ($model->term_code){
			//$term=Term::model()->findByPk($model->term_code);
		//	$options['title'] = $model->term->description;
		//}
	}
	
	echo $this->renderPartial('../layouts/_allUsers',  array('options'=>$options, 'model' => $model,)); 
	
?>


