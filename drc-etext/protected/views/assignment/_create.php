<?php
	$layoutOptions = array(
		'model' => $model,
		'title' => 'Create Assignment',
		'createNew'=>true,
		'action'=>$options['action'],
	);	

	echo $this->renderPartial('../assignment/_edit', $layoutOptions); 
	 
?>

