<?php

	$layoutOptions = array(
		'model' => $model,
		'contentView' => '../book/_update',
		'contentModel' => $contentModel,
		'titleNavRight' => '<a href="' . $this->createUrl('book/create') . '"><i class="icon-plus"></i> Add Request</a>',
		'action'=>Yii::app()->createUrl("course/saveBook", array('termCode'=>$model->term_code, 'classNum'=>$model->class_num, 'id'=>$contentModel->id)),
	);	

	echo $this->renderPartial('_courseFrame', $layoutOptions); 
	 
?>


