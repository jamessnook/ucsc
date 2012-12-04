<?php
	$options = array(
		'contentView' => '../user/_staff',
		//'dataProvider' => $model->staff(),
		//'contentTitle' => 'DRC Students',
		'titleNavRight' => '<a href="' . $this->createUrl('user/create') . '"><i class="icon-plus"></i> Add User </a>',
		'menuView' => '../layouts/_termMenu',
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	
?>
	