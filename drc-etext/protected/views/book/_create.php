<?php
	$layoutOptions = array(
		'model' => $model,
		'title' => 'Create Book',
		'createNew'=>true,
		'action'=>$options['action'],
	);	

	echo $this->renderPartial('../book/_edit', $layoutOptions); 
	 
?>

