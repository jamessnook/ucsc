<?php

	$layoutOptions = array(
		'model' => $model,
		'contentView' => '../assignment/_update',
		'titleNavRight' => '<a href="' . $this->createUrl('assignment/create') . '"><i class="icon-plus"></i> Add Request</a>',
	);	

	echo $this->renderPartial('_courseFrame', $layoutOptions); 
	 
?>


