<?php
	$options = array(
		'contentView' => '_description',
		//'titleNavRight' => '<a href="' . $this->createUrl('book/create') . '"><i class="icon-plus"></i> Add Request</a>',
		//'action'=>Yii::app()->createUrl("course/saveBook", array('term_code'=>$model->term_code, 'class_num'=>$model->class_num)),
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	
?>
	