<?php

	$layoutOptions = array(
		'model' => $model,
		'contentView' => '../book/_update',
		'contentModel' => $contentModel,
		'titleNavRight' => '<a href="' . $this->createUrl('book/create') . '"><i class="icon-plus"></i> Add Request</a>',
	);	

	echo $this->renderPartial('_courseFrame', $layoutOptions); 
	 
?>


