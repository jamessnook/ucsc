<?php

	$this->layoutOptions = array(
		'model' => $model,
		'menuView' =>'_assignmentMenu',
		'contentView' => '_assignment',
		'title' => $model->title .' (' .$model->idString().')',
		'titleNavRight' => '<a href="' . $this->createUrl('assignment/create') . '"><i class="icon-plus"></i> Add Request</a>',
	);	
?>


