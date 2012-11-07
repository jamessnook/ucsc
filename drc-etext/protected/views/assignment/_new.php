<?php

	$layoutOptions = array(
		'model' => $model,
		'title' => 'Create Assignment',
		'fileUpload'=>true,
	);	

	echo $this->renderPartial('_editForm', $layoutOptions); 
	 
?>

