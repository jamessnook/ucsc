<?php

	$options = array(
		'contentView' => '../user/_view',
		//'titleNavRight' => '<a href="' . $this->createUrl('user/create') . '"><i class="icon-plus"></i> Add User </a>',
		//'action'=>Yii::app()->createUrl("user/save", array('username'=>$model->username)),
		'menuView' => '../layouts/_userMenu',
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	
?>


