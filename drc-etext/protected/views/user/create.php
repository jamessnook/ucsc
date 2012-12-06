<?php

	$options = array(
		'contentView' => '../user/_edit',
		'contentTitle' => 'Create New User',
		'createNew'=>true,
		'activeTab'=>'staff',
		'action'=>Yii::app()->createUrl("user/save"),
		'titleNavRight' => '<a href="' . $this->createUrl('user/create') . '"><i class="icon-plus"></i> Add User </a>',
		'menuView' => '../layouts/_userMenu',
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	 
?>


