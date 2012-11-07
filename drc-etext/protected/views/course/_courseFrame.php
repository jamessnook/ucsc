<?php

	$layoutOptions = array(
		'model' => $model,
		'menuView' =>'_courseMenu',
		'contentView' => $contentView,
		'title' => $model->title .' (' .$model->idString().')',
		'titleNavRight' => $titleNavRight,
	);	

	echo $this->renderPartial('_allUsers', $layoutOptions); 
	 
?>


