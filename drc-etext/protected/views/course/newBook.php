<?php

	$layoutOptions = array(
		'model' => $model,
		'contentView' => '../book/_new',
		'contentModel' => $contentModel,
		'titleNavRight' => '<a href="' . $this->createUrl('book/create') . '"><i class="icon-plus"></i> Add Book</a>',
	);	

	echo $this->renderPartial('_courseFrame', $layoutOptions); 
	 
?>


