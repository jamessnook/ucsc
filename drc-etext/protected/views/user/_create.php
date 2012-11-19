<?php
	$layoutOptions = array(
		'model' => $model,
		'title' => 'Create New User',
		'createNew'=>true,
		'action'=>$options['action'],
	);	

	echo $this->renderPartial('../user/_edit', $layoutOptions); 
	 
?>

