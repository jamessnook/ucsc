<?php
	$layoutOptions = array(
		'model' => $model,
		'title' => 'Create Book',
		'createNew'=>true,
		'action'=>$action,
	);	

	echo $this->renderPartial('../book/_edit', $layoutOptions); 
	 
?>

