<?php
	$options = array(
		'contentView' => '../drcUser/_staff',
		'title' => 'Curent DRC User Accounts',
		//'dataProvider' => $model->staff(),
		//'contentTitle' => 'DRC Students',
		'titleNavRight' => '<a href="' . $this->createUrl('drcUser/create') . '"><i class="icon-plus"></i> Add User </a>',
		'menuView' => '',
		'activeTab' => 'staff',
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	
?>
	