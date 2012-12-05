<?php
	$options = array(
		'contentView' => '../user/_staff',
		'title' => 'Curent DRC User Accounts',
		//'dataProvider' => $model->staff(),
		//'contentTitle' => 'DRC Students',
		'titleNavRight' => '<a href="' . $this->createUrl('user/create') . '"><i class="icon-plus"></i> Add User </a>',
		'menuView' => '',
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	
?>
	