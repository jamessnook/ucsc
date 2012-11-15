<?php

	$options = array(
		'contentView' => '../assignment/_new',
		'contentModel' => $contentModel,
		'titleNavRight' => '<a href="' . $this->createUrl('assignment/create') . '"><i class="icon-plus"></i> Add Request</a>',
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
		 
?>


