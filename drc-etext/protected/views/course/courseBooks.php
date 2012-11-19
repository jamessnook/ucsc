<?php

	$layoutOptions = array(
		'model' => $model,
		'contentView' => '../book/_list',
		'titleNavRight' => '<a href="' . $this->createUrl('assignment/create') . '"><i class="icon-plus"></i> Add Request</a>',
	);	

	echo $this->renderPartial('_frame', $layoutOptions); 
	 
?>


